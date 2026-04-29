<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DraftMasterlistDivisi extends Model
{
    protected $table = 'draft_masterlist_divisis';

    protected $fillable = [
        'divisi_id',
        'proses',
        'pemilik_proses',
        'no_dokumen',
        'nama_jenis',
        'nama_dokumen',
        'no_revisi',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'no_revisi' => 'integer',
    ];
}
