@extends('layouts.main')

@section('content')

    <!-- Check for success message -->
    @if (session('success'))
        <div class="alert alert -success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Check for error message -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <style>
        .badge.bg-purple {
            background-color: #ADD8E6;

            color: rgb(0, 0, 0);
        }

        .table-wrapper {
            position: relative;
            max-height: 400px;
            /* Adjust height as needed */
            overflow-y: auto;
        }

         .table thead tr:nth-child(1) th {
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 2;
        }
    
        /* Baris header kedua — top-nya sesuai tinggi baris pertama */
        .table thead tr:nth-child(2) th {
            position: sticky;
            top: 37px; /* sesuaikan dengan tinggi baris header pertama */
            background-color: #fff;
            z-index: 2;
        }
    </style>
    {{-- <div class="card">
        <div class="card-body">
            <!-- Action Buttons -->
            
        </div>
    </div> --}}
    <div class="d-flex justify-content-start gap-3 mt-3">
                <!-- Filter Button (Trigger Modal) -->
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal"
                    style="font-weight: 500; font-size: 12px; padding: 6px 12px;border-radius: 0;">
                    <i class="fa fa-filter" style="font-size: 14px;"></i> 
                </button>
                <!-- New Issue Button -->
                <a href="{{ route('riskregister.create.iso', ['id' => $id]) }}
                    " class="btn btn-success"
                    style="font-weight: 500;border-radius: 0; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-plus" style="font-size: 14px;"></i> New Issue Resiko 
                </a>
                {{-- 
                <a href="{{ route('riskregister.create', ['id' => $id, 'type' => 'peluang']) }}" 
                   class="btn btn-warning"
                   style="font-weight: 500;border-radius: 0; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-plus" style="font-size: 14px;"></i> New Issue Peluang
                </a>--}}

                <a href="{{ url()->current() }}" class="btn btn-secondary"
                    style="font-weight: 500; font-size: 12px; border-radius: 0;padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-refresh" style="font-size: 14px;"></i> Reset
                </a> 

            </div>

            <br>
    <!-- Modal for Filters -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="filterModalLabel">
                        <i class="bi bi-funnel-fill"></i> Filter Options
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="GET" action="{{ route('riskregister.tablerisk', $id) }}">
                        <div class="row mb-4">
                            <!-- Kriteria -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-card-list"></i> Kriteria</label>
                                    <select name="kriteria" class="form-select">
                                        <option value="">-- Semua Kriteria --</option>
                                        <option value="Unsur keuangan / Kerugian"
                                            {{ request('kriteria') == 'Unsur keuangan / Kerugian' ? 'selected' : '' }}>Unsur
                                            keuangan / Kerugian</option>
                                        <option value="Safety & Health"
                                            {{ request('kriteria') == 'Safety & Health' ? 'selected' : '' }}>Safety & Health
                                        </option>
                                        <option value="Enviromental (lingkungan)"
                                            {{ request('kriteria') == 'Enviromental (lingkungan)' ? 'selected' : '' }}>
                                            Enviromental (lingkungan)</option>
                                        <option value="Reputasi" {{ request('kriteria') == 'Reputasi' ? 'selected' : '' }}>
                                            Reputasi</option>
                                        <option value="Financial"
                                            {{ request('kriteria') == 'Financial' ? 'selected' : '' }}>Financial</option>
                                        <option value="Operational"
                                            {{ request('kriteria') == 'Operational' ? 'selected' : '' }}>Operational
                                        </option>
                                        <option value="Kinerja" {{ request('kriteria') == 'Kinerja' ? 'selected' : '' }}>
                                            Kinerja</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tingkatan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-bar-chart-line"></i> Tingkatan</label>
                                    <select name="tingkatan" class="form-select">
                                        <option value="">-- Semua Tingkatan --</option>
                                        <option value="LOW" {{ request('tingkatan') == 'LOW' ? 'selected' : '' }}>LOW
                                        </option>
                                        <option value="MEDIUM" {{ request('tingkatan') == 'MEDIUM' ? 'selected' : '' }}>
                                            MEDIUM</option>
                                        <option value="HIGH" {{ request('tingkatan') == 'HIGH' ? 'selected' : '' }}>HIGH
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-check-circle"></i> Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">-- Semua Status --</option>
                                        <option value="ON PROGRES"
                                            {{ request('status') == 'ON PROGRES' ? 'selected' : '' }}>ON PROGRESS</option>
                                        <option value="CLOSE" {{ request('status') == 'CLOSE' ? 'selected' : '' }}>CLOSE
                                        </option>    
                                    </select>
                                </div>
                            </div>

                            <!-- Search for Target PIC -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-person"></i> Cari PIC</label>
                                    <select name="targetpic" class="form-select">
                                        <option value="">Pilih Target PIC</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->nama_user }}"
                                                {{ request('targetpic') == $user->nama_user ? 'selected' : '' }}>
                                                {{ $user->nama_user }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Search for Issue -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-search"></i> Cari Issue</label>
                                    <textarea name="keyword" class="form-control" placeholder="Masukkan Issue" rows="3">{{ request('keyword') }}</textarea>
                                </div>
                            </div>

                            <!-- Top 10 Highest Risk -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="top10" value="1" class="form-check-input"
                                            {{ request('top10') ? 'checked' : '' }}>
                                        <label class="form-check-label"><i class="bi bi-sort-numeric-up"></i> Tampilkan
                                            hanya 10 tertinggi</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary px-4" style="border-radius: 0;">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            <button type="reset" class="btn btn-warning px-4" style="border-radius: 0;">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                            <a href="{{ route('riskregister.export-pdf', ['id' => $divisiList]) }}?tingkatan={{ request('tingkatan') }}&status={{ request('status') }}&nama_divisi={{ request('nama_divisi') }}&year={{ request('year') }}&search={{ request('search') }}&kriteria={{ request('kriteria') }}&top10={{ request('top10') }}"
                                style="border-radius: 0;" title="Export PDF" class="btn btn-danger ms-2">
                                <i class="bi bi-file-earmark-pdf"></i> Export PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    <!-- Small tables -->
    <div class="card">
        <div class="card-body">
            <div style="overflow-x: auto;">
                <div class="table-wrapper">
                    <table class="table table-striped" style="width: 180%; font-size: 13px;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle">No</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 150px;">Bagian</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 180px;">Nama Proses</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 180px;">Aktifitas Kunci</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 200px;">Potensi Risk Penyuapan</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 200px;">Skema Penyuapan / Modus Operandi</th>
                                <th rowspan="2" class="text-center align-middle">*S</th>
                                <th rowspan="2" class="text-center align-middle">*P</th>
                                <th rowspan="2" class="text-center align-middle">Level</th>
                                <th rowspan="2" class="text-center align-middle">Tingkatan</th>
                                <th colspan="2" class="text-center align-middle">Tindakan Terhadap Risiko</th>
                                <th colspan="4" class="text-center align-middle">Sisa Risiko</th>
                                {{-- 
                                <th rowspan="2" class="text-center align-middle" style="width: 200px;">Status</th> --}}
                                <th rowspan="2" class="text-center align-middle" style="width: 200px;">Rencana Tindakan / Mitigasi</th>
                                <th rowspan="2" class="text-center align-middle">Action</th>
                            </tr>
                            <tr>
                                <th class="text-center">Tindakan</th>
                                <th class="text-center">Acuan</th>
                                <th class="text-center">*S</th>
                                <th class="text-center">*P</th>
                                <th class="text-center">Level</th>
                               <th class="text-center align-middle" style="width: 60px;">Tingkatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1; // Inisialisasi variabel untuk nomor urut

                            @endphp

                            @foreach ($forms as $form)
                                @php
                                    // Cek apakah data sudah diarsipkan via tombol
                                    $resikos = \App\Models\Resiko::where('id_riskregister', $form->id)->get();
                                    $resiko  = $resikos->first();
                                                        
                                    // Syarat tombol archive muncul: status CLOSE + after sudah diisi
                                    $bolehArchive = $resiko && $resiko->status === 'CLOSE' && !is_null($resiko->after);
                                @endphp
                                                        
                                @if (!$form->is_archived)
                                    <tr>
                                        <td>
                                           {{ $no++ }}
                                        </td>
                                        <td>
                                           @php
                                                $selectedDivisi = $form->pihak ? explode(',', $form->pihak) : [];
                                                $keteranganList = old('keterangan', $form->keterangan ?? []);
                                                $allDivisi = \App\Models\Divisi::all();
                                                $divisiNames = $allDivisi->pluck('nama_divisi')->toArray();

                                                $oldPihak = old('pihak', $selectedDivisi);
                                                $oldCustom = old('pihak_custom', []);
                                                $oldKet = old('keterangan', $riskregister->keterangan ?? []);
                                            @endphp

                                            <form method="POST"
                                                action="{{ route('riskregister.updatepihak', $form->id) }}"
                                                class="d-flex flex-column">
                                                @csrf
                                                @method('PATCH')

                                                {{-- 1. Checkbox Edit --}}
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="editpihak-{{ $form->id }}"
                                                        onchange="togglePihakEdit({{ $form->id }})">
                                                    <label class="form-check-label text-danger"
                                                        for="editpihak-{{ $form->id }}">
                                                        Edit
                                                    </label>
                                                </div>

                                                {{-- 2. Tampilan default ketika tidak edit --}}
                                                <div id="pihak-view-{{ $form->id }}">
                                                    @if (count($selectedDivisi))
                                                        @foreach ($selectedDivisi as $i => $divisiName)
                                                            - <span class="fw-semibold">{{ $divisiName }}</span> @if (is_array($keteranganList) && !empty($keteranganList))
                                                                : {{ $keteranganList[$i] ?? '-' }}
                                                            @endif
                                                            <br>
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </div>

                                                {{-- 3. Kontainer edit (dropdown + Save), hidden default --}}
                                                @php
                                                    // Siapkan data
                                                    $divisiNames = $allDivisi->pluck('nama_divisi')->toArray();
                                                    $oldPihak = old('pihak', $selectedDivisi);
                                                    $oldCustom = old('pihak_custom', []);
                                                    $oldKet = old('keterangan', $form->keterangan ?? []);
                                                @endphp

                                                <div id="pihak-edit-{{ $form->id }}" class="d-none">

                                                    <div id="pihak-list-{{ $form->id }}">
                                                        @foreach ($oldPihak as $i => $p)
                                                            @php
                                                                $isCustom = !in_array($p, $divisiNames);
                                                                $customValue = $isCustom ? $p : $oldCustom[$i] ?? '';
                                                                $ketValue = $oldKet[$i] ?? '';
                                                            @endphp

                                                            <div class="row mb-3 align-items-center input-row">
                                                                {{-- Dropdown Pihak --}}
                                                                <div class="col-9">
                                                                    <div class="row" style="font-size: 10px;"><select
                                                                            name="pihak[]"
                                                                            class="form-select pihak-select">
                                                                            <option value="">-- Pilih Pihak --
                                                                            </option>
                                                                            @foreach ($allDivisi as $d)
                                                                                <option value="{{ $d->nama_divisi }}"
                                                                                    {{ !$isCustom && $p === $d->nama_divisi ? 'selected' : '' }}>
                                                                                    {{ $d->nama_divisi }}
                                                                                </option>
                                                                            @endforeach
                                                                            <option value="Other"
                                                                                {{ $isCustom ? 'selected' : '' }}>Other
                                                                            </option>
                                                                        </select></div>
                                                                    <div class="row pihak-custom-row"
                                                                        style="display: {{ $isCustom ? 'block' : 'none' }};">
                                                                        <input type="text" name="pihak_custom[]"
                                                                            class="form-control pihak-custom"
                                                                            placeholder="Masukkan Pihak Lainnya"
                                                                            value="{{ $customValue }}">
                                                                    </div>
                                                                    <div class="row">
                                                                        <textarea name="keterangan[]" class="form-control auto-resize" placeholder="Keterangan" rows="1">{{ $ketValue }}</textarea>
                                                                    </div>
                                                                </div>
                                                                {{-- Tombol Hapus Baris --}}
                                                                <div class="col-sm-2 ">
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-row"
                                                                        style="height: 100%;">×</button>
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- Tombol Tambah --}}
                                                    <button type="button" id="add-row-{{ $form->id }}"
                                                        class="btn btn-outline-primary btn-sm mb-3 w-100">
                                                        + Tambah Pihak
                                                    </button>

                                                    {{-- Action Buttons --}}
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" class="btn btn-secondary me-2 cancel-edit"
                                                            data-target="#pihak-edit-{{ $form->id }}">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm">Save</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', () => {
                                                    const areas = document.querySelectorAll('.auto-resize');

                                                    function autoGrow(el) {
                                                        el.style.height = 'auto'; // reset
                                                        el.style.height = el.scrollHeight + 'px'; // tumbuh sesuai konten
                                                    }

                                                    areas.forEach(a => {
                                                        // saat pertama load, sesuaikan tinggi
                                                        autoGrow(a);
                                                        // attach event untuk setiap input
                                                        a.addEventListener('input', () => autoGrow(a));
                                                    });
                                                });

                                                function togglePihakEdit(id) {
                                                    const chk = document.getElementById('editpihak-' + id);
                                                    const view = document.getElementById('pihak-view-' + id);
                                                    const edit = document.getElementById('pihak-edit-' + id);

                                                    if (chk.checked) {
                                                        view.classList.add('d-none');
                                                        edit.classList.remove('d-none');
                                                        initPihakDropdown(id);
                                                    } else {
                                                        view.classList.remove('d-none');
                                                        edit.classList.add('d-none');
                                                    }
                                                }

                                                function initPihakDropdown(id) {
                                                    // Inisialisasi "Pilih Semua"
                                                    const selectAll = document.getElementById('select-all-' + id);
                                                    const menu = document.getElementById('dropdown-menu-' + id);
                                                    const items = menu.querySelectorAll('.all-divisi-' + id);

                                                    // toggle semua
                                                    selectAll.addEventListener('change', function() {
                                                        items.forEach(cb => cb.checked = this.checked);
                                                    });
                                                    // cek manual seleksi
                                                    items.forEach(cb => {
                                                        cb.addEventListener('change', function() {
                                                            const semua = Array.from(items).every(ch => ch.checked);
                                                            selectAll.checked = semua;
                                                        });
                                                    });
                                                    // inisialisasi awal
                                                    selectAll.checked = Array.from(items).every(ch => ch.checked);
                                                }

                                                document.addEventListener('DOMContentLoaded', () => {
                                                    const list = document.getElementById('pihak-list-{{ $form->id }}');
                                                    const addBtn = document.getElementById('add-row-{{ $form->id }}');

                                                    // Opsi dropdown
                                                    const divisiOptions = `
      <option value="">-- Pilih Pihak --</option>
      @foreach ($allDivisi as $d)
        <option value="{{ $d->nama_divisi }}">{{ $d->nama_divisi }}</option>
      @endforeach
      <option value="Other">Other</option>
    `;

                                                    // Toggle custom-field
                                                    list.addEventListener('change', e => {
                                                        if (!e.target.matches('.pihak-select')) return;
                                                        const row = e.target.closest('.input-row');
                                                        const customRow = row.querySelector('.pihak-custom-row');
                                                        if (e.target.value === 'Other') {
                                                            customRow.style.display = 'block';
                                                        } else {
                                                            customRow.style.display = 'none';
                                                            customRow.querySelector('.pihak-custom').value = '';
                                                        }
                                                    });

                                                    // Fungsi bikin baris baru (mirror struktur di atas)
                                                    function newRow() {
                                                        const wrapper = document.createElement('div');
                                                        wrapper.className = 'row mb-3 align-items-center input-row';
                                                        wrapper.innerHTML = `<div class="col-9">
        <div class="row" style="font-size:10px;">
          <select name="pihak[]" class="form-select pihak-select">
            ${divisiOptions}
          </select>
        </div>
        <div class="row pihak-custom-row" style="display:none;">
          <input type="text"
                 name="pihak_custom[]"
                 class="form-control pihak-custom"
                 placeholder="Masukkan Pihak Lainnya">
        </div>
        <div class="row mt-2">
          <textarea name="keterangan[]"
                    class="form-control auto-resize"
                    placeholder="Keterangan"
                    rows="1"></textarea>
        </div>
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-danger remove-row" style="height:100%">×</button>
      </div>
      `;
                                                        return wrapper;
                                                    }

                                                    // Tambah baris
                                                    addBtn.addEventListener('click', () => {
                                                        list.appendChild(newRow());
                                                    });

                                                    // Hapus baris
                                                    list.addEventListener('click', e => {
                                                        if (e.target.matches('.remove-row')) {
                                                            e.target.closest('.input-row').remove();
                                                        }
                                                    });

                                                    // Cancel edit (hide container)
                                                    document.querySelectorAll('.cancel-edit').forEach(btn => {
                                                        btn.addEventListener('click', () => {
                                                            document.querySelector(btn.dataset.target).classList.add('d-none');
                                                        });
                                                    });
                                                });
                                            </script>
                                        </td>
                                        <td>
                                            <form method="POST"
                                                action="{{ route('riskregister.updateissue', $form->id) }}"
                                                class="d-flex flex-column">
                                                @csrf
                                                @method('PATCH')

                                                {{-- 1. Checkbox Edit --}}
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="editIssue-{{ $form->id }}"
                                                        onchange="toggleIssue({{ $form->id }})">
                                                    <label class="form-check-label text-danger"
                                                        for="editIssue-{{ $form->id }}">
                                                        Edit
                                                    </label>
                                                </div>

                                                {{-- 2. Teks statis --}}
                                                <span id="issue-text-{{ $form->id }}">
                                                    {{ $form->issue }}
                                                </span>

                                                {{-- 3. Textarea hidden lewat d-none --}}
                                                <textarea name="issue" id="issue-input-{{ $form->id }}" class="form-control form-control-sm mt-2 d-none"
                                                    style="overflow:hidden; resize:none;" oninput="autoResize(this)">{{ $form->issue }}</textarea>

                                                {{-- 4. Tombol Save juga hidden --}}
                                                <button type="submit" id="save-btn-{{ $form->id }}"
                                                    class="btn btn-primary btn-sm mt-2 d-none">
                                                    Save
                                                </button>
                                            </form>
                                            <script>
                                                function autoResize(el) {
                                                    el.style.height = 'auto';
                                                    el.style.height = el.scrollHeight + 'px';
                                                }

                                                function toggleIssue(id) {
                                                    const cb = document.getElementById('editIssue-' + id);
                                                    const span = document.getElementById('issue-text-' + id);
                                                    const input = document.getElementById('issue-input-' + id);
                                                    const button = document.getElementById('save-btn-' + id);

                                                    if (cb.checked) {
                                                        // hide span, show textarea + button
                                                        span.classList.add('d-none');
                                                        input.classList.remove('d-none');
                                                        button.classList.remove('d-none');
                                                        autoResize(input);
                                                    } else {
                                                        // show span, hide textarea + button
                                                        span.classList.remove('d-none');
                                                        input.classList.add('d-none');
                                                        button.classList.add('d-none');
                                                    }
                                                }
                                            </script>
                                        </td>
                                        <td>
                                            <form method="POST"
                                                action="{{ route('riskregister.updateaktifitas', $form->id) }}"
                                                class="d-flex flex-column">
                                                @csrf
                                                @method('PATCH')

                                                {{-- 1. Checkbox Edit --}}
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="editAktifitas-{{ $form->id }}"
                                                        onchange="toggleAktifitas({{ $form->id }})">
                                                    <label class="form-check-label text-danger"
                                                        for="editAktifitas-{{ $form->id }}">
                                                        Edit
                                                    </label>
                                                </div>

                                                {{-- 2. Teks statis --}}
                                                <span id="aktifitas-text-{{ $form->id }}">
                                                    {{ $form->aktifitas_kunci ?? '' }}
                                                </span>

                                                {{-- 3. Textarea hidden lewat d-none --}}
                                                <textarea name="aktifitas_kunci" id="aktifitas-input-{{ $form->id }}" class="form-control form-control-sm mt-2 d-none"
                                                    style="overflow:hidden; resize:none;" oninput="autoResize(this)">{{ $form->aktifitas_kunci }}</textarea>

                                                {{-- 4. Tombol Save juga hidden --}}
                                                <button type="submit" id="save-aktifitas-btn-{{ $form->id }}"{{ $form->id }}"
                                                    class="btn btn-primary btn-sm mt-2 d-none">
                                                    Save
                                                </button>
                                            </form>
                                            <script>
                                                function autoResize(el) {
                                                    el.style.height = 'auto';
                                                    el.style.height = el.scrollHeight + 'px';
                                                }

                                                function toggleAktifitas(id) {
                                                    const cb = document.getElementById('editAktifitas-' + id);
                                                    const span = document.getElementById('aktifitas-text-' + id);
                                                    const input = document.getElementById('aktifitas-input-' + id);
                                                    const button = document.getElementById('save-aktifitas-btn-' + id);

                                                    if (cb.checked) {
                                                        // hide span, show textarea + button
                                                        span.classList.add('d-none');
                                                        input.classList.remove('d-none');
                                                        button.classList.remove('d-none');
                                                        autoResize(input);
                                                    } else {
                                                        // show span, hide textarea + button
                                                        span.classList.remove('d-none');
                                                        input.classList.add('d-none');
                                                        button.classList.add('d-none');
                                                    }
                                                }
                                            </script>
                                        </td>
                                      {{--   <td class="align-top">{{ $form->aktifitas_kunci ?? '' }}</td> --}}
                                        <td>
                                            <form method="POST"
                                                action="{{ route('riskregister.updateresiko', $form->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="editresiko-{{ $form->id }}"
                                                        onchange="toggleresiko({{ $form->id }})">
                                                    <label class="form-check-label text-danger"
                                                        for="editresiko-{{ $form->id }}">
                                                        Edit
                                                    </label>
                                                </div>

                                                <span id="resiko-text-{{ $form->id }}">
                                                    @if ($resikos->isNotEmpty())
                                                        @foreach ($resikos as $resiko)
                                                            {{ $resiko->nama_resiko }}
                                                        @endforeach
                                                    @else
                                                        None
                                                    @endif
                                                </span>

                                                <textarea name="resiko" id="resiko-input-{{ $form->id }}" class="form-control form-control-sm mt-2 d-none"
                                                    style="overflow:hidden; resize:none;" oninput="autoResize(this)">{{ $resiko->nama_resiko }}</textarea>

                                                <button type="submit" id="resiko-save-{{ $form->id }}"
                                                    class="btn btn-primary btn-sm mt-2 d-none">
                                                    Save
                                                </button>
                                            </form>

                                            <script>
                                                // Auto‐resize textarea sesuai isi
                                                function autoResize(el) {
                                                    el.style.height = 'auto';
                                                    el.style.height = el.scrollHeight + 'px';
                                                }

                                                // Toggle edit/view mode untuk Resiko
                                                function toggleresiko(id) {
                                                    const cb = document.getElementById('editresiko-' + id);
                                                    const text = document.getElementById('resiko-text-' + id);
                                                    const input = document.getElementById('resiko-input-' + id);
                                                    const button = document.getElementById('resiko-save-' + id);

                                                    if (cb.checked) {
                                                        text.classList.add('d-none');
                                                        input.classList.remove('d-none');
                                                        button.classList.remove('d-none');
                                                        autoResize(input);
                                                    } else {
                                                        text.classList.remove('d-none');
                                                        input.classList.add('d-none');
                                                        button.classList.add('d-none');
                                                    }
                                                }
                                            </script>
                                        </td>
                                        <td>
                                            <form method="POST"
                                                action="{{ route('riskregister.updatebefore', $form->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="editbefore-{{ $form->id }}"
                                                        onchange="togglebefore({{ $form->id }})">
                                                    <label class="form-check-label text-danger"
                                                        for="editbefore-{{ $form->id }}">
                                                        Edit
                                                    </label>
                                                </div>

                                                <span id="before-text-{{ $form->id }}">
                                                    @if ($resikos->isNotEmpty())
                                                        @foreach ($resikos as $resiko)
                                                            {{ $resiko->before }}
                                                        @endforeach
                                                    @else
                                                        None
                                                    @endif
                                                </span>

                                                <textarea name="before" id="before-input-{{ $form->id }}" class="form-control form-control-sm mt-2 d-none"
                                                    style="overflow:hidden; resize:none;" oninput="autoResize(this)">{{ $resiko->before }}</textarea>

                                                <button type="submit" id="before-save-{{ $form->id }}"
                                                    class="btn btn-primary btn-sm mt-2 d-none">
                                                    Save
                                                </button>
                                            </form>

                                            <script>
                                                // fungsi auto-resize yang dapat dipakai ulang
                                                function autoResize(el) {
                                                    el.style.height = 'auto';
                                                    el.style.height = el.scrollHeight + 'px';
                                                }

                                                // toggle view/edit mode untuk kolom "before"
                                                function togglebefore(id) {
                                                    const cb = document.getElementById('editbefore-' + id);
                                                    const text = document.getElementById('before-text-' + id);
                                                    const input = document.getElementById('before-input-' + id);
                                                    const button = document.getElementById('before-save-' + id);

                                                    if (cb.checked) {
                                                        text.classList.add('d-none');
                                                        input.classList.remove('d-none');
                                                        button.classList.remove('d-none');
                                                        autoResize(input);
                                                    } else {
                                                        text.classList.remove('d-none');
                                                        input.classList.add('d-none');
                                                        button.classList.add('d-none');
                                                    }
                                                }
                                            </script>
                                        </td>
                                        </td>
                                        <td>{{ $form->resikos->first()->severity ?? '-' }}</td>
                                        <td>{{ $form->resikos->first()->probability ?? '-' }}</td>
                                        <td class="text-center">
                                            @php
                                                $s_awal = $form->resikos->first()->severity ?? 0;
                                                $p_awal = $form->resikos->first()->probability ?? 0;
                                                $score_awal = $s_awal * $p_awal;
                                            @endphp
                                            {{ $score_awal > 0 ? $score_awal : '-' }}
                                        </td>
                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    @php
                                                        $btnClass = '';
                                                        if ($resiko->tingkatan === 'HIGH') {
                                                            $btnClass = 'btn-danger';
                                                        } elseif ($resiko->tingkatan === 'MEDIUM') {
                                                            $btnClass = 'btn-warning';
                                                        } elseif ($resiko->tingkatan === 'LOW') {
                                                            $btnClass = 'btn-success';
                                                        }
                                                    @endphp

                                                    <a href="{{ route('resiko.edit', ['id' => $form->id, 'tingkatan' => $resiko->tingkatan]) }}"
                                                        title="Matriks Before" class="btn {{ $btnClass }}"
                                                        style="font-size: 9px; padding: 2px; color: white;">
                                                        <strong>{{ $resiko->tingkatan }}</strong><i class="ri-grid-line"
                                                            style="font-size: 14px;"></i>
                                                    </a>

                                                    <br>
                                                    {{--  <a class="btn btn-success mt-2"
                                                        href="{{ route('resiko.edit', ['id' => $form]) }}"
                                                        title="Edit Matriks"
                                                        style="font-size: 10px; padding: 3px; color: white;">
                                                        <strong>Edit</strong><i class="bx bx-edit"
                                                            style="font-size: 13px;"></i>
                                                    </a>--}}
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                // Data tindakan yang sudah ada
                                                $tindakanExisting = $data[$form->id] ?? collect();
                                            @endphp

                                            {{-- Checkbox untuk switch mode --}}
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    id="editTindakan-{{ $form->id }}"
                                                    onchange="toggleTindakanEdit({{ $form->id }})">
                                                <label class="form-check-label text-danger"
                                                    for="editTindakan-{{ $form->id }}">
                                                    Edit
                                                </label>
                                            </div>

                                            {{-- VIEW MODE (tampilan daftar saja) --}}
                                            <div id="tindakan-view-{{ $form->id }}">
                                                @if ($tindakanExisting->isNotEmpty())
                                                    <ul class="list-unstyled">
                                                        @foreach ($tindakanExisting as $t)
                                                            <li class="mb-2">
                                                                {{ $loop->iteration }}.
                                                                <a
                                                                    href="{{ route('realisasi.index', $t->id) }}">{{ $t->nama_tindakan }}</a>
                                                                    @if ($t->isClosed)
                                                                        <span class="ms-1 text-success" title="Status: Closed">
                                                                            <i class="fas fa-check-circle"></i> {{-- atau pakai simbol centang teks: ✔ --}}
                                                                        </span>
                                                                    @endif
                                                                    <br>
                                                                   
                                                               {{-- <span
                                                                    class="badge bg-purple">{{ $t->tgl_penyelesaian }}</span>
                                                                <span
                                                                    class="badge bg-purple">{{ $t->user->nama_user ?? '-' }}</span>
                                                                @if ($t->isClosed)
                                                                    <span class="badge bg-success">CLOSE</span>
                                                                @elseif($t->isOnProgress)
                                                                    <span class="badge bg-warning">ON PROGRESS</span>
                                                                @endif  --}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    Tidak ada tindakan lanjut
                                                @endif
                                            </div>

                                            {{-- EDIT MODE (form input), hidden default --}}
                                            <div id="tindakan-edit-{{ $form->id }}" class="card d-none">
                                                <div class="card-header py-2 px-3">
                                                    <h5 class="card-title mb-0">Tindakan Terhadap resiko</h5>
                                                </div>
                                                <div class="card-body py-2 px-3">

                                                    <form method="POST"
                                                        action="{{ route('realisasi.updateBatch', $form->id) }}">
                                                        @csrf
                                                        @method('PATCH')

                                                        <div id="inputContainer-{{ $form->id }}">
                                                            @foreach ($tindakanExisting as $t)
                                                                <div class="mb-3 border-bottom pb-2">
                                                                    {{-- Tindakan --}}
                                                                    <div class="mb-2">
                                                                        <label
                                                                            class="form-label"><strong>Tindakan</strong></label>
                                                                        <textarea name="tindakan[{{ $t->id }}]" class="form-control form-control-sm" rows="2" required>{{ old("tindakan.{$t->id}", $t->nama_tindakan) }}</textarea>
                                                                    </div>
                                                                    
                                                                    <div class="mb-2">
                                                                        <label class="form-label"><strong>Acuan</strong></label>
                                                                        <input type="text" name="acuan[{{ $t->id }}]" class="form-control form-control-sm" 
                                                                               value="{{ old("acuan.{$t->id}", $t->acuan) }}" placeholder="Masukkan Acuan">
                                                                    </div>

                                                                    {{-- PIC --}}
                                                                    <label class="mb-2">
                                                                        <label
                                                                            class="form-label"><strong>PIC</strong></label>
                                                                        <select name="targetpic[{{ $t->id }}]"
                                                                            class="form-select form-select-sm" required>
                                                                            <option value="">Pilih PIC</option>
                                                                            @foreach ($users as $user)
                                                                                <option value="{{ $user->id }}"
                                                                                    {{ old("targetpic.{$t->id}", $t->targetpic) == $user->id ? 'selected' : '' }}>
                                                                                    {{ $user->nama_user }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </label>

                                                                    {{-- Target Tanggal --}}
                                                                    <div class="mb-2">
                                                                        <label class="form-label"><strong>Target
                                                                                Tgl</strong></label>
                                                                        <input type="date"
                                                                            name="tgl_penyelesaian[{{ $t->id }}]"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ old("tgl_penyelesaian.{$t->id}", \Carbon\Carbon::createFromFormat('d-m-Y', $t->tgl_penyelesaian)->format('Y-m-d')) }}"
                                                                            required>
                                                                    </div>

                                                                    {{-- Hapus --}}
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            name="hapus[{{ $t->id }}]"
                                                                            id="hapus_{{ $t->id }}"
                                                                            value="1">
                                                                        <label class="form-check-label text-danger"
                                                                            for="hapus_{{ $t->id }}">
                                                                            Hapus Tindakan Ini
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <div class="d-flex justify-content-between">
                                                            <button type="button" class="btn btn-info btn-sm"
                                                                onclick="addMoreTindakan({{ $form->id }})">
                                                                Add More
                                                            </button>
                                                            <button type="submit" class="btn btn-success btn-sm">
                                                                Update Semua
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                    </td>
                                    <script>
                                            function toggleTindakanEdit(id) {
                                                const chk = document.getElementById('editTindakan-' + id);
                                                const view = document.getElementById('tindakan-view-' + id);
                                                const edt = document.getElementById('tindakan-edit-' + id);

                                                if (chk.checked) {
                                                    view.classList.add('d-none');
                                                    edt.classList.remove('d-none');
                                                } else {
                                                    view.classList.remove('d-none');
                                                    edt.classList.add('d-none');
                                                }
                                            }

                                            function addMoreTindakan(id) {
                                                const container = document.getElementById('inputContainer-' + id);
                                                const index = Date.now();
                                                const html = `
                                                  <div class="mb-3 border-bottom pb-2">
                                                    <div class="mb-2">
                                                      <label class="form-label"><strong>Tindakan</strong></label>
                                                      <textarea name="tindakan_new[${index}]" class="form-control form-control-sm" rows="2" required></textarea>
                                                    </div>
                                                    <div class="mb-2">
                                                      <label class="form-label"><strong>Acuan</strong></label>
                                                      <textarea name="acuan_new[${index}]" class="form-control form-control-sm" rows="2" required></textarea>
                                                    </div>
                                                    <div class="mb-2">
                                                      <label class="form-label"><strong>PIC</strong></label>
                                                      <select name="targetpic_new[${index}]" class="form-select form-select-sm" required>
                                                        <option value="">Pilih PIC</option>
                                                        @foreach ($users as $user)
                                                          <option value="{{ $user->id }}">{{ $user->nama_user }}</option>
                                                        @endforeach
                                                      </select>
                                                    </div>
                                                    <div class="mb-2">
                                                      <label class="form-label"><strong>Target Tgl</strong></label>
                                                      <input type="date" name="tgl_penyelesaian_new[${index}]" class="form-control form-control-sm" required>
                                                    </div>
                                                    <div class="text-end">
                                                      <button type="button"
                                                              class="btn btn-danger btn-sm"
                                                              onclick="this.closest('.mb-3').remove()">
                                                        Delete
                                                      </button>
                                                    </div>
                                                  </div>`;
                                                container.insertAdjacentHTML('beforeend', html);
                                            }
                                        </script>

                                       <td class="align-top">
                                        <br>
                                        
                                            @forelse($data[$form->id] as $index => $t)
                                                <div class="mb-1 text-wrap" style="min-height: 25px;">
                                            {{ $index + 1 }}. {{ $t->acuan ?? '-' }}</div>
                                            <br>
                                            @empty
                                                <div>-</div>
                                            @endforelse
                                        </td>
                                        
                                         {{-- <td>
                                            <form method="POST"
                                                action="{{ route('riskregister.updatedate', $form->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="editdate-{{ $form->id }}"
                                                        onchange="toggledate({{ $form->id }})">
                                                    <label class="form-check-label text-danger"
                                                        for="editdate-{{ $form->id }}">
                                                        Edit
                                                    </label>
                                                </div>

                                                <span id="date-text-{{ $form->id }}">
                                                    {{ $form->target_penyelesaian }}
                                                </span>

                                                <input type="date" name="target_penyelesaian"
                                                    id="date-input-{{ $form->id }}"
                                                    class="form-control form-control-sm mt-2 d-none" {{-- Convert format d-m-Y → Y-m-d untuk date input 
                                                    value="{{ \Carbon\Carbon::createFromFormat('d-m-Y', $form->target_penyelesaian)->format('Y-m-d') }}">

                                                <button type="submit" id="date-save-{{ $form->id }}"
                                                    class="btn btn-primary btn-sm mt-2 d-none">
                                                    Save
                                                </button>
                                            </form>

                                            <script>
                                                function toggledate(id) {
                                                    const cb = document.getElementById('editdate-' + id);
                                                    const text = document.getElementById('date-text-' + id);
                                                    const input = document.getElementById('date-input-' + id);
                                                    const button = document.getElementById('date-save-' + id);

                                                    if (cb.checked) {
                                                        text.classList.add('d-none');
                                                        input.classList.remove('d-none');
                                                        button.classList.remove('d-none');
                                                    } else {
                                                        text.classList.remove('d-none');
                                                        input.classList.add('d-none');
                                                        button.classList.add('d-none');
                                                    }
                                                }
                                            </script>
                                        </td> --}}
                                       
                                        <td>
                                        
                   
                                           {{ $form->resikos->first()->severityrisk ?? '-' }}
                                        </td>
                                        <td>
                                           {{ $form->resikos->first()->probabilityrisk ?? '-' }}
                                           
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $s = $form->resikos->first()->severityrisk ?? 0;
                                                $p = $form->resikos->first()->probabilityrisk ?? 0;
                                                $score = $s * $p;
                                            @endphp
                                            <span>{{ $score > 0 ? $score : '-' }}</span>
                                        </td>
                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    <a href="{{ route('resiko.edit', ['id' => $form->id]) }}"
                                                        title="Matriks After"
                                                        class="btn
                                                                       @if ($resiko->risk == 'HIGH') btn-danger
                                                                       @elseif($resiko->risk == 'MEDIUM') btn-warning
                                                                       @elseif($resiko->risk == 'LOW') btn-success
                                                                       @else btn-info @endif"
                                                        style="font-size: 9px; padding: 2px; color: white; margin-bottom: 5px;">
                                                        <strong>{{ $resiko->risk }}</strong>
                                                        <i class="ri-grid-line" style="font-size: 14px;"></i>
                                                    </a>
                                                @endforeach
                                            @else
                                                None
                                            @endif

                                           {{-- <a class="btn btn-success mt-2"
                                                href="{{ route('resiko.edit', ['id' => $form]) }}" title="Edit Matriks"
                                                style="font-size: 10px; padding: 3px; color: white;">
                                                <strong>Edit</strong>
                                                <i class="bx bx-edit" style="font-size: 10px;"></i>
                                            </a>
                                        </td>  --}}
                                        {{-- 
                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    <span
                                                        class="badge
                                                                    @if ($resiko->status == 'OPEN') bg-danger
                                                                    @elseif($resiko->status == 'ON PROGRES')
                                                                        bg-warning
                                                                    @elseif($resiko->status == 'CLOSE')
                                                                        bg-success @endif">
                                                        {{ $resiko->status }}<br>
                                                        {{ $form->nilai_actual }}%
                                                    </span>
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </td> --}}
                                        <td>
                                            @php
                                                $firstResiko  = $resikos->first();
                                                $bolehAfter   = $firstResiko
                                                             && $firstResiko->status === 'CLOSE'
                                                             && ($form->nilai_actual ?? 0) >= 100
                                                             && !is_null($firstResiko->severityrisk);
                                            @endphp
                                              @if(!$bolehAfter)
                                                    <span class="badge bg-danger" 
                                                        title="Tersedia setelah status CLOSE, realisasi 100%, dan Level After (matriks) sudah diisi">
                                                       <i class="bi bi-exclamation-triangle-fill"></i> Input Tindakan serta update status matrix 
                                                    </span>
                                                @else
                                                    <form method="POST" action="{{ route('riskregister.updateafter', $form->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                    
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="editafter-{{ $form->id }}"
                                                                onchange="toggleafter({{ $form->id }})">
                                                            <label class="form-check-label text-danger"
                                                                for="editafter-{{ $form->id }}">
                                                                Edit
                                                            </label>
                                                        </div>

                                                        <span id="after-text-{{ $form->id }}">
                                                            @if ($resikos->isNotEmpty())
                                                                @foreach ($resikos as $resiko)
                                                                    {{ $resiko->after }}
                                                                @endforeach
                                                            @else
                                                                None
                                                            @endif
                                                        </span>
                                                    
                                                        <textarea name="after" id="after-input-{{ $form->id }}" class="form-control form-control-sm mt-2 d-none"
                                                            style="overflow:hidden; resize:none;" oninput="autoResize(this)">{{ $resiko->after }}</textarea>
                                                        
                                                        <button type="submit" id="after-save-{{ $form->id }}"
                                                            class="btn btn-primary btn-sm mt-2 d-none">
                                                            Save
                                                        </button>
                                                    </form>
                                        @endif
                                            <script>
                                                // fungsi auto-resize yang dapat dipakai ulang
                                                function autoResize(el) {
                                                    el.style.height = 'auto';
                                                    el.style.height = el.scrollHeight + 'px';
                                                }

                                                // toggle view/edit mode untuk kolom "after"
                                                function toggleafter(id) {
                                                    const cb = document.getElementById('editafter-' + id);
                                                    const text = document.getElementById('after-text-' + id);
                                                    const input = document.getElementById('after-input-' + id);
                                                    const button = document.getElementById('after-save-' + id);

                                                    if (cb.checked) {
                                                        text.classList.add('d-none');
                                                        input.classList.remove('d-none');
                                                        button.classList.remove('d-none');
                                                        autoResize(input);
                                                    } else {
                                                        text.classList.remove('d-none');
                                                        input.classList.add('d-none');
                                                        button.classList.add('d-none');
                                                    }
                                                }
                                            </script>
                                        </td>
                                        {{-- <td>
                                            <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                                <a href="{{ route('riskregister.edit.iso', $form->id) }}" title="Edit Issue"
                                                    class="btn btn-success"
                                                    style="font-weight: 500; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                                                    <i class="bx bx-edit" style="font-size: 14px;"></i>
                                                </a>
                                            
                                                {{-- Tombol archive: hanya aktif jika status CLOSE + after sudah diisi 
                                                @if ($bolehArchive)
                                                    <form action="{{ route('riskregister.archive', $form->id) }}" method="POST"
                                                        onsubmit="return confirm('Pindahkan data ini ke report?')" style="margin: 0;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" title="Pindah ke Report" class="btn btn-warning"
                                                            style="font-weight: 500; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                                                            <i class="bx bx-archive" style="font-size: 14px;"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    {{-- Tombol disable jika syarat belum terpenuhi 
                                                    <button type="button" title="Syarat belum terpenuhi (Status belum CLOSE / After belum diisi)"
                                                        class="btn btn-secondary" disabled
                                                        style="font-weight: 500; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                                                        <i class="bx bx-archive" style="font-size: 14px;"></i>
                                                    </button>
                                                @endif
                                                
                                                <form action="{{ route('riskregister.destroy', $form['id']) }}" title="destroy issue"
                                                    method="POST" style="margin: 0;"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        style="display: flex; align-items: center; gap: 5px;">
                                                        <i class="ri ri-delete-bin-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>--}}
                                        
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    style="font-size: 12px;">
                                                    <i class="bx bx-cog"></i> Action
                                                </button>
                                                <ul class="dropdown-menu">

                                                    <li>
                                                        <a href="{{ route('riskregister.edit.iso', $form->id) }}"
                                                            class="dropdown-item" style="font-size: 12px;">
                                                            <i class="bx bx-edit text-success"></i> Edit Issue
                                                        </a>
                                                    </li>

                                                    <li>
                                                        @if ($bolehArchive)
                                                            <button type="button" class="dropdown-item" style="font-size: 12px;"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#previewModal{{ $form->id }}">
                                                                <i class="bx bx-archive text-warning"></i> Pindah ke Report
                                                            </button>
                                                        @else
                                                            <button type="button" class="dropdown-item disabled" style="font-size: 12px;"
                                                                title="Status belum CLOSE / After belum diisi">
                                                                <i class="bx bx-archive text-secondary"></i> Pindah ke Report
                                                            </button>
                                                        @endif
                                                    </li>

                                                    <li><hr class="dropdown-divider"></li>

                                                    <li>
                                                        <form action="{{ route('riskregister.destroy', $form['id']) }}" method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                            style="margin: 0;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item" style="font-size: 12px;">
                                                                <i class="ri ri-delete-bin-fill text-danger"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </li>

                                                </ul>
                                            </div>
                                        </td>

                                        {{-- ===== MODAL PREVIEW ===== --}}
                                        <div class="modal fade" id="previewModal{{ $form->id }}" tabindex="-1"
                                            aria-labelledby="previewModalLabel{{ $form->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                <div class="modal-content">

                                                    {{-- Header --}}
                                                    <div class="modal-header bg-dark text-white">
                                                        <h5 class="modal-title" id="previewModalLabel{{ $form->id }}">
                                                            <i class="bx bx-file"></i> Preview Data Risk #{{ $no - 1 }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    {{-- Body --}}
                                                    <div class="modal-body" style="font-size: 13px;">

                                                        {{-- Bagian / Pihak --}}
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Bagian / Pihak Terkait</label>
                                                            @php $selectedDivisiModal = $form->pihak ? explode(',', $form->pihak) : []; @endphp
                                                            <div class="form-control" style="min-height: 40px; background:#f8f9fa;">
                                                                @if (count($selectedDivisiModal))
                                                                    @foreach ($selectedDivisiModal as $divisiName)
                                                                        <span class="badge bg-secondary me-1">{{ trim($divisiName) }}</span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        {{-- Nama Proses --}}
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Nama Proses</label>
                                                            <input type="text" class="form-control" readonly
                                                                value="{{ $form->issue ?? '-' }}">
                                                        </div>

                                                        {{-- Aktifitas Kunci --}}
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Aktifitas Kunci</label>
                                                            <textarea class="form-control" rows="2" readonly>{{ $form->aktifitas_kunci ?? '-' }}</textarea>
                                                        </div>

                                                        {{-- Potensi Risk / Issue --}}
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Potensi Risk Penyuapan</label>
                                                            <textarea class="form-control" rows="2" readonly>{{ $resikos->first()->nama_resiko ?? '-' }}</textarea>
                                                        </div>

                                                        {{-- Skema / Modus Operandi --}}
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Skema Penyuapan / Modus Operandi</label>
                                                            <textarea class="form-control" rows="2" readonly>{{ $resikos->first()->before ?? '-' }}</textarea>
                                                        </div>

                                                        {{-- Risiko Awal (Before) --}}
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Penilaian Risiko Awal (Before)</label>
                                                            <div class="row g-2">
                                                                <div class="col-4">
                                                                    <label class="form-label text-muted" style="font-size:11px;">Severity (*S)</label>
                                                                    <input type="text" class="form-control text-center" readonly
                                                                        value="{{ $resikos->first()->severity ?? '-' }}">
                                                                </div>
                                                                <div class="col-4">
                                                                    <label class="form-label text-muted" style="font-size:11px;">Probability (*P)</label>
                                                                    <input type="text" class="form-control text-center" readonly
                                                                        value="{{ $resikos->first()->probability ?? '-' }}">
                                                                </div>
                                                                <div class="col-4">
                                                                    <label class="form-label text-muted" style="font-size:11px;">Level</label>
                                                                    @php
                                                                        $sBefore = $resikos->first()->severity ?? 0;
                                                                        $pBefore = $resikos->first()->probability ?? 0;
                                                                        $levelBefore = ($sBefore && $pBefore) ? $sBefore * $pBefore : '-';
                                                                    @endphp
                                                                    <div class="form-control text-center fw-bold" style="background:#f8f9fa;">
                                                                        {{ $levelBefore }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="mt-2">
                                                                <label class="form-label text-muted" style="font-size:11px;">Uraian Before</label>
                                                                <textarea class="form-control" rows="2" readonly></textarea>
                                                            </div> --}}
                                                        </div>

                                                        {{-- Tindakan & Rencana Mitigasi --}}
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Tindakan Terhadap Risiko</label>
                                                            @php $tindakanModal = $data[$form->id] ?? collect(); @endphp
                                                            @if ($tindakanModal->isNotEmpty())
                                                                @foreach ($tindakanModal as $idx => $t)
                                                                    <div class="border rounded p-2 mb-2" style="background:#f8f9fa;">
                                                                        <div class="row g-2">
                                                                            <div class="col-12">
                                                                                <label class="form-label text-muted mb-1" style="font-size:11px;">{{ $idx + 1 }}. Tindakan</label>
                                                                                <textarea class="form-control form-control-sm" rows="2" readonly>{{ $t->nama_tindakan }}</textarea>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <label class="form-label text-muted mb-1" style="font-size:11px;">Acuan</label>
                                                                                <input type="text" class="form-control form-control-sm" readonly value="{{ $t->acuan ?? '-' }}">
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted mb-1" style="font-size:11px;">PIC</label>
                                                                                <input type="text" class="form-control form-control-sm" readonly value="{{ $t->user->nama_user ?? '-' }}">
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted mb-1" style="font-size:11px;">Target Tanggal</label>
                                                                                <input type="text" class="form-control form-control-sm" readonly value="{{ $t->tgl_penyelesaian ?? '-' }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="form-control" style="background:#f8f9fa; color:#6c757d;">Belum ada tindakan.</div>
                                                            @endif
                                                        </div>
                                                        {{-- Sisa Risiko (After) --}}
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Sisa Risiko (After)</label>
                                                            <div class="row g-2">
                                                                <div class="col-4">
                                                                    <label class="form-label text-muted" style="font-size:11px;">Severity (*S)</label>
                                                                    <input type="text" class="form-control text-center" readonly
                                                                        value="{{ $resikos->first()->severityrisk ?? '-' }}">
                                                                </div>
                                                                <div class="col-4">
                                                                    <label class="form-label text-muted" style="font-size:11px;">Probability (*P)</label>
                                                                    <input type="text" class="form-control text-center" readonly
                                                                        value="{{ $resikos->first()->probabilityrisk ?? '-' }}">
                                                                </div>
                                                                <div class="col-4">
                                                                    <label class="form-label text-muted" style="font-size:11px;">Level After</label>
                                                                    @php
                                                                        $sAfter = $resikos->first()->severityrisk ?? 0;
                                                                        $pAfter = $resikos->first()->probabilityrisk ?? 0;
                                                                        $levelAfter = ($sAfter && $pAfter) ? $sAfter * $pAfter : '-';
                                                                    @endphp
                                                                    <div class="form-control text-center fw-bold" style="background:#f8f9fa;">
                                                                        {{ $levelAfter }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2">
                                                                <label class="form-label fw-bold" style="font-size:11px;">Rencana Tindakan Mitigasi</label>
                                                                <textarea class="form-control" rows="2" readonly>{{ $resikos->first()->after ?? '-' }}</textarea>
                                                            </div>
                                                        </div>

                                                        {{-- Status --}}
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Status</label>
                                                            @php
                                                                $statusVal = $resikos->first()->status ?? '-';
                                                                $statusColor = $statusVal === 'CLOSE' ? '#198754' : ($statusVal === 'ON PROGRES' ? '#ffc107' : '#0d6efd');
                                                            @endphp
                                                            <div class="form-control fw-bold" style="background:#f8f9fa; color:{{ $statusColor }};">
                                                                {{ $statusVal }}
                                                            </div>
                                                        </div>

                                                    </div>{{-- end modal-body --}}

                                                    {{-- Footer --}}
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('riskregister.archive', $form->id) }}" method="POST"
                                                            onsubmit="return confirm('Pindahkan data ini ke report?')"
                                                            style="margin: 0;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-warning">
                                                                <i class="bx bx-archive"></i> Kirim ke Report
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        {{-- ===== END MODAL PREVIEW ===== --}}
 
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    {{-- ===== TABEL RESUME RINGKASAN RISK ===== --}}
    @php
        $resumeBefore = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];
        $resumeAfter  = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];

        foreach ($forms as $form) {
            if ($form->is_archived) continue;

            $resiko = $form->resikos->first();
            if (!$resiko) continue;

            // Hitung Before
            $levelBefore = strtoupper($resiko->tingkatan ?? '');
            if (isset($resumeBefore[$levelBefore])) {
                $resumeBefore[$levelBefore]++;
            }

            // Hitung After — jika belum diisi, fallback ke Before
            $levelAfter = strtoupper($resiko->risk ?? '');
            if (!isset($resumeAfter[$levelAfter]) || $levelAfter === '') {
                $levelAfter = $levelBefore;
            }
            if (isset($resumeAfter[$levelAfter])) {
                $resumeAfter[$levelAfter]++;
            }
        }

        $totalBefore = array_sum($resumeBefore);
        $totalAfter  = array_sum($resumeAfter);
    @endphp

    <div class="card mt-3">
        <div class="card-body">
            <h6 class="card-title fw-bold mb-3">
                <i class="bi bi-bar-chart-line"></i> Ringkasan Kriteria Level Risiko
            </h6>
            <div style="overflow-x: auto;">
                <table class="table table-bordered" style="width: auto; min-width: 400px; font-size: 13px;">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th style="width: 40px;">No</th>
                            <th>Kriteria Level Risiko</th>
                            <th>Jumlah Risk (Awal)</th>
                            <th>Jumlah Risk (Setelah Mitigasi)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center fw-bold">1</td>
                            <td>
                                <span class="badge text-dark fw-semibold px-3 py-2" style="background-color: #92d050; font-size: 13px;">
                                    Risiko Rendah (1 - 3)
                                </span>
                            </td>
                            <td class="text-center">{{ $resumeBefore['LOW'] }}</td>
                            <td class="text-center">{{ $resumeAfter['LOW'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-center fw-bold">2</td>
                            <td>
                                <span class="badge text-dark fw-semibold px-3 py-2" style="background-color: #ffff00; font-size: 13px;">
                                    Risiko Sedang (&gt; 3 - 12)
                                </span>
                            </td>
                            <td class="text-center">{{ $resumeBefore['MEDIUM'] }}</td>
                            <td class="text-center">{{ $resumeAfter['MEDIUM'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-center fw-bold">3</td>
                            <td>
                                <span class="badge text-white fw-semibold px-3 py-2" style="background-color: #ff0000; font-size: 13px;">
                                    Risiko Tinggi (&gt; 12 - 25)
                                </span>
                            </td>
                            <td class="text-center">{{ $resumeBefore['HIGH'] }}</td>
                            <td class="text-center">{{ $resumeAfter['HIGH'] }}</td>
                        </tr>
                        <tr class="table-secondary fw-bold">
                            <td colspan="2" class="text-end">Total</td>
                            <td class="text-center">{{ $totalBefore }}</td>
                            <td class="text-center">{{ $totalAfter }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- ===== END TABEL RESUME ===== --}}


    <script>
        function loadDetail(id) {
            $.ajax({
                url: `/realisasi/${id}/detail`,
                method: 'GET',
                success: function(response) {
                    if (response.length > 0) {
                        let modalContent = '';
                        response.forEach((detail, index) => {
                            modalContent += `
                            <div class="mb-3">
                                <label for="nama_realisasi_${index}" class="form-label"><strong>Nama Activity:</strong></label>
                                <textarea class="form-control" id="nama_realisasi_${index}" name="nama_realisasi[]" readonly>${detail.nama_realisasi}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tgl_penyelesaian_${index}" class="form-label"><strong>Tanggal Penyelesaian:</strong></label>
                                <input type="date" class="form-control" id="tgl_penyelesaian_${index}" name="tgl_penyelesaian[]" value="${detail.tgl_penyelesaian}" readonly>
                            </div>
                            <input type="hidden" name="id[]" value="${detail.id}">
                            <hr>
                        `;
                        });

                        $('#modalContent').html(modalContent);
                    } else {
                        $('#modalContent').html('<p>Detail tidak tersedia.</p>');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    $('#modalContent').html(`<p>Terjadi kesalahan: ${xhr.responseText}</p>`);
                }
            });
        }

        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '/realisasi/update',
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Data berhasil diperbarui!');
                    $('#detailModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });

    </script>
    @if(session('open_preview_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalId = 'previewModal{{ session('open_preview_id') }}';
            var modalEl = document.getElementById(modalId);

            if (modalEl) {
                // Gunakan instance modal agar event 'dismiss' terdaftar dengan benar
                var myModal = new bootstrap.Modal(modalEl);
                myModal.show();

                // Script tambahan untuk memastikan tombol 'Batal' bekerja
                const closeBtns = modalEl.querySelectorAll('[data-bs-dismiss="modal"]');
                closeBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        myModal.hide();
                    });
                });
            }
        });
    </script>
    @endif
@endsection