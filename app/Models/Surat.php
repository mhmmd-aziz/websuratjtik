<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surats';

    protected $fillable = [
        'kode_tiket', 
        'nama_pengirim',
        'email',
        'perihal_surat',
        'sifat_surat',
        'file_surat',
        'status'
    ];

    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
           
            if (empty($model->kode_tiket)) {
               
                $model->kode_tiket = strtoupper(Str::random(6));
            }
        });
    }

    // Relasi ke tabel Disposisi
    public function disposisi()
    {
        return $this->hasMany(DisposisiSurat::class, 'surat_id');
    }
}