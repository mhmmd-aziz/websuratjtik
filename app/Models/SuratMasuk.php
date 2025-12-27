<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk'; 

    protected $fillable = [
        'pengirim',
        'email',
        'isi_surat',
        'tanggal',
        'status'
    ];

    public function disposisi()
    {
        return $this->hasMany(DisposisiSurat::class, 'surat_id');
    }
}
