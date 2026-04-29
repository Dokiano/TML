<?php

namespace App\Http\Controllers;

use App\Models\DokumenReview;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\PdfAnnotation;
use App\Models\DokumenApproval; 
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\NotifikasiReviewerBaru;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class DokumenReviewController extends Controller
{


    public function index(Request $r)
    {
        $u    = $r->user();
        $role = $u->role ?? null;

        $q = DokumenReview::with(['pembuat','pembuat2','divisi','approvals.user'])->latest();

        // Non-admin hanya lihat yang relevan
        if (!in_array($role, ['admin','manager','manajemen','supervisor'])) {
            $q->where(function ($w) use ($u) {
                $w->where('pembuat_id', $u->id)
                  ->orWhere('pembuat2_id', $u->id)
                  ->orWhereJsonContains('reviewer_ids', $u->id)
                  ->orWhere('approver_main_id', $u->id) 
                  ->orWhere('reviewer_ids', 'like', '%"'.$u->id.'"%')
                  ->orWhereRaw("JSON_CONTAINS(approver_support_ids, JSON_QUOTE(?))", [(string) $u->id]);
            });
        }

        $dokumen = $q->whereNull('tanggal_terbit')
             ->where(function($w) {
                 $w->whereNull('status_review')
                   ->orWhere('status_review', '!=', 'terbit');
             })
             ->paginate(12);

        // ===== OPTIMIZED: Single query untuk semua users yang dibutuhkan =====
        // Ambil semua user sekali, kemudia generate userMap dari sana
        $allUsers = User::orderBy('nama_user')->get(['id','nama_user']);
        
        // Extract reviewer IDs yang ada di dokumen
        $ids = collect($dokumen->items())
                ->flatMap(fn($d) => $d->reviewer_ids ?? [])
                ->filter()->unique()->values();
        
        // Generate userMap dari collection yang sudah ada (bukan query tambahan)
        $userMap = $allUsers->whereIn('id', $ids)->pluck('nama_user', 'id');
        $users = $allUsers;

        return view('dokumen.dokumenRevw', compact('dokumen','userMap','users'));
    }

    public function store(Request $r)
    {
        $v = $r->validate([
            'pembuat2_id'    => 'required|exists:user,id', // tabel 'user' (singular)
            'divisi_id'      => 'required|exists:divisi,id',
            'jabatan'        => 'required|in:admin,staff,manajemen,manager,supervisor',
            'nama_jenis'     => 'required|string|max:100',
            'nama_dokumen'   => 'required|string|max:200',
            'nomor_dokumen'  => 'nullable|string|max:100',
            'no_revisi'      => 'nullable|string|max:100',
            'keterangan'     => 'nullable|string|max:200',
            'alasan_revisi'  => 'nullable|string',
            'reviewer_ids'   => 'nullable|array',
            'reviewer_ids.*' => 'integer|exists:user,id', 
            'approver_main_id'        => 'nullable|integer|exists:user,id',
            'approver_support_ids'    => 'nullable|array',
            'approver_support_ids.*'  => 'integer|exists:user,id',
            'draft_dokumen'  => 'required|file|mimes:pdf|max:20480', 
        ]);

        $reviewerIds = collect($r->input('reviewer_ids', []))
            ->filter()->unique()->values();
        $approverMainId     = $r->input('approver_main_id');
        $approverSupportIds = collect($r->input('approver_support_ids', []))->filter()->unique()->values();

        // $reviewerIds = $reviewerIds->all(); yamg asli
       
        
        // Simpan file draft (PDF). Karena validasi mimes:pdf, path ini juga bisa jadi pdf_path.
        $file = $r->file('draft_dokumen');
        $path = $file->store('dokumen_draft'); // disk 'local' default

        
        $year = now()->year;
        $lastSeq = \App\Models\DokumenReview::where('dr_year', $year)->max('dr_seq') ?? 0;
        $seq  = $lastSeq + 1;
        $drNo = str_pad($seq, 4, '0', STR_PAD_LEFT) . '/' . $year;  //kalo mau ganti digit ganti 2 menjadi berapapun
        $dokumen = \App\Models\Dokumen::where('divisi_id', $v['divisi_id'])
            ->whereRaw("TRIM(UPPER(nama_jenis)) = TRIM(UPPER(?))", [$v['nama_jenis']])
            ->first();  

        // Simpan record
        $dr = \App\Models\DokumenReview::create([
            'pembuat_id'    => $r->user()->id,      // pengaju nomer dr = user login
            'pembuat2_id'   => $v['pembuat2_id'] ?? $r->user()->id, //pembuat surat dokumen
            'divisi_id'     => $v['divisi_id'],
            'jabatan'       => $v['jabatan'],
            'nama_jenis'    => $v['nama_jenis'],
            'nama_dokumen'  => $v['nama_dokumen'],
            'nomor_dokumen' => $v['nomor_dokumen'] ?? null,
            'no_revisi'     => $v['no_revisi'] ?? null,
            'keterangan'    => $v['keterangan'] ?? null,
            'alasan_revisi' => $v['alasan_revisi'] ?? null,
            'reviewer_ids'  => $reviewerIds ?: null,
            'approver_main_id'     => $approverMainId,
            'approver_support_ids' => $approverSupportIds->all() ?: null,
            'draft_path'    => $path,
            'pdf_path'      => $path,               
            'dokumen_id'    => $dokumen?->id,
            // kolom No. DR:
            'dr_year'       => (int) $year,
            'dr_seq'        => (int) $seq,
            'dr_no'         => $drNo,
        ]);

         $reviewerIds = is_array($r->reviewer_ids) ? $r->reviewer_ids : json_decode($r->reviewer_ids, true);
         if ($reviewerIds) {
        $reviewers = User::whereIn('id', $reviewerIds)->get();

        foreach ($reviewers as $rev) {
            // panggil Layanan SMTP Gmail (Service Provider)
            try {
                Mail::to($rev->email)->send(new NotifikasiReviewerBaru($dr, $rev));
            } catch (\Exception $e) {
                // Catat log jika gagal agar aplikasi tidak error
                \Log::error("Gagal mengirim email ke Reviewer: " . $rev->email);
            }
        }
    }
        try {   
            // Proses kirim email
            foreach ($reviewers as $rev) {
                Mail::to('argapasha04@gmail.com')->send(new NotifikasiReviewerBaru($dr, $rev));
            }

            return redirect()
                ->route('dokumenReview.index')
                ->with('success', 'Dokumen berhasil diajukan. No. DR: ' . $dr->dr_no . ' dan notifikasi email telah dikirim ke Reviewer.');

        } catch (\Exception $e) {
            // Jika data tersimpan tapi email gagal (misal SMTP error/internet down)
            return redirect()
                ->route('dokumenReview.index')
                ->with('success', 'Dokumen berhasil diajukan (No. DR: ' . $dr->dr_no . '), namun notifikasi email gagal dikirim.');
        }
    }

    public function show(DokumenReview $dr, Request $r)
    {
        $u = $r->user();
        $this->authorizeView($r->user(), $dr);

        $dr->load(['pembuat','divisi','approvals.user']);
        $userMap = \App\Models\User::whereIn('id', collect($dr->reviewer_ids ?? [])->filter())->pluck('nama_user','id');
        $dokumen = collect([$dr]); // bungkus jadi koleksi 1 baris
        return view('dokumen.dokumenRevw', compact('dr'));

    }

    public function streamDraft(DokumenReview $dr, Request $r)
    {
        $u = $r->user();
        $this->authorizeView($r->user(), $dr);
        $mime = Storage::mimeType($dr->draft_path) ?: 'application/octet-stream';
        $name = basename($dr->draft_path);

        return response()->streamDownload(fn()=>print(Storage::get($dr->draft_path)), $name, [
            'Content-Type'=>$mime,
            'Content-Disposition'=>'inline; filename="'.$name.'"'
        ]);
    }

    // Stream PDF ke PDF.js
    public function pdf(Request $r, DokumenReview $dr)
    {
             $this->authorizeView($r->user(), $dr);
        
        // pakai pdf_path; kalau kosong tapi draft sudah pdf, pakai draft_path
        $rel = $dr->pdf_path ?: (strtolower(pathinfo($dr->draft_path ?? '', PATHINFO_EXTENSION)) === 'pdf' ? $dr->draft_path : null);
        abort_unless($rel && Storage::disk('local')->exists($rel), 404, 'PDF tidak ditemukan');
        
        $abs = Storage::disk('local')->path($rel);
        
        return response()->file($abs, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($abs).'"',
        ]);
    }

    // Halaman Blade untuk menampilkan PDF.js + layer anotasi
    public function annotate(Request $r, DokumenReview $dr)
    {
        $this->authorizeView($r->user(), $dr);
         if (!$dr->pdf_path
        && $dr->draft_path
        && Str::of($dr->draft_path)->lower()->endsWith('.pdf')
        && Storage::disk('local')->exists($dr->draft_path)) {
        $dr->pdf_path = $dr->draft_path;
        $dr->save();
    }

    
        abort_if(!$dr->pdf_path || !Storage::exists($dr->pdf_path), 404, 'PDF belum tersedia');

        return view('dokumen.annotate', ['d' => $dr]);
    }


    private function authorizeView($user, DokumenReview $dr)
    {
        $isPembuat = (int)($dr->pembuat_id ?? 0) === (int)$user->id 
                 || (int)($dr->pembuat2_id ?? 0) === (int)$user->id;
        $reviewerIds = is_array($dr->reviewer_ids ?? null) ? $dr->reviewer_ids : (json_decode($dr->reviewer_ids ?? '[]', true) ?: []);
        $isReviewer = in_array($user->id, $reviewerIds);

        $isApproverM = (int) ($dr->approver_main_id ?? 0) === (int) $user->id;
        $supportIds  = (array) (is_array($dr->approver_support_ids)? $dr->approver_support_ids
            : (json_decode($dr->approver_support_ids ?? '[]', true) ?: []));
        $isApproverS = in_array((int)$user->id, array_map('intval', $supportIds));
        $isAdmin    = ($user->role ?? null) === 'admin';

        if (!$isPembuat && !$isReviewer && !$isApproverM && !$isApproverS && !$isAdmin) {
            abort(403);
        }
    }
    public function draftDetail(DokumenReview $dr,Request $r)
    {
        $this->authorizeView($r->user(), $dr);

        $dr->load(['pembuat', 'divisi', 'approvals.user']); 
        $userMap = \App\Models\User::whereIn(
            'id',
            collect($dr->reviewer_ids ?? [])->filter()
        )->pluck('nama_user', 'id');

        
        $meta = [
            'no_dr'            => $dr->dr_no,                 
            'no_dokumen'       => $dr->nomor_dokumen,
            'no_revisi'       => $dr->no_revisi,
            'judul_dokumen'    => $dr->nama_dokumen,
            'pembuat'          => optional($dr->pembuat)->nama_user,
            'tanggal_diedarkan'=> optional($dr->created_at)?->format('d/m/Y'),
            'keterangan'       => $dr->keterangan,
        ];

         //  Tambahan: ambil komentar anotasi dari database
        $annotations = PdfAnnotation::with(['user', 'images'])
            ->where('dokumen_review_id', $dr->id)
            ->orderBy('page')->orderBy('id')
            ->get();

        $isTerbit = ($dr->status_review === 'terbit') || !empty($dr->tanggal_terbit);

        return view('dokumen.draftDokumenRevw', compact('dr', 'userMap', 'meta','annotations','isTerbit'));
    }

    public function masterListDR()
    {
        
        $q = \App\Models\DokumenReview::with(['pembuat','pembuat2','divisi','approvals.user']);


        $dokumen = $q->paginate(12);

        // Siapkan userMap untuk menampilkan nama-nama Reviewer di view masterListDR
        $ids = collect($dokumen->items())
                ->flatMap(fn($d) => $d->reviewer_ids ?? [])
                ->filter()->unique()->values();

        $userMap = $ids->isNotEmpty()
            ? \App\Models\User::whereIn('id', $ids)->pluck('nama_user', 'id')
            : collect();
        
        return view('dokumen.masterListDR', compact('dokumen', 'userMap'));
    }

    public function publishDokumenDivisi(DokumenReview $dr)
    {
        
        if (!$dr->divisi_id) {
            return back()->with('danger', 'Dokumen ini belum memiliki divisi.');
        }
    
        return redirect()->route('dok.master.ckr.divisi', ['id' => $dr->divisi_id])
                         ->with('success', 'Dokumen berhasil dikirim ke Master List Divisi.');
    }

    public function publishDokumen(\Illuminate\Http\Request $r, DokumenReview $dr)
    {
        // Otorisasi (Tetap)
        $user = $r->user();
        abort_unless(
            ($user->role ?? null) === 'admin' 
            || (int)$dr->pembuat_id === (int)$user->id 
            || (int)$dr->pembuat2_id === (int)$user->id, 
            403, 
            'Anda tidak memiliki hak untuk menerbitkan dokumen ini.'
        );

        if (($dr->status_review === 'terbit') || !empty($dr->tanggal_terbit)) {
            return back()->with('info', 'Dokumen sudah berstatus TERBIT.');
        }
        
        $status = $dr->status; 
        abort_unless($status && $status->is_approved, 403, 'Dokumen belum fully approved oleh semua pihak terkait.');

        $dr->tanggal_terbit = now(); 
        $dr->status_review = 'terbit'; 
        // Otomatis samakan tanggal diterima doc control dengan tanggal terbit
        $dr->tanggal_diterima_dokumen_kontrol = $dr->tanggal_terbit;
        $dr->save(); 

         if ($dr->nomor_dokumen) {
            \App\Models\DokumenReview::where('nomor_dokumen', $dr->nomor_dokumen)
                ->where('id', '!=', $dr->id)
                ->where('status_review', 'terbit')
                ->update(['status_review' => 'revisi']);
        }
        return redirect()->route('dokumenReview.masterListDR')->with('success', 'Dokumen berhasil DITERBITKAN dan dimasukkan ke Master List.');
    }

    public function destroy(Request $request, DokumenReview $dr)
    {
        $filePaths = $dr->files()->pluck('path')->filter()->values()->all();
        DB::transaction(function () use ($dr) {
            $dr->delete();
        });
        foreach ($filePaths as $p) {
            try { Storage::disk(config('filesystems.default'))->delete($p); } catch (\Throwable $e) {}
        }

        return back()->with('success', 'Dokumen berhasil dihapus beserta seluruh data terkait.');
    }

    public function updateTanggal(DokumenReview $dr, Request $r)
    {
        $r->validate([
            'tanggal_penyelesaian' => 'nullable|date',
            'tanggal_diterima_dokumen_kontrol' => 'nullable|date',
        ]);

        $dr->tanggal_penyelesaian = $r->input('tanggal_penyelesaian');
        $dr->tanggal_diterima_dokumen_kontrol = $r->input('tanggal_diterima_dokumen_kontrol');
        $dr->save();

        return back()->with('success', 'Tanggal draft berhasil diperbarui.');
    }


    public function exportPdf(\App\Models\DokumenReview $dr)
    {
        
        $meta = [
            'no_dr'           => $dr->dr_no ?? null,
            'no_dokumen'      => $dr->nomor_dokumen ?? null,
            'no_revisi'      => $dr->no_revisi ?? null,
            'judul_dokumen'   => $dr->nama_dokumen ?? null,
            'pembuat'         => optional($dr->pembuat)->nama_user ?? optional($dr->pembuat)->name,
            'tanggal_diedarkan'=> optional($dr->created_at)->format('d/m/Y'),
            'keterangan'      => $dr->keterangan,
        ];
    
        $userMap = \App\Models\User::whereIn('id', $dr->reviewer_ids ?? [])
            ->pluck('nama_user','id')
            ->toArray();
    
        $annotations = $dr->annotations()->with('images')->latest()->get();
        $approvals = $dr->approvals ?? collect();
        $apprMain  = $approvals->where('kind','main')->first();
        $apprSupp  = $approvals->where('kind','support')->first();
    
        $approverSigDataUrl = $this->toDataUrl($apprMain);
        $supportSigDataUrl  = $this->toDataUrl($apprSupp);
    
        
        $revSigMap = [];
        foreach (($dr->reviewer_ids ?? []) as $uid) {
            $apprRev = $approvals->first(fn($a) => (int)$a->user_id === (int)$uid && ($a->kind ?? null) === 'reviewer');
            $revSigMap[$uid] = [
                'sig'     => $this->toDataUrl($apprRev),
                'date'    => optional($apprRev?->signed_at ?? $apprRev?->updated_at ?? $apprRev?->created_at)->format('d/m/Y'),
                'action'  => $apprRev ? (($apprRev->action ?? null) === 'approved' ? 'Ya' : 'Tidak') : '',
            ];
        }
    
        // Tanggal kembali otomatis 
        $mainAt = $apprMain?->signed_at ?? $apprMain?->updated_at ?? $apprMain?->created_at;
        $suppAt = $apprSupp?->signed_at ?? $apprSupp?->updated_at ?? $apprSupp?->created_at;
        $tanggalKembaliOtomatis = ($mainAt && $suppAt) ? max($mainAt, $suppAt) : null;

        $viewData = [
            'dr'                 => $dr,
            'meta'               => $meta,
            'userMap'            => $userMap,
            'annotations'        => $annotations,
            'revSigMap'          => $revSigMap,
            'approverSigDataUrl' => $approverSigDataUrl,
            'supportSigDataUrl'  => $supportSigDataUrl,
            'tanggalKembaliOtomatis' => $tanggalKembaliOtomatis,
            'totalHalaman'       => 1, // sementara
        ];

        // Render pertama untuk hitung total halaman
        $pdfTemp = Pdf::loadView('dokumen.PdfDr', $viewData)->setPaper('a4', 'portrait');
        $dompdf  = $pdfTemp->getDomPDF();
        $dompdf->render();
        $totalHalaman = $dompdf->getCanvas()->get_page_count();
    
        // Render kedua dengan total halaman yang benar
        $viewData['totalHalaman'] = $totalHalaman;
        $pdf = Pdf::loadView('dokumen.PdfDr', $viewData)->setPaper('a4', 'portrait');
        
        return $pdf->stream('Draft-Dokumen-Review-'.$dr->id.'.pdf'); // atau ->download(...)
    }
    public function pengajuanRevisi(DokumenReview $dr)
    {
        $userLogin      = auth()->user();
        $namaDivisiUser = $userLogin->divisi ?? null;

        $divisis = \App\Models\Divisi::where('nama_divisi', $namaDivisiUser)->get();
        if ($divisis->isEmpty()) {
            $divisis = \App\Models\Divisi::orderBy('nama_divisi')->get();
        }

        $jenisList = \App\Models\Dokumen::query()
            ->when($namaDivisiUser, function($query) use ($namaDivisiUser) {
                return $query->whereHas('divisi', function($q) use ($namaDivisiUser) {
                    $q->where('nama_divisi', $namaDivisiUser);
                });
            })
            ->select('nama_jenis')
            ->distinct()
            ->orderBy('nama_jenis')
            ->pluck('nama_jenis');

        // Hitung no revisi berikutnya dari dokumen yang dipilih
        $lastRevisi = \App\Models\DokumenReview::where('nomor_dokumen', $dr->nomor_dokumen)
            ->whereNotNull('no_revisi')
            ->where('status_review', 'terbit')
            ->pluck('no_revisi')
            ->map(fn($r) => (int) $r)
            ->max() ?? 0;

        $nextRevisi = str_pad($lastRevisi + 1, 2, '0', STR_PAD_LEFT);

        $users     = \App\Models\User::orderBy('nama_user')->get(['id','nama_user']);
        $reviewers = $users;

        return view('dokumen.pengajuanRevisi', compact(
            'users', 'divisis', 'jenisList', 'reviewers', 'dr', 'nextRevisi'
        ));
    }

    public function getNextNomor(Request $r)
    {
        $namaJenis = trim($r->query('nama_jenis', ''));
        $type      = $r->query('type', 'baru'); // 'baru' atau 'revisi'
        $nomorDok  = trim($r->query('nomor_dokumen', ''));

        if ($type === 'baru') {
            // Cari semua nomor_dokumen yang diawali nama_jenis
            $nomors = \App\Models\DokumenReview::where('nama_jenis', $namaJenis)
                ->whereNotNull('nomor_dokumen')
                ->pluck('nomor_dokumen');

            // Ambil angka paling belakang dari tiap nomor, cari yang terbesar
            $maxAngka = 0;
            foreach ($nomors as $nomor) {
                if (preg_match('/(\d+)$/', $nomor, $matches)) {
                    $angka = (int) $matches[1];
                    if ($angka > $maxAngka) {
                        $maxAngka = $angka;
                    }
                }
            }

            $nextAngka    = str_pad($maxAngka + 1, 2, '0', STR_PAD_LEFT);
            $nextNomor    = $namaJenis . $nextAngka;

            return response()->json([
                'nomor_dokumen' => $nextNomor,
                'no_revisi'     => '00',
            ]);
        }

        if ($type === 'revisi') {
            // Cari no_revisi terakhir berdasarkan nomor_dokumen yang dipilih
            $lastRevisi = \App\Models\DokumenReview::where('nomor_dokumen', $nomorDok)
                ->whereNotNull('no_revisi')
                ->where('status_review', 'terbit')
                ->pluck('no_revisi')
                ->map(fn($r) => (int) $r)
                ->max() ?? 0;

            $nextRevisi = str_pad($lastRevisi + 1, 2, '0', STR_PAD_LEFT);//Fungsi ini dipakai untuk memformat angka menjadi 2 digit dengan tambahan 0 di depan jika perlu.

            return response()->json([
                'nomor_dokumen' => $nomorDok,
                'no_revisi'     => $nextRevisi,
            ]);
        }

        return response()->json(['error' => 'Type tidak valid'], 422);
    }
    
    private function toDataUrl($approval)
    {
        if (!$approval) return null;
    
        // 1) Jika sudah data-url (misal hasil SignaturePad)
        if ($approval->signature_json && str_starts_with($approval->signature_json, 'data:image')) {
            return $approval->signature_json;
        }
    
        // 2) Jika ada path file (contoh storage/app/signatures/xxx.png)
        if ($approval->signature_path && Storage::exists($approval->signature_path)) {
            $mime = \Illuminate\Support\Facades\File::mimeType(Storage::path($approval->signature_path)) ?? 'image/png';
            $bin  = Storage::get($approval->signature_path);
            return 'data:'.$mime.';base64,'.base64_encode($bin);
        }
    
        // 3) Terakhir: coba ambil dari route image
        try {
            $url = route('approvals.signature', $approval->id);
            $res = Http::timeout(5)->get($url);
            if ($res->ok()) {
                // asumsikan image/png
                return 'data:image/png;base64,'.base64_encode($res->body());
            }
        } catch (\Throwable $e) {}
    
        return null;
    }   

    public function edit(DokumenReview $dr, Request $request)
    {
        // Otorisasi: pakai method yang sudah ada di controller
        $this->authorizeView($request->user(), $dr);
    
        $dr->load(['pembuat', 'pembuat2', 'divisi', 'approvals.user']);
    
        $users     = \App\Models\User::orderBy('nama_user')->get(['id', 'nama_user']);
        $reviewers = $users;
    
        return view('dokumen.editDokumenRevw', compact('dr', 'users', 'reviewers'));
    }

    public function update(Request $request, $id)
    {
      
        $dokumen = DokumenReview::findOrFail($id);

        // Validasi hanya field yang dikirim
        $validated = $request->validate([
            'alasan_revisi' => 'nullable|string|max:1000',
            'pembuat2_id'   => 'nullable|exists:user,id',
            'nama_dokumen'  => 'nullable|string|max:255',
            'reviewer_ids'  => 'nullable|array',
            'reviewer_ids.*' => 'nullable|integer',
            'draft_dokumen' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // ── Update field teks ──────────────────────────────────────
        if ($request->filled('alasan_revisi')) {
            $dokumen->alasan_revisi = $validated['alasan_revisi'];
        }

        if ($request->filled('pembuat2_id')) {
            $dokumen->pembuat2_id = $validated['pembuat2_id'];
        }

        if ($request->filled('nama_dokumen')) {
            $dokumen->nama_dokumen = $validated['nama_dokumen'];
        }

        // ── Update reviewer_ids (filter null/kosong) ───────────────
        if ($request->has('reviewer_ids')) {
            $reviewerIds = collect($request->input('reviewer_ids', []))  // ← pakai $request->input, bukan $validated
                ->filter()
                ->map(fn($v) => (int) $v)   // ← cast ke integer
                ->unique()
                ->values()
                ->toArray();
            $dokumen->reviewer_ids = $reviewerIds;
        }

        // ── Ganti file draft ───────────────────────────────────────
        if ($request->hasFile('draft_dokumen')) {
            // Hapus file lama jika ada
            if (!empty($dokumen->draft_path)) {
                Storage::disk('local')->delete($dokumen->draft_path);
            }
            $path = $request->file('draft_dokumen')->store('dokumen_draft');
            $dokumen->draft_path = $path;
        }

        $dokumen->save();

        // ── Siapkan response untuk update tampilan baris tabel ─────
        $pembuat     = $dokumen->pembuat2;
        $pembuatNama = optional($pembuat)->nama_user
                    ?? optional($pembuat)->name
                    ?? ('User#' . ($dokumen->pembuat2_id ?? '-'));

        $reviewerNames = collect($dokumen->reviewer_ids ?? [])
            ->filter()
            ->map(fn($rid) => optional(\App\Models\User::find($rid))->nama_user
                           ?? optional(\App\Models\User::find($rid))->name
                           ?? ('User#' . $rid))
            ->values()
            ->toArray();

        return redirect()->route('dokumenReview.index') ->with('success', 'Dokumen berhasil diperbarui.');
    }
     public function uploadFileFinal(Request $r, DokumenReview $dr)
    {
        // Hanya admin yang boleh upload file_final_dr
        abort_unless(($r->user()->role ?? null) === 'admin', 403, 'Hanya admin yang dapat mengunggah file final DR.');
 
        $r->validate([
            'file_final_dr' => 'required|file|mimes:pdf|max:20480',
        ], [
            'file_final_dr.required' => 'File PDF wajib dipilih.',
            'file_final_dr.mimes'    => 'File harus berformat PDF.',
            'file_final_dr.max'      => 'Ukuran file maksimal 20 MB.',
        ]);
 
        // Hapus file lama jika ada
        if (!empty($dr->file_final_dr) && Storage::disk('local')->exists($dr->file_final_dr)) {
            Storage::disk('local')->delete($dr->file_final_dr);
        }
 
        // Simpan file baru
        $path = $r->file('file_final_dr')->store('file_final_dr');
 
        $dr->file_final_dr = $path;
        // Otomatis isi tanggal_penyelesaian saat admin unggah file final
        $dr->tanggal_penyelesaian = now();
        $dr->save();
 
        return back()->with('success', 'File Final DR berhasil diunggah.');
    }

     public function streamFileFinal(Request $r, DokumenReview $dr)
    {
        $this->authorizeView($r->user(), $dr);
 
        abort_unless(
            !empty($dr->file_final_dr) && Storage::disk('local')->exists($dr->file_final_dr),
            404,
            'File Final DR belum tersedia.'
        );
 
        $fullPath = Storage::disk('local')->path($dr->file_final_dr);
        $name     = basename($dr->file_final_dr);
 
        return response()->file($fullPath, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $name . '"',
        ]);
    }
    
    public function destroyFileFinal(Request $r, DokumenReview $dr)
    {
        abort_unless(($r->user()->role ?? null) === 'admin', 403, 'Hanya admin yang dapat menghapus file final DR.');
 
        if (!empty($dr->file_final_dr) && Storage::disk('local')->exists($dr->file_final_dr)) {
            Storage::disk('local')->delete($dr->file_final_dr);
        }
 
        $dr->file_final_dr = null;
        $dr->save();
 
        if ($r->expectsJson() || $r->ajax()) {
            return response()->json(['ok' => true]);
        }
 
        return back()->with('success', 'File Final DR berhasil dihapus.');
    }

}
