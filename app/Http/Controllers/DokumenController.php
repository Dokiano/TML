<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Dokumen;
use App\Models\Divisi;
use App\Models\DraftMasterlistDivisi;
use App\Exports\DraftMasterListExport;
use Maatwebsite\Excel\Facades\Excel;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $q = Dokumen::with('divisi');

        if ($request->filled('keyword')) {
            $q->where('nama_jenis', 'like', '%'.$request->keyword.'%');
        }
        if ($request->filled('divisi_id')) {
            $q->where('divisi_id', $request->divisi_id);
        }
        //urutkan by id
        $q->orderBy('id','asc');

        $dokumens = $q->get();//->appends($request->only('keyword','divisi_id'));
        $divisis  = Divisi::orderBy('nama_divisi')->get();

        return view('dokumen.index', compact('dokumens','divisis'));
    }
     public function create()
    {
        $divisis = Divisi::orderBy('nama_divisi')->get();
        return view('dokumen.create', compact('divisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => ['required','string','max:100',
                Rule::unique('dokumen','nama_jenis')
                    ->where(fn($q)=>$q->where('divisi_id',$request->divisi_id))
            ],
            'divisi_id'  => ['required','exists:divisi,id'],
        ], [
            'nama_jenis.unique' => 'Kombinasi jenis & divisi sudah ada.',
        ]);

        Dokumen::create($request->only('nama_jenis','divisi_id'));
        return redirect()->route('dokumen.index')->with('success','Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $divisis = Divisi::orderBy('nama_divisi')->get();
        return view('dokumen.edit', compact('dokumen','divisis'));
    }

    public function update(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $request->validate([
            'pembuat_id'   => ['required','exists:users,id'],
            'nama_jenis'   => ['required','string','max:100',
                Rule::unique('dokumen','nama_jenis')
                    ->where(fn($q)=>$q->where('divisi_id',$request->divisi_id))
                    ->ignore($dokumen->id, 'id')
            ],
            'divisi_id'  => ['required','exists:divisi,id'],
        ], [
            'nama_jenis.unique' => 'Kombinasi jenis & divisi sudah ada.',
        ]);

        $dokumen->update($request->only('nama_jenis','divisi_id'));
        return redirect()->route('dokumen.index')->with('success','Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Dokumen::findOrFail($id)->delete();
        return redirect()->route('dokumen.index')->with('success','Data berhasil dihapus.');
    }
    
    public function pengajuanDok()
    {
        $userLogin = auth()->user();
        $namaDivisiUser = $userLogin->divisi ?? null;

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

        $divisis = \App\Models\Divisi::where('nama_divisi', $namaDivisiUser)->get();
        if ($divisis->isEmpty()) {
            $divisis = \App\Models\Divisi::orderBy('nama_divisi')->get();
        }

        $users     = \App\Models\User::orderBy('nama_user')->get(['id','nama_user']);
        $reviewers = $users;

        // ✅ Hardcode ID user yang otomatis terpilih di "Mendukung"
        $defaultSupportIds = [27]; // <-- ganti dengan ID yang diinginkan

        $supportUsers = \App\Models\User::whereIn('id', $defaultSupportIds)
                            ->orderBy('nama_user')
                            ->get(['id','nama_user']);

        return view('dokumen.pengajuanDok', compact(
            'users', 'divisis', 'jenisList', 'reviewers', 'supportUsers'
        ));
    }
    public function dashboardDok()
    {
        return view('dokumen.DashboardDok'); // pakai view yang sudah kamu buat
    }

    public function masterListCKR()
    {
        $divisis = \App\Models\Divisi::orderBy('nama_divisi')->get();

        return view('dokumen.masterList', [
            'divisis'         => $divisis,
            'title'           => 'Master List Dokumen – Cikarang',
            'routeDivisiName' => 'dok.master.ckr.divisi',
            'userDivisiId'    => (int) Divisi::where('nama_divisi', auth()->user()->divisi)->value('id')
        ]);
    }
    public function masterListHO()
    {
        $divisis = \App\Models\Divisi::orderBy('nama_divisi')->get();

        return view('dokumen.masterList3', [
            'divisis'         => $divisis,
            'title'           => 'Master List Dokumen – HO',
            'routeDivisiName' => 'dok.master.ho.divisi',
            'userDivisiId'    => (int) Divisi::where('nama_divisi', auth()->user()->divisi)->value('id')
        ]);
    }

    public function masterListSDG()
    {
        $divisis = \App\Models\Divisi::orderBy('nama_divisi')->get();

        return view('dokumen.masterList2', [
            'divisis'         => $divisis,
            'title'           => 'Master List Dokumen – Sadang',
            'routeDivisiName' => 'dok.master.sdg.divisi',
            'userDivisiId'    => (int) Divisi::where('nama_divisi', auth()->user()->divisi)->value('id')
        ]);
    }
     public function masterListDivisi($id)
    {
        $divisi = \App\Models\Divisi::findOrFail($id);

        $dokumens = \App\Models\DokumenReview::where(function($q) use ($id) {
            $q->where('divisi_id', $id)
              ->orWhereIn('nama_jenis', function($sub) use ($id) {
                  $sub->select('nama_jenis')
                      ->from('dokumen')
                      ->where('divisi_id', $id);
              });
        })
        ->where('status_review', 'terbit')
        ->with('files')
        ->orderBy('dr_no')
        ->get();

        return view('dokumen.masterListDivisi', compact('divisi', 'dokumens'));
    }

   public function draftmasterListDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);
    
        // Filter jenisList hanya untuk divisi ini saja
        $jenisList = Dokumen::where('divisi_id', $id)
            ->select('nama_jenis')
            ->distinct()
            ->orderBy('nama_jenis')
            ->pluck('nama_jenis');
    
        $activeJenis = request('jenis', 'ALL');
    
        $query = \App\Models\DokumenReview::where(function($q) use ($id) {
            $q->where('divisi_id', $id)
              ->orWhereIn('nama_jenis', function($sub) use ($id) {
                  $sub->select('nama_jenis')
                      ->from('dokumen')
                      ->where('divisi_id', $id);
              });
        })
        ->where('status_review', 'revisi')
        ->with('files')
        ->orderBy('nomor_dokumen')
        ->orderBy('no_revisi');
    
        // Terapkan filter jenis jika bukan ALL
        if ($activeJenis !== 'ALL') {
            $query->where('nama_jenis', $activeJenis);
        }
    
        $dokumens = $query->paginate(10)->withQueryString();
    
        return view('dokumen.draftmasterListDivisi', [
            'divisi'      => $divisi,
            'divisiId'    => $divisi->id,
            'dokumens'    => $dokumens,
            'jenisList'   => $jenisList,
            'activeJenis' => $activeJenis,
        ]);
    }

    public function exportExcelDraftDivisi($id)
    {
        $divisi      = \App\Models\Divisi::findOrFail($id);
        $activeJenis = request('jenis', 'ALL');
    
        $filename = 'MasterList-' . \Illuminate\Support\Str::slug($divisi->nama_divisi)
                  . ($activeJenis !== 'ALL' ? '-' . Str::slug($activeJenis) : '')
                  . '-' . now()->format('Ymd')
                  . '.xlsx';
    
        return Excel::download(new DraftMasterListExport($divisi, $activeJenis), $filename);
    }


}
