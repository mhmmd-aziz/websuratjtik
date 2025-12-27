<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat; 
use App\Models\Prodi;
use App\Models\DisposisiSurat;
use Illuminate\Support\Facades\Storage; 

class AdminJTIKController extends Controller
{
    public function index(Request $request)
    {
       
        
        $query = Surat::whereIn('status', ['pending', 'terkirim']); 

      
        if ($request->has('cari') && $request->cari != '') {
            $keyword = $request->cari;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_pengirim', 'LIKE', "%$keyword%")
                  ->orWhere('perihal_surat', 'LIKE', "%$keyword%")
                  ->orWhere('kode_tiket', 'LIKE', "%$keyword%")
                  ->orWhere('email', 'LIKE', "%$keyword%");
            });
        }

       
        $surat = $query->with(['disposisi.prodi'])
                       ->orderBy('created_at', 'desc')
                       ->get();

       
        $prodi = Prodi::all();
        $stats = [
            'pending'   => Surat::where('status', 'pending')->count(),
            'diproses'  => Surat::where('status', 'terkirim')->count(),
            'selesai'   => Surat::whereIn('status', ['disposisi', 'arsip'])->count(),
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

  
    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->delete(); 
        return back()->with('success', 'Surat dipindahkan ke Tong Sampah.');
    }

    
    public function sampah()
    {
        $sampah = Surat::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.jtik.sampah', compact('sampah'));
    }

    
    public function restore($id)
    {
        $surat = Surat::withTrashed()->findOrFail($id);
        $surat->restore();
        return redirect()->route('adminjtik.sampah.index')
            ->with('success', 'Surat berhasil dikembalikan (Restore).');
    }

   
    public function forceDelete($id)
    {
        $surat = Surat::withTrashed()->findOrFail($id);

       
        if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        $surat->forceDelete();

        return redirect()->route('adminjtik.sampah.index')
            ->with('success', 'Surat dan File berhasil dimusnahkan selamanya.');
    }

    public function batalKirim($id_disposisi)
    {
        
        $disposisi = DisposisiSurat::findOrFail($id_disposisi);
        $surat_id = $disposisi->surat_id; 

        // 2. Hapus (Cabut)
        $disposisi->delete();

       
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
            fputcsv($file, $columns); 

            foreach ($surats as $k => $s) {
                
                
                $tracking_info = [];
                if($s->disposisi->count() > 0){
                    foreach($s->disposisi as $d){
                        
                        $tracking_info[] = $d->prodi->nama . " (" . strtoupper($d->status) . ")";
                    }
                    $status_detail = implode(' | ', $tracking_info);
                } else {
                    $status_detail = "Belum Diteruskan (Di Admin JTIK)";
                }

                
                fputcsv($file, [
                    $k + 1,
                    $s->kode_tiket,
                    $s->nama_pengirim,
                    $s->email,
                    $s->perihal_surat,
                    strtoupper($s->sifat_surat),
                    $s->created_at->format('d-m-Y H:i'),
                    $status_detail 
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    
}