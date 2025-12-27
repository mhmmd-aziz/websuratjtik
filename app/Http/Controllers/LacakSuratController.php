<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat; 


class LacakSuratController extends Controller
{
    /**
     * Menampilkan formulir pelacakan status surat.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
        return view('esurat.surat.lacak_surat', [
            'surat_data' => null,
           
            'status_message' => session('status_message', null) 
        ]);
    }

    /**
     
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function track(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required'
        ]);

      
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