<?php

namespace App\Http\Controllers;

use App\Models\DokumenApproval;
use App\Models\DokumenReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenApprovalController extends Controller
{
    public function store(Request $r, DokumenReview $dr)
    {
        $this->authorizeAccess($r->user(), $dr);

        $v = $r->validate([
            'kind'            => 'required|in:main,support,reviewer',
            'action'          => 'required|in:approved,rejected',
            'signature_file'  => 'nullable|image|max:2048',
            'signature_json'  => 'nullable|string', // akan berisi dataURL PNG dari canvas
            'comment'         => 'nullable|string|max:1000',
        ]);

        $sigPath = null;
        $sigSrc  = null;

        // 1) kalau ada file gambar yang di-upload
        if ($r->hasFile('signature_file')) {
            $sigPath = $r->file('signature_file')->store('approvals/signatures');
            $sigSrc  = 'upload';
        }
        // 2) kalau ada dataURL dari canvas (SignaturePad)
        elseif (!empty($v['signature_json']) && str_starts_with($v['signature_json'], 'data:image')) {
            $sigPath = $this->storeDataUrlImage($v['signature_json'], 'approvals/signatures');
            $sigSrc  = 'canvas';
        }

        DokumenApproval::create([
            'dokumen_review_id' => $dr->id,
            'user_id'           => $r->user()->id,
            'kind'              => $v['kind'],
            'action'            => $v['action'],
            'signature_path'    => $sigPath,
            'signature_source'  => $sigSrc,
            'comment'           => $v['comment'] ?? null,
            'signed_at'         => now(),
        ]);

        //  Setelah approval disimpan → update status otomatis
        $hasMain    = $dr->approvals()->where('kind','main')->exists();
        $hasSupport = $dr->approvals()->where('kind','support')->exists();
        $hasFinal   = $dr->files()->where('type','final')->exists();
        $hasReview  = $dr->annotations()->exists();

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

        return back()->with('success', 'Approval tersimpan.');
    }

    // --- simpan dataURL PNG ke storage
    private function storeDataUrlImage(string $dataUrl, string $dir): string
    {
        [$meta, $content] = explode(',', $dataUrl, 2);
        $ext = 'png';
        if (preg_match('/^data:image\/(\w+);base64$/', $meta, $m)) {
            $ext = strtolower($m[1]);
        }
        $binary = base64_decode($content);
        $name   = $dir.'/sig_'.uniqid().'.'.$ext;
        Storage::put($name, $binary);
        return $name;
    }

    // guard sederhana: admin, pembuat, atau reviewer
    private function authorizeAccess($user, DokumenReview $dr): void
    {
        $isAdmin   = ($user->role ?? null) === 'admin';
        $isPembuat = (int)$dr->pembuat_id === (int)$user->id;

        $reviewerIds = is_array($dr->reviewer_ids ?? null)
            ? $dr->reviewer_ids
            : (json_decode($dr->reviewer_ids ?? '[]', true) ?: []);

        $isReviewer = in_array($user->id, $reviewerIds);
        $isApproverM = (int) ($dr->approver_main_id ?? 0) === (int) $user->id; 
        $supportIds  = array_map('intval', (array) (is_array($dr->approver_support_ids)
            ? $dr->approver_support_ids
            : (json_decode($dr->approver_support_ids ?? '[]', true) ?: [])));
        $isApproverS = in_array((int)$user->id, $supportIds);

        if (!$isAdmin && !$isReviewer && !$isPembuat && !$isApproverM && !$isApproverS) {
        abort(403);
        }
    }
     public function signature(Request $r, DokumenApproval $approval)
    {
        $dr = DokumenReview::find($approval->dokumen_review_id);
        abort_if(!$dr, 404);
    
        $this->authorizeAccess($r->user(), $dr);
    
        abort_unless($approval->signature_path && Storage::exists($approval->signature_path), 404);
    
        $mime = Storage::mimeType($approval->signature_path) ?: 'image/png';
        return response()->file(Storage::path($approval->signature_path), [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
        ]);
    }

}
