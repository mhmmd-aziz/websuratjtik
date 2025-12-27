<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    // Arahkan ke tabel 'prodi'
    protected $table = 'prodi'; 

    // Kolom yang boleh diisi
    protected $fillable = ['nama'];
    
    // Relasi ke Disposisi (Opsional, buat jaga-jaga)
    public function disposisi()
    {
        return $this->hasMany(DisposisiSurat::class, 'prodi_id');
    }
}