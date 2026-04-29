<?php

namespace App\Http\Controllers;

use App\Models\DokumenReview;
use App\Models\PdfAnnotation;
use Illuminate\Http\Request;

class PdfAnnotationController extends Controller
{
  
    public function index(Request $r, DokumenReview $dr)
    {
        $this->authorizeAccess($r->user(), $dr);

        $items = PdfAnnotation::where('dokumen_review_id', $dr->id)->get();
        return response()->json($items);
    }

    // Simpan anotasi baru
    public function store(Request $r, DokumenReview $dr)
    {
        $this->authorizeAccess($r->user(), $dr);

        $data = $r->validate([
            'page' => 'required|integer|min:1',
            'type' => 'required|string|max:50',
            'rect' => 'nullable|array',
            'data' => 'nullable|array',
        ]);

        $authorName = $r->user()->nama_user ?? $r->user()->name_user ?? $r->user()->name ?? 'User';

        $ann = PdfAnnotation::create([
            'dokumen_review_id' => $dr->id,
            'user_id'           => $r->user()->id,
            'page'              => $data['page'],
            'type'              => $data['type'],
            'rect'              => $data['rect'] ?? null,
            'data'              =>  array_merge($data['data'] ?? [], ['author_name' => $authorName,]),
        ]);

        $dr->status()->updateOrCreate(
            ['dokumen_review_id' => $dr->id],
            [
                'is_final'    => $dr->files()->where('type','final')->exists(),
                'is_review'   => $dr->annotations()->exists(),
                'is_approved' => $dr->approvals()->where('kind','main')->exists()
                                && $dr->approvals()->where('kind','support')->exists(),
                'updated_by'  => auth()->id()
            ]
        );

        return response()->json($ann, 201);
    }

    // Ubah anotasi
    public function update(Request $r, DokumenReview $dr, PdfAnnotation $ann)
    {
        $this->authorizeAccess($r->user(), $dr);
        if ($ann->dokumen_review_id !== $dr->id) abort(404);

        $data = $r->validate([
            'page' => 'sometimes|integer|min:1',
            'type' => 'sometimes|string|max:50',
            'rect' => 'nullable|array',
            'data' => 'nullable|array',
        ]);
         if (isset($data['data'])) {
            $data['data']['author_name'] = $ann->data['author_name'] ??
             ( $r->user()->nama_user ?? $r->user()->name_user ?? $r->user()->name ?? 'User' );
        }

        $ann->update($data);
        return response()->json($ann);
    }

    // Hapus anotasi
    public function destroy(Request $r, DokumenReview $dr, PdfAnnotation $ann)
    {
        $this->authorizeAccess($r->user(), $dr);
        if ($ann->dokumen_review_id !== $dr->id) abort(404);

        // hanya pembuat anotasi atau admin
        if ($r->user()->id !== $ann->user_id && ($r->user()->role ?? null) !== 'admin') {
            abort(403);
        }

        $ann->delete();
        return response()->json(['ok' => true]);
    }

    // --- Guard akses sederhana: pembuat, reviewer, atau admin
    private function authorizeAccess($user, DokumenReview $dr)
    {
        $isPembuat  = (int)($dr->pembuat_id ?? 0) === (int)$user->id;
        $reviewerIds = is_array($dr->reviewer_ids ?? null) ? $dr->reviewer_ids : (json_decode($dr->reviewer_ids ?? '[]', true) ?: []);
        $isReviewer = in_array($user->id, $reviewerIds);
        $isAdmin    = ($user->role ?? null) === 'admin';

        if (!$isPembuat && !$isReviewer && !$isAdmin) abort(403);
    }
}
