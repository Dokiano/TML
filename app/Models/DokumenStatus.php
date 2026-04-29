<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenStatus extends Model
{
    protected $fillable = [
        'dokumen_review_id',
        'is_review', 'is_revisi', 'is_final', 'is_approved',
        'updated_by',
    ];

    protected $casts = [
        'is_review'   => 'boolean',
        'is_revisi'   => 'boolean',
        'is_final'    => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function dokumen()
    {
        return $this->belongsTo(DokumenReview::class, 'dokumen_review_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
