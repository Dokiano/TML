<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AnnotationImage extends Model
{
    protected $fillable = [
        'annotation_id',
        'path',
        'original_name',
    ];

    // ── Relasi ──────────────────────────────────────────────
    public function annotation()
    {
        return $this->belongsTo(PdfAnnotation::class, 'annotation_id');
    }

    // ── Accessor: URL publik untuk ditampilkan di view / export ──
   public function getUrlAttribute(): string
   {
       return route('annotation.images.stream', $this->id);
   }

    // ── Accessor: base64 data-url untuk export PDF (DomPDF) ──
    public function getDataUrlAttribute(): ?string
    {
       

        if (!Storage::disk('local')->exists($this->path)) return null;

        $mime = Storage::disk('local')->mimeType($this->path) ?? 'image/jpeg';
        $bin  = Storage::disk('local')->get($this->path);
        $result = 'data:' . $mime . ';base64,' . base64_encode($bin);

        

        return $result;
    }
}