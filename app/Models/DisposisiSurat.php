<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposisiSurat extends Model
{
    use HasFactory;

    protected $table = 'disposisi_surat';

    // Tambahkan status dan catatan agar bisa di-update
    protected $fillable = ['surat_id', 'prodi_id', 'status', 'catatan'];

    // Relasi BALIK ke Surat (Untuk mengambil Judul/Pengirim)
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }

    // Relasi ke Prodi (Opsional, buat jaga-jaga)
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
}