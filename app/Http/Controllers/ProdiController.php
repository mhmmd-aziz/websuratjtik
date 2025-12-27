<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Prodi;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        $role = session('admin_role'); 
        $nama_prodi = strtoupper(str_replace('prodi_', '', $role)); 
        $prodi_db = \App\Models\Prodi::where('nama', $nama_prodi)->first();

        if(!$prodi_db) abort(403);

        $keyword = $request->input('cari');

        
        $query_baru = \App\Models\DisposisiSurat::with('surat')
            ->whereHas('surat') 
            ->where('prodi_id', $prodi_db->id)
            ->where('status', 'pending'); 

        if ($keyword) {
            $query_baru->whereHas('surat', function($q) use ($keyword) {
                $q->where('nama_pengirim', 'LIKE', "%$keyword%")
                  ->orWhere('perihal_surat', 'LIKE', "%$keyword%")
                  ->orWhere('kode_tiket', 'LIKE', "%$keyword%");
            });
        }
        $surat_baru = $query_baru->orderBy('updated_at', 'desc')->get();


       
        $query_selesai = \App\Models\DisposisiSurat::with('surat')
            ->whereHas('surat') 
            ->where('prodi_id', $prodi_db->id)
            ->whereIn('status', ['disposisi', 'arsip']);

        if ($keyword) {
            $query_selesai->whereHas('surat', function($q) use ($keyword) {
                $q->where('nama_pengirim', 'LIKE', "%$keyword%")
                  ->orWhere('perihal_surat', 'LIKE', "%$keyword%");
            });
        }
        $surat_selesai = $query_selesai->orderBy('updated_at', 'desc')->get();

        return view('admin.prodi.dashboard', compact('surat_baru', 'surat_selesai', 'nama_prodi'));
    }

   public function updateStatus(Request $request, $id)
    {
     
        
        $request->validate([
            'aksi' => 'required',
            'catatan' => 'nullable|string'
        ]);

        // Update di tabel disposisi_surat
        \App\Models\DisposisiSurat::where('id', $id)->update([
            'status' => $request->aksi,
            'catatan' => $request->catatan
        ]);

        return back()->with('success', 'Status dan catatan berhasil diperbarui!');
    }

    public function cetak($id)
    {
        // $id disini adalah ID dari tabel disposisi_surat (karena diklik dari dashboard prodi)
        $disposisi = \App\Models\DisposisiSurat::with('surat')->findOrFail($id);
        
        // Ambil data surat induknya
        $surat = $disposisi->surat;
        
        // Timpa catatan surat induk dengan catatan spesifik prodi (supaya di view cetak ga perlu ubah kode banyak)
        $surat->catatan = $disposisi->catatan; 
        $surat->status = $disposisi->status;

        $role = session('admin_role'); 
        $nama_prodi = strtoupper(str_replace('prodi_', '', $role)); 

        return view('admin.prodi.cetak', compact('surat', 'nama_prodi'));
    }
}