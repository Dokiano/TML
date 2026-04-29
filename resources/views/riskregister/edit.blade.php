@extends('layouts.main')

@section('content')
    <div class="container">
        {{-- <h2 class="card-title">Edit Risk Register</h2> --}}

        <!-- Alert untuk menampilkan error -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Terjadi kesalahan!</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form untuk edit riskregister -->
        <form action="{{ route('riskregister.update', $riskregister->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Divisi -->
            <input type="hidden" name="id_divisi" value="{{ $riskregister->id_divisi }}">

            <!-- Risk Register Fields -->
            <div class="card p-3 my-3">
                <h4 class="card-title mb-3">Edit Risk & Opportunity Register</h4>

                <!-- Issue -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label mt-1"><strong>Issue</strong></label>
                    <div class="col-sm-10">
                        <textarea name="issue" id="issue" class="form-control">{{ old('issue', $riskregister->issue) }}</textarea>
                    </div>
                </div>
                {{--
             @if($isISO37001 == 1)
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label"><strong>Aktifitas Kunci</strong></label>
                    <div class="col-sm-10">
                        <textarea name="aktifitas_kunci" class="form-control">{{ old('aktifitas_kunci', $riskregister->aktifitas_kunci) }}</textarea>
                    </div>
                </div>
            @endif  --}}
                <!-- Ext/Int -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label mt-1"><strong>I/E</strong></label>
                    <div class="col-sm-10">
                        <select name="inex" id="inex" class="form-select">
                            <option value="I" {{ old('inex', $riskregister->inex) == 'I' ? 'selected' : '' }}>Internal
                            </option>
                            <option value="E" {{ old('inex', $riskregister->inex) == 'E' ? 'selected' : '' }}>External
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Opportunity -->
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label mt-1"><strong>Peluang</strong></label>
                    <div class="col-sm-10">
                        <textarea placeholder="Masukkan Peluang jika ada" name="peluang" id="peluang" class="form-control">{{ old('peluang', $riskregister->peluang) }}</textarea>
                    </div>
                </div>


                <!-- Interested Parties -->
                {{-- resources/views/…your-form.blade.php --}}

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label"><strong>Pihak yang Berkepentingan</strong></label>
                    <div class="col-sm-10">
                        @php
                            // Daftar nama divisi dari DB
                            $divisiNames = $divisi->pluck('nama_divisi')->toArray();

                            // Fallback ke old() atau data awal
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
                                            <input type="text" name="keterangan[]" class="form-control"
                                                placeholder="Keterangan" value="{{ $oldKet[$i] ?? '' }}">
                                        </div>

                                        {{-- Hapus --}}
                                        <div class="col-sm-1 text-end">
                                            <button type="button" class="btn btn-danger remove-row">×</button>
                                        </div>
                                    </div>

                                    {{-- Baris input Other, tampil jika isCustom --}}
                                    <div class="row mt-2 pihak-custom-row"
                                        style="display: {{ $isCustom ? 'flex' : 'none' }};">
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

                <!-- Target Penyelesaian -->
                <div class="row mb-3 align-items-center">
                    <label class="col-sm-2 col-form-label mt-2"><strong>Target Penyelesaian</strong></label>
                    <!-- Menambahkan margin-top -->
                    <div class="col-sm-10">
                        <input type="date" name="target_penyelesaian" id="target_penyelesaian" class="form-control"
                            value="{{ old('target_penyelesaian', $riskregister->target_penyelesaian) }}">
                    </div>
                </div>

                <!-- Risk Edit Section -->
                <div class="card p-3 my-3">
                    <h4 class="card-title">Edit Risiko</h4>

                    <div id="riskInputContainer">
                        @foreach ($resikoList as $resiko)
                            <div class="risk-card border p-3 my-2">
                                <div class="mb-3">
                                    <label for="nama_resiko_{{ $resiko->id }}"
                                        class="form-label"><strong>Resiko</strong></label>
                                    <textarea name="nama_resiko[{{ $resiko->id }}]" id="nama_resiko_{{ $resiko->id }}" class="form-control">{{ old('resiko.' . $resiko->id, $resiko->nama_resiko) }}</textarea>
                                </div>

                                <!-- Before Textarea -->
                                <div class="mb-3">
                                    <label for="before_{{ $resiko->id }}"
                                        class="form-label"><strong>Before</strong></label>
                                    <textarea placeholder="Masukkan kondisi saat ini sebelum mitigasi atau tindakan lanjut dilakukan"
                                        name="before[{{ $resiko->id }}]" id="before_{{ $resiko->id }}" class="form-control">{{ old('before.' . $resiko->id, $resiko->before) }}</textarea>
                                </div>

                                <!-- After Textarea -->
                                <div class="mb-3">
                                    <label for="after_{{ $resiko->id }}"
                                        class="form-label"><strong>After</strong></label>
                                    <textarea placeholder="Masukkan setelah mitigasi atau tindakan lanjut dilakukan" name="after[{{ $resiko->id }}]"
                                        id="after_{{ $resiko->id }}" class="form-control">{{ old('after.' . $resiko->id, $resiko->after) }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr>
                <h3 class="card-title">Tindakan Lanjut</h3>

                <div id="inputContainer">
                    @foreach ($tindakanList as $tindakan)
                        <div class="action-block" data-id="{{ $tindakan->id }}">

                            <!-- Tindakan -->
                            <div class="row mb-3">
                                <label for="tindakan_{{ $tindakan->id }}"
                                    class="col-sm-2 col-form-label"><strong>Tindakan</strong></label>
                                <div class="col-sm-7">
                                    <textarea name="tindakan[{{ $tindakan->id }}]" id="tindakan_{{ $tindakan->id }}" class="form-control" required>{{ old('tindakan.' . $tindakan->id, $tindakan->nama_tindakan) }}</textarea>
                                </div>
                            </div>

                            <!-- Target PIC -->
                            <div class="row mb-3">
                                <label for="inputPIC" class="col-sm-2 col-form-label"><strong>PIC</strong></label>
                                <div class="col-sm-7">
                                    <select name="targetpic[{{ $tindakan->id }}]" class="form-select" required>
                                        <option value="">Pilih PIC</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('targetpic.' . $tindakan->id, $tindakan->targetpic) == $user->id ? 'selected' : '' }}>
                                                {{ $user->nama_user }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Target Tanggal Penyelesaian -->
                            <div class="row mb-3">
                                <label for="tgl_penyelesaian_{{ $tindakan->id }}"
                                    class="col-sm-2 col-form-label"><strong>Target Tanggal</strong></label>
                                <div class="col-sm-7">
                                    <input type="date" name="tgl_penyelesaian[{{ $tindakan->id }}]"
                                        id="tgl_penyelesaian_{{ $tindakan->id }}" class="form-control"
                                        value="{{ old('tgl_penyelesaian.' . $tindakan->id, $tindakan->tgl_penyelesaian) }}"
                                        required>
                                </div>
                            </div>

                     {{--   @if($isISO37001 == 1)
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"><strong>Acuan</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" name="acuan[{{ $tindakan->id }}]" class="form-control" value="{{ old('acuan.'.$tindakan->id, $tindakan->acuan) }}">
                                </div>
                            </div>
                        @endif  --}}
                            @if (isset($tindakan))
                                <div class="row mb-3">
                                    <div class="col-sm-8 offset-sm-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="tindakan_to_delete_{{ $tindakan->id }}"
                                                name="tindakan_to_delete[{{ $tindakan->id }}]" value="1">
                                            <label class="form-check-label" for="tindakan_to_delete_{{ $tindakan->id }}">
                                                <span class="badge bg-danger">Hapus</span> Tindakan ini
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <hr>
                        </div>
                    @endforeach
                </div>


                <!-- Tombol untuk menambah lebih banyak -->
                <div class="mt-2 d-flex">
                    <button type="button" class="btn btn-info me-auto" id="addMore">Add More</button>
                </div>

                <!-- Tombol untuk menyimpan -->
                <div class="mt-3">
                    <a href="javascript:history.back()" class="btn btn-danger" title="Kembali"
                        style="border-radius: 0;">
                        <i class="ri-arrow-go-back-line"></i>
                    </a>
                    <button type="submit" class="btn btn-success" style="border-radius: 0;" title="Update">Update
                        <i class="ri-save-3-fill"></i>
                    </button>
                </div>
        </form>
    </div>

    <script>
        document.getElementById('addMore').addEventListener('click', function() {
            var newInputSection = `
        <div class="input-section">
            <hr>
            <div class="row mb-3">
                <label for="inputTindakan" class="col-sm-2 col-form-label"><strong>Tindakan Lanjut</strong></label>
                <div class="col-sm-7">
                    <textarea placeholder="Masukan Tindakan Lanjut" name="tindakan[]" class="form-control" rows="3" required></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputTarget" class="col-sm-2 col-form-label"><strong>Target Tanggal Tindakan Lanjut</strong></label>
                <div class="col-sm-7">
                    <input type="date" name="tgl_penyelesaian[]" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPIC" class="col-sm-2 col-form-label"><strong>PIC</strong></label>
                <div class="col-sm-7">
                    <select name="targetpic[]" class="form-select" required>
                        <option value="">Pilih PIC</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->nama_user }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Tombol Delete -->
            <div class="mt-2 d-flex">
                <button type="button" class="btn btn-danger btn-sm delete-section ms-auto" title="Hapus">
                    <i class="ri-delete-bin-6-line"></i> Delete
                </button>
            </div>
        </div>
    `;
            document.getElementById('inputContainer').insertAdjacentHTML('beforeend', newInputSection);

            // Tambahkan event listener ke tombol delete baru
            attachDeleteListeners();
        });

        // Fungsi untuk menambahkan event listener pada tombol delete
        function attachDeleteListeners() {
            document.querySelectorAll('.delete-section').forEach(button => {
                button.addEventListener('click', function() {
                    button.closest('.input-section').remove(); // Hapus bagian input terkait
                });
            });
        }

        // Panggil fungsi untuk inisialisasi pertama kali
        attachDeleteListeners();
    </script>

@endsection
