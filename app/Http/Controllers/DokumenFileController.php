<?php

namespace App\Http\Controllers;

use App\Models\DokumenReview;
use App\Models\DokumenFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenFileController extends Controller
{
    // POST /dokumen-review/{dr}/files  -> name: dokumenFiles.store
    public function store(Request $r, DokumenReview $dr)
    {
        $this->authorizeView($r->user(), $dr);

        $data = $r->validate([
            'type' => 'required|in:final,revisi_final',
            'file' => 'required|file|mimes:pdf|max:20480',
            'note' => 'nullable|string|max:200',
        ]);

        $f    = $r->file('file');
        $path = $f->store('dokumen_final');
        $mime = $f->getClientMimeType() ?: 'application/pdf';

        DokumenFile::create([
            'dokumen_review_id' => $dr->id,
            'uploaded_by'       => $r->user()->id,
            'type'              => $data['type'],
            'path'              => $path,
            'original_name'     => $f->getClientOriginalName(),
            'size'              => $f->getSize(),
            'mime'              => $mime, 
            'note'              => $data['note'] ?? null,
        ]);

        //  Update status otomatis setelah upload
        $dr->status()->updateOrCreate(
            ['dokumen_review_id' => $dr->id],
            [
                'is_final'    => true,
                'is_review'   => $dr->annotations()->exists(),
                'is_approved' => $dr->approvals()->where('kind','main')->exists()
                                && $dr->approvals()->where('kind','support')->exists(),
                'updated_by'  => $r->user()->id
            ]
        );

        return back()->with('success', 'File final/revisi berhasil diunggah.');
    }

    // GET /dokumen-review/{dr}/files  -> name: dokumenFiles.index
    public function index(Request $r, DokumenReview $dr)
    {
        $this->authorizeView($r->user(), $dr);

        $rows = DokumenFile::where('dokumen_review_id', $dr->id)
            ->latest()
            ->get()
            ->map(function ($x) {
                return [
                    'id'            => $x->id,
                    'type'          => $x->type,
                    'original_name' => $x->original_name,
                    'size'          => $x->size,
                    'uploaded_by'   => optional($x->uploader)->nama_user
                                    ?? optional($x->uploader)->name_user
                                    ?? optional($x->uploader)->name
                                    ?? ('User#'.$x->user_id),
                    'created_at'    => optional($x->created_at)->format('d/m/Y H:i'),
                    'note'          => $x->note,
                    'preview_url'   => route('dokumenFiles.preview', $x->id),
                    'viewer_url'    => route('dokumenFiles.viewer', $x->id),
                    'destroy_url' => route('dokumenFiles.destroy', $x->id),

                ];
            });

        return response()->json($rows);
    }
    // --- guard akses sama dgn controller lain
    private function authorizeView($user, DokumenReview $dr)
    {
        $isPembuat = (int)($dr->pembuat_id ?? 0) === (int)$user->id 
                    || (int)($dr->pembuat2_id ?? 0) === (int)$user->id;
        $reviewerIds = is_array($dr->reviewer_ids ?? null)
            ? $dr->reviewer_ids
            : (json_decode($dr->reviewer_ids ?? '[]', true) ?: []);
        $isReviewer  = in_array($user->id, $reviewerIds);
        $isAdmin     = ($user->role ?? null) === 'admin';

        if (!$isPembuat && !$isReviewer && !$isAdmin) abort(403);
    }

    public function destroy(Request $r, DokumenFile $file)
    {
        // pastikan user yang sama dengan yang boleh melihat juga boleh menghapus
        $dr = $file->dokumen ?: \App\Models\DokumenReview::find($file->dokumen_review_id);
        abort_if(!$dr, 404, 'Dokumen review tidak ditemukan untuk file ini.');
        $this->authorizeView($r->user(), $dr);
        // hapus file fisik bila ada
        if ($file->path && Storage::exists($file->path)) {
            Storage::delete($file->path);
        }
        // hapus record database
        $file->delete();

        //  Cek apakah masih ada file final tersisa
         $hasFinal = $dr->files()->where('type', 'final')->exists();
            
         $dr->status()->updateOrCreate(
             ['dokumen_review_id' => $dr->id],
             [
                 'is_final'    => $hasFinal,
                 'is_review'   => $dr->annotations()->exists(),
                 'is_approved' => $dr->approvals()->where('kind','main')->exists()
                                 && $dr->approvals()->where('kind','support')->exists(),
                 'updated_by'  => $r->user()->id
             ]
         );
        // jika request dari AJAX, balas JSON; jika form biasa, redirect back
        if ($r->expectsJson() || $r->ajax()) {
            return response()->json(['ok' => true]);
        }
        return back()->with('success', 'File berhasil dihapus.');
    }

    // Viewer read-only
    public function viewer(Request $r, DokumenFile $file)
    {
        $dr = $file->dokumen ?: DokumenReview::find($file->dokumen_review_id);
        abort_if(!$dr, 404, 'Dokumen review tidak ditemukan untuk file ini.');
    
        $this->authorizeView($r->user(), $dr);
    
        return view('dokumen.viewer', ['file' => $file]);
    }
    
    // (Disarankan juga lindungi stream/preview)
    public function preview(Request $r, DokumenFile $file)
    {
        $dr = $file->dokumen ?: DokumenReview::find($file->dokumen_review_id);
        abort_if(!$dr, 404, 'Dokumen review tidak ditemukan untuk file ini.');
        $this->authorizeView($r->user(), $dr);
    
        abort_unless(Storage::exists($file->path), 404, 'File tidak ditemukan');
        $name = $file->original_name ?: basename($file->path);
    
        return response()->file(Storage::path($file->path), [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($name).'"',
        ]);
    }
    public function stream(\App\Models\DokumenFile $file)
{
    // Pastikan file ada di storage
    if (!\Storage::disk('local')->exists($file->path)) {
        abort(404, 'File tidak ditemukan di storage.');
    }

    // Ambil path fisik
    $fullPath = \Storage::disk('local')->path($file->path);

    // Stream langsung ke browser
    return response()->file($fullPath, [
        'Content-Type' => $file->mime ?? 'application/pdf',
        'Content-Disposition' => 'inline; filename="'.$file->original_name.'"',
    ]);
}



}
