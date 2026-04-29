@extends('layouts.main')

@section('content')

    <h5 class="card-title">Create Risk & Opportunity Register </h5>

    <!-- Tambahkan alert untuk menampilkan pesan error -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('riskregister.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_divisi" value="{{ $enchan }}" required>
        <input type="hidden" name="jenis_iso_id" value="2">

        <br>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">
                <strong>Bagian*</strong>
            </label>
        
            <div class="col-sm-10">
            
                @php
                    $userDivisi = auth()->user()->divisi ?? 'Divisi Tidak Ditemukan';
                    // Set default value untuk input
                    $valuePihak = old('pihak.0', $userDivisi);
                    // $divisiNames = $divisi->pluck('nama_divisi')->toArray();
                     $oldPihak = old('pihak', ['']); // ← minimal 1 row
                    // $oldCustom = old('pihak_custom', []);
                    // $oldKet = old('keterangan', []);
                @endphp

                <div id="pihak-list">
                
                    @foreach ($oldPihak as $i => $p)
                      {{--   @php
                            $isCustom = $p && !in_array($p, $divisiNames);
                            $customValue = $isCustom ? $p : ($oldCustom[$i] ?? '');
                            
                        @endphp --}}

                        <div class="mb-3 input-row">
                            <div class="row">
                                {{-- Label (Opsional, jika ingin seragam dengan Pengaju) --}}

                                <div class="col-sm-10">
                                    {{-- Input yang tampil ke user (readonly) --}}
                                    <select name="pihak[]" class="form-control">
                                        <option value="">-- Pilih Bagian --</option>

                                        @foreach($divisi as $d)
                                            <option value="{{ $d->nama_divisi }}"
                                                {{ $p == $d->nama_divisi ? 'selected' : '' }}>
                                                {{ $d->nama_divisi }}
                                            </option>
                                        @endforeach
                                        
                                    </select>
                                    {{-- <small class="text-muted">
                                        Bagian otomatis: <strong>{{ $userDivisi }}</strong>
                                    </small> --}}
                                </div>
                            </div>
                        </div>
                                {{-- Keterangan 
                                <div class="col-sm-7">
                                    <input type="text"
                                           name="keterangan[]"
                                           class="form-control"
                                           placeholder="Keterangan"
                                           value="{{ $oldKet[$i] ?? '' }}">
                                </div>--}}
                            
                                {{-- Hapus 
                                <div class="col-sm-1 text-end">
                                    <button type="button" class="btn btn-danger remove-row">×</button>
                                </div>--}}
                            
                </div>
                        
                            {{-- Custom Other
                            <div class="row mt-2 pihak-custom-row"
                                 style="display: {{ $isCustom ? 'flex' : 'none' }};">
                                <div class="col-sm-4">
                                    <input type="text"
                                           name="pihak_custom[]"
                                           class="form-control pihak-custom"
                                           placeholder="Masukkan Pihak Lainnya"
                                           value="{{ $customValue }}">
                                </div>
                            </div> --}}
                        
                 </div>
             @endforeach
                    
         </div>
            
               {{-- <button type="button" id="add-row" class="btn btn-outline-primary btn-sm">
                    + Tambah Bagian
                </button>
             --}} 
            </div>
        </div>


        <script>
        document.addEventListener('DOMContentLoaded', () => {
        
            const list = document.getElementById('pihak-list');
            const addBtn = document.getElementById('add-row');
        
            const divisiOptions = `
                @foreach ($divisi as $d)
                    <option value="{{ $d->nama_divisi }}">{{ $d->nama_divisi }}</option>
                @endforeach
                <option value="Other">Other</option>
            `;
        
            // toggle other
            list.addEventListener('change', e => {
                if (!e.target.matches('.pihak-select')) return;
            
                const row = e.target.closest('.input-row');
                const customRow = row.querySelector('.pihak-custom-row');
            
                if (e.target.value === 'Other') {
                    customRow.style.display = 'flex';
                } else {
                    customRow.style.display = 'none';
                    row.querySelector('.pihak-custom').value = '';
                }
            });
        
            // tambah row
            addBtn.addEventListener('click', () => {
                const div = document.createElement('div');
                div.className = 'mb-3 input-row';
            
                div.innerHTML = `
                    <div class="row">
                        <div class="col-sm-4">
                            <select name="pihak[]" class="form-select pihak-select">
                                <option value="">-- Pilih Pihak --</option>
                                ${divisiOptions}
                            </select>
                        </div>
                    
                        <div class="col-sm-7">
                            <input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan">
                        </div>
                    
                        <div class="col-sm-1 text-end">
                            <button type="button" class="btn btn-danger remove-row">×</button>
                        </div>
                    </div>
                
                    <div class="row mt-2 pihak-custom-row" style="display:none;">
                        <div class="col-sm-4">
                            <input type="text" name="pihak_custom[]" class="form-control pihak-custom"
                                   placeholder="Masukkan Pihak Lainnya">
                        </div>
                    </div>
                `;
                
                list.appendChild(div);
            });
        
            // hapus row
            list.addEventListener('click', e => {
                if (e.target.matches('.remove-row')) {
                    e.target.closest('.input-row').remove();
                }
            });
        
        });
        </script>


        <br>

        <!-- Bagian untuk mengisi Issue -->
        <div class="row mb-3">
            <label for="inputIssue" class="col-sm-2 col-form-label"><strong>Nama Proses*</strong></label>
            <div class="col-sm-7">
                <textarea name="issue" class="form-control" rows="3" placeholder="Masukkan Proses" required></textarea>
            </div>
        </div>
        <br>

       <div class="row mb-3 ">
           <label for="inputaktifitaskunci" class="col-sm-2 col-form-label"><strong>Aktifitas Kunci</strong></label>
           <div class="col-sm-7">
             <textarea name="aktifitas_kunci" class="form-control" rows="2"
                       placeholder="Aktifitas kunci dari proses/issue ini"></textarea>
           </div>
        </div>

        <br>

        <div id="collapseResiko" class="accordion-collapse collapse show" aria-labelledby="headingResiko"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row mb-3">
                            <label for="inputRisiko" class="col-sm-2 col-form-label"><strong>Potensi Risk Penyuapan</strong></label>
                            <div class="col-sm-7">
                                <textarea id="inputRisiko" name="nama_resiko" class="form-control" placeholder="Masukkan Potensi" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
        {{--  <div class="accordion" id="accordionExample">
            <!-- Bagian Risiko -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingResiko">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseResiko" aria-expanded="true" aria-controls="collapseResiko">
                        <strong>Risiko</strong>
                    </button>
                </h2>
                
            </div>--}}

            <!-- Bagian Peluang
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPeluang">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePeluang" aria-expanded="false" aria-controls="collapsePeluang">
                        <strong>Peluang</strong>
                    </button>
                </h2>
                <div id="collapsePeluang" class="accordion-collapse collapse" aria-labelledby="headingPeluang"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row mb-3">
                            <label for="inputPeluang" class="col-sm-2 col-form-label"><strong>Peluang</strong></label>
                            <div class="col-sm-7">
                                <textarea id="inputPeluang" name="peluang" class="form-control" placeholder="Masukkan Peluang" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  -->
        </div>

        <!-- Script -->
        <script>
            const inputRisiko = document.getElementById('inputRisiko');
            const inputPeluang = document.getElementById('inputPeluang');

            // Event listener untuk risiko
            inputRisiko.addEventListener('input', function() {
                if (inputRisiko.value.trim() !== '') {
                    inputPeluang.disabled = true; // Nonaktifkan input peluang
                } else {
                    inputPeluang.disabled = false; // Aktifkan kembali jika risiko kosong
                }
            });

            // Event listener untuk peluang
            inputPeluang.addEventListener('input', function() {
                if (inputPeluang.value.trim() !== '') {
                    inputRisiko.disabled = true; // Nonaktifkan input risiko
                } else {
                    inputRisiko.disabled = false; // Aktifkan kembali jika peluang kosong
                }
            });
        </script>

        <br>

        {{-- <div class="row mb-3">
            <label for="inex" class="col-sm-2 col-form-label"><strong>I/E*</strong></label>
            <div class="col-sm-4">
                <select name="inex" class="form-control" required>
                    <option value="">--Silahkan Pilih--</option>
                    <option value="I">INTERNAL</option>
                    <option value="E">EXTERNAL</option>
                </select>
            </div>
        </div> --}}
        <br>

        <div class="row mb-3">
                <label for="inputIssue" class="col-sm-2 col-form-label" "><strong>Skema Modus Operandi</strong></label>
                <div class="col-sm-7">
                    <textarea name="before" placeholder="Masukkan Deskripsi Saat Ini atau sebelum tindakan lanjut (mitigasi) dilakukan"
                        class="form-control" rows="3"></textarea>
                </div>
        </div>

        <!-- Kriteria Dropdown -->
        <div class="row mb-3">
            <label for="kriteria" class="col-sm-2 col-form-label"><strong>Kriteria*</strong></label>
            <div class="col-sm-4">
                <div class="input-group">
                    <select name="kriteria" class="form-control" id="kriteriaSelect" required onchange="updateSeverityDropdown()">
                        <option value="">--Pilih Kriteria--</option>
                        @foreach ($kriteria as $k)
                            <option value="{{ $k->nama_kriteria }}">{{ $k->nama_kriteria }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMatriks">
                        <i class="bi bi-grid-3x3"></i> Set Pre-Matrix
                    </button>
                </div>
            </div>
        </div>

        <!-- Severity Dropdown -->
        <div class="row mb-3">
            <label for="severity" class="col-sm-2 col-form-label"><strong>Severity / Dampak*</strong></label>
            <div class="col-sm-4">
                <select class="form-select" name="severity" id="severity" required>
                    <option value="">--Pilih Severity--</option>
                    <!-- Opsi severity akan diisi secara dinamis di sini -->
                </select>
            </div>
        </div>

        <style>
            /* CSS untuk memaksimalkan ruang dan menampilkan deskripsi di bawah nilai */
            #severity option {
                white-space: normal;
                /* Memungkinkan teks untuk membungkus ke baris baru */
                word-wrap: break-word;
                /* Membungkus kata jika panjangnya melebihi lebar dropdown */
            }
        </style>


        <script>
            // Simulasi data kriteria (ambil ini dari database menggunakan Laravel)
            const kriteriaData = @json($kriteria);

            // Function untuk mengupdate dropdown severity berdasarkan kriteria yang dipilih
            function updateSeverityDropdown() {
                const selectedKriteria = document.getElementById('kriteriaSelect').value;
                const severitySelect = document.getElementById('severity');
                severitySelect.innerHTML = '<option value="">--Pilih Severity--</option>'; // Clear previous options

                if (selectedKriteria) {
                    // Filter kriteria berdasarkan nama yang dipilih
                    const filteredKriteria = kriteriaData.filter(k => k.nama_kriteria === selectedKriteria);

                    filteredKriteria.forEach(kriteria => {
                        // Memisahkan nilai_kriteria dan desc_kriteria menjadi array
                        const nilaiKriteriaString = kriteria.nilai_kriteria.replace(/[\[\]"]+/g,
                            ''); // Menghapus [ ] dan tanda kutip ganda
                        const descKriteriaString = kriteria.desc_kriteria.replace(/[\[\]"]+/g,
                            ''); // Menghapus [ ] dan tanda kutip ganda

                        const nilaiKriteriaArray = nilaiKriteriaString.split(',').map(v => v.trim());
                        const descKriteriaArray = descKriteriaString.split(',').map(v => v.trim());

                        // Loop melalui setiap pasangan nilai dan deskripsi kriteria
                        for (let i = 0; i < nilaiKriteriaArray.length; i++) {
                            const option = document.createElement('option');
                            option.value = nilaiKriteriaArray[i];
                            // Menambahkan deskripsi di bawah nilai
                            option.textContent = `${nilaiKriteriaArray[i]}\n${descKriteriaArray[i]}`;
                            severitySelect.appendChild(option);
                        }
                    });
                }
            }

            // Memastikan dropdown severity diupdate saat kriteria dipilih
            document.getElementById('kriteriaSelect').addEventListener('change', updateSeverityDropdown);
        </script>

        <!-- Probability -->
        <div class="row mb-3">
            <label for="probability" class="col-sm-2 col-form-label"><strong>Probability / Kemungkinan
                    Terjadi*</strong></label>
            <div class="col-sm-4">
                <select class="form-select" name="probability" id="probability" required
                    onchange="calculateTingkatan()">
                    <option value="">--Silahkan Pilih Probability--</option>
                    <option value="1" {{ old('probability') == 1 ? 'selected' : '' }}>1. Sangat Jarang
                    </option>
                    <option value="2" {{ old('probability') == 2 ? 'selected' : '' }}>2. Jarang</option>
                    <option value="3" {{ old('probability') == 3 ? 'selected' : '' }}>3. Kadang Kadang</option>
                    <option value="4" {{ old('probability') == 4 ? 'selected' : '' }}>4. Sering </option>
                    <option value="5" {{ old('probability') == 5 ? 'selected' : '' }}>5. Sangat Sering</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="level" class="col-sm-2 col-form-label"><strong>Level</strong></label>
            <div class="col-sm-4">
                <input type="text" placeholder="Nilai Otomatis"class="form-control" readonly name="level"
                    id="level" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="tingkatan" class="col-sm-2 col-form-label"><strong>Tingkatan</strong></label>
            <div class="col-sm-4">
                <input type="text" placeholder="Nilai Otomatis"class="form-control" readonly name="tingkatan"
                    id="tingkatan" required>
            </div>
        </div>

        <hr>
        <h5 class="card-title">Tindakan Terhadap Resiko </h5>

        <!-- Bagian untuk mengisi Tindakan, Pihak, Target, dan PIC -->
        <div id="inputContainer">
            <!-- Input sections yang bisa ditambahkan oleh user -->
            <div class="dynamic-inputs">
                <div class="row mb-3">
                    <label for="inputTindakan" class="col-sm-2 col-form-label"><strong>Tindakan</strong></label>
                    <div class="col-sm-7">
                        <textarea placeholder="Masukkan Tindakan" name="nama_tindakan[]" class="form-control"
                            placeholder="Masukkan Tindakan Lanjut" rows="3" required></textarea>
                    </div>
                </div>
                <div class="row mb-3 acuan-row">
                  <label for="inputacuan"class="col-sm-2 col-form-label"><strong>Acuan</strong></label>
                  <div class="col-sm-7">
                    <textarea type="text" name="acuan[]" class="form-control"
                           placeholder=""></textarea>
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="inputTarget" class="col-sm-2 col-form-label"><strong>Target Tanggal Tindakan
                            Lanjut*</strong></label>
                    <div class="col-sm-7">
                        <input type="date" name="tgl_penyelesaian[]" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPIC" class="col-sm-2 col-form-label"><strong>PIC*</strong></label>
                    <div class="col-sm-7">
                        <select name="targetpic[]" class="form-select" required>
                            <option value="">Pilih PIC</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->nama_user }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tombol Add More berada di bawah input -->
            <div>
                <button type="button" class="btn btn-secondary" id="addMore">Add More</button>
            </div>

            <hr>

            

                                {{--  <div class="row mb-3">
                                    <label for="inputTarget" class="col-sm-2 col-form-label"><strong>Target Tanggal Besar Penyelesaian Issue*</strong></label>
                                    <div class="col-sm-7">
                                        <input type="date" name="target_penyelesaian" class="form-control" >
                                    </div>
                                </div>--}}

                                {{-- status --}}
                                <div class="row mb-3" style="display: none;">
                                    <label for="inputStatus" class="col-sm-2 col-form-label"><strong>Status</strong></label>
                                    <div class="col-sm-7">
                                        <select type="hidden" name="status" class="form-control" required>
                                            {{-- <option value="">-- Pilih Status --</option> --}}
                                            <option value="OPEN">OPEN</option>
                                            {{-- <option value="ON PROGRESS">ON PROGRESS</option>
                <option value="CLOSE">CLOSE</option> --}}
                                        </select>
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <!-- modal matrix -->
                            <div class="modal fade" id="modalMatriks" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen p-3">
                                    <div class="modal-content">
                                        <div class="modal-header bg-white text-black p-2">
                                            <h6 class="modal-title">Set Pre-Matrix: Pilih Severity & Probability</h6>
                                            <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <div class="bg-light p-2 border-bottom d-flex gap-3 sticky-top">
                                                <div id="status-kriteria"><strong>Kriteria:</strong> -</div>
                                                <div id="status-severity"><strong>Severity:</strong> -</div>
                                                <div id="status-probability"><strong>Probability:</strong> -</div>
                                            </div>
                                            
                                            <div class="table-responsive">
                                                <table id="matrixTable" class="table table-bordered align-middle m-0 text-center">

                                                    <thead class="table-white text-center">
                                                        <tr>
                                                            <th rowspan="2" style="width: 120px;">Level</th>
                                                            <th id="kriteriaHeaderContainer">Kriteria </th>
                                                            <th colspan="5">Probability </th>
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
                                            <button type="button"
                                                    class="btn btn-primary"
                                                    data-bs-dismiss="modal" id="btnSimpanMatriks">
                                                Simpan ke Form
                                            </button>
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
                                    vertical-align: top !important; /* Teks mulai dari atas kotak */
                                    background-color: #fafafa;
                                    min-width: 250px; /* Berikan ruang yang cukup */
                                    padding: 8px !important;
                                }
                                .cell-keterangan ul {
                                    list-style-type: disc;
                                }
                                .cell-keterangan li {
                                    margin-bottom: 4px; /* Jarak antar poin */
                                }
                            </style>

                            <!-- Full Screen Modal -->
                            <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-labelledby="fullscreenModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="fullscreenModalLabel">Severity / Keparahan</h3>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="modalContent">
                                            <!-- Dynamic content will be injected here based on selected kriteria -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Script untuk menambah input " Add More" -->
                    <script>
                        function calculateTingkatan() {
    var probability = document.getElementById('probability').value;
    var severity = document.getElementById('severity').value;
    var levelInput = document.getElementById('level');
    var tingkatanInput = document.getElementById('tingkatan');

    // Cek apakah kedua input sudah terisi
    if (probability && severity) {
        var score = parseInt(probability) * parseInt(severity);
        
        // Isi nilai Level (Angka)
        levelInput.value = score;

        // Tentukan teks Tingkatan
        var tingkatan = '';
        if (score >= 1 && score <= 3) {
            tingkatan = 'LOW';
        } else if (score >= 4 && score <= 12) {
            tingkatan = 'MEDIUM';
        } else if (score >= 13 && score <= 25) {
            tingkatan = 'HIGH';
        }
        
        // Isi nilai Tingkatan
        tingkatanInput.value = tingkatan;

    } else {
        // Jika salah satu kosong, bersihkan kedua field otomatis
        levelInput.value = '';
        tingkatanInput.value = '';
    }
}

                        document.getElementById('addMore').addEventListener('click', function() {
                            // Membuat elemen input baru
                            var newInputSection = `
                            <div class="dynamic-input mb-3">
                                <div class="row mb-3">
                                    <label for="inputTindakan" class="col-sm-2 col-form-label"><strong>Tindakan Lanjut*</strong></label>
                                    <div class="col-sm-7">
                                        <textarea placeholder="Masukkan Tindakan" name="nama_tindakan[]" class="form-control" placeholder="Masukkan Tindakan Lanjut" rows="3" required></textarea>
                                    </div>
                                </div>
                            
                                <div class="row mb-3 acuan-row ">
                                  <label for="inputacuan" class="col-sm-2 col-form-label"><strong>Acuan</strong></label>
                                  <div class="col-sm-7">
                                    <textarea type="text" name="acuan[]" class="form-control"
                                           placeholder=""></textarea>
                                  </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputTarget" class="col-sm-2 col-form-label"><strong>Target Tanggal Tindakan Lanjut*</strong></label>
                                    <div class="col-sm-7">
                                        <input type="date" name="tgl_penyelesaian[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputPIC" class="col-sm-2 col-form-label"><strong>PIC*</strong></label>
                                    <div class="col-sm-7">
                                        <select name="targetpic[]" class="form-select" required>
                                            <option value="">Pilih PIC</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->nama_user }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <button type="button" class="btn btn-danger btn-sm deleteSection" style="margin-top: 10px;">Delete</button>
                            </div>
                                  `;              
                                            // Menambahkan input baru setelah input yang ada
                                            var dynamicContainer = document.querySelector('.dynamic-inputs');
                                            dynamicContainer.insertAdjacentHTML('beforeend', newInputSection);
                                        });
                                    
                                        // Event listener untuk tombol delete
                                        document.addEventListener('click', function(event) {
                                            if (event.target && event.target.classList.contains('deleteSection')) {
                                                var sectionToRemove = event.target.closest('.dynamic-input');
                                                sectionToRemove.remove();
                                            }
                                        });
                                            document.addEventListener('DOMContentLoaded', function() {
                                            const kriteriaData = @json($kriteria);
                                            const matrixBody = document.getElementById('matrixBody');
                                            const kriteriaHeaderContainer = document.getElementById('kriteriaHeaderContainer');
                                                                                
                                            let selectedKName = null;
                                            let selectedSVal = null;
                                            let selectedPVal = null;
                                            let selectedLevel = null; // Menampung baris yang dipilih
                                                                                
                                            // 1. Render Header Kriteria secara Dinamis
                                            if(kriteriaData && kriteriaData.length > 0) {
                                                kriteriaHeaderContainer.colSpan = kriteriaData.length + 1;
                                                const probHeaderRow = document.getElementById('probabilityHeaderRow');
                                                
                                                // Bersihkan area sebelum render (mencegah error prepend)
                                                kriteriaData.forEach(k => {
                                                    const th = document.createElement('th');
                                                    th.textContent = k.nama_kriteria;
                                                    th.className = "bg-secondary text-white text-center column-kriteria";
                                                    const firstProbTh = probHeaderRow.querySelector('.bg-primary');
                                                    probHeaderRow.insertBefore(th, firstProbTh);
                                                });
                                                // TAMBAHKAN INI: Render Header Kolom Keterangan di akhir Kriteria
                                                    const thKet = document.createElement('th');
                                                    thKet.textContent = "Keterangan";
                                                    thKet.className = "bg-white text-black text-center";
                                                    thKet.style.width = "150px";
                                                    const firstProbTh = probHeaderRow.querySelector('.bg-primary');
                                                    probHeaderRow.insertBefore(thKet, firstProbTh);
                                                
                                            }
                                        
                                            // 2. Render Baris Matriks (Level 1 - 5)
                                            for (let i = 1; i <= 5; i++) {
                                                let tr = document.createElement('tr');
                                                tr.setAttribute('data-level', i); // Tandai baris dengan atribut level

                                                let levelDesc = "";
                                                let levelDetail = "";
                                               if (i === 1) {
                                                    levelDesc = "Tidak Signifikan (Sangat Rendah)";
                                                    levelDetail = `
                                                        <ul class="text-start m-0 ps-3" style="font-size: 8px;">
                                                            <li>Dampak sangat kecil terhadap SMAP</li>
                                                            <li>Tidak menimbulkan pelanggaran kebijakan anti penyuapan</li>
                                                            <li>Tidak berdampak hukum, finansial, atau reputasi</li>
                                                            <li>Tidak mempengaruhi efektivitas pengendalian internal SMAP</li>
                                                            <li>Dapat ditangani langsung tanpa tindakan korektif formal</li>
                                                        </ul>`;
                                                }
                                                else if (i === 2) {
                                                    levelDesc = "Kurang Signifikan (Rendah)";
                                                    levelDetail = `
                                                        <ul class="text-start m-0 ps-3" style="font-size: 8px;">
                                                            <li>Dampak kecil dan terbatas pada sebagian proses</li>
                                                            <li>Potensi ketidak sesuaian minor tetrhadap prosedur</li>
                                                            <li>Tidak melibatkan indikasi penyuapan aktual</li>
                                                            <li>Tidak berdampak hukum</li>
                                                            <li>Dampak finansial sangat kecil dan reputasi tidak terpengaruh</li>
                                                        </ul>`;
                                                }
                                                else if (i === 3) {
                                                    levelDesc = "Sedang (Menengah)";
                                                    levelDetail = `
                                                        <ul class="text-start m-0 ps-3" style="font-size: 8px;">
                                                            <li>Dampak "cukup berarti" dan perlu perhatian FKAP</li>
                                                            <li>Kelemahan pengendalian yang "berpotensi memungkinkan penyuapan"</li>
                                                            <li>Ketidaksesuaian terhadap kebijakan atau prosedur SMAP</li>
                                                            <li>Berpotensi menimbulkan temuan audit atau komplain</li>
                                                            <li>Memerlukan tindakan korektif terstruktur</li>
                                                        </ul>`;
                                                }
                                                else if (i === 4) {
                                                  levelDesc = "Signifikan (Tinggi)";
                                                  levelDetail = `
                                                        <ul class="text-start m-0 ps-3" style="font-size: 8px;">
                                                            <li>Dampak "besar" terhadap efektivitas SMAP</li>
                                                            <li>Kegagalan pengendalian yang dapat "mengarah pada praktik penyuapan"</li>
                                                            <li>Potensi pelanggaran hukum atau regulasi</li>
                                                            <li>Dampak finansial dan reputasi yang nyata</li>
                                                            <li>Membutuhkan tindakan korektif segera dan pengawasan FKAP</li>
                                                        </ul>`;
                                                }
                                                else if (i === 5) {
                                                    levelDesc = "Sangat Signifikan (Sangat Tinggi)";
                                                    levelDetail = `
                                                        <ul class="text-start m-0 ps-3" style="font-size: 8px;">
                                                            <li>Dampak "sangat besar dan kritikal" terjadi atau mungkin terjadi "praktik penyuapan aktual" </li>
                                                            <li>Pelanggaran hukum serius (Pidana/Perdata)</li>
                                                            <li>Kerugian finansial material</li>
                                                            <li>Dampak reputasi yang berat dan berjangka panjang</li>
                                                            <li>Mengancam keberlangsungan organisasi atau sertifikasi ISO 37001</li>
                                                            <li>Melibatkan Manajemen Puncak/ada persetujuan atau pembiaran oleh Manajemen</li>
                                                            <li>Berhubungan dengan pejabat publik dengan nilai suap besar</li>
                                                            <li>Potensi menghentikan bisnis</li>
                                                            <li>Dampak jangka panjang dan sistemik</li>
                                                        </ul>`;
                                                }
                                                tr.innerHTML = `
                                                <td class="text-center fw-bold bg-light" style="min-width: 80px;">
                                                    ${i}<br>
                                                    <small class=" fw-normal" style="font-size: 12px;">${levelDesc}</small>
                                                </td>`;
                                            
                                                // Render Kolom Severity (Deskripsi Kriteria)
                                                kriteriaData.forEach(k => {
                                                    const descArr = k.desc_kriteria.replace(/[\[\]"]+/g, '').split(',');
                                                    const nilaiArr = k.nilai_kriteria.replace(/[\[\]"]+/g, '').split(',');
                                                    const deskripsi = descArr[i-1] ? descArr[i-1].trim() : '-';
                                                    const sevVal = nilaiArr[i-1] ? nilaiArr[i-1].trim() : i;
                                                
                                                    let td = document.createElement('td');
                                                    td.className = "cell-desc";
                                                    td.innerHTML = `<input type="checkbox" class="cb-sev"> ${deskripsi}`;
                                                
                                                    td.onclick = function() {
                                                        // Reset semua pilihan
                                                        document.querySelectorAll('.cb-sev, .cb-prob').forEach(cb => cb.checked = false);
                                                        document.querySelectorAll('tr').forEach(r => r.style.opacity = "1");
                                                    
                                                        // Aktifkan pilihan ini
                                                        this.querySelector('input').checked = true;
                                                        selectedKName = k.nama_kriteria;
                                                        selectedSVal = sevVal.trim();

                                                        selectedLevel = i; // Kunci level di sini
                                                        selectedPVal = null; // Reset probability karena pindah baris
                                                    
                                                        // Visual: Redupkan baris lain agar user fokus pada baris yang sama
                                                        document.querySelectorAll('#matrixBody tr').forEach(r => {
                                                            if(r.getAttribute('data-level') != i) r.style.opacity = "0.4";
                                                        });
                                                    
                                                        document.getElementById('status-kriteria').innerHTML = `<strong>Kriteria:</strong> ${k.nama_kriteria}`;
                                                        document.getElementById('status-severity').innerHTML = `<strong>Severity:</strong> ${sevVal}`;
                                                        document.getElementById('status-probability').innerHTML = `<strong>Probability:</strong> -`;
                                                    };
                                                    tr.appendChild(td);
                                                });
                                                        let tdKet = document.createElement('td');
                                                        tdKet.className = "cell-keterangan";
                                                        tdKet.style.fontSize = "7px";
                                                        tdKet.innerHTML = `<strong>${levelDetail}</strong>`;
                                                        tr.appendChild(tdKet);
                                            
                                                // Render Kolom Probability (Kotak Warna)
                                                for (let p = 1; p <= 5; p++) {
                                                    let score = i * p;
                                                    let riskClass = (score <= 3) ? 'bg-low' : (score <= 12) ? 'bg-medium' : 'bg-high';
                                                    let riskLabel = (score <= 3) ? 'LOW' : (score <= 12) ? 'MEDIUM' : 'HIGH';
                                                
                                                    let tdRisk = document.createElement('td');
                                                    tdRisk.className = `cell-risk ${riskClass}`;
                                                    tdRisk.innerHTML = `<input type="checkbox" class="cb-prob"><br>${riskLabel}<br><span style="font-size: 20px; font-weight: bold; color: #00000;">${score}</span>`;
                                                    tdRisk.onclick = function() {
                                                        // VALIDASI: Cek apakah barisnya sama dengan Severity yang dipilih
                                                        if (selectedLevel === null) {
                                                            alert('Silahkan pilih deskripsi kriteria (Severity) terlebih dahulu!');
                                                            return;
                                                        }
                                                        if (i !== selectedLevel) {
                                                            alert('Salah baris! Anda memilih Severity di Level ' + selectedLevel + ', maka Probability juga harus di Level ' + selectedLevel);
                                                            return;
                                                        }
                                                    
                                                        // Reset checkbox probability hanya di baris aktif
                                                        document.querySelectorAll('.cb-prob').forEach(cb => cb.checked = false);
                                                        this.querySelector('input').checked = true;
                                                    
                                                        selectedPVal = p;
                                                        document.getElementById('status-probability').innerHTML = `<strong>Probability:</strong> ${p}`;
                                                    };
                                                    tr.appendChild(tdRisk);
                                                }
                                                matrixBody.appendChild(tr);
                                            }
                                        
                                            // Fungsi Simpan (Tetap Sama)
                                            document.getElementById('btnSimpanMatriks').onclick = function() {
                                                if(!selectedKName || !selectedSVal || !selectedPVal) {
                                                    alert('Silahkan pilih 1 deskripsi kriteria dan 1 kotak probability pada baris yang sama!');
                                                    return;
                                                }
                                                document.getElementById('kriteriaSelect').value = selectedKName;
                                                updateSeverityDropdown();
                                                setTimeout(() => {
                                                    document.getElementById('severity').value = selectedSVal;
                                                    document.getElementById('probability').value = selectedPVal;
                                                    calculateTingkatan(); 
                                                    bootstrap.Modal.getInstance(document.getElementById('modalMatriks')).hide();
                                                }, 200);
                                            };
                                        });                     
                                    </script>

                @endsection
