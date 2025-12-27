<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

  
    protected $table = 'admins';

   
    protected $primaryKey = 'id';

   
    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',
        'prodi_id', 
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 5. CASTING (Opsional, biar tanggal otomatis jadi objek Carbon)
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Fitur baru Laravel biar otomatis hash (opsional)
    ];
}