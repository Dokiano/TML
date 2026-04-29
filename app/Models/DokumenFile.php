<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenFile extends Model
{
    protected $table = 'dokumen_files';

    protected $fillable = [
        'dokumen_review_id','type','path','original_name','mime','size','note','uploaded_by',
    ];

    public function dokumenReview() { return $this->belongsTo(\App\Models\DokumenReview::class); }
    public function uploader()      { return $this->belongsTo(\App\Models\User::class, 'uploaded_by'); }
    // app/Models/DokumenFile.php
    public function dokumen(){ return $this->belongsTo(\App\Models\DokumenReview::class, 'dokumen_review_id');}

}
