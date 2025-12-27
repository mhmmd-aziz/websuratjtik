<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposisiSurat extends Model
{
    use HasFactory;

    protected $table = 'disposisi_surat';

    
    protected $fillable = ['surat_id', 'prodi_id', 'status', 'catatan'];

    
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }

    
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
}