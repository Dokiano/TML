<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Realisasi extends Model
{
    use HasFactory;

    protected $table = 'realisasi';

    protected $fillable = [
        'id_tindakan',
        'id_riskregister',
        'nama_realisasi',
        'target', // pic
        'desc', // noted
        'tgl_realisasi',
        'evidencerealisasi',
        'status',
        'presentase'
    ];

    protected $casts = [
        'nama_realisasi' => 'array', // Casting sebagai array (JSON)
        'evidencerealisasi' => 'array',
    ];

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class, 'id_tindakan');
    }

    public function resiko()
    {
        return $this->belongsTo(Resiko::class, 'id_tindakan');
    }
}
