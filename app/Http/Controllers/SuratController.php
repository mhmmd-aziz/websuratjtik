<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;

class SuratController extends Controller
{
    // Menampilkan form input surat
    public function create()
    {
        return view('esurat.surat.form');
    }

    // Proses simpan surat (DIPERBAIKI AGAR KAYAK WEB PHP)
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengirim'   => 'required|string',
            'perihal_surat'   => 'required|string',
            'email'           => 'required|email',
            'sifat_surat'     => 'required',
            'file_surat'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // File wajib ada
        ]);

        // Upload file
        $path = $request->file('file_surat')->store('surat_masuk', 'public');

        // SIMPAN DATA (Tanpa mengisi 'kode_tiket', karena Model yang akan mengisinya otomatis)
        $surat = Surat::create([
            'nama_pengirim' => $request->nama_pengirim,
            'perihal_surat' => $request->perihal_surat,
            'email'         => $request->email,
            'sifat_surat'   => $request->sifat_surat,
            'file_surat'    => $path,
            'status'        => 'pending',
        ]);

        // --- BAGIAN INI YANG DIUBAH ---
        // Kita kirim 'kode_tiket' ke View, BUKAN ID lagi.
        return redirect()->back()->with([
            'success'  => 'Surat berhasil dikirim!',
            'id_surat' => $surat->id, // ID Tetap dikirim buat sistem (opsional)
            'kode_tiket_baru' => $surat->kode_tiket, // Variable khusus buat ditangkap view
            'message_detail' => 
                'KODE TIKET ANDA: <strong>' . $surat->kode_tiket . '</strong><br>' .
                'Mohon catat kode ini untuk melacak status surat.'
        ]);
    }

    // Menampilkan daftar surat (misalnya untuk admin)
    public function index()
    {
        $surat = Surat::all();
        return view('surat.index', compact('surat'));
    }

    public function disposisiForm($id)
    {
        $surat = Surat::findOrFail($id);

        $prodi = Prodi::all();

        $selectedProdi = PermissionSurat::where('id_surat', $id)
            ->pluck('id_prodi')
            ->toArray();

        return view('surat.disposisi', compact('surat', 'prodi', 'selectedProdi'));
    }
}
