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
        <input type="hidden" name="jenis_iso_id" value="1">

        <!-- Bagian untuk mengisi Issue -->
        <div class="row mb-3">
            <label for="inputIssue" class="col-sm-2 col-form-label"><strong>Issue*</strong></label>
            <div class="col-sm-7">
                <textarea name="issue" class="form-control" rows="3" placeholder="Masukkan Issue" required></textarea>
            </div>
        </div>
        <br>

        <div class="row mb-3">
            <label for="inex" class="col-sm-2 col-form-label"><strong>I/E*</strong></label>
            <div class="col-sm-4">
                <select name="inex" class="form-control" required>
                    <option value="">--Silahkan Pilih--</option>
                    <option value="I">INTERNAL</option>
                    <option value="E">EXTERNAL</option>
                </select>
            </div>
        </div>
        <br>

        <!-- Default Accordion -->
        <div class="accordion" id="accordionExample">
            <!-- Bagian Risiko -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingResiko">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseResiko" aria-expanded="true" aria-controls="collapseResiko">
                        <strong>Risiko</strong>
                    </button>
                </h2>
                <div id="collapseResiko" class="accordion-collapse collapse show" aria-labelledby="headingResiko"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row mb-3">
                            <label for="inputRisiko" class="col-sm-2 col-form-label"><strong>Risiko</strong></label>
                            <div class="col-sm-7">
                                <textarea id="inputRisiko" name="nama_resiko" class="form-control" placeholder="Masukkan Risiko" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Peluang -->
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
            </div>
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
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label"><strong>Pihak Berkepentingan*</strong></label>
            <div class="col-sm-10">
                @php
                    // Daftar nama divisi dari DB
                    $divisiNames = $divisi->pluck('nama_divisi')->toArray();

                    // Fallback ke old() atau data awal
                    $selectedDivisi = [];
                    $oldPihak = old('pihak', $selectedDivisi);
                    $oldCustom = old('pihak_custom', []);
                    $oldKet = old('keterangan', $riskregister->keterangan ?? []);
                @endphp

                <div id="pihak-list">
                    @foreach ($oldPihak as $i => $p)
                        @php
                            // Deteksi custom: jika $p tidak ada di daftar divisi
                            $isCustom = !in_array($p, $divisiNames);
                            // Jika custom, nilai pihak_custom default-nya $p, bukan oldCustom[$i]
                            $customValue = $isCustom ? $p : $oldCustom[$i] ?? '';
                        @endphp

                        <div class="mb-3 input-row">
                            <div class="row">
                                {{-- Dropdown --}}
                                <div class="col-sm-4">
                                    <select name="pihak[]" class="form-select pihak-select">
                                        <option value="">-- Pilih Pihak --</option>
                                        @foreach ($divisi as $d)
                                            <option value="{{ $d->nama_divisi }}"
                                                {{ !$isCustom && $p === $d->nama_divisi ? 'selected' : '' }}>
                                                {{ $d->nama_divisi }}
                                            </option>
                                        @endforeach
                                        {{-- Option Other --}}
                                        <option value="Other" {{ $isCustom ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                {{-- Keterangan --}}
                                <div class="col-sm-7">
                                    <input type="text" name="keterangan[]" class="form-control" placeholder="Keterangan"
                                        value="{{ $oldKet[$i] ?? '' }}">
                                </div>

                                {{-- Hapus --}}
                                <div class="col-sm-1 text-end">
                                    <button type="button" class="btn btn-danger remove-row">×</button>
                                </div>
                            </div>

                            {{-- Baris input Other, tampil jika isCustom --}}
                            <div class="row mt-2 pihak-custom-row" style="display: {{ $isCustom ? 'flex' : 'none' }};">
                                <div class="col-sm-4">
                                    <input type="text" name="pihak_custom[]" class="form-control pihak-custom"
                                        placeholder="Masukkan Pihak Lainnya" value="{{ $customValue }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <button type="button" id="add-row" class="btn btn-outline-primary btn-sm">
                    + Tambah Pihak
                </button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // 1) Ambil container sekali
                const list = document.getElementById('pihak-list');
                const addBtn = document.getElementById('add-row');

                // 2) Siapkan opsi dropdown
                const divisiOptions = `
    @foreach ($divisi as $d)
      <option value="{{ $d->nama_divisi }}">{{ $d->nama_divisi }}</option>
    @endforeach
    <option value="Other">Other</option>
  `;

                // 3) Toggle baris .pihak-custom-row saat select berubah
                list.addEventListener('change', e => {
                    if (!e.target.matches('.pihak-select')) return;
                    const row = e.target.closest('.input-row');
                    const customRow = row.querySelector('.pihak-custom-row');
                    if (e.target.value === 'Other') {
                        customRow.style.display = 'flex';
                    } else {
                        customRow.style.display = 'none';
                        customRow.querySelector('.pihak-custom').value = '';
                    }
                });

                // 4) Fungsi buat baris baru (mirror struktur Blade)
                function newRow() {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'mb-3 input-row';
                    wrapper.innerHTML = `
      <div class="row">
        <div class="col-sm-4">
          <select name="pihak[]" class="form-select pihak-select">
            <option value="">-- Pilih Pihak --</option>
            ${divisiOptions}
          </select>
        </div>
        <div class="col-sm-7">
          <input type="text"
                 name="keterangan[]"
                 class="form-control"
                 placeholder="Keterangan">
        </div>
        <div class="col-sm-1 text-end">
          <button type="button" class="btn btn-danger remove-row">×</button>
        </div>
      </div>
      <div class="row mt-2 pihak-custom-row" style="display:none;">
        <div class="col-sm-4">
          <input type="text"
                 name="pihak_custom[]"
                 class="form-control pihak-custom"
                 placeholder="Masukkan Pihak Lainnya">
        </div>
      </div>`;
                    return wrapper;
                }

                // 5) Tambah baris baru
                addBtn.addEventListener('click', () => {
                    list.appendChild(newRow());
                });

                // 6) Hapus baris
                list.addEventListener('click', e => {
                    if (e.target.matches('.remove-row')) {
                        e.target.closest('.input-row').remove();
                    }
                });
            });
        </script>

        <!-- JavaScript to handle the 'select all' functionality -->
        <script>
            // Handle "Select All" checkbox functionality
            document.getElementById('select-all').addEventListener('change', function() {
                let checkboxes = document.querySelectorAll('.checkbox-group input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked; // Set all checkboxes to match 'Select All' status
                });
            });
        </script>

        <br>
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
                   {{--  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMatriks">
                        <i class="bi bi-grid-3x3"></i> Set Pre-Matrix
                    </button>   --}}
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

                        const nilaiKriteriaArray = nilaiKriteriaString.split(','); // Memisahkan dengan koma
                        const descKriteriaArray = descKriteriaString.split(','); // Memisahkan dengan koma

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
                    <option value="1" {{ old('probability') == 1 ? 'selected' : '' }}>1. Sangat jarang terjadi
                    </option>
                    <option value="2" {{ old('probability') == 2 ? 'selected' : '' }}>2. Jarang terjadi</option>
                    <option value="3" {{ old('probability') == 3 ? 'selected' : '' }}>3. Dapat Terjadi</option>
                    <option value="4" {{ old('probability') == 4 ? 'selected' : '' }}>4. Sering terjadi</option>
                    <option value="5" {{ old('probability') == 5 ? 'selected' : '' }}>5. Selalu terjadi</option>
                </select>
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
        <h5 class="card-title">Tindakan Lanjut </h5>

        <!-- Bagian untuk mengisi Tindakan, Pihak, Target, dan PIC -->
        <div id="inputContainer">
            <!-- Input sections yang bisa ditambahkan oleh user -->
            <div class="dynamic-inputs">
                <div class="row mb-3">
                    <label for="inputTindakan" class="col-sm-2 col-form-label"><strong>Tindakan Lanjut*</strong></label>
                    <div class="col-sm-7">
                        <textarea placeholder="Masukkan Tindakan" name="nama_tindakan[]" class="form-control"
                            placeholder="Masukkan Tindakan Lanjut" rows="3" required></textarea>
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

            <div class="row mb-3">
                <label for="inputIssue" class="col-sm-2 col-form-label" "><strong>Before</strong></label>
                                    <div class="col-sm-7">
                                        <textarea name="before" placeholder="Masukkan Deskripsi Saat Ini atau sebelum tindakan lanjut (mitigasi) dilakukan"
                                            class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputTarget" class="col-sm-2 col-form-label"><strong>Target Tanggal Besar Penyelesaian Issue*</strong></label>
                                    <div class="col-sm-7">
                                        <input type="date" name="target_penyelesaian" class="form-control" required>
                                    </div>
                                </div>

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
                                                <table class="table table-bordered align-middle m-0" style="font-size: 0.7rem; min-width: 1300px;">
                                                    <thead class="table-white text-center">
                                                        <tr>
                                                            <th rowspan="2" style="width: 50px;">Level</th>
                                                            <th id="kriteriaHeaderContainer">Kriteria (Pilih Salah Satu Deskripsi)</th>
                                                            <th colspan="5">Probability (Pilih Salah Satu Kotak Warna)</th>
                                                        </tr>
                                                        <tr id="probabilityHeaderRow">
                                                            <th class="bg-primary text-white">1. Sangat Jarang</th>
                                                            <th class="bg-primary text-white">2. Jarang</th>
                                                            <th class="bg-primary text-white">3. Kadang Kadang</th>
                                                            <th class="bg-primary text-white">4. Sering</th>
                                                            <th class="bg-primary text-white">5. Sangat Sering</th>
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
                                 .cell-desc { cursor: pointer; padding: 5px !important; line-height: 1.2; vertical-align: top; min-width: 140px; border: 1px solid #dee2e6; }
                                 .cell-desc:hover { background-color: #f1faff; color: #000; font-weight: 500; }
                                 .cell-risk { text-align: center; font-weight: bold; color: white; cursor: pointer; width: 80px; transition: 0.2s; }
                                 .cell-risk:hover { filter: brightness(1.2); transform: scale(0.98); }
                                 .bg-low { background-color: #28a745 !important; }
                                 .bg-medium { background-color: #ffc107 !important; color: #000 !important; }
                                 .bg-high { background-color: #dc3545 !important; }
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
                            var tingkatan = '';

                            if (probability && severity) {
                                var score = probability * severity;

                                if (score >= 1 && score <= 2) {
                                    tingkatan = 'LOW';
                                } else if (score >= 3 && score <= 4) {
                                    tingkatan = 'MEDIUM';
                                } else if (score >= 5 && score <= 25) {
                                    tingkatan = 'HIGH';
                                }
                            }

                            document.getElementById('tingkatan').value = tingkatan;
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

                // Variabel penampung pilihan sementara
                let selectedKName = null;
                let selectedSVal = null;
                let selectedPVal = null;
            
                if(kriteriaData.length > 0) {
                    kriteriaHeaderContainer.colSpan = kriteriaData.length;
                    const probHeaderRow = document.getElementById('probabilityHeaderRow');
                    kriteriaData.reverse().forEach(k => {
                        const th = document.createElement('th');
                        th.textContent = k.nama_kriteria;
                        th.className = "bg-secondary text-white text-center";
                        probHeaderRow.prepend(th);
                    });
                    kriteriaData.reverse();
                }
            
                for (let i = 1; i <= 5; i++) {
                    let tr = document.createElement('tr');
                    tr.innerHTML = `<td class="text-center fw-bold bg-light">${i}</td>`;
                
                    // Kolom Deskripsi Kriteria (Severity)
                    kriteriaData.forEach(k => {
                        const descArr = k.desc_kriteria.replace(/[\[\]"]+/g, '').split(',');
                        const nilaiArr = k.nilai_kriteria.replace(/[\[\]"]+/g, '').split(',');
                        const deskripsi = descArr[i-1] ? descArr[i-1].trim() : '-';
                        const sevVal = nilaiArr[i-1] ? nilaiArr[i-1].trim() : i;
                    
                        let td = document.createElement('td');
                        td.className = "cell-desc";
                        td.innerHTML = `<input type="checkbox" class="cb-sev"> ${deskripsi}`;

                        td.onclick = function() {
                            // Reset checkbox kriteria lain
                            document.querySelectorAll('.cb-sev').forEach(cb => cb.checked = false);
                            this.querySelector('input').checked = true;

                            selectedKName = k.nama_kriteria;
                            selectedSVal = sevVal;
                            document.getElementById('status-kriteria').innerHTML = `<strong>Kriteria:</strong> ${k.nama_kriteria}`;
                            document.getElementById('status-severity').innerHTML = `<strong>Severity:</strong> ${sevVal}`;
                        };
                        tr.appendChild(td);
                    });
                
                    // Kolom Matriks Berwarna (Probability)
                    for (let p = 1; p <= 5; p++) {
                        let score = i * p;
                        let riskClass = (score <= 2) ? 'bg-low' : (score <= 4) ? 'bg-medium' : 'bg-high';
                        let riskLabel = (score <= 2) ? 'LOW' : (score <= 4) ? 'MEDIUM' : 'HIGH';
                    
                        let tdRisk = document.createElement('td');
                        tdRisk.className = `cell-risk ${riskClass}`;
                        tdRisk.innerHTML = `<input type="checkbox" class="cb-prob"><br>${riskLabel}`;

                        tdRisk.onclick = function() {
                            // Reset checkbox probability lain
                            document.querySelectorAll('.cb-prob').forEach(cb => cb.checked = false);
                            this.querySelector('input').checked = true;
                        
                            selectedPVal = p;
                            document.getElementById('status-probability').innerHTML = `<strong>Probability:</strong> ${p}`;
                        };
                        tr.appendChild(tdRisk);
                    }
                    matrixBody.appendChild(tr);
                }
        
               // Fungsi untuk memproses tombol Simpan ke Form
                document.getElementById('btnSimpanMatriks').onclick = function() {
                    // 1. Validasi: Cek apakah user sudah memilih Severity (Kriteria) dan Probability
                    if(!selectedKName || !selectedSVal || !selectedPVal) {
                        alert('Silahkan pilih 1 deskripsi kriteria dan 1 kotak probability sebelum menyimpan!');
                        return;
                    }
                
                    // 2. Kirim data Nama Kriteria ke dropdown form utama
                    document.getElementById('kriteriaSelect').value = selectedKName;

                    // 3. Jalankan fungsi update agar opsi dropdown Severity muncul
                    updateSeverityDropdown();
                
                    // 4. Beri jeda sedikit agar dropdown selesai dirender sebelum mengisi nilainya
                    setTimeout(() => {
                        // Isi nilai Severity dan Probability di form utama
                        document.getElementById('severity').value = selectedSVal;
                        document.getElementById('probability').value = selectedPVal;

                        // Update label tingkatan (LOW/MEDIUM/HIGH)
                        calculateTingkatan(); 

                        // 5. TUTUP MODAL OTOMATIS
                        const modalElement = document.getElementById('modalMatriks');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide(); // Menutup modal setelah semua data terisi
                        }
                    }, 200); 
                };
            });  
   </script>

                @endsection
