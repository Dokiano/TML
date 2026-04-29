<?php

namespace App\Http\Controllers;

use App\Models\DokumenReview;
use Illuminate\Http\Request;

class DokumenStatusController extends Controller
{
    public function update(Request $r, DokumenReview $dr)
    {
        // 1) Cek kondisi REAL dari database
        $hasMain    = method_exists($dr, 'approvals') ? $dr->approvals()->where('kind','main')->exists()    : false;
        $hasSupport = method_exists($dr, 'approvals') ? $dr->approvals()->where('kind','support')->exists() : false;
        $isApproved = $hasMain && $hasSupport;
    
        // Kamu memilih final saja (tanpa revisi)
        $hasFinal   = method_exists($dr, 'files') ? $dr->files()->where('type','final')->exists() : false;
    
        // Review = ada anotasi/komentar pertama
        $isReview   = method_exists($dr, 'annotations') ? $dr->annotations()->exists() : false;
    
        // 2) Simpan/Update status (boolean cast sudah ada di model)
        $st = $dr->status()->firstOrCreate([]);
        $st->fill([
            'is_review'   => $isReview,
            'is_revisi'   => false,        // kamu putuskan tidak pakai revisi
            'is_final'    => $hasFinal,
            'is_approved' => $isApproved,
            'updated_by'  => $r->user()->id ?? null,
        ])->save();
        
        return back()->with('success', 'Status dokumen diperbarui dari kondisi aktual.');
    }

}
