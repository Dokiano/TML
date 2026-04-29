@extends('layouts.main')

@section('content')
    <div class="container">

        <!-- Tampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 0;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search Button (Trigger Modal)
        <div class="card text-center shadow-sm border-0 rounded-lg">
            <div class="card-body py-1">
                <h2 class="card-title text-uppercase fw-bold text-primary"
                    style="font-size: 21px; letter-spacing: 0px; word-spacing: 2px;">
                    ALL REPORT RISK & OPPORTUNITY REGISTER 37001
                </h2>
            </div>
        </div> -->

        <div class="d-flex justify-content-between align-items-center w-100">
            <div role="group" class="d-flex align-items-center">
                <!-- Filter Button -->
                <button type="button" class="btn btn-outline-primary shadow-sm px-1 py-1 rounded-lg" data-bs-toggle="modal"
                    data-bs-target="#filterModal" style="border-radius: 0 !important;">
                    <i class="fa fa-filter me-1"></i> 
                </button>

                <!-- Export PDF Button (ISO 9001) -->
                <a href="{{ route(
                    'riskregister.export-pdf',
                    array_merge(['id' => $divisiList->first()->id ?? '', 'layout' => 'layout_b'], request()->query()),
                ) }}"
                    class="btn btn-link text-danger shadow-sm px-1 py-1 ms-1 rounded-lg" title="Export PDF ISO 9001"
                    style="border-radius: 0 !important;">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> 
                </a>
                
                <a href="{{ route('riskregister.export-excel', ['id' => $divisiList->first()->id ?? '', 'layout' => 'layout_b']) }}&tingkatan={{ request('tingkatan') }}&status={{ request('status') }}&nama_divisi={{ request('nama_divisi') }}&year={{ request('year') }}&keyword={{ request('keyword') }}&kriteria={{ request('kriteria') }}&top10={{ request('top10') }}&sorting_tingkatan={{ request('sorting_tingkatan') }}&sorting_tanggal={{ request('sorting_tanggal') }}"
                     class="btn btn-link text-success shadow-sm px-1 py-1 ms-1 rounded-lg" title="Export Excel"
                     style="border-radius: 0 !important;">
                     <i class="bi bi-file-earmark-excel-fill me-1"></i> 
                 </a>

            </div>

            <span class="text-primary" 
                style="font-weight: 800; font-size: 1rem; opacity: 0.8; line-height: 1;">
                All RISK & OPPORTUNITY REGISTER ISO 37001
            </span>
           {{--  <a href="{{ route('admin.kriteria') }}"
                class="btn btn-primary shadow-sm d-flex align-items-center justify-content-center" title="Setting Kriteria"
                style="width: 45px; height: 45px; border-radius: 50%;">
                <i class="ri-settings-5-line fs-4"></i>
            </a> --}}

            <!-- Tabel Kriteria Button -->
            <button type="button"
                class="btn btn-primary shadow-sm d-flex align-items-center justify-content-center"
                data-bs-toggle="modal" data-bs-target="#modalTabelKriteria"
                title="Tabel Kriteria Severity"
                style="width: 30px; height: 30px; border-radius: 40%;">
                <i class="ri-settings-5-line fs-4"></i>
            </button>
        </div>


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
                transition: all 0.2 ease;
            }

            .table th {
                position: sticky;
                top: 0;
                background-color: #fff;
                /* Optional: to make sure the header has a white background */
                z-index: 10;
                box-shadow: 0 2px 2px -1px rgba(0,0,0,1)
                /* Ensure the header is above the table rows */
            }

            .table-fit {
                transition: transform 0.2s ease-in-out;
                transform-origin: top left;
                /* Trik agar proses rendering pindah ke GPU */
                will-change: transform;
                backface-visibility: hidden;
                -webkit-font-smoothing: subpixel-antialiased;
            }

            /* Class khusus saat Zoom Fit aktif */
            .zoom-fit-active {
                   transform-origin: top left;
                   width: 100% !important;
                   transition: all 0.3s ease;
            }
            
            .zoom-fit-active th, 
            .zoom-fit-active td {
                padding: 4px 2px !important; 
                white-space: normal !important;
            }
        
            /* Styling untuk zoom controls */
            .zoom-controls {
                display: flex;
                align-items: center;
            }
        
            #zoom-slider {
                cursor: pointer;
            }
        
            #zoom-slider::-webkit-slider-thumb {
                background: #0d6efd;
                cursor: pointer;
            }
      
            #zoom-slider::-moz-range-thumb {
                background: #0d6efd;
                cursor: pointer;Y
            }
        </style>

        <!-- Modal for Filters -->
        <!-- Modal Filter -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg agar lebih luas -->
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="filterModalLabel"><i class="bi bi-funnel"></i> Filter Options</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form Filter -->
                    <form method="GET" action="{{ route('riskregister.biglist.iso') }}">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row g-3"> <!-- Menggunakan g-3 untuk jarak antar elemen -->

                                    <div class="col-md-6">
                                        <label for="nama_divisi" class="form-label">
                                            <i class="bi bi-building"></i> <strong>Departemen:</strong>
                                        </label>
                                        <select id="nama_divisi" name="nama_divisi" class="form-select">
                                            <option value="">-- Semua Departemen --</option>
                                            @foreach ($divisiListFilter as $divisi)
                                                <option value="{{ $divisi->nama_divisi }}"
                                                    {{ request('nama_divisi') == $divisi->nama_divisi ? 'selected' : '' }}>
                                                    {{ $divisi->nama_divisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                   {{--  <div class="col-md-6">
                                        <label for="year" class="form-label">
                                            <i class="bi bi-calendar"></i> <strong>Tahun Penyelesaian:</strong>
                                        </label>
                                        <select id="year" name="year" class="form-select">
                                            <option value="">-- Semua Tahun --</option>
                                            @for ($year = date('Y'); $year >= 2000; $year--)
                                                <option value="{{ $year }}"
                                                    {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div> --}}

                                    <div class="col-md-6">
                                        <label for="kriteria" class="form-label">
                                            <i class="bi bi-list-task"></i> <strong>Kriteria:</strong>
                                        </label>
                                        <select id="kriteria" name="kriteria" class="form-select">
                                            <option value="">-- Semua Kriteria --</option>
                                            <option value="Unsur keuangan / Kerugian"
                                                {{ request('kriteria') == 'Unsur keuangan / Kerugian' ? 'selected' : '' }}>
                                                Unsur keuangan / Kerugian</option>
                                            <option value="Safety & Health"
                                                {{ request('kriteria') == 'Safety & Health' ? 'selected' : '' }}>Safety &
                                                Health</option>
                                            <option value="Enviromental (lingkungan)"
                                                {{ request('kriteria') == 'Enviromental (lingkungan)' ? 'selected' : '' }}>
                                                Enviromental (lingkungan)</option>
                                            <option value="Reputasi"
                                                {{ request('kriteria') == 'Reputasi' ? 'selected' : '' }}>Reputasi</option>
                                            <option value="Financial"
                                                {{ request('kriteria') == 'Financial' ? 'selected' : '' }}>Financial
                                            </option>
                                            <option value="Operational"
                                                {{ request('kriteria') == 'Operational' ? 'selected' : '' }}>Operational
                                            </option>
                                            <option value="Kinerja"
                                                {{ request('kriteria') == 'Kinerja' ? 'selected' : '' }}>Kinerja</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tingkatan" class="form-label">
                                            <i class="bi bi-bar-chart"></i> <strong>Tingkatan:</strong>
                                        </label>
                                        <select id="tingkatan" name="tingkatan" class="form-select">
                                            <option value="">-- Semua Tingkatan --</option>
                                            <option value="LOW" {{ request('tingkatan') == 'LOW' ? 'selected' : '' }}>
                                                LOW</option>
                                            <option value="MEDIUM"
                                                {{ request('tingkatan') == 'MEDIUM' ? 'selected' : '' }}>MEDIUM</option>
                                            <option value="HIGH" {{ request('tingkatan') == 'HIGH' ? 'selected' : '' }}>
                                                HIGH</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="status" class="form-label">
                                            <i class="bi bi-check-circle"></i> <strong>Status:</strong>
                                        </label>
                                        <select id="status" name="status" class="form-select">
                                            <option value="">-- Semua Status --</option>
                                            <option value="ON PROGRES"
                                                {{ request('status') == 'ON PROGRES' ? 'selected' : '' }}>ON PROGRESS
                                            </option>
                                            <option value="CLOSE" {{ request('status') == 'CLOSE' ? 'selected' : '' }}>
                                                CLOSE</option>
                                        </select>
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <label for="keyword" class="form-label">
                                            <i class="bi bi-search"></i> <strong>Search:</strong>
                                        </label>
                                        <input type="text" id="keyword" name="keyword" class="form-control"
                                            placeholder="Search..." value="{{ request('keyword') }}">
                                    </div> --}}

                                   {{-- <div class="col-12 text-center mt-3">
                                        <h6 class="text-muted"><strong>-- Sorting Menu --</strong></h6>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sorting_tingkatan" class="form-label">
                                            <i class="bi bi-arrow-down-up"></i> <strong>Tingkatan:</strong>
                                        </label>
                                        <select id="sorting_tingkatan" name="sorting_tingkatan" class="form-select">
                                            <option value="">-- Default --</option>
                                            <option value="high_to_low"
                                                {{ request('sorting_tingkatan') == 'high_to_low' ? 'selected' : '' }}>HIGH
                                                - LOW</option>
                                            <option value="low_to_high"
                                                {{ request('sorting_tingkatan') == 'low_to_high' ? 'selected' : '' }}>LOW -
                                                HIGH</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sorting_tanggal" class="form-label">
                                            <i class="bi bi-calendar-range"></i> <strong>Tanggal:</strong>
                                        </label>
                                        <select id="sorting_tanggal" name="sorting_tanggal" class="form-select">
                                            <option value="">-- Default --</option>
                                            <option value="terbaru"
                                                {{ request('sorting_tanggal') == 'terbaru' ? 'selected' : '' }}>Terbaru
                                            </option>
                                            <option value="terlama"
                                                {{ request('sorting_tanggal') == 'terlama' ? 'selected' : '' }}>Terlama
                                            </option>
                                        </select>
                                    </div> --}} 
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
                            <a href="{{ route('riskregister.biglist.iso') }}" class="btn btn-secondary"><i
                                    class="bi bi-arrow-clockwise"></i> Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <br>

        <!-- Small tables -->
        <div class="card">
            <div class="card-body">
                <div style="overflow-x: auto;">
                    <div class="table-wrapper">
                        <table class="table table-striped table-fit" style="width: 180%; font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th width="300px">Bagian</th>{{-- Pihak Berkepentingan --}}
                                    <th>Nama Proses</th>{{-- Issue --}}
                                    <th>Aktifitas Kunci</th>
                                    <th>Potensi Risk Penyuapan</th>{{-- Risiko --}}
                                    <th>Skema Modus Operandi</th> {{-- Before --}}
                                   {{--  <th>I/E</th> --}}
                                    <th>Resiko</th>
                                    <th>S</th>
                                    <th>P</th>
                                    <th>Level</th>
                                    <th>Tindakan </th> {{-- Tindak Lanjut --}}
                                    <th>Acuan</th>
                                    <th>Sisa Resiko</th>
                                    <th>S</th>
                                    <th>P</th>
                                    <th>Level</th>
                                    <th>Rencana Tindakan Mitigasi</th>
                                   {{--  <th>Status</th>--}} 
                                    <th>Create At</th>
                                    <th>Review At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <?php dd($formattedData); ?> --}}
                                @foreach ($formattedData as $data)
                                    <tr>
                                        <td>
                                            <a>
                                                {{ $loop->iteration }}
                                            </a>
                                        </td>
                                        <td>
                                            @php
                                                // Ubah string "divisi1,divisi2,divisi3" jadi array
                                                $pihakList = explode(',', $data['pihak'] ?? '');
                                                $keterangan = $data['keterangan'] ?? [];
                                            @endphp

                                            <ul>
                                                @foreach ($pihakList as $i => $pihak)
                                                    <li>{{ trim($pihak) }} @if (is_array($keterangan) && !empty($keterangan))
                                                        : {{ $keterangan[$i] ?? '-' }}
                                                    @endif</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $data['issue'] }}</td>
                                        <td>{{ $data['aktifitas_kunci'] ?? '' }}</td>

                                        <td>
                                            <div id="source">
                                                @if ($data['risiko'])
                                                    @foreach ($data['risiko'] as $risiko)
                                                        {{ $risiko }}<br>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <hr>
                                        </td>

                                        <td>
                                            @foreach ($data['before'] as $risiko)
                                                {{ $risiko }}<br>
                                            @endforeach
                                        </td>
                                      {{--   <td>{{ $data['inex'] }}</td> --}}
                                        
                                        <td>
                                            @foreach ($data['tingkatan'] as $index => $tingkatan)
                                                <a href="#"
                                                    class="text-decoration-none d-block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetailRisiko"
                                                    data-risiko="{{ $data['risiko'][$index] ?? '-' }}"
                                                    data-kriteria="{{ $data['kriteria_resiko'][$index] ?? '-' }}"
                                                    data-severity="{{ $data['severities'][$index] ?? '-' }}"
                                                    data-probability="{{ $data['probabilities'][$index] ?? '-' }}"
                                                    data-desc-severity="{{ $data['desc_severity'][$index] ?? '-' }}"
                                                    data-desc-probability="{{ $data['desc_probability'][$index] ?? '-' }}"
                                                >{{ $tingkatan }}</a>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($data['severities'] as $s)
                                                {{ $s }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($data['probabilities'] as $p)
                                                {{ $p }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($data['scores'] as $score)
                                                @php
                                                    $colorClass = '';
                                                    if ($score >= 1 && $score <= 3) {
                                                        $colorClass = 'bg-success text-white'; // Hijau
                                                    } elseif ($score >= 4 && $score <= 12) {
                                                        $colorClass = 'bg-warning text-white'; // Kuning
                                                    } elseif ($score >= 13 && $score <= 25) {
                                                        $colorClass = 'bg-danger text-white'; // Merah
                                                    }
                                                @endphp
                                                <span class="badge {{ $colorClass }}">{{ $score }}</span><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div style="width: 150px;">
                                                @foreach ($data['tindak'] as $index => $pihak)
                                                    {{-- <li> --}}
                                                    <strong>{{ $pihak }}</strong>
                                                    <ul>
                                                        <li>{{ $data['tindak_lanjut'][$index] }}</li>
                                                    </ul>
                                                    {{-- </li> --}}
                                                    <hr>
                                                @endforeach
                                            </div>
                                        </td>

                                        <td>
                                            @forelse($data['acuan'] as $i => $a)
                                                <div>{{ $i+1 }}. {{ $a }}</div>
                                            @empty
                                                <div>-</div>
                                            @endforelse
                                        </td>
                                        

                                        <!-- Skor -->
                                     
                                        <td>
                                            @foreach ($data['risk'] as $risiko)
                                                {{ $risiko }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($data['severitiesrisk'] as $s)
                                                {{ $s }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($data['probabilitiesrisk'] as $p)
                                                {{ $p }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($data['scoreactual'] as $score)
                                                @php
                                                    $colorClass = '';
                                                    if ($score >= 1 && $score <= 3) {
                                                        $colorClass = 'bg-success text-white'; // Hijau
                                                    } elseif ($score >= 4 && $score <= 12) {
                                                        $colorClass = 'bg-warning text-white'; // Kuning
                                                    } elseif ($score >= 13 && $score <= 25) {
                                                        $colorClass = 'bg-danger text-white'; // Merah
                                                    }
                                                @endphp
                                                <span class="badge {{ $colorClass }}">{{ $score }}</span><br>
                                            @endforeach

                                        </td>

                                        
                                        <td>
                                            @foreach ($data['after'] as $risiko)
                                                {{ $risiko }}<br>
                                            @endforeach
                                        </td>

                                        <!-- Status -->
                                        {{-- <td>
                                            @foreach ($data['status'] as $status)
                                                <span
                                                    class="badge
                                            @if ($status == 'OPEN') bg-danger
                                            @elseif($status == 'ON PROGRES')
                                                bg-warning
                                            @elseif($status == 'CLOSE')
                                                bg-success @endif">
                                                    {{ $status }}<br>
                                                    {{ $data['nilai_actual'] }}%
                                                </span><br>
                                            @endforeach
                                        </td> --}}

                                        {{-- Create at --}}
                                        <td style="width: 100px">
                                            @if (isset($data['updated_at']))
                                                {{ \Carbon\Carbon::parse($data['updated_at'])->format('d-m-Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        {{-- Review At --}}
                                        <td style="width: 130px">
                                            <form action="{{ route('riskregister.update-review-at', $data['id']) }}" method="POST" class="d-flex align-items-center gap-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="date"
                                                    name="review_at"
                                                    class="form-control form-control-sm"
                                                    value="{{ isset($data['review_at']) && $data['review_at'] ? \Carbon\Carbon::parse($data['review_at'])->format('Y-m-d') : '' }}"
                                                    style="font-size: 11px; min-width: 110px;">
                                                <button type="submit" class="btn btn-sm btn-primary px-1 py-0" title="Simpan Review At">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Action Buttons -->
                                         <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    style="font-size: 12px;">
                                                    <i class="bx bx-cog"></i> Action
                                                </button>
                                                <ul class="dropdown-menu">

                                                    <li>
                                                        <a href="{{ route('riskregister.edit.iso', $data['id']) }}"
                                                            class="dropdown-item" style="font-size: 12px;">
                                                            <i class="bx bx-edit text-success"></i> Edit Issue
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <form action="{{ route('riskregister.unarchive', $data['id']) }}" method="POST"
                                                            onsubmit="return confirm('Kembalikan data ini dari report?')" style="margin: 0;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item" style="font-size: 12px;">
                                                                <i class="bx bx-archive-out text-warning"></i> Un-Archive
                                                            </button>
                                                        </form>
                                                    </li>

                                                    <li><hr class="dropdown-divider"></li>

                                                    <li>
                                                        <form action="{{ route('riskregister.destroy', $data['id']) }}" method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="margin: 0;">
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
                                        {{-- <td>
                                            <div id="target" style="width: 150px;opacity: 0;">
                                                @foreach ($data['tindak'] as $index => $pihak)
                                                    {{-- <li> 
                                                    <hr>
                                                    <strong>{{ $pihak }}</strong>
                                                    <ul>
                                                        <li>{{ $data['tindak_lanjut'][$index] }}</li>
                                                    </ul>
                                                    {{-- </li> 
                                                @endforeach
                                            </div>
                                             @if ($data['peluang'])
                                                <p
                                                    style="border-color: #212529; border-top: 1px solid #2125293f; !important;">
                                                    {{ $data['peluang'] }}</p>
                                            @endif
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="zoom-controls d-flex align-items-center gap-2">
                  <!-- Zoom Fit Button -->
                  <button type="button" id="btn-zoom-fit" class="btn btn-outline-info shadow-sm px-3 py-2" style="border-radius:0!important;">
                      <i class="ri-fullscreen-exit-line"></i> Zoom Fit
                  </button>

                  <!-- Zoom Controls (tersembunyi saat pertama kali) -->
                  <div id="zoom-slider-container" class="d-none align-items-center gap-2">
                      <button type="button" id="btn-zoom-out" class="btn btn-outline-secondary btn-sm">
                          <i class="ri-zoom-out-line"></i>
                      </button>
                      {{-- <input type="range" id="zoom-slider" min="40" max="100" value="55" step="5" class="form-range" style="width: 150px;">--}}
                      <span id="zoom-percentage" class="badge bg-info">55%</span>
                      <button type="button" id="btn-zoom-in" class="btn btn-outline-secondary btn-sm">
                          <i class="ri-zoom-out-line"></i>
                      </button>
            </div>
        </div>
        {{-- ===== TABEL RESUME RINGKASAN RISK ===== --}}
@php
    $resumeBefore = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];
    $resumeAfter  = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];

    foreach ($formattedData as $item) {
        // tingkatan & risk adalah Collection (hasil pluck), ambil index pertama
        $levelBefore = strtoupper($item['tingkatan'][0] ?? '');
        if (isset($resumeBefore[$levelBefore])) {
            $resumeBefore[$levelBefore]++;
        }

        $levelAfter = strtoupper($item['risk'][0] ?? '');
        if (!isset($resumeAfter[$levelAfter]) || $levelAfter === '') {
            $levelAfter = $levelBefore; // fallback ke before
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
        <small class="text-muted">
            <i class="bi bi-info-circle"></i>
            * Risiko yang belum memiliki data Sisa Risiko (After) dihitung berdasarkan nilai awal (Before).
        </small>
    </div>
</div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnZoomFit = document.getElementById('btn-zoom-fit');
                const btnZoomIn = document.getElementById('btn-zoom-in');
                const btnZoomOut = document.getElementById('btn-zoom-out');
                const zoomSlider = document.getElementById('zoom-slider');
                const zoomPercentage = document.getElementById('zoom-percentage');
                const sliderContainer = document.getElementById('zoom-slider-container');
                const table = document.querySelector('.table-fit');
                const wrapper = document.querySelector('.table-wrapper');

                let isZoomFitActive = false;
                let currentZoom = 55; // default zoom 55%

                // Fungsi untuk apply zoom
                function applyZoom(zoomValue) {
                    currentZoom = zoomValue;
                    const zoomDecimal = zoomValue / 100;

                    table.style.zoom = zoomDecimal;
                    table.style.fontSize = (9 * (zoomValue / 55)) + 'px'; // scale font relative to 55%
                    zoomPercentage.textContent = zoomValue + '%';
                    if (zoomSlider) zoomSlider.value = zoomValue;
                }
            
                // Toggle Zoom Fit Mode
                btnZoomFit.addEventListener('click', function() {
                    isZoomFitActive = !isZoomFitActive;

                    if (isZoomFitActive) {
                        // Aktifkan zoom fit
                        table.classList.add('zoom-fit-active');
                        sliderContainer.classList.remove('d-none');
                        sliderContainer.classList.add('d-flex');
                        wrapper.style.overflowX = 'auto';
                        wrapper.style.overflowY = 'auto';
                        
                        this.innerHTML = '<i class="ri-fullscreen-line"></i> Normal View';
                        this.classList.remove('btn-outline-info');
                        this.classList.add('btn-info');

                        // Apply zoom default
                        applyZoom(55);
                    } else {
                        // Nonaktifkan zoom fit
                        table.classList.remove('zoom-fit-active');
                        sliderContainer.classList.remove('d-flex');
                        sliderContainer.classList.add('d-none');
                        wrapper.style.overflowX = 'auto';
                        wrapper.style.overflowY = 'auto';
                        table.style.zoom = '1';
                        table.style.fontSize = '13px';

                        this.innerHTML = '<i class="ri-fullscreen-exit-line"></i> Zoom Fit';
                        this.classList.remove('btn-info');
                        this.classList.add('btn-outline-info');
                    }
                });
            
                // Zoom In Button
                btnZoomIn.addEventListener('click', function() {
                    if (currentZoom < 100) {
                        applyZoom(Math.min(currentZoom + 5, 100));
                    }
                });
            
                // Zoom Out Button
                btnZoomOut.addEventListener('click', function() {
                    if (currentZoom > 40) {
                        applyZoom(Math.max(currentZoom - 5, 40));
                    }
                });
            
                // Slider Input
                if (zoomSlider) {
                    zoomSlider.addEventListener('input', function() {
                        applyZoom(parseInt(this.value));
                    });
                }
            });
        </script>
{{-- ===== END TABEL RESUME ===== --}}

        {{-- ===== MODAL TABEL KRITERIA ===== --}}
        <div class="modal fade" id="modalTabelKriteria" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-grid-3x3 me-2"></i> Tabel Kriteria & Severity
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 align-top" style="font-size: 11px; min-width: 900px;">
                                <thead>
                                    <tr class="table-primary text-center align-middle">
                                        <th style="width: 100px;">Tingkat Dampak</th>
                                        <th>Reputasi / SMAP</th>
                                        <th>Legal / Regulasi</th>
                                        <th>Operasional</th>
                                        <th>Financial</th>
                                        <th>Kinerja / Keberlangsungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Baris 1 --}}
                                    <tr>
                                        <td class="fw-semibold text-center align-middle" >
                                            1 – Tidak Signifikan (Sangat Rendah)
                                        </td>
                                        <td>Tidak ada dampak reputasi. Tidak mempengaruhi efektivitas SMAP. Hanya administratif minor.</td>
                                        <td>Tidak ada pelanggaran hukum atau kebijakan anti-penyuapan.</td>
                                        <td>Tidak berdampak pada operasional pabrik. Proses tetap berjalan normal.</td>
                                        <td>Tidak ada dampak finansial.</td>
                                        <td>Tidak memerlukan tindakan korektif formal. Dapat ditangani langsung.</td>
                                    </tr>
                                    {{-- Baris 2 --}}
                                    <tr>
                                        <td class="fw-semibold text-center align-middle" >
                                            2 – Kurang Signifikan (Rendah)
                                        </td>
                                        <td>Reputasi tidak terpengaruh. Tidak ada indikasi penyuapan aktual.</td>
                                        <td>Potensi ketidaksesuaian minor terhadap prosedur SMAP. Tidak berdampak hukum.</td>
                                        <td>Gangguan kecil dan terbatas pada sebagian proses.</td>
                                        <td>Dampak finansial sangat kecil.</td>
                                        <td>Teguran internal. Tidak memerlukan tindakan korektif besar.</td>
                                    </tr>
                                    {{-- Baris 3 --}}
                                    <tr>
                                        <td class="fw-semibold text-center align-middle" >
                                            3 – Sedang (Menengah)
                                        </td>
                                        <td>Dampak cukup berarti terhadap efektivitas SMAP. Berpotensi menurunkan kepercayaan internal.</td>
                                        <td>Ketidaksesuaian terhadap kebijakan atau prosedur SMAP. Berpotensi menimbulkan temuan audit atau komplain.</td>
                                        <td>Keterlambatan produksi. Gangguan operasional pada 1 unit/proses utama.</td>
                                        <td>Dampak finansial moderat.</td>
                                        <td>Memerlukan tindakan korektif terstruktur dan perhatian FKAP.</td>
                                    </tr>
                                    {{-- Baris 4 --}}
                                    <tr>
                                        <td class="fw-semibold text-center align-middle" >
                                            4 – Signifikan (Tinggi)
                                        </td>
                                        <td>Dampak besar terhadap efektivitas SMAP. Kegagalan pengendalian yang mengarah pada praktik penyuapan. Reputasi perusahaan menurun</td>
                                        <td>Potensi pelanggaran hukum atau regulasi, peraturan perusahaan, VALUE perusahaan, code of conduct</td>
                                        <td>Gangguan operasional signifikan, berdampak pada lebih dari 1 unit bisnis.</td>
                                        <td>Dampak finansial besar, denda</td>
                                        <td>Membutuhkan tindakan korektif segera dan pengawasan FKAP.</td>
                                    </tr>
                                    {{-- Baris 5 --}}
                                    <tr>
                                        <td class="fw-semibold text-center align-middle" >
                                            5 – Sangat Signifikan (Sangat Tinggi)
                                        </td>
                                        <td>Dampak sangat besar dan kritikal terhadap SMAP.Terjadi atau sangat mungkin terjadi praktik penyuapan aktual, sanksi daftar hitam pada instansi pemerintah / swasta yang berdampak ke kredibilitas perusahaan. Reputasi perusahaan rusak secara nasional / internasional.</td>
                                        <td>Pelanggaran hukum serius (pidana/perdata). Risiko pencabutan izin & denda besar. Direksi / Manajemen Puncak terancam pidana.</td>
                                        <td>Kegagalan operasional besar.Proses bisnis terganggu luas.Operasional pabrik dihentikan oleh regulator. Kehilangan kontrak utama dengan pelanggan global.Gangguan rantai pasok.</td>
                                        <td>Kerugian finansial material.</td>
                                        <td>Mengancam keberlangsungan organisasi atau sertifikasi ISO 37001.Menunjukan lemahnya komitmen Manajemen.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- ===== END MODAL TABEL KRITERIA ===== --}}

        {{-- ===== MODAL DETAIL RISIKO ===== --}}
            <div class="modal fade" id="modalDetailRisiko" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="bi bi-exclamation-triangle me-2"></i> Detail Risiko
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-0">
                            <table class="table table-bordered mb-0 align-middle">
                                <tbody>
                                    <tr>
                                        <td class="bg-light fw-semibold text-muted" style="width:35%">Nama Risiko</td>
                                        <td id="modal-nama-risiko">-</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light fw-semibold text-muted">Kriteria</td>
                                        <td id="modal-kriteria">-</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light ">S</td>
                                        <td>
                                            <span class=" me-2" id="modal-severity">-</span>
                                            <span id="modal-desc-severity" style="font-size:13px">-</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bg-light">P</td>
                                        <td>
                                            <span class="me-2" id="modal-probability">-</span>
                                            <span id="modal-desc-probability" style="font-size:13px">-</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ===== END MODAL DETAIL RISIKO ===== --}}

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('modalDetailRisiko').addEventListener('show.bs.modal', function (event) {
                    const trigger = event.relatedTarget;
                    document.getElementById('modal-nama-risiko').textContent     = trigger.getAttribute('data-risiko')           || '-';
                    document.getElementById('modal-kriteria').textContent         = trigger.getAttribute('data-kriteria')          || '-';
                    document.getElementById('modal-severity').textContent         = trigger.getAttribute('data-severity')          || '-';
                    document.getElementById('modal-probability').textContent      = trigger.getAttribute('data-probability')       || '-';
                    document.getElementById('modal-desc-severity').textContent    = trigger.getAttribute('data-desc-severity')     || '-';
                    document.getElementById('modal-desc-probability').textContent = trigger.getAttribute('data-desc-probability')  || '-';
                });
            });
        </script>

    @endsection