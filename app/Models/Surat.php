<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // <--- WAJIB: Jangan lupa import ini!
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surats';

    protected $fillable = [
        'kode_tiket', // <--- Pastikan kolom ini sudah ada di fillable
        'nama_pengirim',
        'email',
        'perihal_surat',
        'sifat_surat',
        'file_surat',
        'status'
    ];

    // --- LOGIKA UNIK (AUTO GENERATE KODE) ---
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Jika kode tiket belum ada, buatkan otomatis
            if (empty($model->kode_tiket)) {
                // Buat kode acak 6 karakter huruf besar (Contoh: X8Y29A)
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