<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenApproval extends Model
{
    protected $fillable = [
        'dokumen_review_id', 'user_id', 'kind', 'action',
        'signature_path', 'signature_source', 'comment', 'signed_at',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function dokumen()
    {
        return $this->belongsTo(DokumenReview::class, 'dokumen_review_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
