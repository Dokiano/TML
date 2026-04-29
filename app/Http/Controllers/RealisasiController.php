<?php

namespace App\Http\Controllers;

use Svg\Tag\Rect;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Resiko;
use App\Models\Tindakan;
use App\Models\Realisasi;
use App\Models\Riskregister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealisasiController extends Controller
{
    public function index($id)
    {
        // Ambil data tindakan berdasarkan ID
        $form = Tindakan::with('riskregister')->findOrFail($id);
     
        $realisasiList = Realisasi::where('id_tindakan', $id)->get();
        $tindak = $form->nama_tindakan; // Mengambil langsung dari $form

        // Ambil targetpic (user_id) dan nama_user
        $targetpicId = $form->targetpic;
        $pic = User::where('id', $targetpicId)->value('nama_user'); // Mengambil nama_user berdasarkan user_id dari targetpic

        // Format deadline
        $deadline = Carbon::parse($form->tgl_penyelesaian)->format('d-m-Y');

        // Ambil id_divisi dari tabel Riskregister berdasarkan id_tindakan
        $riskregister = Riskregister::where('id', $form->id_riskregister)->first();
        $divisi = $riskregister->id_divisi;

        // Ambil semua user yang berada dalam divisi yang sama
        $usersInDivisi = User::orderBy('nama_user', 'asc')->get();

        // Return view dengan data yang relevan
        return view('realisasi.index', compact('form', 'realisasiList', 'usersInDivisi', 'divisi', 'id', 'tindak', 'pic', 'deadline'));
    }


    public function edit($id)
    {
        // Ambil data realisasi yang ingin diedit
        $realisasi = Realisasi::findOrFail($id);

        // Ambil tindakan yang terkait sebagai informasi tambahan
        $tindakan = Tindakan::findOrFail($realisasi->id_tindakan);

        // Ambil nama tindakan dan PIC dari tindakan
        $tindak = $tindakan->nama_tindakan;
        $pic = $tindakan->targetpic;

        // Ambil semua realisasi yang terkait dengan id_tindakan
        $realisasiList = Realisasi::where('id_tindakan', $realisasi->id_tindakan)->get();

        return view('realisasi.edit', compact('realisasi', 'tindakan', 'tindak', 'realisasiList'));
    }


    public function store(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'id_tindakan' => 'required|exists:tindakan,id',
            'nama_realisasi.*' => 'nullable|string|max:255',
            'tgl_realisasi.*' => 'nullable|date',
            'target.*' => 'nullable|string|max:255',
            'desc.*' => 'nullable|string',
            'presentase.*' => 'nullable|numeric|min:0|max:100',
            'status' => 'nullable|in:ON PROGRES,CLOSE',
        ]);

        // Ambil id_riskregister dari tindakan
        $id_riskregister = Tindakan::where('id', $validated['id_tindakan'])->value('id_riskregister');

        if (!empty($validated['nama_realisasi'])) {
            foreach ($validated['tgl_realisasi'] as $key => $tgl_realisasi) {
                // Simpan realisasi
                $realisasi = Realisasi::create([
                    'id_tindakan' => $validated['id_tindakan'],
                    'id_riskregister' => $id_riskregister,
                    'status' => $validated['status'] ?? null,
                    'nama_realisasi' => $validated['nama_realisasi'][$key],
                    'tgl_realisasi' => $tgl_realisasi ?? null ,
                    'target' => $validated['target'][$key] ?? null,
                    'desc' => $validated['desc'][$key] ?? null,
                    'presentase' => $validated['presentase'][$key] ?? null,
                    'nilai_akhir' => $validated['presentase'][$key] ?? null, // Simpan nilai akhir di realisasi
                ]);
            }
        }

        // Hitung total persentase dan jumlah aktivitas
        $realisasiList = Realisasi::where('id_tindakan', $validated['id_tindakan'])->get();
        $totalPresentase = $realisasiList->sum('presentase');
        $jumlahActivity = $realisasiList->count();

        // Menghitung nilai rata-rata persentase
        $nilaiAkhir = $jumlahActivity > 0 ? round($totalPresentase / $jumlahActivity, 2) : 0;

        // Simpan nilai akhir ke tabel realisasi terbaru
        Realisasi::where('id_tindakan', $validated['id_tindakan'])
            ->update(['nilai_akhir' => $nilaiAkhir]);  // Update nilai_akhir di setiap realisasi

        // Hitung nilai_actual keseluruhan untuk id_riskregister yang sama
        $nilaiActual = Realisasi::where('id_riskregister', $id_riskregister)->sum('nilai_akhir');
        $jumlahTindakan = Realisasi::where('id_riskregister', $id_riskregister)->count('id_tindakan');

        // Menghitung rata-rata nilai_actual
        $rataNilaiActual = $jumlahTindakan > 0 ? round($nilaiActual / $jumlahTindakan, 2) : 0;

        // Update nilai_actual di realisasi terbaru
        Realisasi::where('id_tindakan', $validated['id_tindakan'])
            ->update(['nilai_actual' => $rataNilaiActual]);

        // Update status di tabel resiko jika ada
        if (isset($validated['status'])) {
            $resiko = Resiko::where('id', $id_riskregister)->first();
            if ($resiko) {
                $resiko->status = $validated['status']; // Ambil status dari input form
                $resiko->save();
            }

            // Cek apakah ada status yang bukan 'CLOSE' untuk id_riskregister yang sama
            $hasOpenStatus = Realisasi::where('id_riskregister', $id_riskregister)
                ->where('status', '!=', 'CLOSE')
                ->exists();

            // Jika tidak ada status selain CLOSE, update status di tabel resiko menjadi 'CLOSE'
            if (!$hasOpenStatus) {
                $resiko->status = 'CLOSE';
            } else {
                $resiko->status = 'ON PROGRES';
            }
            $resiko->save();
        }

        return redirect()->route('realisasi.index', ['id' => $validated['id_tindakan']])
            ->with('success', 'Activity berhasil ditambahkan!.✅');
    }

    public function update(Request $request, $id)
{

    // 1) Validasi input, termasuk attachments baru dan daftar path yang akan dihapus
    $validated = $request->validate([
        'nama_realisasi'        => 'nullable|string|max:255',
        'tgl_realisasi'         => 'nullable|date',
        'target'                => 'nullable|string|max:255',
        'desc'                  => 'nullable|string',
        'presentase'            => 'nullable|numeric|min:0|max:100',
        'status'                => 'nullable|in:ON PROGRES,CLOSE',
        'delete_attachments'    => 'nullable|array',
        'delete_attachments.*'  => 'string',
        'attachments.*'         => 'file|mimes:jpg,jpeg,png,pdf,xls,xlsx|max:5120',
    ]);

    // 2) Cari record
    $realisasi = Realisasi::findOrFail($id);

    // 3) Update field dasar
    $realisasi->nama_realisasi  = $validated['nama_realisasi']  ?? $realisasi->nama_realisasi;
    $realisasi->target           = $validated['target']           ?? $realisasi->target;
    $realisasi->desc             = $validated['desc']             ?? $realisasi->desc;
    $realisasi->tgl_realisasi    = $validated['tgl_realisasi']    ?? $realisasi->tgl_realisasi;
    $realisasi->presentase       = $validated['presentase']       ?? $realisasi->presentase;
    if (isset($validated['status'])) {
        $realisasi->status = $validated['status'];
    }

    // 4) Ambil array path lama dari kolom JSON
    $existing = $realisasi->evidencerealisasi ?? [];

    // 5) Hapus file & path yang dicentang user
    foreach ($validated['delete_attachments'] ?? [] as $delPath) {
        if (Storage::disk('public')->exists($delPath)) {
            Storage::disk('public')->delete($delPath);
        }
        if (($idx = array_search($delPath, $existing)) !== false) {
            unset($existing[$idx]);
        }
    }
    $existing = array_values($existing);

    // 6) Simpan upload baru (attachments[])
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $path = $file->store('realisasi-attachments', 'public');
            $existing[] = $path;
        }
    }

    // 7) Tulis kembali ke kolom JSON
    $realisasi->evidencerealisasi = $existing;

    // 8) Simpan perubahan
    $realisasi->save();

    // 9) Jika status CLOSE, tutup semua realisasi di id_tindakan yang sama
    if ($realisasi->status === 'CLOSE') {
        Realisasi::where('id_tindakan', $realisasi->id_tindakan)
            ->update(['status' => 'CLOSE']);
    }

    // 10) Update status Resiko
    $hasOpen = Realisasi::where('id_tindakan', $realisasi->id_tindakan)
                        ->where('status', '!=', 'CLOSE')
                        ->exists();
    $statusResiko = $hasOpen ? 'ON PROGRES' : 'CLOSE';
    if ($resiko = Resiko::find($realisasi->id_riskregister)) {
        $resiko->status = $statusResiko;
        $resiko->save();
    }

    // 11) Hitung nilai_akhir per tindakan
    $list = Realisasi::where('id_tindakan', $realisasi->id_tindakan)->get();
    $avg  = $list->count()
          ? round($list->sum('presentase') / $list->count(), 2)
          : 0;
    Realisasi::where('id_tindakan', $realisasi->id_tindakan)
        ->update(['nilai_akhir' => $avg]);

    // 12) Hitung nilai_actual per riskregister
    $all  = Realisasi::where('id_riskregister', $realisasi->id_riskregister)->get();
    $rata = $all->count()
          ? round($all->sum('nilai_akhir') / $all->count('id_tindakan'), 2)
          : 0;
    Realisasi::where('id_riskregister', $realisasi->id_riskregister)
        ->update(['nilai_actual' => $rata]);

    // 13) Redirect kembali dengan pesan sukses
    return redirect()
        ->route('realisasi.index', ['id' => $realisasi->id_tindakan])
        ->with('success', 'Activity berhasil diperbarui! ✅');
}

    public function getDetail($id)
    {
        // Mengambil data track record berdasarkan ID
        $details = Realisasi::where('id_tindakan', $id)->get(['nama_realisasi', 'tgl_penyelesaian']);
        return response()->json($details);
    }

    public function destroy($id)
    {
        // Temukan realisasi berdasarkan ID
        $realisasi = Realisasi::findOrFail($id);

        // Ambil id_tindakan sebelum menghapus
        $id_tindakan = $realisasi->id_tindakan;

        // Hapus realisasi
        $realisasi->delete();

        // Update nilai_akhir dan nilai_actual setelah penghapusan
        $realisasiList = Realisasi::where('id_tindakan', $id_tindakan)->get();
        $totalPresentase = $realisasiList->sum('presentase');
        $jumlahActivity = $realisasiList->count();

        $nilaiAkhir = $jumlahActivity > 0 ? round($totalPresentase / $jumlahActivity, 2) : 0;

        // Simpan nilai akhir di tabel realisasi untuk id_tindakan
        Realisasi::where('id_tindakan', $id_tindakan)
            ->update(['nilai_akhir' => $nilaiAkhir]);

        // Hitung nilai_actual keseluruhan untuk id_riskregister yang sama
        $id_riskregister = $realisasi->id_riskregister;
        $nilaiActual = Realisasi::where('id_riskregister', $id_riskregister)->sum('nilai_akhir');
        $jumlahTindakan = Realisasi::where('id_riskregister', $id_riskregister)->count('id_tindakan');

        // Menghitung rata-rata nilai_actual
        $rataNilaiActual = $jumlahTindakan > 0 ? round($nilaiActual / $jumlahTindakan, 2) : 0;

        // Update nilai_actual di tabel realisasi untuk id_riskregister yang sama
        Realisasi::where('id_riskregister', $id_riskregister)
            ->update(['nilai_actual' => $rataNilaiActual]);

        return redirect()->route('realisasi.index', ['id' => $id_tindakan])
            ->with('success', 'Activity berhasil dihapus!.✅');
    }

    public function updateStatusByTindakan(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:ON PROGRES,CLOSE',
    ]);
    

    // Update semua realisasi dengan id_tindakan ini
    Realisasi::where('id_tindakan', $id)
        ->update(['status' => $request->status]);

    // Jika status CLOSE, cek tindakan lain dalam riskregister yang sama
    if ($request->status === 'CLOSE') {
        $tindakan = Tindakan::findOrFail($id);
        $id_riskregister = $tindakan->id_riskregister;

        // Cari tindakan lain yang belum CLOSE dalam riskregister yang sama
        $tindakanLain = Tindakan::where('id_riskregister', $id_riskregister)
            ->where('id', '!=', $id)
            ->whereHas('realisasi', function ($q) {
                $q->where('status', '!=', 'CLOSE');
            })
            ->first();

        if ($tindakanLain) {
            // Ada tindakan lain yang belum close → redirect ke sana
            return redirect()
                ->route('realisasi.index', ['id' => $tindakanLain->id])
                ->with('success', 'Status diupdate. Lanjutkan tindakan berikutnya! ✅');
        }
    }

    // Tidak ada tindakan lain / status bukan CLOSE → pakai redirect_to atau back
    $redirectTo = $request->input('redirect_to');
    if ($redirectTo) {
        return redirect($redirectTo)->with('success', 'Status berhasil diupdate. ✅');
    }

    return back()->with('success', 'Status berhasil diupdate. ✅');
}


    public function updateBatch(Request $request, $riskregisterId)
    {
        // 1. Validasi input
        $request->validate([
            'tindakan.*'             => 'required|string|max:255',
            'targetpic.*'            => 'required|exists:user,id',
            'tgl_penyelesaian.*'     => 'required|date',
            'hapus.*'                => 'nullable|boolean',
            'tindakan_new.*'         => 'nullable|string|max:255',
            'targetpic_new.*'        => 'nullable|exists:user,id',
            'tgl_penyelesaian_new.*' => 'nullable|date',
        ]);

        // 2. Proses tindakan yang sudah ada
        $existing = $request->input('tindakan', []);
        foreach ($existing as $tindakanId => $namaTindakan) {
            // jika dicentang hapus, destroy
            if ($request->input("hapus.$tindakanId")) {
                Tindakan::destroy($tindakanId);
                continue;
            }
            // update record
            $t = Tindakan::find($tindakanId);
            if ($t) {
                $t->nama_tindakan    = $namaTindakan;
                $t->tgl_penyelesaian = Carbon::parse(
                    $request->input("tgl_penyelesaian.$tindakanId")
                )->format('Y-m-d');
                $t->targetpic          = $request->input("targetpic.$tindakanId");
                $t->acuan            = $request->input("acuan.$tindakanId");
                $t->save();
            }
        }

        // 3. Buat tindakan baru jika ada
        $newTindakan = $request->input('tindakan_new', []);
        foreach ($newTindakan as $key => $namaBaru) {
            if (trim($namaBaru) === '') {
                continue;
            }
             $newT = Tindakan::create([
                'id_riskregister'   => $riskregisterId,
                'nama_tindakan'     => $namaBaru,
                'tgl_penyelesaian'  => Carbon::parse(
                    $request->input("tgl_penyelesaian_new.$key")
                )->format('Y-m-d'),
                'targetpic'           => $request->input("targetpic_new.$key"),
                'acuan'             => $request->input("acuan_new.$key"),
            ]);
            Realisasi::create([
                'id_riskregister' => $riskregisterId,
                'id_tindakan'     => $newT->id,
                'nama_realisasi'  => null,
                'presentase'      => 0,
                'status'          => 'ON PROGRES',
            ]);
        }

        return back()->with('success', 'Tindakan lanjutan berhasil diperbarui.');
    }
}
