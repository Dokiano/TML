<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'id_resiko',
        'nama_kriteria',
        'desc_kriteria',
        'nilai_kriteria',
        'divisi_id',
        'jenis_iso_id'

    ];

    public function divisi(){
        return $this->belongsTo(\App\Models\Divisi::class, 'divisi_id');
    }
     public function jenisIso()
    {
        return $this->belongsTo(JenisIso::class, 'jenis_iso_id');
    }
}
