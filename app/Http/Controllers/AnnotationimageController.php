<?php

namespace App\Http\Controllers;

use App\Models\AnnotationImage;
use App\Models\DokumenReview;
use App\Models\PdfAnnotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnotationImageController extends Controller
{
    /**
     * Upload satu atau lebih gambar untuk sebuah anotasi.
     * POST /dokumen-review/{dr}/annotations/{ann}/images
     */
    public function store(Request $r, DokumenReview $dr, PdfAnnotation $ann)
    {
        $this->authorizeAccess($r->user(), $dr);

        // Pastikan anotasi milik dokumen yang benar
        if ($ann->dokumen_review_id !== $dr->id) abort(404);

        $r->validate([
            'images'   => 'required|array|min:1|max:5',
            'images.*' => 'required|file|mimes:jpg,jpeg,png,webp|max:4096', // maks 4 MB per file
        ]);

        $saved = [];

        foreach ($r->file('images') as $file) {
           $path = $file->store('annotation_images');

            $img = AnnotationImage::create([
                'annotation_id' => $ann->id,
                'path'          => $path,
                'original_name' => $file->getClientOriginalName(),
            ]);

            $saved[] = [
                'id'            => $img->id,
                'url'           => $img->url,
                'original_name' => $img->original_name,
            ];
        }

        return response()->json($saved, 201);
    }

    /**
     * Ambil semua gambar milik satu anotasi.
     * GET /dokumen-review/{dr}/annotations/{ann}/images
     */
    public function index(Request $r, DokumenReview $dr, PdfAnnotation $ann)
    {
        $this->authorizeAccess($r->user(), $dr);

        if ($ann->dokumen_review_id !== $dr->id) abort(404);

        $images = $ann->images->map(fn($img) => [
            'id'            => $img->id,
            'url'           => $img->url,
            'original_name' => $img->original_name,
        ]);

        return response()->json($images);
    }

    /**
     * Hapus satu gambar.
     * DELETE /dokumen-review/{dr}/annotations/{ann}/images/{img}
     */
    public function destroy(Request $r, DokumenReview $dr, PdfAnnotation $ann, AnnotationImage $img)
    {
        $this->authorizeAccess($r->user(), $dr);

        if ($ann->dokumen_review_id !== $dr->id) abort(404);
        if ($img->annotation_id !== $ann->id) abort(404);

        // Hanya pembuat anotasi atau admin yang boleh hapus
        if ($r->user()->id !== $ann->user_id && ($r->user()->role ?? null) !== 'admin') {
            abort(403);
        }

        Storage::disk('public')->delete($img->path);
        $img->delete();

        return response()->json(['ok' => true]);
    }

    // ── Guard akses: sama dengan PdfAnnotationController ────
    private function authorizeAccess($user, DokumenReview $dr): void
    {
        $isPembuat   = (int)($dr->pembuat_id ?? 0) === (int)$user->id;
        $reviewerIds = is_array($dr->reviewer_ids ?? null)
            ? $dr->reviewer_ids
            : (json_decode($dr->reviewer_ids ?? '[]', true) ?: []);
        $isReviewer  = in_array($user->id, $reviewerIds);
        $isAdmin     = ($user->role ?? null) === 'admin';

        if (!$isPembuat && !$isReviewer && !$isAdmin) abort(403);
    }
    
    public function stream(Request $r, AnnotationImage $img)
    {
        // pastikan user punya akses ke dokumen terkait
        $ann = $img->annotation;
        $this->authorizeAccess($r->user(), $ann->dokumenReview);

        abort_unless(Storage::disk('local')->exists($img->path), 404);

        $abs  = Storage::disk('local')->path($img->path);
        $mime = Storage::disk('local')->mimeType($img->path) ?? 'image/jpeg';

        return response()->file($abs, ['Content-Type' => $mime]);
    }
}