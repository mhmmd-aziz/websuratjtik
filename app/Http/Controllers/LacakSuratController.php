<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat; // Pastikan Anda menggunakan Model Surat yang benar
// use Illuminate\Support\Facades\DB; // Tidak diperlukan jika menggunakan Eloquent

class LacakSuratController extends Controller
{
    /**
     * Menampilkan formulir pelacakan status surat.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // PERBAIKAN: Menggunakan path view lengkap (folder.subfolder.namafile)
        return view('esurat.surat.lacak_surat', [
            'surat_data' => null,
            // Ambil pesan status dari sesi (misalnya dari SuratController saat redirect)
            'status_message' => session('status_message', null) 
        ]);
    }

    /**
     * Memproses permintaan POST untuk melacak surat berdasarkan ID.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function track(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required'
        ]);

        // Tambahkan with(['disposisi.prodi']) biar datanya lengkap
        $surat = Surat::with(['disposisi.prodi'])
                      ->where('kode_tiket', $request->kode_tiket)
                      ->first();

        if ($surat) {
            return view('esurat.surat.lacak_surat', [
                'surat_data' => $surat
            ]);
        } else {
            return back()->with('status_message', [
                'type' => 'danger',
                'text' => 'Kode Surat <b>' . $request->kode_tiket . '</b> tidak ditemukan.'
            ]);
        }
    }
}