<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Resiko;
use App\Models\Kriteria;
use App\Models\Tindakan;
use App\Models\Realisasi; // Pastikan untuk mengimpor model Riskregister
use App\Models\Riskregister;
use Illuminate\Http\Request;

class ResikoController extends Controller
{
    public function index($id)
    {
        // Ambil semua resiko yang memiliki id_riskregister yang sesuai
        $resikos = Resiko::where('id_riskregister', $id)->paginate(10); // Ganti 10 dengan jumlah item per halaman yang kamu inginkan

        return view('resiko.index', compact('resikos'));
    }


    public function create($id, $resikoId = null)
    {
        $enchan = $id;
        $divisi = Divisi::all();
        $riskregister = Riskregister::find($id);

        if (!$riskregister) {
            return redirect()->route('riskregister.index')->with('error', 'Risk Register tidak ditemukan.');
        }

        $resiko = null;
        if ($resikoId) {
            $resiko = Resiko::find($resikoId); // Mengambil data resiko jika sedang dalam mode edit
        }

        return view('resiko.create', compact('enchan', 'divisi', 'id', 'riskregister', 'resiko',));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_riskregister' => 'required|exists:riskregister,id',
            'nama_resiko' => 'nullable|string|max:255',
            'kriteria' => 'nullable|string',
            'probability' => 'nullable|integer|min:1|max:5',
            'severity' => 'nullable|integer|min:1|max:5',
            'probabilityrisk' => 'nullable|integer|min:1|max:5',
            'severityrisk' => 'nullable|integer|min:1|max:5',
            'before' => 'nullable|string',
            'after' => 'nullable|string',
        ]);

        // Buat instance model Resiko
        $resiko = new Resiko();
        $resiko->id_riskregister = $request->input('id_riskregister');
        $resiko->nama_resiko = $request->input('nama_resiko');
        $resiko->kriteria = $request->input('kriteria');
        $resiko->probability = $request->input('probability');
        $resiko->severity = $request->input('severity');

        // Inject relasi riskregister manual agar calculateTingkatan & calculateRisk bisa deteksi jenis ISO
        $riskregisterRelasi = Riskregister::find($request->input('id_riskregister'));
        $resiko->setRelation('riskregister', $riskregisterRelasi);

        // Hitung tingkatan berdasarkan probability dan severity
        $resiko->calculateTingkatan();

        // Set nilai before dari input pengguna
        $resiko->before = $request->input('before');

        // Hitung risk berdasarkan probabilityrisk dan severityrisk
        $resiko->probabilityrisk = $request->input('probabilityrisk');
        $resiko->severityrisk = $request->input('severityrisk');
        $resiko->calculateRisk();

        // Set nilai after dari input pengguna
        $resiko->after = $request->input('after');

        // Simpan data ke database
        $resiko->save();

        // Update status resiko berdasarkan realisasi
        $this->updateStatusResiko($resiko);

        return redirect()->route('resiko.index', ['id' => $resiko->id_riskregister])->with('success', 'Data resiko berhasil disimpan.✅');
    }

    public function edit($id)
{
    // Fetch the resiko data based on the provided ID
    $resiko = Resiko::where("id_riskregister", $id)->firstOrFail();  // Fetch risk data
    // dd($kriteria);
    
    // Fetch the associated Riskregister to get the division ID
    $riskregister = Riskregister::findOrFail($resiko->id_riskregister); // Get Riskregister based on resiko relation
    $divisionId = $riskregister->id_divisi; // Division ID for the current Riskregister

    $one = $resiko;
    $two = Riskregister::where('id', $one->id_riskregister)->first();
    $three = $two->id_divisi; // Division ID for the current Riskregister
    $isISO37001 = ($riskregister->jenis_iso_id == 2);
    $kriteria = $isISO37001
    ? Kriteria::where('divisi_id', $three)->where('jenis_iso_id', 2)->get()
    : Kriteria::where('divisi_id', $three)->whereNull('jenis_iso_id')->get();

    $severityOptions = [];
        foreach ($kriteria as $k) {
            // Pecah nilai dan deskripsi berdasarkan koma
            $nilaiArray = explode(',', $k->nilai_kriteria); // Tidak perlu hapus simbol lagi
            $descArray = explode(',', $k->desc_kriteria); // Tidak perlu hapus simbol lagi

            // Menyusun array dengan masing-masing pasangan nilai dan deskripsi
            $severityOptions[] = [
                'nama_kriteria' => $k->nama_kriteria,
                'options' => array_map(function ($nilai, $desc) {
                    return ['value' => trim($nilai), 'desc' => trim($desc)];
                }, $nilaiArray, $descArray),
            ];
        }



    // Pass the data to the view
    return view('resiko.edit', compact('resiko', 'kriteria', 'divisionId','three','severityOptions','isISO37001','riskregister'));
}


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_resiko' => 'nullable|string|max:255',
            'kriteria' => 'nullable|string',
            'probability' => 'nullable|integer|min:1|max:5',
            'severity' => 'nullable|integer|min:1|max:5',
            'status' => 'nullable|in:OPEN,ON PROGRES,CLOSE', // Pastikan status valid
            'probabilityrisk' => 'nullable|integer|min:1|max:5',
            'severityrisk' => 'nullable|integer|min:1|max:5',
            // 'before' => 'nullable|string|max:255',
            // 'after' => 'nullable|string|max:255',
        ]);

        // Ambil data resiko berdasarkan ID
        $resiko = Resiko::findOrFail($id);

        // Update data resiko
        $resiko->nama_resiko = $request->input('nama_resiko');
        $resiko->kriteria = $request->input('kriteria');
        $resiko->probability = $request->input('probability');
        $resiko->severity = $request->input('severity');
        $resiko->load('riskregister'); // Load relasi agar ISO type terdeteksi
        $resiko->calculateTingkatan(); // Hitung tingkatan
        // $resiko->before = $request->input('before');

        // Ambil status dari tabel realisasi
        $nilaiAkhir = Realisasi::where('id_tindakan', $resiko->id_tindakan)->value('nilai_akhir');
        $statusRealisasi = Realisasi::where('id_riskregister', $resiko->id_riskregister)->value('status');

        // Set status dari nilai yang diambil
        if ($statusRealisasi) {
            $resiko->status = $statusRealisasi; // Pastikan status diisi
        } else {
            $resiko->status = $request->input('status'); // Jika tidak ada status di tabel realisasi, ambil dari input
        }

        // Update nilai risk
        $resiko->probabilityrisk = $request->input('probabilityrisk');
        $resiko->severityrisk = $request->input('severityrisk');
        $resiko->calculateRisk(); // Hitung risk
        $resiko->calculateRiskNew(); // Menghitung kategori baru
        // $resiko->after = $request->input('after');

        // Simpan perubahan ke database
        $resiko->save();

        // Ambil nilai actual dari tabel realisasi berdasarkan id_riskregister
        $nilaiActual = Realisasi::where('id_riskregister', $resiko->id_riskregister)->sum('nilai_actual');

        $riskregister = RiskRegister::find($resiko->id_riskregister);

        if ($riskregister && $riskregister->jenis_iso_id == 2) {
            return redirect()->route('riskregister.edit.iso', ['id' => $riskregister->id])
                ->with('success', 'Matriks berhasil diupdate! ✅')
                ->withFragment('after-section');
        }
        
        return redirect()->route('resiko.matriks2', ['id' => $resiko->id_riskregister])
            ->with('success', 'Matriks berhasil diupdate! ✅')
            ->with('nilai_akhir', $nilaiAkhir)
            ->with('nilai_actual', $nilaiActual);
            }


   public function matriks($id)
    {
        try {
            // Fetch the resiko name from the Resiko table
            $resiko_nama = Resiko::where('id', $id)->value('nama_resiko');
             // Fetch the riskregister, resiko, and divisi based on the id
            $riskregister = Riskregister::findOrFail($id);
            $resiko = Resiko::where('id_riskregister', $riskregister->id)->first();

            // Deteksi ISO 37001
            $isISO37001 = ($riskregister->jenis_iso_id == 2);

            // Define matriks scores (sama untuk semua ISO)
            $matriks = [
                [1, 2, 3, 4, 5],
                [2, 4, 6, 8, 10],
                [3, 6, 9, 12, 15],
                [4, 8, 12, 16, 20],
                [5, 10, 15, 20, 25],
            ];

            // Colors untuk ISO General
            $colors_general = [
                ['green', 'green', 'yellow', 'yellow', 'red'],
                ['green', 'yellow', 'red', 'red', 'red'],
                ['yellow', 'red', 'red', 'red', 'red'],
                ['yellow', 'red', 'red', 'red', 'red'],
                ['red', 'red', 'red', 'red', 'red'],
            ];

            // Colors untuk ISO 37001 (range berbeda)
            $colors_37001 = [
                ['green', 'green', 'green', 'yellow', 'yellow'],
                ['green', 'yellow', 'yellow', 'yellow', 'yellow'],
                ['green', 'yellow', 'yellow', 'yellow', 'red'],
                ['yellow', 'yellow', 'yellow', 'red', 'red'],
                ['yellow', 'yellow', 'red', 'red', 'red'],
            ];

            $lol = Resiko::where('id_riskregister', $id)->value('id');
            if (!$lol) {
                return back()->withErrors(['error' => 'Data resiko tidak ditemukan untuk ID riskregister: ' . $id]);
            }

            // Get divisi name
            $divisi = Divisi::where('id', $riskregister->id_divisi)->value('nama_divisi');

            // Get resiko details
            $status = $riskregister->status;
            $kategori = $resiko ? $resiko->kriteria : null;

            // Pilih colors berdasarkan ISO type
            $colors_used = $isISO37001 ? $colors_37001 : $colors_general;

            // Label probability berdasarkan ISO type
            if ($isISO37001) {
                $probabilityLabels = [
                    '1 Sangat Jarang',
                    '2 Jarang',
                    '3 Kadang Kadang',
                    '4 Sering',
                    '5 Sangat Sering'
                ];
            } else {
                $probabilityLabels = [
                    '1 Sangat Jarang Terjadi',
                    '2 Jarang Terjadi',
                    '3 Dapat Terjadi',
                    '4 Sering Terjadi',
                    '5 Selalu Terjadi'
                ];
            }

            // Initialize kriteriaData based on the 'kategori'
            $kriteriaData = [];
            if ($kategori) {
                $kriteria = Kriteria::where('nama_kriteria', $kategori)->first();
                if ($kriteria) {
                    // Mengonversi string 'desc_kriteria' yang sudah di-implode menjadi array
                    $descArray = explode(',', $kriteria->desc_kriteria);

                    // Menghilangkan elemen kosong dari array
                    $filteredDesc = array_filter($descArray);

                    // Pastikan ada data sebelum dimasukkan ke dalam $kriteriaData
                    if (!empty($filteredDesc)) {
                        $kriteriaData[] = [
                            'nama_kriteria' => $kriteria->nama_kriteria,
                            'desc_kriteria' => array_values($filteredDesc), // Reset indeks array
                            'nilai_kriteria' => $kriteria->nilai_kriteria,
                        ];
                    }
                }
            }

            // Calculate actual progress based on 'realisasi' data
            $totalNilaiAkhir = Realisasi::where('id_riskregister', $id)->sum('nilai_akhir');
            $jumlahEntry = Realisasi::where('id_riskregister', $id)->count();
            $actual = $jumlahEntry > 0 ? round($totalNilaiAkhir / $jumlahEntry, 2) : 0;

            // Default values in case there are no risk data
            $probability = $severity = $riskscore = $tingkatan = 'N/A';
            $probabilityrisk = $severityrisk = $riskscorerisk = 'N/A';
            $deskripsiSeverity = [];

            // If resiko exists, calculate values
            if ($resiko) {
                $probability = $resiko->probability;
                $severity = $resiko->severity;
                $riskscore = $probability * $severity;
                $tingkatan = $resiko->tingkatan;

                $matriks_used = $matriks;

                // Additional risk data for specific categories
                $probabilityrisk = $resiko->probabilityrisk;
                $severityrisk = $resiko->severityrisk;
                $riskscorerisk = $probabilityrisk * $severityrisk;
                $deskripsiSeverity = $this->getDeskripsiSeverity($kategori);
            }

            // Fetch kriteria data based on the selected kategori
            $kriteriaData = Kriteria::where('nama_kriteria', $kategori)->get();
            if (!$kategori) {
                $kriteriaData = Kriteria::all(); // If no kategori is selected, fetch all kriteria
            }

            // Get division ID
            $three = $riskregister->id_divisi;

            // Return view with all the necessary data
            return view('resiko.matriks', compact(
                'matriks_used', 'colors_used', 'divisi', 'probability', 'severity', 'riskscore',
                'tingkatan', 'resiko_nama', 'deskripsiSeverity', 'kategori', 'probabilityrisk',
                'severityrisk', 'riskscorerisk', 'status', 'kriteriaData', 'three', 'lol',
                'isISO37001', 'probabilityLabels'
            ));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
    public function matriks2($id)
    {
        // Fetch Riskregister data and related information
        $resiko_nama = Resiko::where('id_riskregister', $id)->value('nama_resiko');
    
        // Define the matriks data
        $matriks = [
            [1, 2, 3, 4, 5],
            [2, 4, 6, 8, 10],
            [3, 6, 9, 12, 15],
            [4, 8, 12, 16, 20],
            [5, 10, 15, 20, 25],
        ];
    
        // Colors untuk ISO General
        $colors_general = [
            ['green', 'green', 'green', 'yellow', 'orange'],
            ['green', 'yellow', 'yellow', 'yellow', 'orange'],
            ['green', 'yellow', 'yellow', 'orange', 'red'],
            ['yellow', 'yellow', 'orange', 'red', 'red'],
            ['orange', 'orange', 'red', 'red', 'red'],
        ];
    
        // Colors untuk ISO 37001
        $colors_37001 = [
           ['green', 'green', 'green', 'green', 'yellow'],
           ['green', 'green', 'green', 'yellow', 'yellow'],
           ['green', 'green', 'yellow', 'yellow', 'red'],
           ['green', 'yellow', 'yellow', 'red', 'red'],
           ['yellow', 'yellow', 'red', 'red', 'red'],
        ];
    
        // Fetch the relevant data
        $same = Tindakan::where('id_riskregister', $id)->value('id_riskregister');
        $form = Resiko::where('id_riskregister', $id)->firstOrFail();
        $riskregister = Riskregister::where('id', $form->id_riskregister)->first();
        $samee = $riskregister->id_divisi;
    
        $divisi = Divisi::where('id', $id)->value('nama_divisi');
        $resiko = Resiko::where('id_riskregister', $id)->first();
    
       $riskregister = Riskregister::find($resiko->id_riskregister);
       $isISO37001 = ($riskregister && $riskregister->jenis_iso_id == 2);
    
        $status = $riskregister->status;
        $kategori = $resiko ? $resiko->kriteria : null;
    
        // Pilih colors berdasarkan ISO type
        $colors_used = $isISO37001 ? $colors_37001 : $colors_general;
    
        // Label probability berdasarkan ISO type
        if ($isISO37001) {
           $probabilityLabels = [
                    '1 Sangat Jarang',
                    '2 Jarang',
                    '3 Kadang Kadang',
                    '4 Sering',
                    '5 Sangat Sering'
                ];
            } else {
                $probabilityLabels = [
                    '1 Sangat Jarang Terjadi',
                    '2 Jarang Terjadi',
                    '3 Dapat Terjadi',
                    '4 Sering Terjadi',
                    '5 Selalu Terjadi'
              ];
        }
    
        // Fetch kriteria data based on the selected 'kategori'
        $kriteriaData = [];
        if ($kategori) {
            $kriteria = Kriteria::where('nama_kriteria', $kategori)->get();
    
            foreach ($kriteria as $k) {
                // Decode or parse desc_kriteria as array
                $descArray = is_string($k->desc_kriteria) ? json_decode($k->desc_kriteria, true) : $k->desc_kriteria;
                $descArray = is_array($descArray) ? $descArray : explode(',', $k->desc_kriteria);
    
                if (!empty($descArray)) {
                    $kriteriaData[] = [
                        'nama_kriteria' => $k->nama_kriteria,
                        'desc_kriteria' => array_values($descArray),
                        'nilai_kriteria' => $k->nilai_kriteria,
                    ];
                }
            }
        }
    
        // Calculate risk data
        $totalNilaiAkhir = Realisasi::where('id_riskregister', $id)->sum('nilai_akhir');
        $jumlahEntry = Realisasi::where('id_riskregister', $id)->count();
        $actual = $jumlahEntry > 0 ? round($totalNilaiAkhir / $jumlahEntry, 2) : 0;
    
        // Default values in case there are no risk data
        $probability = $severity = $riskscore = $tingkatan = 'N/A';
        $probabilityrisk = $severityrisk = $riskscorerisk = 'N/A';
        $deskripsiSeverity = [];
    
        if ($resiko) {
            $probability = $resiko->probability;
            $severity = $resiko->severity;
            $riskscore = $probability * $severity;
            $tingkatan = $resiko->tingkatan;
    
            $matriks_used = $matriks;
    
            $probabilityrisk = $resiko->probabilityrisk;
            $severityrisk = $resiko->severityrisk;
            $riskscorerisk = $probabilityrisk * $severityrisk;
            $deskripsiSeverity = $this->getDeskripsiSeverity($kategori);
        }
    
        // Fetch kriteria data based on the selected 'kategori' in your model
        if ($kategori) {
            $kriteriaData = Kriteria::where('nama_kriteria', $kategori)->get();
        } else {
            $kriteriaData = Kriteria::all(); // If no kategori is selected, fetch all kriteria
        }
    
        // Retrieve division id for the 'three' variable
        $one = Resiko::where('id_riskregister', $id)->firstOrFail();
        $two = Riskregister::where('id', $one->id_riskregister)->first();
        $three = $two->id_divisi;
    
        // Pass all variables to the view
        return view('resiko.matriks2', compact(
            'matriks_used', 'colors_used', 'divisi', 'probability', 'severity', 'riskscore',
            'tingkatan', 'same', 'resiko_nama', 'deskripsiSeverity', 'kategori', 'probabilityrisk',
            'severityrisk', 'riskscorerisk', 'status', 'samee', 'actual', 'matriks', 'colors_general',
            'kriteriaData', 'three', 'isISO37001', 'probabilityLabels'
        ));
    }


    private function getDeskripsiSeverity($kategori)
       {
        // Fetch the kriteria data based on 'nama_kriteria' matching the category (kategori)
        $deskripsiSeverity = Kriteria::where('nama_kriteria', $kategori)
                                      ->orderBy('nilai_kriteria')
                                      ->pluck('desc_kriteria', 'nilai_kriteria'); // Getting 'desc_kriteria' and 'nilai_kriteria' as key-value pairs

        // Map descriptions based on the nilai_kriteria
        $mappedDeskripsi = [];
        foreach ($deskripsiSeverity as $nilai => $desc) {
            // Assuming desc_kriteria is a comma-separated string, we split it into an array
            $mappedDeskripsi[$nilai] = explode(',', $desc);
        }

        // Return the mapped descriptions
        return $mappedDeskripsi;
    }
}