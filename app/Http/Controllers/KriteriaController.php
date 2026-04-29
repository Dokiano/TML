<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Resiko;
use App\Models\Divisi;
use App\Models\JenisIso;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $divisiId   = $request->get('divisi_id');
        $jenisIsoId = $request->get('jenis_iso_id');
        $kriteria   = collect();

        if ($divisiId && $jenisIsoId) {
            $q = Kriteria::query()->where('divisi_id', (int) $divisiId);

            // Jika ISO 9001 (id=1), ambil yang jenis_iso_id = 1 ATAU null (data lama)
            if ((int) $jenisIsoId === 1) {
                $q->where(function ($query) {
                    $query->where('jenis_iso_id', 1)
                          ->orWhereNull('jenis_iso_id');
                });
            } else {
                $q->where('jenis_iso_id', (int) $jenisIsoId);
            }

            if ($nama = $request->get('nama_kriteria')) {
                $q->where('nama_kriteria', $nama);
            }
            if ($desc = $request->get('desc_kriteria')) {
                $q->where('desc_kriteria', 'like', '%' . $desc . '%');
            }

            $kriteria = $q->orderBy('nama_kriteria')->get();
        }

        $divisiList   = Divisi::orderBy('nama_divisi')->pluck('nama_divisi', 'id');
        $jenisIsoList = JenisIso::orderBy('jenis_iso')->pluck('jenis_iso', 'id');

        // Nama kriteria dropdown juga ikut logika yang sama
        $namaKriteriaList = collect();
        if ($divisiId && $jenisIsoId) {
            $qNama = Kriteria::where('divisi_id', $divisiId);
            if ((int) $jenisIsoId === 1) {
                $qNama->where(function ($query) {
                    $query->where('jenis_iso_id', 1)
                          ->orWhereNull('jenis_iso_id');
                });
            } else {
                $qNama->where('jenis_iso_id', (int) $jenisIsoId);
            }
            $namaKriteriaList = $qNama->orderBy('nama_kriteria')
                ->pluck('nama_kriteria')
                ->unique()
                ->values();
        }

        return view('admin.kriteria', compact('kriteria', 'namaKriteriaList', 'divisiId', 'divisiList', 'jenisIsoList'));
    }



    public function create()
    {
        $kriteria = Kriteria::all();
        $divisis = Divisi::orderBy('nama_divisi')->get();
        $resiko = Resiko::all();
        $jenisIsos = JenisIso::orderBy('jenis_iso')->get();

        return view('admin.kriteriacreate', compact('kriteria', 'resiko','divisis','jenisIsos'));
    }


    public function store(Request $request)
{
    // Validasi input array
    $request->validate([
        'nama_kriteria' => 'required|string',
        'divisi_id'        => 'required|exists:divisi,id',
        'desc_kriteria' => 'required|array',
        'desc_kriteria.*' => 'required|string', // Setiap item dalam array harus string
        'nilai_kriteria' => 'required|array',
        'nilai_kriteria.*' => 'required|string', // Setiap item dalam array harus string
        'jenis_iso_id' => 'nullable|exists:jenis_isos,id',
    ]);

    $descKriteria = implode(", ", $request->desc_kriteria);
    $nilaiKriteria = implode(", ", $request->nilai_kriteria);

    // Simpan data kriteria
    Kriteria::create([
        'divisi_id'      => $request->divisi_id,
        'nama_kriteria' => $request->nama_kriteria,
        'desc_kriteria' => $descKriteria, 
        'nilai_kriteria' => $nilaiKriteria, 
        'jenis_iso_id'   => $request->jenis_iso_id,
    ]);

    return redirect()->route('admin.kriteria',['divisi_id'=>$request->divisi_id])->with('success', 'Kriteria berhasil ditambahkan dengan deskripsi dan nilai!✅');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('admin.kriteriaedit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        
        // Validasi input array
        $request->validate([
            'nama_kriteria' => 'required|string',
            'desc_kriteria' => 'required|array',
            'desc_kriteria.*' => 'required|string',
            'nilai_kriteria' => 'required|array',
            'nilai_kriteria.*' => 'required|string',
            'jenis_iso_id' => 'nullable|exists:jenis_isos,id',
            
        ]);

        $descKriteria = implode(", ", $request->desc_kriteria);
        $nilaiKriteria = implode(", ", $request->nilai_kriteria);

        // Cari data kriteria berdasarkan ID
        $kriteria = Kriteria::findOrFail($id);
        $divisiId = $kriteria->divisi_id;   

        // Perbarui data kriteria
        $kriteria->update([
            'nama_kriteria' => $request->nama_kriteria,
            'desc_kriteria' => $descKriteria, 
            'nilai_kriteria' => $nilaiKriteria,
            'jenis_iso_id'  => $request->jenis_iso_id, 
        ]);

        return redirect()->route('admin.kriteria', ['divisi_id' => $divisiId])->with('success', 'Kriteria berhasil diperbarui!✅');
    }


    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();
        return redirect()->route('admin.kriteria')->with('success', 'Kriteria berhasil dihapus!✅');
    }

}