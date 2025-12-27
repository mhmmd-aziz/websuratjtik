<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat; 
use App\Models\Prodi;
use App\Models\DisposisiSurat;
use Illuminate\Support\Facades\Storage; // <--- PENTING!

class AdminJTIKController extends Controller
{
    public function index(Request $request)
    {
       
        
        $query = Surat::whereIn('status', ['pending', 'terkirim']); 

        // ----------------------------------

        // Logika Pencarian
        if ($request->has('cari') && $request->cari != '') {
            $keyword = $request->cari;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_pengirim', 'LIKE', "%$keyword%")
                  ->orWhere('perihal_surat', 'LIKE', "%$keyword%")
                  ->orWhere('kode_tiket', 'LIKE', "%$keyword%")
                  ->orWhere('email', 'LIKE', "%$keyword%");
            });
        }

        // Ambil data + Data Disposisi (Wajib pakai with untuk monitoring)
        $surat = $query->with(['disposisi.prodi'])
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Data Pendukung
        $prodi = Prodi::all();
        $stats = [
            'pending'   => Surat::where('status', 'pending')->count(),
            'diproses'  => Surat::where('status', 'terkirim')->count(),
            'selesai'   => Surat::whereIn('status', ['disposisi', 'arsip'])->count(), // Ini hitungan kasar global
            'total'     => Surat::count(),
        ];

        return view('admin.jtik.dashboard', compact('surat', 'prodi', 'stats'));
    }

    public function kirim(Request $request, $id)
    {
        $request->validate([ 'tujuan_prodi' => 'required|array' ]);

        foreach ($request->tujuan_prodi as $prodi_id) {
            DisposisiSurat::create([
                'surat_id' => $id,
                'prodi_id' => $prodi_id
            ]);
        }

        Surat::where('id', $id)->update(['status' => 'terkirim']);

        return back()->with('success', 'Surat berhasil diteruskan ke Prodi!');
    }

    // --- FITUR HAPUS & SAMPAH ---

    // 1. Hapus Sementara (Soft Delete)
    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->delete(); 
        return back()->with('success', 'Surat dipindahkan ke Tong Sampah.');
    }

    // 2. Halaman Sampah
    public function sampah()
    {
        $sampah = Surat::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.jtik.sampah', compact('sampah'));
    }

    // 3. Restore
    public function restore($id)
    {
        $surat = Surat::withTrashed()->findOrFail($id);
        $surat->restore();
        return redirect()->route('adminjtik.sampah.index')
            ->with('success', 'Surat berhasil dikembalikan (Restore).');
    }

    // 4. Hapus Permanen
    public function forceDelete($id)
    {
        $surat = Surat::withTrashed()->findOrFail($id);

        // Hapus File Fisik
        if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        $surat->forceDelete();

        return redirect()->route('adminjtik.sampah.index')
            ->with('success', 'Surat dan File berhasil dimusnahkan selamanya.');
    }

    public function batalKirim($id_disposisi)
    {
        // 1. Cari data disposisi berdasarkan ID-nya
        $disposisi = DisposisiSurat::findOrFail($id_disposisi);
        $surat_id = $disposisi->surat_id; // Simpan ID surat induk buat pengecekan nanti

        // 2. Hapus (Cabut)
        $disposisi->delete();

        // 3. Cek Logika Status Induk
        // Jika setelah dihapus ternyata surat ini TIDAK ADA lagi yang pegang (kosong),
        // kembalikan status surat induk jadi 'pending' (biar admin sadar surat ini nganggur).
        $sisa = DisposisiSurat::where('surat_id', $surat_id)->count();
        if ($sisa == 0) {
            Surat::where('id', $surat_id)->update(['status' => 'pending']);
        }

        return back()->with('success', 'Pengiriman surat berhasil dicabut/dibatalkan.');
    }

    // FITUR EXPORT EXCEL (CSV)
    public function exportExcel()
    {
        $filename = "Rekap_Surat_JTIK_" . date('Y-m-d_H-i') . ".csv";
        
        // Ambil semua surat (termasuk yang di tong sampah kalau mau, tapi biasanya yang aktif saja)
        // Kita ambil yang aktif saja (pending, terkirim, disposisi, arsip)
        $surats = Surat::with(['disposisi.prodi'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'Kode Tiket', 'Pengirim', 'Email', 'Perihal', 'Sifat', 'Tgl Masuk', 'Status Tracking (Detail)'];

        $callback = function() use ($surats, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis Header Kolom

            foreach ($surats as $k => $s) {
                
                // Susun Status Tracking (Contoh: "TI: Arsip, TRKJ: Pending")
                $tracking_info = [];
                if($s->disposisi->count() > 0){
                    foreach($s->disposisi as $d){
                        // Format: NAMA_PRODI (STATUS)
                        $tracking_info[] = $d->prodi->nama . " (" . strtoupper($d->status) . ")";
                    }
                    $status_detail = implode(' | ', $tracking_info);
                } else {
                    $status_detail = "Belum Diteruskan (Di Admin JTIK)";
                }

                // Tulis Baris Data
                fputcsv($file, [
                    $k + 1,
                    $s->kode_tiket,
                    $s->nama_pengirim,
                    $s->email,
                    $s->perihal_surat,
                    strtoupper($s->sifat_surat),
                    $s->created_at->format('d-m-Y H:i'),
                    $status_detail // Kolom paling penting buat laporan
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    
}