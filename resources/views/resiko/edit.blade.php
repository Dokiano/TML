@extends('layouts.main')

@section('content')
    <div class="container">

        <!-- Menampilkan Nilai Actual jika tersedia -->
        @if (session('nilai_actual'))
            <div class="alert alert-success">
                <strong>Nilai Actual dari Realisasi:</strong> {{ session('nilai_actual') }}%
            </div>
        @endif

        <!-- Form untuk edit -->
        <form action="{{ route('resiko.update', $resiko->id) }}" method="POST">
            @csrf

            <!-- Judul Matriks Before -->
            <div class="row mb-3">
                <h1 class="card-title">
                    @if(isset($resiko->riskRegister) && $resiko->riskRegister->jenis_iso_id == 2)
                        LEVEL (Resiko)
                    @else
                        TINGKATAN (Matriks Before)
                    @endif
                </h1>
                <label for="nama_resiko" class="col-sm-2 col-form-label">
                    <strong>{{ (isset($resiko->riskRegister) && $resiko->riskRegister->jenis_iso_id == 2) ? 'Potensi Risk Penyuapan' : 'Resiko' }}</strong>
                </label>
                <div class="col-sm-10">
                    <textarea name="nama_resiko" class="form-control" rows="3">{{ old('nama_resiko', $resiko->nama_resiko) }}</textarea>
                </div>
            </div>

            
            <!-- Kriteria Dropdown -->
                <div class="row mb-3">
                    <label for="kriteriaSelect" class="col-sm-2 col-form-label"><strong>Kriteria</strong></label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select name="kriteria" class="form-control" id="kriteriaSelect" required onchange="updateSeverityDropdown('severity'); updateSeverityDropdown('severityrisk');">
                                <option value="">--Pilih Kriteria--</option>
                                @foreach ($kriteria as $k)
                                    <option value="{{ $k->nama_kriteria }}"
                                        data-divisi="{{ $k->id_divisi }}"
                                        {{ old('kriteria', $resiko->kriteria) == $k->nama_kriteria ? 'selected' : '' }}>
                                        {{ $k->nama_kriteria }}
                                    </option>
                                @endforeach
                            <div class="col-sm-4">
                            </select>
                            <button type="button" class="btn btn-primary btn-sm"
                                onclick="openMatrixModal('before')"
                                data-bs-toggle="modal" data-bs-target="#modalMatriks">
                                <i class="bi bi-grid-3x3"></i> Pre-Matrix
                            </button>
                        </div>
                    </div>
                </div>

            <!-- Severity Before -->
            <div class="row mb-3">
                <label for="severity" class="col-sm-2 col-form-label"><strong>Severity/Dampak</strong></label>
                <div class="col-sm-4">
                    <select class="form-select" name="severity" id="severity">
                        <option value="">--Pilih Severity--</option>
                        @if (old('kriteria', $resiko->kriteria))
                            @foreach ($kriteria as $k)
                                @if ($k->nama_kriteria == old('kriteria', $resiko->kriteria))
                                    @php
                                        $vals = explode(',', str_replace(['[', ']', '"'], '', $k->nilai_kriteria));
                                        $descs = explode(',', str_replace(['[', ']', '"'], '', $k->desc_kriteria));
                                    @endphp
                                    @foreach ($vals as $i => $v)
                                        <option value="{{ trim($v) }}"
                                            {{ old('severity', $resiko->severity) == trim($v) ? 'selected' : '' }}>
                                            {{ trim($v) }} - {{ $descs[$i] ?? '' }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <!-- Probability Before -->
            <div class="row mb-3">
                <label for="probability" class="col-sm-2 col-form-label">
                    <strong>Probability / Kemungkinan Terjadi</strong>
                </label>
                <div class="col-sm-4">
                    <select class="form-select" name="probability" id="probability" onchange="calculateTingkatan()">
                        <option value="">--Silahkan Pilih Probability--</option>

                        @if($isISO37001)
                            {{-- Probability untuk ISO 37001 --}}
                            <option value="1" {{ old('probability', $resiko->probability) == 1 ? 'selected' : '' }}>
                                1. Sangat Jarang
                            </option>
                            <option value="2" {{ old('probability', $resiko->probability) == 2 ? 'selected' : '' }}>
                                2. Jarang
                            </option>
                            <option value="3" {{ old('probability', $resiko->probability) == 3 ? 'selected' : '' }}>
                                3. Kadang Kadang
                            </option>
                            <option value="4" {{ old('probability', $resiko->probability) == 4 ? 'selected' : '' }}>
                                4. Sering
                            </option>
                            <option value="5" {{ old('probability', $resiko->probability) == 5 ? 'selected' : '' }}>
                                5. Sangat Sering
                            </option>
                        @else
                            {{-- Probability untuk ISO General --}}
                            <option value="1" {{ old('probability', $resiko->probability) == 1 ? 'selected' : '' }}>
                                1. Sangat jarang terjadi ( < 2 kejadian dalam 1 tahun)
                            </option>
                            <option value="2" {{ old('probability', $resiko->probability) == 2 ? 'selected' : '' }}>
                                2. Jarang terjadi ( 3-5 kejadian dalam 1 tahun)
                            </option>
                            <option value="3" {{ old('probability', $resiko->probability) == 3 ? 'selected' : '' }}>
                                3. Dapat Terjadi ( 6-8 kejadian dalam 1 tahun)
                            </option>
                            <option value="4" {{ old('probability', $resiko->probability) == 4 ? 'selected' : '' }}>
                                4. Sering terjadi ( 9-11 2 kejadian dalam 1 tahun)
                            </option>
                            <option value="5" {{ old('probability', $resiko->probability) == 5 ? 'selected' : '' }}>
                                5. Selalu terjadi ( > 12 kejadian dalam 1 tahun)
                            </option>
                        @endif
                    </select>

                    @if($isISO37001)
                        <small class="text-success">
                            <i class="bi bi-shield-check"></i> Probability untuk ISO 37001
                        </small>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <label for="level" class="col-sm-2 col-form-label"><strong>Level</strong></label>
                <div class="col-sm-4">
                    <input type="text"
                        class="form-control"
                        name="level"
                        id="level"
                        value="{{ old('level', $resiko->probability * $resiko->severity) }}"
                        readonly>
                </div>
            </div>
            
            <!-- Tingkatan Before -->
            <div class="row mb-3">
                <label for="tingkatan" class="col-sm-2 col-form-label">
                    <strong>{{ (isset($resiko->riskRegister) && $resiko->riskRegister->jenis_iso_id == 2) ? 'Level' : 'Tingkatan' }}</strong>
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="tingkatan" id="tingkatan"
                        value="{{ old('tingkatan', $resiko->tingkatan) }}" readonly>
                </div>
            </div>

            <hr>
            <hr>

<div>
           <h1 class="card-title">
                @if(isset($resiko->riskRegister) && $resiko->riskRegister->jenis_iso_id == 2)
                    ACTUAL LEVEL (Sisa Resiko)
                @else
                    ACTUAL RISK (Matriks After)
                @endif
            </h1>

            <!-- Severity After -->
            <div class="row mb-3">
                
                <label for="severityrisk" class="col-sm-2 col-form-label"><strong>Severity/Dampak</strong></label>
                <div class="col-sm-4">
                    <div class="input-group">
                    <select class="form-select" name="severityrisk" id="severityrisk">
                        <option value="">--Pilih Severity--</option>
                        @if (old('kriteria', $resiko->kriteria))
                            @foreach ($kriteria as $k)
                                @if ($k->nama_kriteria == old('kriteria', $resiko->kriteria))
                                    @php
                                        $vals = explode(',', str_replace(['[', ']', '"'], '', $k->nilai_kriteria));
                                        $descs = explode(',', str_replace(['[', ']', '"'], '', $k->desc_kriteria));
                                    @endphp
                                    @foreach ($vals as $i => $v)
                                        <option value="{{ trim($v) }}"
                                            {{ old('severityrisk', $resiko->severityrisk) == trim($v) ? 'selected' : '' }}>
                                            {{ trim($v) }} - {{ $descs[$i] ?? '' }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                     </select>
                     <button type="button" class="btn btn-warning btn-sm"
                         onclick="openMatrixModal('after')"
                         data-bs-toggle="modal" data-bs-target="#modalMatriks">
                         <i class="bi bi-grid-3x3"></i> Post-Matrix
                     </button>
                    </div>            
                </div>
            </div>

            <!-- Probability After -->
            <div class="row mb-3">
                <label for="probabilityrisk" class="col-sm-2 col-form-label">
                    <strong>Probability / Kemungkinan Terjadi</strong>
                </label>
                <div class="col-sm-4">
                    <select class="form-select" name="probabilityrisk" id="probabilityrisk" onchange="calculateRisk()">
                        <option value="">--Silahkan Pilih Probability--</option>

                        @if($isISO37001)
                            {{-- Probability untuk ISO 37001 --}}
                            <option value="1" {{ old('probabilityrisk', $resiko->probabilityrisk) == 1 ? 'selected' : '' }}>
                                1. Sangat Jarang
                            </option>
                            <option value="2" {{ old('probabilityrisk', $resiko->probabilityrisk) == 2 ? 'selected' : '' }}>
                                2. Jarang
                            </option>
                            <option value="3" {{ old('probabilityrisk', $resiko->probabilityrisk) == 3 ? 'selected' : '' }}>
                                3. Kadang Kadang
                            </option>
                            <option value="4" {{ old('probabilityrisk', $resiko->probabilityrisk) == 4 ? 'selected' : '' }}>
                                4. Sering
                            </option>
                            <option value="5" {{ old('probabilityrisk', $resiko->probabilityrisk) == 5 ? 'selected' : '' }}>
                                5. Sangat Sering
                            </option>
                        @else
                            {{-- Probability untuk ISO General --}}
                            <option value="1" {{ old('probabilityrisk', $resiko->probabilityrisk) == 1 ? 'selected' : '' }}>
                                1. Sangat jarang terjadi ( < 2 kejadian dalam 1 tahun)
                            </option>
                            <option value="2" {{ old('probabilityrisk', $resiko->probabilityrisk) == 2 ? 'selected' : '' }}>
                                2. Jarang terjadi ( 3-5 kejadian dalam 1 tahun)
                            </option>
                            <option value="3" {{ old('probabilityrisk', $resiko->probabilityrisk) == 3 ? 'selected' : '' }}>
                                3. Dapat Terjadi  ( 6-8 kejadian dalam 1 tahun)
                            </option>
                            <option value="4" {{ old('probabilityrisk', $resiko->probabilityrisk) == 4 ? 'selected' : '' }}>
                                4. Sering terjadi ( 9-11 kejadian dalam 1 tahun)
                            </option>
                            <option value="5" {{ old('probabilityrisk', $resiko->probabilityrisk) == 5 ? 'selected' : '' }}>
                                5. Selalu terjadi ( > 12 kejadian dalam 1 tahun)
                            </option>
                        @endif
                    </select>

                    @if($isISO37001)
                        <small class="text-success">
                            <i class="bi bi-shield-check"></i> Probability untuk ISO 37001
                        </small>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <label for="levelrisk" class="col-sm-2 col-form-label"><strong>Level</strong></label>
                <div class="col-sm-4">
                    <input type="text"
                        class="form-control"
                        id="levelrisk"
                        name="levelrisk"
                        value="{{ old('levelrisk', $resiko->severityrisk * $resiko->probabilityrisk) }}"
                        readonly>
                </div>
            </div>
            

            <!-- Risk After -->
            <div class="row mb-3">
                <label for="risk" class="col-sm-2 col-form-label">
                    <strong>{{ (isset($resiko->riskRegister) && $resiko->riskRegister->jenis_iso_id == 2) ? 'Level' : 'Tingkatan' }}</strong>
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="risk" id="risk"
                        value="{{ old('risk', $resiko->risk) }}" readonly>
                </div>
            </div>

            <!-- Status (admin only) -->
            
                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label"><strong>Status</strong></label>
                    <div class="col-sm-4">
                        <select name="status" class="form-control">
                            <option value="">--Pilih Status--</option>
                            <option value="OPEN" {{ $resiko->status == 'OPEN' ? 'selected' : '' }}>OPEN</option>
                            <option value="ON PROGRES" {{ $resiko->status == 'ON PROGRES' ? 'selected' : '' }}>ON PROGRES
                            </option>
                            <option value="CLOSE" {{ $resiko->status == 'CLOSE' ? 'selected' : '' }}>CLOSE</option>
                        </select>
                    </div>
                </div>
            
            <!-- Buttons -->
             
            <button type="submit" class="btn btn-success">
                Update <i class="ri-save-3-fill"></i>
            </button>
            </div>
            <br>
            <a class="btn btn-danger" 
               href="{{ $riskregister->jenis_iso_id == 2 
                   ? route('riskregister.tablerisk.iso37001', ['id' => $riskregister->id_divisi]) 

                   : route('riskregister.tablerisk', ['id' => $riskregister->id_divisi]) }}">
                <i class="ri-arrow-go-back-line"></i>
            </a>
        </form>
    </div>

    <style>
        /* wrapping teks di severity dropdown */
        #severity option,
        #severityrisk option {
            white-space: normal;
            word-wrap: break-word;
        }
        
    </style>
    {{-- MODAL MATRIX --}}
<div class="modal fade" id="modalMatriks" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen p-3">
        <div class="modal-content">
            <div class="modal-header p-2">
                <h6 class="modal-title" id="modalMatriksTitle">Set Matrix</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light p-2 border-bottom d-flex gap-3 sticky-top">
                    <div id="status-kriteria"><strong>Kriteria:</strong> -</div>
                    <div id="status-severity"><strong>Severity:</strong> -</div>
                    <div id="status-probability"><strong>Probability:</strong> -</div>
                </div>
                <div class="table-responsive">
                    <table id="matrixTable" class="table table-bordered align-middle m-0 text-center">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width:150px;">Level</th>
                                <th id="kriteriaHeaderContainer">Kriteria</th>
                                <th colspan="5">Probability</th>
                            </tr>
                            <tr id="probabilityHeaderRow">
                                  <th class="bg-primary text-white">1. Sangat Jarang<br>
                                      <small>Hampir Tidak Pernah Terjadi</small><br>
                                      <small>(&lt; 1x dalam 5 tahun)</small>
                                  </th>
                                  <th class="bg-primary text-white">2. Jarang<br>
                                      <small>Jarang Terjadi</small><br>
                                      <small>( 1x dalam 2-5 tahun)</small>
                                  </th>
                                  <th class="bg-primary text-white">3. Kadang Kadang<br>
                                      <small>Pernah Terjadi</small><br>
                                      <small>( 1x dalam per tahun)</small>
                                  </th>
                                  <th class="bg-primary text-white">4. Sering<br>
                                      <small>Sering Terjadi</small><br>
                                      <small>(Beberapa kali per tahun)</small>
                                  </th>
                                  <th class="bg-primary text-white">5. Sangat Sering<br>
                                      <small>Terjadi berulang atau sistemik</small><br>
                                      <small>(Hampir pasti terjadi)</small>
                                  </th>
                              </tr>
                        </thead>
                        <tbody id="matrixBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanMatriks">Simpan ke Form</button>
            </div>
        </div>
    </div>
</div>

<style>
                                #matrixTable {
                                    table-layout: fixed; /* Kunci agar lebar kolom bisa dipaksa sama */
                                    width: 100%;
                                    border-collapse: separate;
                                    border-spacing: 2px; /* Memberi jarak halus antar kotak */
                                }
                            
                                /* Kolom Level (Sangat Kecil) */
                                #matrixTable th:first-child, 
                                #matrixTable td:first-child {
                                    width: 50px;
                                    text-align: center;
                                }
                            
                                /* Kolom Kriteria (Disamakan Lebarnya) */
                                /* Jika ada 3 kriteria, kita beri porsi yang adil */
                                .column-kriteria {
                                    width: 180px; /* Atur lebar kolom teks kriteria */
                                }
                            
                                /* Kolom Probability (Dibuat Kotak Sempurna) */
                                .column-prob {
                                    width: 100px;
                                }
                            
                                .cell-desc {
                                    cursor: pointer;
                                    padding: 12px !important;
                                    font-size: 0.75rem;
                                    line-height: 1.4;
                                    vertical-align: top !important;
                                    background-color: #ffffff;
                                    border: 1px solid #dee2e6 !important;
                                    transition: 0.2s;
                                    word-wrap: break-word; /* Memastikan teks panjang pindah baris */
                                }
                            
                                .cell-desc:hover {
                                    background-color: #f0f7ff;
                                }
                            
                                .cell-risk {
                                    text-align: center;
                                    vertical-align: middle !important;
                                    font-weight: bold;
                                    font-size: 0.7rem;
                                    cursor: pointer;
                                    color: rgba(0,0,0,0.7);
                                    border: none !important;
                                    height: 80px; /* Menjaga tinggi baris tetap konsisten */
                                }
                            
                                /* Ukuran Checkbox */
                                .cb-sev, .cb-prob {
                                    transform: scale(1.2);
                                    margin-bottom: 5px;
                                }
                            
                                /* Warna yang lebih solid dan bersih */
                                .bg-low { background-color: #2ecc71 !important; color: white !important; }
                                .bg-medium { background-color: #f1c40f !important; color: black !important; }
                                .bg-high { background-color: #e74c3c !important; color: white !important; }
                            
                                /* Header tetap di atas saat scroll */
                                .sticky-header {
                                    position: sticky;
                                    top: 0;
                                    z-index: 100;
                                    background: white;
                                }
                                /* Header Probability lebih compact */
                                #probabilityHeaderRow th {
                                    font-size: 0.7rem;
                                    padding: 6px 4px;
                                }
                                .cell-keterangan {
                                    text-align: left !important;
                                    vertical-align: top !important;
                                    background-color: #fafafa;
                                    min-width: 250px;
                                    padding: 8px !important;
                                }
                                .cell-keterangan ul {
                                    list-style-type: disc;
                                }
                                .cell-keterangan li {
                                    margin-bottom: 4px;
                                }
                            </style>


    <script>
        // ⚠️ kriteriaData sudah ada di script atas, tidak perlu deklarasi ulang

        let matrixMode = 'before';
        let selKName = null, selSVal = null, selPVal = null, selLevel = null;

        function openMatrixModal(mode) {
            matrixMode = mode;
            selKName = selSVal = selPVal = selLevel = null;

            if (mode === 'after') {
                // Hanya kunci kriteria dari Before, severity & probability bebas dipilih
                const kritBefore = document.getElementById('kriteriaSelect').value;
                if (!kritBefore) {
                    alert('Harap pilih Kriteria pada Matriks Before terlebih dahulu!');
                    return false;
                }
                selKName = kritBefore;
                selSVal  = null;
                selLevel = null;
                selPVal  = null;
                document.getElementById('status-kriteria').innerHTML    = `<strong>Kriteria:</strong> ${kritBefore} `;
                document.getElementById('status-severity').innerHTML    = '<strong>Severity:</strong> -';
                document.getElementById('status-probability').innerHTML = '<strong>Probability:</strong> -';
            } else {
                document.getElementById('status-kriteria').innerHTML   = '<strong>Kriteria:</strong> -';
                document.getElementById('status-severity').innerHTML   = '<strong>Severity:</strong> -';
                document.getElementById('status-probability').innerHTML = '<strong>Probability:</strong> -';
            }

            document.getElementById('modalMatriksTitle').textContent =
                mode === 'before' ? 'Pre-Matrix (Before)' : 'Post-Matrix (After) - Pilih Probability';
            renderMatrix();
        }

        function renderMatrix() {
            const matrixBody = document.getElementById('matrixBody');
            const headerContainer = document.getElementById('kriteriaHeaderContainer');
            const probHeaderRow   = document.getElementById('probabilityHeaderRow');

            matrixBody.innerHTML = '';
            // Reset kolom kriteria di header (hapus th yang di-insert sebelumnya, sisakan 5 probability)
            while (probHeaderRow.children.length > 5) {
                probHeaderRow.removeChild(probHeaderRow.firstChild);
            }

            if (matrixMode === 'after') {
                // Mode After: hanya tampilkan 1 kriteria (dari Before), severity & probability bebas dipilih
                const kriteriaBefore = kriteriaData.find(k => k.nama_kriteria === selKName);
                if (!kriteriaBefore) return;

                // Header: 1 kolom kriteria saja (dikunci)
                headerContainer.colSpan = 1;
                const th = document.createElement('th');
                th.textContent = kriteriaBefore.nama_kriteria ;
                th.className = 'bg-secondary text-white text-center';
                const firstProbTh = probHeaderRow.querySelector('.bg-primary');
                probHeaderRow.insertBefore(th, firstProbTh);

                // Tambah header Keterangan
                const thKetAfter = document.createElement('th');
                thKetAfter.textContent = 'Keterangan';
                thKetAfter.className = 'bg-white text-black text-center';
                thKetAfter.style.width = '150px';
                probHeaderRow.insertBefore(thKetAfter, firstProbTh);

                // Render semua 5 baris, severity bisa dipilih bebas
                for (let i = 1; i <= 5; i++) {
                    const descArr  = kriteriaBefore.desc_kriteria.replace(/[\[\]"]+/g, '').split(',');
                    const nilaiArr = kriteriaBefore.nilai_kriteria.replace(/[\[\]"]+/g, '').split(',');
                    const deskripsi = descArr[i-1] ? descArr[i-1].trim() : '-';
                    const sevVal    = nilaiArr[i-1] ? nilaiArr[i-1].trim() : i;

                    let levelDesc = '';
                    let levelDetail = '';
                    if (i === 1) {
                        levelDesc = 'Tidak Signifikan (Sangat Rendah)';
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak sangat kecil terhadap SMAP</li><li>Tidak menimbulkan pelanggaran kebijakan anti penyuapan</li><li>Tidak berdampak hukum, finansial, atau reputasi</li><li>Tidak mempengaruhi efektivitas pengendalian internal SMAP</li><li>Dapat ditangani langsung tanpa tindakan korektif formal</li></ul>`;
                    } else if (i === 2) {
                        levelDesc = 'Kurang Signifikan (Rendah)';
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak kecil dan terbatas pada sebagian proses</li><li>Potensi ketidak sesuaian minor terhadap prosedur</li><li>Tidak melibatkan indikasi penyuapan aktual</li><li>Tidak berdampak hukum</li><li>Dampak finansial sangat kecil dan reputasi tidak terpengaruh</li></ul>`;
                    } else if (i === 3) {
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak "cukup berarti" dan perlu perhatian FKAP</li><li>Kelemahan pengendalian yang "berpotensi memungkinkan penyuapan"</li><li>Ketidaksesuaian terhadap kebijakan atau prosedur SMAP</li><li>Berpotensi menimbulkan temuan audit atau komplain</li><li>Memerlukan tindakan korektif terstruktur</li></ul>`;
                    } else if (i === 4) {
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak "besar" terhadap efektivitas SMAP</li><li>Kegagalan pengendalian yang dapat "mengarah pada praktik penyuapan"</li><li>Potensi pelanggaran hukum atau regulasi</li><li>Dampak finansial dan reputasi yang nyata</li><li>Membutuhkan tindakan korektif segera dan pengawasan FKAP</li></ul>`;
                    } else if (i === 5) {
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak "sangat besar dan kritikal" - terjadi atau mungkin terjadi "praktik penyuapan aktual"</li><li>Pelanggaran hukum serius (Pidana/Perdata)</li><li>Kerugian finansial material</li><li>Dampak reputasi yang berat dan berjangka panjang</li><li>Mengancam keberlangsungan organisasi atau sertifikasi ISO 37001</li><li>Melibatkan Manajemen Puncak/ada persetujuan atau pembiaran oleh Manajemen</li><li>Berhubungan dengan pejabat publik dengan nilai suap besar</li><li>Potensi menghentikan bisnis</li></ul>`;
                    }

                    let tr = document.createElement('tr');
                    tr.setAttribute('data-level', i);
                    tr.innerHTML = `<td class="text-center fw-bold bg-light" style="min-width: 80px;">${i}<br><small class="fw-normal" style="font-size: 12px;">${levelDesc}</small></td>`;

                    // Kolom severity: bisa diklik seperti Before
                    let td = document.createElement('td');
                    td.className = 'cell-desc';
                    td.innerHTML = `<input type="checkbox" class="cb-sev"> ${deskripsi}`;
                    td.onclick = function() {
                        document.querySelectorAll('.cb-sev, .cb-prob').forEach(cb => cb.checked = false);
                        document.querySelectorAll('#matrixBody tr').forEach(r => r.style.opacity = '1');
                        this.querySelector('input').checked = true;
                        selSVal  = sevVal;
                        selLevel = i;
                        selPVal  = null;
                        document.querySelectorAll('#matrixBody tr').forEach(r => {
                            if (r.getAttribute('data-level') != i) r.style.opacity = '0.4';
                        });
                        document.getElementById('status-severity').innerHTML   = `<strong>Severity:</strong> ${sevVal}`;
                        document.getElementById('status-probability').innerHTML = `<strong>Probability:</strong> -`;
                    };
                    tr.appendChild(td);

                    // Kolom Keterangan
                    let tdKetAfter = document.createElement('td');
                    tdKetAfter.className = 'cell-keterangan';
                    tdKetAfter.style.fontSize = '7px';
                    tdKetAfter.innerHTML = `<strong>${levelDetail}</strong>`;
                    tr.appendChild(tdKetAfter);

                    // Kolom probability
                    for (let p = 1; p <= 5; p++) {
                        let score = i * p;
                        let cls, label;
                        if (isISO37001) {
                            cls   = score <= 3 ? 'bg-low' : score <= 12 ? 'bg-medium' : 'bg-high';
                            label = score <= 3 ? 'LOW'    : score <= 12 ? 'MEDIUM'    : 'HIGH';
                        } else {
                            cls   = score <= 2 ? 'bg-low' : score <= 4 ? 'bg-medium' : 'bg-high';
                            label = score <= 2 ? 'LOW'    : score <= 4 ? 'MEDIUM'    : 'HIGH';
                        }
                        let tdR   = document.createElement('td');
                        tdR.className = `cell-risk ${cls}`;
                        tdR.innerHTML = `<input type="checkbox" class="cb-prob"><br>${label}<br><span style="font-size: 20px; font-weight: bold; color: #00000  ">${score}</span>`;
                        tdR.onclick = function() {
                            if (selLevel === null) { alert('Pilih Severity terlebih dahulu!'); return; }
                            if (i !== selLevel)    { alert(`Probability harus di Level ${selLevel}!`); return; }
                            document.querySelectorAll('.cb-prob').forEach(cb => cb.checked = false);
                            this.querySelector('input').checked = true;
                            selPVal = p;
                            document.getElementById('status-probability').innerHTML = `<strong>Probability:</strong> ${p}`;
                        };
                        tr.appendChild(tdR);
                    }
                    matrixBody.appendChild(tr);
                }

            } else {
                // Mode Before: render semua kriteria dan semua baris seperti biasa
                headerContainer.colSpan = kriteriaData.length || 1;
                kriteriaData.forEach(k => {
                    const th = document.createElement('th');
                    th.textContent = k.nama_kriteria;
                    th.className = 'bg-secondary text-white text-center';
                    const firstProbTh = probHeaderRow.querySelector('.bg-primary');
                    probHeaderRow.insertBefore(th, firstProbTh);
                });

                // Tambah header Keterangan
                const thKetBefore = document.createElement('th');
                thKetBefore.textContent = 'Keterangan';
                thKetBefore.className = 'bg-white text-black text-center';
                thKetBefore.style.width = '150px';
                const firstProbThBefore = probHeaderRow.querySelector('.bg-primary');
                probHeaderRow.insertBefore(thKetBefore, firstProbThBefore);

                for (let i = 1; i <= 5; i++) {
                    let tr = document.createElement('tr');
                    tr.setAttribute('data-level', i);

                    let levelDesc = '';
                    let levelDetail = '';
                    if (i === 1) {
                        levelDesc = 'Tidak Signifikan (Sangat Rendah)';
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak sangat kecil terhadap SMAP</li><li>Tidak menimbulkan pelanggaran kebijakan anti penyuapan</li><li>Tidak berdampak hukum, finansial, atau reputasi</li><li>Tidak mempengaruhi efektivitas pengendalian internal SMAP</li><li>Dapat ditangani langsung tanpa tindakan korektif formal</li></ul>`;
                    } else if (i === 2) {
                        levelDesc = 'Kurang Signifikan (Rendah)';
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak kecil dan terbatas pada sebagian proses</li><li>Potensi ketidak sesuaian minor terhadap prosedur</li><li>Tidak melibatkan indikasi penyuapan aktual</li><li>Tidak berdampak hukum</li><li>Dampak finansial sangat kecil dan reputasi tidak terpengaruh</li></ul>`;
                    } else if (i === 3) {
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak "cukup berarti" dan perlu perhatian FKAP</li><li>Kelemahan pengendalian yang "berpotensi memungkinkan penyuapan"</li><li>Ketidaksesuaian terhadap kebijakan atau prosedur SMAP</li><li>Berpotensi menimbulkan temuan audit atau komplain</li><li>Memerlukan tindakan korektif terstruktur</li></ul>`;
                    } else if (i === 4) {
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak "besar" terhadap efektivitas SMAP</li><li>Kegagalan pengendalian yang dapat "mengarah pada praktik penyuapan"</li><li>Potensi pelanggaran hukum atau regulasi</li><li>Dampak finansial dan reputasi yang nyata</li><li>Membutuhkan tindakan korektif segera dan pengawasan FKAP</li></ul>`;
                    } else if (i === 5) {
                        levelDetail = `<ul class="text-start m-0 ps-3" style="font-size: 8px;"><li>Dampak "sangat besar dan kritikal" - terjadi atau mungkin terjadi "praktik penyuapan aktual"</li><li>Pelanggaran hukum serius (Pidana/Perdata)</li><li>Kerugian finansial material</li><li>Dampak reputasi yang berat dan berjangka panjang</li><li>Mengancam keberlangsungan organisasi atau sertifikasi ISO 37001</li><li>Melibatkan Manajemen Puncak/ada persetujuan atau pembiaran oleh Manajemen</li><li>Berhubungan dengan pejabat publik dengan nilai suap besar</li><li>Potensi menghentikan bisnis</li></ul>`;
                    }

                    tr.innerHTML = `<td class="text-center fw-bold bg-light" style="min-width: 80px;">${i}<br><small class="fw-normal" style="font-size: 12px;">${levelDesc}</small></td>`;

                    kriteriaData.forEach(k => {
                        const descArr  = k.desc_kriteria.replace(/[\[\]"]+/g, '').split(',');
                        const nilaiArr = k.nilai_kriteria.replace(/[\[\]"]+/g, '').split(',');
                        const deskripsi = descArr[i-1]  ? descArr[i-1].trim()  : '-';
                        const sevVal    = nilaiArr[i-1] ? nilaiArr[i-1].trim() : i;

                        let td = document.createElement('td');
                        td.className = 'cell-desc';
                        td.innerHTML = `<input type="checkbox" class="cb-sev"> ${deskripsi}`;
                        td.onclick = function() {
                            document.querySelectorAll('.cb-sev, .cb-prob').forEach(cb => cb.checked = false);
                            document.querySelectorAll('#matrixBody tr').forEach(r => r.style.opacity = '1');
                            this.querySelector('input').checked = true;
                            selKName = k.nama_kriteria;
                            selSVal  = sevVal;
                            selLevel = i;
                            selPVal  = null;
                            document.querySelectorAll('#matrixBody tr').forEach(r => {
                                if (r.getAttribute('data-level') != i) r.style.opacity = '0.4';
                            });
                            document.getElementById('status-kriteria').innerHTML   = `<strong>Kriteria:</strong> ${k.nama_kriteria}`;
                            document.getElementById('status-severity').innerHTML   = `<strong>Severity:</strong> ${sevVal}`;
                            document.getElementById('status-probability').innerHTML = `<strong>Probability:</strong> -`;
                        };
                        tr.appendChild(td);
                    });

                    // Kolom Keterangan
                    let tdKetBefore = document.createElement('td');
                    tdKetBefore.className = 'cell-keterangan';
                    tdKetBefore.style.fontSize = '7px';
                    tdKetBefore.innerHTML = `<strong>${levelDetail}</strong>`;
                    tr.appendChild(tdKetBefore);

                    for (let p = 1; p <= 5; p++) {
                        let score = i * p;
                        let cls, label;
                        if (isISO37001) {
                            cls   = score <= 3 ? 'bg-low' : score <= 12 ? 'bg-medium' : 'bg-high';
                            label = score <= 3 ? 'LOW'    : score <= 12 ? 'MEDIUM'    : 'HIGH';
                        } else {
                            cls   = score <= 2 ? 'bg-low' : score <= 4 ? 'bg-medium' : 'bg-high';
                            label = score <= 2 ? 'LOW'    : score <= 4 ? 'MEDIUM'    : 'HIGH';
                        }
                        let tdR   = document.createElement('td');
                        tdR.className = `cell-risk ${cls}`;
                        tdR.innerHTML = `<input type="checkbox" class="cb-prob"><br>${label}<br><span style="font-size: 20px; font-weight: bold; color: #00000;">${score}</span>`;
                        tdR.onclick = function() {
                            if (selLevel === null) { alert('Pilih Severity terlebih dahulu!'); return; }
                            if (i !== selLevel)    { alert(`Probability harus di Level ${selLevel}!`); return; }
                            document.querySelectorAll('.cb-prob').forEach(cb => cb.checked = false);
                            this.querySelector('input').checked = true;
                            selPVal = p;
                            document.getElementById('status-probability').innerHTML = `<strong>Probability:</strong> ${p}`;
                        };
                        tr.appendChild(tdR);
                    }
                    matrixBody.appendChild(tr);
                }
            }
        }

        document.getElementById('btnSimpanMatriks').onclick = function() {
            if (matrixMode === 'before') {
                if (!selKName || !selSVal || !selPVal) {
                    alert('Pilih deskripsi kriteria dan kotak probability pada baris yang sama!');
                    return;
                }
                document.getElementById('kriteriaSelect').value = selKName;
                updateSeverityDropdown('severity');
                updateSeverityDropdown('severityrisk');
                setTimeout(() => {
                    document.getElementById('severity').value    = selSVal;
                    document.getElementById('probability').value = selPVal;
                    calculateTingkatan();
                    document.querySelector('#modalMatriks .btn-close').click();
                }, 200);
            } else {
                // After: kriteria dikunci dari Before, severity & probability bisa berubah
                if (!selSVal || !selPVal) {
                    alert('Pilih Severity dan kotak Probability terlebih dahulu!');
                    return;
                }
                document.getElementById('severityrisk').value    = selSVal;
                document.getElementById('probabilityrisk').value = selPVal;
                calculateRisk();
                document.querySelector('#modalMatriks .btn-close').click();
            }
        };
    </script>
    <script>
        const kriteriaData = @json($kriteria);

        function updateSeverityDropdown(targetId) {
            const selKrit = document.getElementById('kriteriaSelect').value;
            const sel = document.getElementById(targetId);
            sel.innerHTML = '<option value="">--Pilih Severity--</option>';
            if (!selKrit) return;
            kriteriaData
                .filter(k => k.nama_kriteria === selKrit)
                .forEach(k => {
                    const vals = k.nilai_kriteria.replace(/[\[\]"]+/g, '').split(',');
                    const desc = k.desc_kriteria.replace(/[\[\]"]+/g, '').split(',');
                    vals.forEach((v, i) => {
                        const o = document.createElement('option');
                        o.value = v.trim();
                        o.textContent = v.trim() + ' - ' + (desc[i] || '');
                        sel.appendChild(o);
                    });
                });
        }

        document.getElementById('kriteriaSelect').addEventListener('change', function() {
            updateSeverityDropdown('severity');
            updateSeverityDropdown('severityrisk');
            // reset probabilities
            document.getElementById('probability').value = '';
            document.getElementById('probabilityrisk').value = '';
            if (typeof calculateTingkatan === 'function') calculateTingkatan();
            if (typeof calculateRisk === 'function') calculateRisk();
        });

        document.getElementById('severity').addEventListener('change', function() {
            document.getElementById('probability').value = '';
            if (typeof calculateTingkatan === 'function') calculateTingkatan();
        });

        document.getElementById('severityrisk').addEventListener('change', function() {
            document.getElementById('probabilityrisk').value = '';
            if (typeof calculateRisk === 'function') calculateRisk();
        });

        var isISO37001 = {{ $isISO37001 ? 'true' : 'false' }};

        function getTingkatanLevel(score) {
            if (isISO37001) {
                if (score >= 1 && score <= 3)  return 'LOW';
                if (score >= 4 && score <= 12) return 'MEDIUM';
                if (score >= 13)               return 'HIGH';
            } else {
                if (score >= 1 && score <= 2)  return 'LOW';
                if (score >= 3 && score <= 4)  return 'MEDIUM';
                if (score >= 5)                return 'HIGH';
            }
            return '';
        }

        function calculateTingkatan() {

            var probability = document.getElementById('probability').value;
            var severity = document.getElementById('severity').value;

            var levelInput = document.getElementById('level');
            var tingkatanInput = document.getElementById('tingkatan');

            if (probability && severity) {
            
                var score = parseInt(probability) * parseInt(severity);
            
                // isi level angka
                levelInput.value = score;
            
                // isi tingkatan
                tingkatanInput.value = getTingkatanLevel(score);
            
            } else {
            
                levelInput.value = '';
                tingkatanInput.value = '';
            
            }
        }
        function calculateRiskAfter() {

            var probability = document.getElementById('probabilityrisk').value;
            var severity = document.getElementById('severityrisk').value;
                
            var levelInput = document.getElementById('levelrisk');
            var tingkatanInput = document.getElementById('tingkatanrisk');
                
            if (probability && severity) {
            
                var score = parseInt(probability) * parseInt(severity);
            
                levelInput.value = score;
            
                tingkatanInput.value = getTingkatanLevel(score);
            
            } else {
            
                levelInput.value = '';
                tingkatanInput.value = '';
            
            }
        }

        function calculateRisk() {
            var p = +document.getElementById('probabilityrisk').value;
            var s = +document.getElementById('severityrisk').value;
            var r = '';
            if (p && s) {
                r = getTingkatanLevel(p * s);
            }
            document.getElementById('risk').value = r;
        }
        $(document).ready(function() {
            // Kriteria yang akan difilter
            var allKriteriaOptions = $('#kriteriaSelect option.kriteria-option');
                
            // Dropdown Divisi
            $('#divisiSelect').on('change', function() {
                var selectedDivisiId = $(this).val();
                
                // Sembunyikan semua opsi
                allKriteriaOptions.hide();
                $('#kriteriaSelect').val('');
                
                if (selectedDivisiId) {
                    // Tampilkan opsi yang data-divisi-nya cocok
                    $('#kriteriaSelect option[data-divisi="' + selectedDivisiId + '"]').show();
                } 
                
                // Pastikan opsi default terlihat
                $('#kriteriaSelect option[value=""]').show();
            });
            
            // Trigger perubahan awal (misalnya jika Divisi sudah terpilih saat load)
            var initialDivisi = $('#divisiSelect').val();
            if (initialDivisi) {
                $('#divisiSelect').trigger('change'); 
            } else {
                // Jika tidak ada Divisi terpilih, hanya tampilkan kriteria yang memiliki data-divisi yang sama dengan $three saat ini (untuk mode edit)
                var currentDivisiId = '{{ $three }}'; 
                if (currentDivisiId) {
                     allKriteriaOptions.hide();
                     $('#kriteriaSelect option[data-divisi="' + currentDivisiId + '"]').show();
                     $('#kriteriaSelect option[value=""]').show();
                }
            }
        });
    </script>
@endsection