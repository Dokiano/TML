<?php

namespace App\Http\Controllers;

use App\Models\LaporanAudit;
use App\Models\Temuan;
use App\Models\TemuanEvidence;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\File;            


class LaporanAuditController extends Controller
{
   public function createLa()
    {

        $users = DB::table('user')
            ->orderBy('nama_user')
            ->get(['id','nama_user']);
        $reviewers = $users;
        $divisis = DB::table('divisi')->orderBy('nama_divisi')->get(['id','nama_divisi']);
        $statusPpk = DB :: table('status')->orderBy('nama_statusppk')->pluck('nama_statusppk','id');

        return view('ppk.createLa', compact('users','reviewers','statusPpk','divisis'));
    }
    
    public function index(Request $request)
    {
        $laporans = LaporanAudit::query()
            ->select('id','nomor_dokumen','divisi_id','created_at','lead_auditor_id', 'auditor_ids', 'auditee_ids') // <-- Tambah kolom IDs
            ->when($request->keyword, fn($q) =>
                $q->where('nomor_dokumen', 'like', '%'.$request->keyword.'%'))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        
        $allAuditorIds = $laporans->pluck('auditor_ids')->flatten()->filter()->unique()->toArray();
        $allAuditeeIds = $laporans->pluck('auditee_ids')->flatten()->filter()->unique()->toArray();
        $allUserIds = array_unique(array_merge($allAuditorIds, $allAuditeeIds));

        $userMap = DB::table('user')
            ->whereIn('id', $allUserIds)
            ->pluck('nama_user', 'id');

       
        $laporans->each(function($laporan) use ($userMap) {
            $auditorIds = (array) ($laporan->auditor_ids ?? []);
            $auditeeIds = (array) ($laporan->auditee_ids ?? []);

            $laporan->auditors_nama = collect($auditorIds)
                ->map(fn($uid) => $userMap[$uid] ?? 'User#'.$uid)
                ->filter()
                ->implode(', ');

            $laporan->auditees_nama = collect($auditeeIds)
                ->map(fn($uid) => $userMap[$uid] ?? 'User#'.$uid)
                ->filter()
                ->implode(', ');
        });

      
        return view('ppk.LaDashboard', compact('laporans')); 
    }
    public function destroy(LaporanAudit $laporan)
    {
        DB::transaction(function () use ($laporan) {
            // Ambil semua temuan + evidences
            $temuan = Temuan::with('evidences')
                ->where('laporan_id', $laporan->id)
                ->get();
        
            // Hapus file evidence di storage/public
            foreach ($temuan as $t) {
                foreach ($t->evidences as $ev) {
                    if (!empty($ev->file_path)) {
                        Storage::disk('public')->delete($ev->file_path);
                    }
                }
            }
        
            // Hapus record evidences & temuan
            TemuanEvidence::whereIn('temuan_id', $temuan->pluck('id'))->delete();
            Temuan::where('laporan_id', $laporan->id)->delete();
        
            // Terakhir: hapus header laporan
            $laporan->delete();
        });
    
        return back()->with('success', 'Laporan dan seluruh temuan/evidence berhasil dihapus.');
    }
    public function show($id)
    {
        $laporan = LaporanAudit::with([
            'leadAuditor:id,nama_user',
            'divisi:id,nama_divisi',
            'temuan' => fn($q) => $q->orderBy('order_index'),
            'temuan.evidences' => fn($q) => $q->orderBy('order_index'),
        ])->findOrFail($id);
        $statusMap = DB::table('status')->pluck('nama_statusppk', 'id');
        $temuan = Temuan::with(['evidences' => fn($q)=>$q->orderBy('order_index')])
        ->where('laporan_id', $laporan->id)
        ->orderBy('order_index')
        ->get();
        $auditorIds = (array) ($laporan->auditor_ids ?? []);
        $auditeeIds = (array) ($laporan->auditee_ids ?? []);
        $userMap = DB::table('user')
            ->whereIn('id', array_unique(array_merge($auditorIds, $auditeeIds)))
            ->pluck('nama_user', 'id');

        $auditors = collect($auditorIds)->map(fn($uid) => $userMap[$uid] ?? 'User#'.$uid)->filter()->values();
        $auditees = collect($auditeeIds)->map(fn($uid) => $userMap[$uid] ?? 'User#'.$uid)->filter()->values();

        return view('ppk.LaReview', compact('laporan', 'temuan','auditors', 'auditees', 'statusMap'));
    }


    public function store(Request $request)
    {
        // === 1) VALIDASI SESUAI INPUT DI createLa.blade ===
        $rules = [
            'nomor_dokumen'      => ['required','string','max:190', Rule::unique('laporan_audits','nomor_dokumen')],
            'pembuat2_id'        => ['nullable','exists:user,id'],         
            'auditor_ids'        => ['nullable','array'],
            'auditor_ids.*'      => ['nullable','exists:user,id'],
            'auditee_ids'        => ['nullable','array'],
            'auditee_ids.*'      => ['nullable','exists:user,id'],
            'divisi_id'          => ['required','exists:divisi,id'],

            // Temuan
            'temuan'                         => ['required','array','min:1'],
            'temuan.*.deskripsi'             => ['required','string'],
            'temuan.*.referensi'             => ['nullable','string'],
            'temuan.*.status'                => ['required','integer','exists:status,id'],
            'temuan.*.evidence'              => ['required','array','min:1'],

            // Evidence (per baris: file + desc)
            'temuan.*.evidence.*.file'       => ['required','file','mimes:jpg,jpeg,png,pdf','max:20480'], // 20MB
            'temuan.*.evidence.*.desc'       => ['required','string','max:1000'],
        ];
        $messages = [
            'nomor_dokumen.required' => 'Nomor dokumen wajib diisi.',
            'temuan.required'        => 'Minimal satu temuan.',
            'temuan.*.status.required' => 'Status temuan wajib dipilih.',
            'temuan.*.evidence.required' => 'Minimal satu evidence per temuan.',
            'temuan.*.evidence.*.file.required' => 'File evidence wajib diunggah.',
            'temuan.*.evidence.*.desc.required' => 'Deskripsi evidence wajib diisi.',
        ];
        $data = $request->validate($rules, $messages);

        // Normalisasi array ID (hapus null/duplikat)
        $auditorIds = array_values(array_unique(array_filter($data['auditor_ids'] ?? [], fn($v) => filled($v))));
        $auditeeIds = array_values(array_unique(array_filter($data['auditee_ids'] ?? [], fn($v) => filled($v))));

        // === 2) SIMPAN DALAM TRANSAKSI ===
        DB::transaction(function () use ($data, $auditorIds, $auditeeIds) {
            // 2a. Simpan header laporan
            $laporan = LaporanAudit::create([
                'nomor_dokumen'   => $data['nomor_dokumen'],
                'lead_auditor_id' => $data['pembuat2_id'] ?? null,   // name="pembuat2_id" di form
                'auditor_ids'     => $auditorIds,
                'auditee_ids'     => $auditeeIds,
                'divisi_id'       => $data['divisi_id'],
            ]);
            
            // 2b. Simpan tiap temuan
            foreach ($data['temuan'] as $i => $t) {
                $temuan = Temuan::create([
                    'laporan_id'  => $laporan->id,
                    'deskripsi'   => $t['deskripsi'],
                    'referensi'   => $t['referensi'] ?? null,
                    'status' => is_array($t['status']) ? ($t['status'][0] ?? null) : $t['status'],
                    'order_index' => $i,
                ]);

                // 2c. Simpan tiap evidence (file + desc)
                foreach ($t['evidence'] as $j => $ev) {
                    $file    = $ev['file'];
                    $path    = $file->store('evidence', 'public'); // storage/app/public/evidence
                    TemuanEvidence::create([
                        'temuan_id'   => $temuan->id,
                        'file_path'   => $path,
                        'mime_type'   => $file->getClientMimeType(),
                        'desc'        => $ev['desc'],
                        'order_index' => $j,
                    ]);
                }
            }
        });

        if (!Storage::disk('public')->exists('evidence')) {
            Storage::disk('public')->makeDirectory('evidence');
        }

        return redirect()->route('laporan.index')->with('success', 'Laporan audit berhasil disimpan.');
    }

    public function showEvidence(TemuanEvidence $evidence)
    {
        $disk = Storage::disk('public');
    
        abort_unless($disk->exists($evidence->file_path), 404);
    
        $path = $disk->path($evidence->file_path);
    
        return response()->file($path, [
            'Content-Type' => $evidence->mime_type ?: File::mimeType($path),
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }


        public function patchTemuan(Request $request, Temuan $temuan)
    {
        
        $field = $request->string('field')->toString();  
        $value = $request->input('value');

        // Validasi dinamis
        $rules = match ($field) {
            'deskripsi' => ['required','string'],
            'referensi' => ['nullable','string'],
            'status'    => ['required','integer', Rule::exists('status','id')],
            default     => ['prohibited']
        };
        $request->validate(['value' => $rules]);

        $temuan->update([$field => $value]);

        // balikan nama status jika field status
        if ($field === 'status') {
            $nama = DB::table('status')->where('id',(int)$value)->value('nama_statusppk');
            return response()->json(['ok'=>true,'field'=>$field,'value'=>$value,'label'=>$nama]);
        }
        return response()->json(['ok'=>true,'field'=>$field,'value'=>$value]);
    }

   public function storeSignatures(Request $request, LaporanAudit $laporanAudit)
    {
        $data = $request->validate([
            'tgl_ttd_lead'    => 'nullable|date',
            'tgl_ttd_auditee' => 'nullable|date',
            'lembar_ke'       => 'nullable|integer|min:1',
            'sign_lead'       => 'required|string',
            'sign_auditee'    => 'required|string',
        ]);
    
        $saveDataUrl = function(string $dataUrl, string $prefix) use ($laporanAudit) {
            if (!str_contains($dataUrl, ',')) abort(422, 'Data tanda tangan tidak valid');
            [$meta, $base64] = explode(',', $dataUrl, 2);
            $bin = base64_decode($base64);
            if ($bin === false) abort(422, 'Base64 decode gagal');
            $filename = sprintf('%s-laporaudit-%d-%d.png', $prefix, $laporanAudit->id, time());
            $path = "signatures/{$filename}";
            Storage::disk('public')->put($path, $bin);
            return $path;
        };
    
        $leadPath = $saveDataUrl($data['sign_lead'], 'lead');
        $auditeePath = $saveDataUrl($data['sign_auditee'], 'auditee');
    
        $laporanAudit->update([
            'tgl_ttd_lead'     => $data['tgl_ttd_lead'] ?? null,
            'tgl_ttd_auditee'  => $data['tgl_ttd_auditee'] ?? null,
            'lembar_ke'        => $data['lembar_ke'] ?? null,
            'ttd_lead_path'    => $leadPath,
            'ttd_auditee_path' => $auditeePath,
        ]);
    
        return response()->json([
            'ok' => true,
            'message' => 'Tanda tangan tersimpan',
            'lead_url' => $laporanAudit->ttd_lead_path ? asset('storage/'.$laporanAudit->ttd_lead_path) : null,
            'auditee_url' => $laporanAudit->ttd_auditee_path ? asset('storage/'.$laporanAudit->ttd_auditee_path) : null,
        ]);
    }

    public function showSignature(string $filename)
    {
        $filePath = 'signatures/' . $filename;
        $disk = Storage::disk('public');
        abort_unless($disk->exists($filePath), 404, 'Tanda Tangan tidak ditemukan.');
        $path = $disk->path($filePath);
        $mimeType = File::mimeType($path);
    
        // Kembalikan file dengan header yang benar
        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000', // Cache 1 tahun /// di apus atau tidak
        ]);
    }
}
