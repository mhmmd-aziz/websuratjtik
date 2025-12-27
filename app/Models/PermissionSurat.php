<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionSurat extends Model
{
    protected $table = 'surat_permissions';    

    protected $fillable = [
        'id_surat',
        'id_prodi',
    ];

    
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }

    
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi', 'id_prodi');
    }
}
