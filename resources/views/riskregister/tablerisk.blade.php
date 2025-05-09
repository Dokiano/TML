@extends('layouts.main')

@section('content')

    <!-- Check for success message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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

        .table th {
            position: sticky;
            top: 0;
            background-color: #fff;
            /* Optional: to make sure the header has a white background */
            z-index: 1;
            /* Ensure the header is above the table rows */
        }
    </style>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">TABLE RISK & OPPORTUNITY REGISTER {{ $forms->first()->divisi->nama_divisi ?? '' }}</h5>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-start gap-3 mt-3">
                <!-- Filter Button (Trigger Modal) -->
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal"
                    style="font-weight: 500; font-size: 12px; padding: 6px 12px;border-radius: 0;">
                    <i class="fa fa-filter" style="font-size: 14px;"></i> Filter Options
                </button>
                <!-- New Issue Button -->
                <a href="{{ route('riskregister.create', ['id' => $id]) }}" class="btn btn-success"
                    style="font-weight: 500;border-radius: 0; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-plus" style="font-size: 14px;"></i> New Issue
                </a>
                <a href="{{ url()->current() }}" class="btn btn-secondary"
                    style="font-weight: 500; font-size: 12px; border-radius: 0;padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-refresh" style="font-size: 14px;"></i> Reset
                </a>

            </div>
        </div>
    </div>
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
                                        <option value="OPEN" {{ request('status') == 'OPEN' ? 'selected' : '' }}>OPEN
                                        </option>
                                        <option value="ON PROGRES"
                                            {{ request('status') == 'ON PROGRES' ? 'selected' : '' }}>ON PROGRESS</option>
                                        <option value="CLOSE" {{ request('status') == 'CLOSE' ? 'selected' : '' }}>CLOSE
                                        </option>
                                        <option value="open_on_progres"
                                            {{ request('status') == 'open_on_progres' ? 'selected' : '' }}>OPEN & ON
                                            PROGRES</option>
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
                                <th scope="col">No</th>
                                <th scope="col">Issue (Int:Ex)</th>
                                <th scope="col">I/E</th>
                                <th scope="col" style="width: 200px;">Pihak Berkepentingan</th>
                                <th scope="col">Resiko</th>
                                <th scope="col">Peluang</th>
                                <th scope="col">Tingkatan</th>
                                <th scope="col" style="width: 300px;">Tindakan Lanjut</th>
                                <th scope="col">Target Penyelesaian</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actual Risk</th>
                                <th scope="col">Before</th>
                                <th scope="col">After</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1; // Inisialisasi variabel untuk nomor urut

                            @endphp

                            @foreach ($forms as $form)
                                @php
                                    // Ambil resiko yang terkait dengan form ini
                                    $resikos = \App\Models\Resiko::where('id_riskregister', $form->id)->get();

                                    // Cek apakah ada resiko dengan status CLOSE dan after tidak null
                                    $isClosed = $resikos->contains(function ($resiko) {
                                        return !is_null($resiko->after) && $resiko->status === 'CLOSE';
                                    });
                                @endphp

                                @if (!$isClosed)
                                    <tr>
                                        <td>{{ $no++ }}
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
                                                action="{{ route('riskregister.updateData', $form->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <select name="inex" class="form-select form-select-sm"
                                                    onchange="this.form.submit()"
                                                    style="font-size: 10px; width: auto; display: inline-block;">
                                                    <option value="I" {{ $form->inex === 'I' ? 'selected' : '' }}>I
                                                    </option>
                                                    <option value="E" {{ $form->inex === 'E' ? 'selected' : '' }}>E
                                                    </option>
                                                </select>
                                            </form>
                                        </td>

                                        <td style="max-width:300px">
                                            @php
                                                $selectedDivisi = $form->pihak ? explode(',', $form->pihak) : [];
                                                $allDivisi = \App\Models\Divisi::all();
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
                                                    @foreach ($selectedDivisi as $s)
                                                        - {{ $s }}<br>
                                                    @endforeach
                                                    @if (count($selectedDivisi) === 0)
                                                        -
                                                    @endif
                                                </div>

                                                {{-- 3. Kontainer edit (dropdown + Save), hidden default --}}
                                                <div id="pihak-edit-{{ $form->id }}" class="d-none">
                                                    <div class="dropdown mb-2">
                                                        <button
                                                            class="btn btn-outline-dark dropdown-toggle text-start text-wrap"
                                                            type="button" id="dropdownDivisiAkses-{{ $form->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                            style="max-width:3 00px; white-space:normal; word-break:break-word; font-size:13px;">
                                                            @foreach ($selectedDivisi as $s)
                                                                - {{ $s }}<br>
                                                            @endforeach
                                                            @if (count($selectedDivisi) === 0)
                                                                -
                                                            @endif
                                                        </button>
                                                        <ul class="dropdown-menu checkbox-group p-2"
                                                            aria-labelledby="dropdownDivisiAkses-{{ $form->id }}"
                                                            style=" max-height: 200px; overflow-y: auto;">
                                                            <li class="form-check mb-2">
                                                                <input
                                                                    class="form-check-input select-all-{{ $form->id }}"
                                                                    type="checkbox" id="select-all-{{ $form->id }}">
                                                                <label class="form-check-label"
                                                                    for="select-all-{{ $form->id }}">
                                                                    Pilih Semua
                                                                </label>
                                                            </li>

                                                            @foreach ($allDivisi as $d)
                                                                <li class="form-check mb-1">
                                                                    <input
                                                                        class="form-check-input all-divisi-{{ $form->id }}"
                                                                        type="checkbox" name="pihak[]"
                                                                        value="{{ $d->nama_divisi }}"
                                                                        id="divisi-{{ $form->id }}-{{ $d->id }}"
                                                                        {{ in_array($d->nama_divisi, $selectedDivisi) ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="divisi-{{ $form->id }}-{{ $d->id }}">
                                                                        {{ $d->nama_divisi }}
                                                                    </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    {{-- 4. Tombol Save --}}
                                                    <button type="submit" id="save-pihak-{{ $form->id }}"
                                                        class="btn btn-primary btn-sm">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>

                                            <script>
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
                                            </script>
                                        </td>




                                        <!-- Kolom Resiko -->
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
                                                action="{{ route('riskregister.updatepeluang', $form->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="editpeluang-{{ $form->id }}"
                                                        onchange="togglepeluang({{ $form->id }})">
                                                    <label class="form-check-label text-danger"
                                                        for="editpeluang-{{ $form->id }}">
                                                        Edit
                                                    </label>
                                                </div>

                                                <span id="peluang-text-{{ $form->id }}">
                                                    {{ $form->peluang ?? '-' }}
                                                </span>

                                                <textarea name="peluang" id="peluang-input-{{ $form->id }}" class="form-control form-control-sm mt-2 d-none"
                                                    style="overflow:hidden; resize:none;" oninput="autoResize(this)">{{ $form->peluang }}</textarea>

                                                <button type="submit" id="peluang-save-{{ $form->id }}"
                                                    class="btn btn-primary btn-sm mt-2 d-none">
                                                    Save
                                                </button>

                                                <script>
                                                    // Auto‐resize textarea sesuai isi
                                                    function autoResize(el) {
                                                        el.style.height = 'auto';
                                                        el.style.height = el.scrollHeight + 'px';
                                                    }

                                                    // Toggle edit/view mode untuk Peluang
                                                    function togglepeluang(id) {
                                                        const cb = document.getElementById('editpeluang-' + id);
                                                        const text = document.getElementById('peluang-text-' + id);
                                                        const input = document.getElementById('peluang-input-' + id);
                                                        const button = document.getElementById('peluang-save-' + id);

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
                                            </form>
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

                                                    <a href="{{ route('resiko.matriks', ['id' => $form->id, 'tingkatan' => $resiko->tingkatan]) }}"
                                                        title="Matriks Before" class="btn {{ $btnClass }}"
                                                        style="font-size: 9px; padding: 2px; color: white;">
                                                        <strong>{{ $resiko->tingkatan }}</strong><i class="ri-grid-line"
                                                            style="font-size: 14px;"></i>
                                                    </a>

                                                    <br>
                                                    <a class="btn btn-success mt-2"
                                                        href="{{ route('resiko.edit', ['id' => $form]) }}"
                                                        title="Edit Matriks"
                                                        style="font-size: 10px; padding: 3px; color: white;">
                                                        <strong>Edit</strong><i class="bx bx-edit"
                                                            style="font-size: 13px;"></i>
                                                    </a>
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </td>

                                        <!-- Kolom pihak berkepentingan dan tindakan lanjut -->
                                        <td style="vertical-align: top;">

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
                                                                <a
                                                                    href="{{ route('realisasi.index', $t->id) }}">{{ $t->nama_tindakan }}</a><br>
                                                                <span
                                                                    class="badge bg-purple">{{ $t->tgl_penyelesaian }}</span>
                                                                <span
                                                                    class="badge bg-purple">{{ $t->user->nama_user ?? '-' }}</span>
                                                                @if ($t->isClosed)
                                                                    <span class="badge bg-success">CLOSE</span>
                                                                @elseif($t->isOnProgress)
                                                                    <span class="badge bg-warning">ON PROGRESS</span>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    Tidak ada tindakan lanjut
                                                @endif
                                            </div>

                                            {{-- EDIT MODE (form input), hidden default --}}
                                            <div id="tindakan-edit-{{ $form->id }}" class="d-none">
                                                <h3 class="card-title">Tindakan Lanjut</h3>

                                                <form method="POST"
                                                    action="{{ route('realisasi.updateBatch', $form->id) }}">
                                                    {{-- route custom --}}
                                                    @csrf
                                                    @method('PATCH')

                                                    <div id="inputContainer-{{ $form->id }}">
                                                        @foreach ($tindakanExisting as $t)
                                                            <div class="action-block mb-3"
                                                                data-id="{{ $t->id }}">
                                                                {{-- Tindakan --}}
                                                                <div class="row mb-2">
                                                                    <label
                                                                        class="col-sm-3 col-form-label"><strong>Tindakan</strong></label>
                                                                    <div class="col-sm-9">
                                                                        <textarea name="tindakan[{{ $t->id }}]" class="form-control" rows="2" required>{{ old("tindakan.{$t->id}", $t->nama_tindakan) }}</textarea>
                                                                    </div>
                                                                </div>
                                                                {{-- PIC --}}
                                                                <div class="row mb-2">
                                                                    <label
                                                                        class="col-sm-3 col-form-label"><strong>PIC</strong></label>
                                                                    <div class="col-sm-9">
                                                                        <select name="targetpic[{{ $t->id }}]"
                                                                            class="form-select" required>
                                                                            <option value="">Pilih PIC</option>
                                                                            @foreach ($users as $user)
                                                                                <option value="{{ $user->id }}"
                                                                                    {{ old("targetpic.{$t->id}", $t->targetpic) == $user->id ? 'selected' : '' }}>
                                                                                    {{ $user->nama_user }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                {{-- Tanggal --}}
                                                                <div class="row mb-2">
                                                                    <label class="col-sm-3 col-form-label"><strong>Target
                                                                            Tgl</strong></label>
                                                                    <div class="col-sm-9">
                                                                        <input type="date"
                                                                            name="tgl_penyelesaian[{{ $t->id }}]"
                                                                            class="form-control"
                                                                            value="{{ old("tgl_penyelesaian.{$t->id}", \Carbon\Carbon::createFromFormat('d-m-Y', $t->tgl_penyelesaian)->format('Y-m-d')) }}"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                {{-- Hapus --}}
                                                                <div class="row mb-2">
                                                                    <div class="col-sm-9 offset-sm-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                name="hapus[{{ $t->id }}]"
                                                                                id="hapus_{{ $t->id }}"
                                                                                value="1">
                                                                            <label class="form-check-label text-danger"
                                                                                for="hapus_{{ $t->id }}">
                                                                                Hapus Tindakan Ini
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- tombol Add More --}}
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            onclick="addMoreTindakan({{ $form->id }})">
                                                            Add More
                                                        </button>
                                                    </div>

                                                    {{-- tombol simpan --}}
                                                    <div class="mt-3 text-end">
                                                        <button type="submit" class="btn btn-success">
                                                            Update Semua
                                                        </button>
                                                    </div>
                                                </form>
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
                                                const index = Date.now(); // unique key
                                                const html = `
                                                <div class="action-block mb-3" data-id="new_${index}">
                                                  <div class="row mb-2">
                                                    <label class="col-sm-3 col-form-label"><strong>Tindakan</strong></label>
                                                    <div class="col-sm-9">
                                                      <textarea name="tindakan_new[${index}]" class="form-control" rows="2" required></textarea>
                                                    </div>
                                                  </div>
                                                  <div class="row mb-2">
                                                    <label class="col-sm-3 col-form-label"><strong>PIC</strong></label>
                                                    <div class="col-sm-9">
                                                      <select name="targetpic_new[${index}]" class="form-select" required>
                                                        <option value="">Pilih PIC</option>
                                                        @foreach ($users as $user)
                                                          <option value="{{ $user->id }}">{{ $user->nama_user }}</option>
                                                        @endforeach
                                                      </select>
                                                    </div>
                                                  </div>
                                                  <div class="row mb-2">
                                                    <label class="col-sm-3 col-form-label"><strong>Target Tgl</strong></label>
                                                    <div class="col-sm-9">
                                                      <input type="date" name="tgl_penyelesaian_new[${index}]" class="form-control" required>
                                                    </div>
                                                  </div>
                                                  <div class="text-end">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.action-block').remove()">
                                                      Delete
                                                    </button>
                                                  </div>
                                                  <hr>
                                                </div>`;
                                                container.insertAdjacentHTML('beforeend', html);
                                            }
                                        </script>


                                        <td>
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
                                                    class="form-control form-control-sm mt-2 d-none" {{-- Convert format d-m-Y → Y-m-d untuk date input --}}
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
                                        </td>

                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                {{-- <?= dd($resikos) ?> --}}
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
                                                        {{-- <?= dd($form) ?> --}}
                                                    </span>
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    <a href="{{ route('resiko.matriks2', ['id' => $form->id]) }}"
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

                                            <a class="btn btn-success mt-2"
                                                href="{{ route('resiko.edit', ['id' => $form]) }}" title="Edit Matriks"
                                                style="font-size: 10px; padding: 3px; color: white;">
                                                <strong>Edit</strong>
                                                <i class="bx bx-edit" style="font-size: 10px;"></i>
                                            </a>
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
                                        <td>
                                            <form method="POST"
                                                action="{{ route('riskregister.updateafter', $form->id) }}">
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
                                        <td>
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                                <a href="{{ route('riskregister.edit', $form->id) }}" title="Edit Issue"
                                                    class="btn btn-success"
                                                    style="font-weight: 500; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                                                    <i class="bx bx-edit" style="font-size: 14px;"></i>
                                                </a>
                                                <form action="{{ route('riskregister.destroy', $form['id']) }}"
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

@endsection
