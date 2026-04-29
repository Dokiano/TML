<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenReview extends Model
{
    protected $table = 'dokumen_reviews';

    protected $fillable = [
        'pembuat_id','pembuat2_id','divisi_id','jabatan','nama_jenis','nama_dokumen',
        'nomor_dokumen','no_revisi','keterangan','alasan_revisi','reviewer_ids','approver_support_ids','approver_main_id',
        'draft_path','pdf_path','dr_no', 'dr_year', 'dr_seq','dokumen_id','file_final_dr',
    ];

    protected $casts = ['reviewer_ids' => 'array',
                        'approver_support_ids' => 'array',
                        'tanggal_penyelesaian' => 'date',
                        'tanggal_diterima_dokumen_kontrol' => 'date',
                        'tanggal_terbit' => 'date', 
    ];

    public function pembuat(){ return $this->belongsTo(\App\Models\User::class, 'pembuat_id'); }
    public function divisi(){ return $this->belongsTo(\App\Models\Divisi::class, 'divisi_id'); }
    public function files() { return $this->hasMany(\App\Models\DokumenFile::class, 'dokumen_review_id'); }
    public function status() {return $this->hasOne(\App\Models\DokumenStatus::class, 'dokumen_review_id');}
    public function approvals() {return $this->hasMany(\App\Models\DokumenApproval::class, 'dokumen_review_id');}
    public function pembuat2() {return $this->belongsTo(User::class, 'pembuat2_id');}
    public function approverMain(){return $this->belongsTo(User::class, 'approver_main_id');}
    public function annotations(){return $this->hasMany(\App\Models\PdfAnnotation::class, 'dokumen_review_id');}
    public function dokumen() {return $this->belongsTo(Dokumen::class);}
    

}
