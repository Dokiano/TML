@extends('layouts.main')

@section('content')
@php $role = auth()->user()->role ?? null; 

$dokumen = $dokumen ?? collect();   // fallback
$userMap = $userMap ?? collect();   // fallback

@endphp

@if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if (session('danger'))  <div class="alert alert-danger">{{ session('danger') }}</div>  @endif

<style>
  /* =====================
     MODERN TABLE DESIGN
  ===================== */
  :root {
    --tbl-header-bg: #eef2f8;
    --tbl-header-text: #1e3a5f;
    --tbl-header-border: #c8d8ec;
    --tbl-row-odd: #ffffff;
    --tbl-row-even: #f8fafc;
    --tbl-row-hover: #eff6ff;
    --tbl-border: #e2e8f0;
    --tbl-text: #334155;
    --tbl-muted: #94a3b8;
    --tbl-accent: #3b82f6;
    --tbl-radius: 12px;
    --shadow: 0 4px 24px rgba(0,0,0,0.08);
  }

  /* Container */
  .tbl-wrapper {
    border-radius: var(--tbl-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    border: 1px solid var(--tbl-border);
  }

  .table-scroll {
    max-height: 72vh;
    overflow-y: auto;
    overflow-x: auto;
  }

  /* Table base */
  #mainTable {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13.5px;
    color: var(--tbl-text);
    width: max-content;
    min-width: 100%;
    transition: transform 0.2s ease;
    transform-origin: top left;
  }

  /* ── STICKY FROZEN HEADER ── */
  #mainTable thead {
    position: sticky;
    top: 0;
    z-index: 10;
  }

  #mainTable thead tr th {
    background: var(--tbl-header-bg);
    color: var(--tbl-header-text);
    font-weight: 700;
    font-size: 12.5px;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    padding: 13px 10px;
    border-right: 1px solid var(--tbl-header-border);
    border-bottom: 2px solid var(--tbl-accent);
    white-space: nowrap;
    vertical-align: middle;
    text-align: center;
  }

  #mainTable thead tr th:last-child {
    border-right: none;
  }

  /* Stripe rows */
  #mainTable tbody tr:nth-child(odd)  td { background: var(--tbl-row-odd); }
  #mainTable tbody tr:nth-child(even) td { background: var(--tbl-row-even); }

  #mainTable tbody tr:hover td {
    background: var(--tbl-row-hover) !important;
    transition: background 0.15s ease;
  }

  /* Cells */
  #mainTable tbody td {
    padding: 9px 10px;
    border-right: 1px solid var(--tbl-border);
    border-bottom: 1px solid var(--tbl-border);
    vertical-align: middle;
  }

  #mainTable tbody td:last-child {
    border-right: none;
  }

  /* ── KOLOM WIDTH ── */
  #mainTable th:nth-child(1),
  #mainTable td:nth-child(1)  { min-width: 75px;  max-width: 85px; }
  #mainTable th:nth-child(2),
  #mainTable td:nth-child(2)  { min-width: 110px; }
  #mainTable th:nth-child(3),
  #mainTable td:nth-child(3)  { min-width: 55px;  max-width: 65px; }
  #mainTable th:nth-child(4),
  #mainTable td:nth-child(4)  { min-width: 160px; max-width: 180px; }
  #mainTable th:nth-child(5),
  #mainTable td:nth-child(5)  { min-width: 180px; max-width: 200px; }
  #mainTable th:nth-child(6),
  #mainTable td:nth-child(6)  { min-width: 160px; max-width: 180px; }
  #mainTable th:nth-child(7),
  #mainTable td:nth-child(7)  { min-width: 180px; max-width: 210px; }
  #mainTable th:nth-child(8),
  #mainTable td:nth-child(8)  { min-width: 75px;  max-width: 85px; }
  #mainTable th:nth-child(9),
  #mainTable td:nth-child(9)  { min-width: 260px; max-width: 280px; }
  #mainTable th:nth-child(10),
  #mainTable td:nth-child(10) { min-width: 100px; max-width: 115px; }
  #mainTable th:nth-child(11),
  #mainTable td:nth-child(11),
  #mainTable th:nth-child(12),
  #mainTable td:nth-child(12) { min-width: 150px;  max-width: 150px; }
  #mainTable th:nth-child(13),
  #mainTable td:nth-child(13) { min-width: 90px;  max-width: 100px; }
  #mainTable th:nth-child(14),
  #mainTable td:nth-child(14) { min-width: 80px;  max-width: 90px; }
  #mainTable th:nth-child(15),
  #mainTable td:nth-child(15) { min-width: 140px; max-width: 155px; }
  #mainTable th:nth-child(16),
  #mainTable td:nth-child(16) { min-width: 100px; max-width: 115px; }

  /* Images in approval columns */
  #mainTable td:nth-child(11) img,
  #mainTable td:nth-child(12) img {
    max-height: 52px;
    max-width: 90px;
    object-fit: contain;
    display: block;
    margin: 0 auto;
    border-radius: 4px;
  }

  /* Cell text overflow */
  #mainTable td:nth-child(4),
  #mainTable td:nth-child(5),
  #mainTable td:nth-child(6),
  #mainTable td:nth-child(7) {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 200px;
  }

  /* No. DR badge style */
  .dr-badge {
    display: inline-block;
    background: #dbeafe;
    color: #1d4ed8;
    border-radius: 6px;
    padding: 2px 8px;
    font-weight: 700;
    font-size: 11px;
    letter-spacing: 0.3px;
  }

  /* Reviewer chip wrapper */
  .reviewer-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    max-width: 260px;
    justify-content: flex-start;
  }

  /* Reviewer chip */
  .reviewer-chip {
    display: inline-flex;
    align-items: center;
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    color: #475569;
    border-radius: 20px;
    padding: 2px 8px;
    font-size: 11px;
    white-space: nowrap;
  }

  /* ── ZOOM FIT MODE ── */
  .is-fit-active-parent { overflow-x: hidden !important; }

  .zoom-fit-active {
    width: 100% !important;
    table-layout: fixed !important;
    transform: none !important;
    white-space: normal !important;
  }

  .zoom-fit-active th,
  .zoom-fit-active td {
    padding: 3px 2px !important;
    font-size: 9px !important;
    word-break: break-word !important;
    white-space: normal !important;
    vertical-align: middle !important;
  }

  .zoom-fit-active td:nth-child(1),
  .zoom-fit-active th:nth-child(1)  { width: 55px !important; }
  .zoom-fit-active td:nth-child(3),
  .zoom-fit-active th:nth-child(3)  { width: 35px !important; }
  .zoom-fit-active td:nth-child(8),
  .zoom-fit-active th:nth-child(8)  { width: 60px !important; }
  .zoom-fit-active td:nth-child(13),
  .zoom-fit-active th:nth-child(13) { width: 80px !important; }
  .zoom-fit-active td:nth-child(14),
  .zoom-fit-active th:nth-child(14) { width: 55px !important; }
  .zoom-fit-active td:nth-child(15),
  .zoom-fit-active th:nth-child(15) { width: 100px !important; }
  .zoom-fit-active td:nth-child(11),
  .zoom-fit-active th:nth-child(11),
  .zoom-fit-active td:nth-child(12),
  .zoom-fit-active th:nth-child(12) { width: 100px !important; }

  .zoom-fit-active td:nth-child(11) img,
  .zoom-fit-active td:nth-child(12) img {
    max-height: 40px !important;
    max-width: 60px !important;
  }

  .zoom-fit-active .btn-sm {
    padding: 1px 3px !important;
    font-size: 8px !important;
  }

  /* ── STATUS TOGGLE ── */
  .status-toggle .form-check-input { margin-top: .15rem; }
  .status-toggle .form-check-label { font-size: .9rem; }

  /* ── ZOOM CONTROLS TOOLBAR ── */
  .zoom-toolbar {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: #f8fafc;
    border-top: 1px solid var(--tbl-border);
    border-radius: 0 0 var(--tbl-radius) var(--tbl-radius);
  }

  .zoom-toolbar .zoom-label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    min-width: 48px;
    text-align: center;
  }

  /* ── MODAL ── */
  .preview-section, .edit-section {
    transition: opacity 0.2s ease;
  }

  .modal-mode-badge {
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 20px;
    margin-left: 8px;
    vertical-align: middle;
  }

  .edit-section .form-control:not([readonly]) {
    border-color: #0d6efd;
    background-color: #f0f6ff !important;
  }

  .reviewer-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
  }

  /* Empty state */
  .empty-state td {
    padding: 40px !important;
  }
</style>

<div class="card text-center shadow-sm border-0 rounded-lg mb-3">
  <div class="card-body py-0">
    <h1 class="card-title" style="font-size:20px;font-weight:700;letter-spacing:1px;">
      ALL DOKUMEN REVIEW
    </h1>
  </div>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <br>

         <div class="tbl-wrapper">
           <div class="table-scroll" id="tableScrollContainer">
           <table class="table align-middle table-fit" id="mainTable">
              <thead>
                <tr class="text-center">
                  <th><i class="bx bx-hash me-1"></i>No. DR</th>
                  <th><i class="bx bx-file-blank me-1"></i>No. Dokumen</th>
                  <th>RV</th>
                  <th>Ket. Revisi</th>
                  <th>Alasan Revisi</th>
                  <th><i class="bx bx-user me-1"></i>Pembuat</th>
                  <th><i class="bx bx-folder me-1"></i>Nama Dokumen</th>
                  <th><i class="bx bx-file-find me-1"></i>File</th>
                  <th><i class="bx bx-group me-1"></i>Reviewer</th>
                  <th>Dokumen Final</th>
                  <th><i class="bx bx-check-shield me-1"></i>Approval</th>
                  <th><i class="bx bx-shield me-1"></i>Mendukung</th>
                  <th><i class="bx bx-calendar me-1"></i>Dibuat</th>
                  <th>Form Dr</th>
                  <th><i class="bx bx-file-blank me-1"></i>File Final DR</th>
                  <th><i class="bx bx-cog me-1"></i>Aksi</th>
                </tr>
              </thead>
              <tbody>
              @forelse($dokumen as $d)
                @php
                  $hasPdf = !empty($d->pdf_path ?? null);
                  $pembuatNama = optional($d->pembuat2)->nama_user
                              ?? optional($d->pembuat2)->name_user
                              ?? optional($d->pembuat2)->name
                              ?? ('User#'.($d->pembuat2_id ?? '-'));
                  $divisiNama  = optional($d->divisi)->nama_divisi ?? '-';
                  $reviewers = collect($d->reviewer_ids ?? [])->filter();
                  $isAdmin   = (auth()->user()->role ?? null) === 'admin';
                  $hasFinalDr = !empty($d->file_final_dr);
                @endphp
                <tr>
                  <td class="text-center">
                    <span class="dr-badge">{{ $d->dr_no ?? '-' }}</span>
                  </td>
                  <td class="text-center">{{ $d->no_dokumen ?? $d->nomor_dokumen ?? '-' }}</td>
                  <td class="text-center">{{ $d->no_revisi ?? $d->nomor_revisi ?? '-' }}</td>
                  <td class="text-center">{{ $d->keterangan ?? '-' }}</td>
                  <td><small class="text-muted">{{ $d->alasan_revisi ?? '-' }}</small></td>
                  <td>
                    {{ $pembuatNama }}<br>
                    <small class="text-muted">{{ $divisiNama }}</small>
                  </td>
                  <td>
                    <span class="badge bg-secondary">{{ $d->nama_jenis ?? $d->jenis_dokumen ?? '-' }}</span>
                    {{ $d->nama_dokumen ?? '-' }}
                  </td>
                  <td class="text-center">
                    <a href="{{ route('dokumenReview.annotate', $d->id) }}" class="btn btn-sm btn-outline-primary">
                      Review
                    </a>
                  </td>
                  <td>
                    <div class="reviewer-chips">
                    @forelse($reviewers as $rid)
                      <span class="reviewer-chip">{{ $userMap[$rid] ?? ('User#'.$rid) }}</span>
                    @empty
                      <span class="text-muted">-</span>
                    @endforelse
                    </div>
                  </td>

                  {{-- Dokumen Final (DokumenFile — riwayat multi-file) --}}
                  <td class="text-center">
                     <div class="d-flex flex-column align-items-center gap-1">
                       <button class="btn btn-sm btn-outline-primary"
                               data-bs-toggle="modal"
                               data-bs-target="#hist{{ $d->id }}">
                         Lihat
                       </button>
                     </div>
                 
                    {{-- Modal UNGGAH (per dokumen) --}}
                    <div class="modal fade" id="upFinal{{ $d->id }}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <form class="modal-content"
                              action="{{ route('dokumenFiles.store', $d->id) }}"
                              method="post" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-header">
                            <h6 class="modal-title">Unggah Final/Revisi – {{ $d->nama_dokumen }}</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            <div class="mb-2">
                              <label class="form-label">Tipe</label>
                              <select name="type" class="form-select form-select-sm" required>
                                <option value="final">Final</option>
                              </select>
                            </div>
                            <div class="mb-2">
                              <label class="form-label">File (PDF)</label>
                              <input type="file" name="file" class="form-control form-control-sm"
                                     accept="application/pdf,.pdf" required>
                              <small class="text-muted">Wajib PDF, maks 20MB</small>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-sm btn-outline-primary">Unggah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  
                    {{-- Modal RIWAYAT (per dokumen) --}}
                    <div class="modal fade"
                         id="hist{{ $d->id }}"
                         tabindex="-1" aria-hidden="true"
                         data-url="{{ route('dokumenFiles.index', $d->id) }}">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h6 class="modal-title">Riwayat Final/Revisi – {{ $d->nama_dokumen }}</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            <div class="table-responsive">
                              <table class="table table-sm table-hover align-middle m-0">
                                <thead>
                                  <tr>
                                    <th>Tipe</th>
                                    <th>Nama File</th>
                                    <th>MB</th>
                                    <th>Pengunggah</th>
                                    <th>Tanggal</th>
                                    <th>catatan</th>
                                    <th class="text-center">Aksi</th>
                                  </tr>
                                </thead>
                                <tbody id="histBody-{{ $d->id }}">
                                  <tr><td colspan="7" class="text-center text-muted">Memuat...</td></tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-sm btn-outline-primary"
                                  data-bs-toggle="modal"
                                  data-bs-target="#upFinal{{ $d->id }}">
                            Unggah
                          </button>
                            <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>

                  {{-- Approval --}}
                  <td class="text-center">
                    @php
                      $user   = auth()->user();
                      $uid    = $user?->id ?? 0;
                      $canEditStatus = $isAdmin || $uid === ($d->pembuat_id ?? 0);

                      $approvals         = $d->approvals ?? collect();
                      $mainApprovals     = $approvals->where('kind','main');
                      $supportApprovals  = $approvals->where('kind','support');
                    @endphp

                    @php
                      $hasMain = ($d->approvals ?? collect())->where('kind','main')->isNotEmpty();
                    @endphp

                    @if($hasMain)
                      <div class="mt-2">
                        <img src="{{ asset('img/approved.png') }}"
                             alt="Approved"
                             class="img-thumbnail"
                             style="max-height:80px;max-width:120px;object-fit:contain;width:auto;height:auto;">
                      </div>
                    @else
                      <div class="text-muted small ">Belum ada approval</div>
                    @endif
                                          
                  {{-- Mendukung --}}
                  <td class="text-center">
                   @php
                      $hasMain = ($d->approvals ?? collect())->where('kind','support')->isNotEmpty();
                    @endphp

                    @if($hasMain)
                      <div class="mt-2">
                        <img src="{{ asset('img/supported-stamp.png') }}"
                             alt="Approved"
                             class="img-thumbnail"
                             style="max-height:80px;max-width:120px;object-fit:contain;width:auto;height:auto;">
                      </div>
                    @else
                      <div class="text-muted small ">Belum ada approval dukungan</div>
                    @endif
                    
                  {{-- Tanggal dibuat --}}
                  <td class="text-center">{{ optional($d->created_at)->format('d/m/Y') ?? '-' }}</td>

                  {{-- Draft --}}
                  <td class="text-center">
                    <a href="{{ route('dokumenReview.draftDetail', $d) }}" class="btn btn-sm btn-outline-primary" title="Detail dokumen">
                      Detail
                    </a>
                  </td>

                  {{-- File Final DR (kolom baru) --}}
                  <td class="text-center">
                    {{-- Preview jika file sudah ada --}}
                    @if($hasFinalDr)
                      <a href="{{ route('dokumenReview.streamFileFinal', $d->id) }}"
                         target="_blank"
                         class="btn btn-sm btn-outline-success mb-1">
                        <i class="bx bx-show me-1"></i>Lihat
                      </a>
                    
                    @endif

                    {{-- Tombol upload/ganti & hapus: hanya admin --}}
                    @if($isAdmin)
                      <button class="btn btn-sm btn-outline-primary"
                              data-bs-toggle="modal"
                              data-bs-target="#upFileFinalDr{{ $d->id }}">
                        <i class="bx bx-upload me-1"></i>{{ $hasFinalDr ? 'Ganti' : 'Upload' }}
                      </button>

                      @if($hasFinalDr)
                        <form action="{{ route('dokumenReview.destroyFileFinal', $d->id) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus File Final DR ini?')"
                              class="mt-1">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bx bx-trash me-1"></i>Hapus
                          </button>
                        </form>
                      @endif

                      {{-- Modal Upload File Final DR --}}
                      <div class="modal fade" id="upFileFinalDr{{ $d->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                          <form class="modal-content"
                                action="{{ route('dokumenReview.uploadFileFinal', $d->id) }}"
                                method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                              <h6 class="modal-title">
                                <i class="bx bx-file-blank me-1 text-primary"></i>
                                File Final DR – {{ $d->nama_dokumen }}
                              </h6>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              @if($hasFinalDr)
                                <div class="alert alert-warning py-2 small mb-3">
                                  <i class="bx bx-info-circle me-1"></i>
                                  Sudah ada file. Upload baru akan <strong>menggantikan</strong> file lama.
                                </div>
                              @endif
                              <div class="mb-2">
                                <label class="form-label">Tipe</label>
                                <select class="form-select form-select-sm" disabled>
                                  <option>Final</option>
                                </select>
                              </div>
                              <div class="mb-2">
                                <label class="form-label">File (PDF)</label>
                                <input type="file"
                                       name="file_final_dr"
                                       class="form-control form-control-sm"
                                       accept="application/pdf,.pdf"
                                       required>
                                <small class="text-muted">Wajib PDF, maks 20MB</small>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                              <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bx bx-upload me-1"></i>Unggah
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    @endif
                  </td>

                  {{-- Aksi --}}
                  <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            style="font-size: 12px;">
                            <i class="bx bx-cog"></i> Action
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('dokumenReview.edit', $d->id) }}"
                                   class="dropdown-item" style="font-size: 12px;">
                                    <i class="bx bx-edit text-success"></i> Edit Dokumen
                                </a>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item" style="font-size: 12px;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#previewModal{{ $d->id }}">
                                    <i class="bx bx-show text-info"></i> Preview
                                </button>
                            </li>
                            <form action="#" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item" style="font-size: 12px;">
                                    <i class="ri ri-delete-bin-fill text-danger"></i> Hapus
                                </button>
                            </form>
                            <li></li>
                        </ul>
                    </div>
                  </td>

                  {{-- ===== MODAL PREVIEW + EDIT ===== --}}
                  <div class="modal fade" id="previewModal{{ $d->id }}" tabindex="-1"
                       aria-labelledby="previewModalLabel{{ $d->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-scrollable">
                          <div class="modal-content">

                              {{-- Header --}}
                              <div class="modal-header bg-dark text-white">
                                  <h5 class="modal-title" id="previewModalLabel{{ $d->id }}">
                                      <i class="bx bx-file me-1"></i> 
                                      Preview Dokumen — No. DR: {{ $d->dr_no ?? '-' }}
                                      <span class="modal-mode-badge bg-secondary" id="modeBadge{{ $d->id }}">
                                          Preview
                                      </span>
                                  </h5>
                                  <button type="button" class="btn-close btn-close-white"
                                          data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                              {{-- Body --}}
                              <div class="modal-body" style="font-size: 13px;">

                                  {{-- ======== PREVIEW SECTION (readonly) ======== --}}
                                  <div class="preview-section" id="previewSection{{ $d->id }}">

                                      {{-- No. DR --}}
                                      <div class="mb-3">
                                          <label class="form-label fw-bold">No. DR</label>
                                          <input type="text" class="form-control bg-light" readonly
                                                 value="{{ $d->dr_no ?? '-' }}">
                                      </div>

                                      {{-- No. Dokumen & No. Revisi --}}
                                      <div class="row mb-3">
                                          <div class="col-md-8">
                                              <label class="form-label fw-bold">No. Dokumen</label>
                                              <input type="text" class="form-control bg-light" readonly
                                                     value="{{ $d->nomor_dokumen ?? $d->no_dokumen ?? '-' }}">
                                          </div>
                                          <div class="col-md-4">
                                              <label class="form-label fw-bold">No. Revisi (RV)</label>
                                              <input type="text" class="form-control bg-light" readonly
                                                     value="{{ $d->no_revisi ?? '-' }}">
                                          </div>
                                      </div>

                                      {{-- Keterangan --}}
                                      <div class="mb-3">
                                          <label class="form-label fw-bold">Keterangan</label>
                                          <input type="text" class="form-control bg-light" readonly
                                                 value="{{ $d->keterangan ?? '-' }}">
                                      </div>

                                      {{-- Alasan Revisi --}}
                                      <div class="mb-3">
                                          <label class="form-label fw-bold">Alasan Revisi</label>
                                          <textarea class="form-control bg-light" rows="3" readonly>{{ $d->alasan_revisi ?? '-' }}</textarea>
                                      </div>

                                      {{-- Pembuat & Divisi --}}
                                      <div class="row mb-3">
                                          <div class="col-md-6">
                                              <label class="form-label fw-bold">Pembuat Dokumen</label>
                                              <input type="text" class="form-control bg-light" readonly
                                                     value="{{ optional($d->pembuat2)->nama_user ?? optional($d->pembuat2)->name ?? '-' }}">
                                          </div>
                                          <div class="col-md-6">
                                              <label class="form-label fw-bold">Divisi</label>
                                              <input type="text" class="form-control bg-light" readonly
                                                     value="{{ optional($d->divisi)->nama_divisi ?? '-' }}">
                                          </div>
                                      </div>

                                      {{-- Jenis & Nama Dokumen --}}
                                      <div class="row mb-3">
                                          <div class="col-md-4">
                                              <label class="form-label fw-bold">Jenis Dokumen</label>
                                              <input type="text" class="form-control bg-light" readonly
                                                     value="{{ $d->nama_jenis ?? $d->jenis_dokumen ?? '-' }}">
                                          </div>
                                          <div class="col-md-8">
                                              <label class="form-label fw-bold">Nama Dokumen</label>
                                              <input type="text" class="form-control bg-light" readonly
                                                     value="{{ $d->nama_dokumen ?? '-' }}">
                                          </div>
                                      </div>

                                      {{-- File Draft --}}
                                      <div class="mb-3">
                                          <label class="form-label fw-bold">File Draft</label>
                                          <div class="d-flex align-items-center gap-2">
                                              @if(!empty($d->draft_path))
                                                  <i class="bx bxs-file-pdf text-danger" style="font-size:20px;"></i>
                                                  <span class="text-muted">{{ basename($d->draft_path) }}</span>
                                                  <a href="{{ route('dokumenReview.pdf', $d->id) }}"
                                                     target="_blank" class="btn btn-sm btn-outline-primary">
                                                      <i class="bx bx-show me-1"></i> Lihat
                                                  </a>
                                              @else
                                                  <span class="text-muted">Belum ada file draft</span>
                                              @endif
                                          </div>
                                      </div>

                                      {{-- Reviewer --}}
                                      <div class="mb-3">
                                          <label class="form-label fw-bold">Reviewer</label>
                                          <div class="form-control bg-light" style="min-height:40px;">
                                              @php $reviewerIds = collect($d->reviewer_ids ?? [])->filter(); @endphp
                                              @forelse($reviewerIds as $rid)
                                                  <span class="badge bg-secondary me-1 mb-1">
                                                      {{ $userMap[$rid] ?? ('User#' . $rid) }}
                                                  </span>
                                              @empty
                                                  <span class="text-muted">-</span>
                                              @endforelse
                                          </div>
                                      </div>

                                      {{-- Status Approval --}}
                                      <div class="row mb-3">
                                          <div class="col-md-6">
                                              <label class="form-label fw-bold">Approval</label>
                                              <div class="form-control bg-light" style="min-height:40px;">
                                                  @php $hasMain = ($d->approvals ?? collect())->where('kind','main')->isNotEmpty(); @endphp
                                                  @if($hasMain)
                                                      <span class="badge bg-success">
                                                          <i class="bx bx-check me-1"></i> Sudah Approval
                                                      </span>
                                                  @else
                                                      <span class="text-muted">Belum ada approval</span>
                                                  @endif
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <label class="form-label fw-bold">Mendukung</label>
                                              <div class="form-control bg-light" style="min-height:40px;">
                                                  @php $hasSupport = ($d->approvals ?? collect())->where('kind','support')->isNotEmpty(); @endphp
                                                  @if($hasSupport)
                                                      <span class="badge bg-success">
                                                          <i class="bx bx-check me-1"></i> Sudah Mendukung
                                                      </span>
                                                  @else
                                                      <span class="text-muted">Belum ada approval dukungan</span>
                                                  @endif
                                              </div>
                                          </div>
                                      </div>

                                      {{-- Tanggal Dibuat --}}
                                      <div class="mb-3">
                                          <label class="form-label fw-bold">Tanggal Dibuat</label>
                                          <input type="text" class="form-control bg-light" readonly
                                                 value="{{ optional($d->created_at)->format('d/m/Y') ?? '-' }}">
                                      </div>

                                  </div>{{-- end preview-section --}}


                                  {{-- ======== EDIT SECTION (form) ======== --}}
                                  <div class="edit-section d-none" id="editSection{{ $d->id }}">

                                      <form method="POST"
                                            action="{{ route('dokumenReview.update', $d->id) }}"
                                            enctype="multipart/form-data"
                                            id="editForm{{ $d->id }}">
                                          @csrf
                                          @method('PATCH')

                                          {{-- Info readonly: No. DR --}}
                                          <div class="mb-3">
                                              <label class="form-label fw-bold">No. DR</label>
                                              <input type="text" class="form-control bg-light" readonly
                                                     value="{{ $d->dr_no ?? '-' }}">
                                          </div>

                                          {{-- Pembuat Dokumen (EDITABLE) --}}
                                          <div class="mb-3">
                                              <label for="pembuat2_id_{{ $d->id }}" class="form-label fw-bold">
                                                  Pembuat Dokumen <span class="text-primary">(dapat diubah)</span>
                                              </label>
                                              <select id="pembuat2_id_{{ $d->id }}" name="pembuat2_id" class="form-control">
                                                  <option value="">-- Pilih Pembuat --</option>
                                                  @foreach($users ?? collect() as $u)
                                                      <option value="{{ $u->id }}"
                                                          {{ ($d->pembuat2_id == $u->id) ? 'selected' : '' }}>
                                                          {{ $u->nama_user ?? $u->name }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                          </div>

                                          {{-- Divisi (READONLY) --}}
                                          <div class="row mb-3">
                                              <div class="col-md-6">
                                                  <label class="form-label fw-bold">Divisi</label>
                                                  <input type="text" class="form-control bg-light" readonly
                                                         value="{{ optional($d->divisi)->nama_divisi ?? '-' }}">
                                              </div>
                                              <div class="col-md-6">
                                                  <label class="form-label fw-bold">Jabatan</label>
                                                  <input type="text" class="form-control bg-light" readonly
                                                         value="{{ strtoupper($d->jabatan ?? '-') }}">
                                              </div>
                                          </div>

                                          {{-- Jenis Dokumen (READONLY) --}}
                                          <div class="mb-3">
                                              <label class="form-label fw-bold">Jenis Dokumen</label>
                                              <input type="text" class="form-control bg-light" readonly
                                                     value="{{ $d->nama_jenis ?? $d->jenis_dokumen ?? '-' }}">
                                          </div>

                                          {{-- Nama Dokumen (EDITABLE) --}}
                                          <div class="mb-3">
                                              <label for="nama_dokumen_{{ $d->id }}" class="form-label fw-bold">
                                                  Nama Dokumen <span class="text-primary">(dapat diubah)</span>
                                              </label>
                                              <input id="nama_dokumen_{{ $d->id }}" name="nama_dokumen"
                                                     type="text" class="form-control"
                                                     value="{{ $d->nama_dokumen ?? '' }}"
                                                     placeholder="Nama dokumen...">
                                          </div>

                                          {{-- Nomor Dokumen & No Revisi (READONLY) --}}
                                          <div class="row mb-3">
                                              <div class="col-md-8">
                                                  <label class="form-label fw-bold">Nomor Dokumen</label>
                                                  <input type="text" class="form-control bg-light" readonly
                                                         value="{{ $d->nomor_dokumen ?? $d->no_dokumen ?? '-' }}">
                                              </div>
                                              <div class="col-md-4">
                                                  <label class="form-label fw-bold">No Revisi</label>
                                                  <input type="text" class="form-control bg-light" readonly
                                                         value="{{ $d->no_revisi ?? '-' }}">
                                              </div>
                                          </div>

                                          {{-- Keterangan (READONLY) --}}
                                          <div class="mb-3">
                                              <label class="form-label fw-bold">Keterangan</label>
                                              <input type="text" class="form-control bg-light" readonly
                                                     value="{{ $d->keterangan ?? '-' }}">
                                          </div>

                                          {{-- Alasan Revisi (EDITABLE) --}}
                                          <div class="mb-3">
                                              <label for="alasan_revisi_{{ $d->id }}" class="form-label fw-bold">
                                                  Alasan Revisi <span class="text-primary">(dapat diubah)</span>
                                              </label>
                                              <textarea id="alasan_revisi_{{ $d->id }}" name="alasan_revisi"
                                                        rows="3" class="form-control"
                                                        placeholder="Alasan revisi dokumen...">{{ $d->alasan_revisi ?? '' }}</textarea>
                                          </div>

                                          {{-- Reviewer (EDITABLE) --}}
                                          <div class="mb-3">
                                              <label class="form-label fw-bold">
                                                  Reviewer <span class="text-primary">(dapat diubah)</span>
                                              </label>
                                              <div id="reviewerContainer{{ $d->id }}">
                                                  @php
                                                      $existingReviewerIds = collect($d->reviewer_ids ?? [])->filter()->values();
                                                  @endphp

                                                  @forelse($existingReviewerIds as $i => $rid)
                                                      <div class="reviewer-row">
                                                          <span class="text-muted" style="min-width:90px;font-size:13px;">
                                                              Reviewer {{ $i + 1 }}
                                                          </span>
                                                          <select name="reviewer_ids[]" class="form-control">
                                                              <option value="">-- pilih reviewer --</option>
                                                              @foreach($reviewers_list ?? $users ?? collect() as $r)
                                                                  <option value="{{ $r->id }}"
                                                                      {{ $r->id == $rid ? 'selected' : '' }}>
                                                                      {{ $r->nama_user ?? $r->name }}
                                                                  </option>
                                                              @endforeach
                                                          </select>
                                                          <button type="button" class="btn btn-sm btn-danger remove-reviewer-modal">
                                                              Hapus
                                                          </button>
                                                      </div>
                                                  @empty
                                                      <div class="reviewer-row">
                                                          <span class="text-muted" style="min-width:90px;font-size:13px;">Reviewer 1</span>
                                                          <select name="reviewer_ids[]" class="form-control">
                                                              <option value="">-- pilih reviewer (opsional) --</option>
                                                              @foreach($reviewers_list ?? $users ?? collect() as $r)
                                                                  <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
                                                              @endforeach
                                                          </select>
                                                          <button type="button" class="btn btn-sm btn-danger remove-reviewer-modal">
                                                              Hapus
                                                          </button>
                                                      </div>
                                                  @endforelse
                                              </div>
                                              <button type="button"
                                                      class="btn btn-sm btn-primary mt-2 add-reviewer-modal"
                                                      data-target="reviewerContainer{{ $d->id }}"
                                                      data-id="{{ $d->id }}">
                                                  + Tambah Reviewer
                                              </button>
                                              <small class="d-block text-muted mt-1">
                                                  Duplikat reviewer akan diabaikan saat simpan.
                                              </small>
                                          </div>

                                          {{-- Ganti File Draft (EDITABLE) --}}
                                          <div class="mb-3">
                                              <label class="form-label fw-bold">
                                                  Ganti File Draft <span class="text-primary">(dapat diubah)</span>
                                              </label>
                                              @if(!empty($d->draft_path))
                                                  <div class="mb-2 d-flex align-items-center gap-2">
                                                      <i class="bx bxs-file-pdf text-danger" style="font-size:18px;"></i>
                                                      <span class="text-muted" style="font-size:13px;">
                                                          File saat ini: <strong>{{ basename($d->draft_path) }}</strong>
                                                      </span>
                                                      <a href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                                                          <i class="bx bx-show me-1"></i> Lihat
                                                      </a>
                                                  </div>
                                              @else
                                                  <p class="text-muted mb-2" style="font-size:13px;">Belum ada file draft.</p>
                                              @endif
                                              <input type="file" name="draft_dokumen"
                                                     class="form-control" accept=".pdf">
                                              <small class="text-muted">
                                                  Format: .pdf, maks 20MB. Kosongkan jika tidak ingin mengganti.
                                              </small>
                                          </div>

                                      </form>{{-- end form --}}

                                  </div>{{-- end edit-section --}}

                              </div>{{-- end modal-body --}}

                              {{-- Footer --}}
                              <div class="modal-footer" id="modalFooter{{ $d->id }}">

                                  {{-- Footer MODE PREVIEW --}}
                                  <div id="footerPreview{{ $d->id }}" class="d-flex w-100 justify-content-between align-items-center gap-2">
                                      <a href="{{ route('dokumenReview.draftDetail', $d) }}"
                                         class="btn btn-info btn-sm">
                                          <i class="bx bx-file me-1"></i> Lihat Detail Lengkap
                                      </a>
                                      <div class="d-flex gap-2">
                                          <button type="button"
                                                  class="btn btn-warning btn-sm btn-toggle-edit"
                                                  data-id="{{ $d->id }}">
                                              <i class="bx bx-edit me-1"></i> Edit
                                          </button>
                                          <button type="button" class="btn btn-secondary btn-sm"
                                                  data-bs-dismiss="modal">Tutup</button>
                                      </div>
                                  </div>

                                  {{-- Footer MODE EDIT --}}
                                  <div id="footerEdit{{ $d->id }}" class="d-flex w-100 justify-content-between align-items-center gap-2 d-none">
                                      <button type="button"
                                              class="btn btn-outline-secondary btn-sm btn-cancel-edit"
                                              data-id="{{ $d->id }}">
                                          <i class="bx bx-arrow-back me-1"></i> Kembali ke Preview
                                      </button>
                                      <div class="d-flex gap-2">
                                          <button type="button"
                                                  class="btn btn-warning btn-sm btn-submit-edit"
                                                  data-id="{{ $d->id }}">
                                              <i class="bx bx-save me-1"></i> Simpan Perubahan
                                          </button>
                                          <button type="button" class="btn btn-secondary btn-sm"
                                                  data-bs-dismiss="modal">Tutup</button>
                                      </div>
                                  </div>

                              </div>{{-- end modal-footer --}}

                          </div>
                      </div>
                  </div>
                  {{-- ===== END MODAL PREVIEW + EDIT ===== --}}

                </tr>

              @empty
                <tr class="empty-state">
                  <td colspan="16" class="text-center text-muted py-5">
                    <i class="bx bx-folder-open" style="font-size:40px;opacity:0.3;display:block;margin-bottom:8px;"></i>
                    Data dokumen tidak ditemukan.
                  </td>
                </tr>
              @endforelse
              </tbody>
             
            </table>
            <div class="zoom-toolbar">
                <button id="zoomOut" class="btn btn-sm btn-outline-secondary" title="Zoom Out">
                  <i class="ri-zoom-out-line"></i>
                </button>
                <input type="range" id="zoomSlider" min="50" max="150" value="100" hidden>
                <span class="zoom-label" id="zoomValue">100%</span>
                <button id="zoomIn" class="btn btn-sm btn-outline-secondary" title="Zoom In">
                  <i class="ri-zoom-in-line"></i>
                </button>
                <div style="width:1px;height:20px;background:#cbd5e1;margin:0 4px;"></div>
                <button id="zoomFitBtn" class="btn btn-sm btn-outline-primary">
                  <i class="bx bx-expand-alt me-1"></i> Fit
                </button>
            </div>
          </div>
          </div>


          @if(method_exists($dokumen, 'links'))
            {{ $dokumen->links() }}
          @endif

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@push('scripts')
<script>
(function(){
  // helper
  function esc(s){return (s||'').replace(/[&<>"']/g,m=>({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;' }[m]))}

  // Untuk setiap modal riwayat (punya data-url)
  document.querySelectorAll('.modal[data-url]').forEach(modal => {
    modal.addEventListener('show.bs.modal', () => {
      const url  = modal.getAttribute('data-url');
      const tbody = modal.querySelector('tbody[id^="histBody-"]');
      if (!url || !tbody) return;
      tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Memuat...</td></tr>`;
  
      fetch(url, { credentials: 'same-origin' })
        .then(r => r.json())
        .then(rows => {
          if (!rows || !rows.length) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted">Belum ada file final/revisi.</td></tr>`;
            return;
          }
          tbody.innerHTML = rows.map(r => {
            const sizeKB = Math.round((r.size || 0) / 1024);
            const tipe = r.type === 'final'
              ? '<span class="badge bg-info text-dark">FINAL</span>'
              : '<span class="badge bg-secondary">REVISI</span>';
            return `<tr id="row-${r.id}">
              <td>${tipe}</td>
              <td>${esc(r.original_name)}</td>
              <td>${sizeKB} KB</td>
              <td>${esc(r.uploaded_by || '-')}</td>
              <td>${esc(r.created_at || '-')}</td>
              <td>${esc(r.note || '')}</td>
              <td class="text-center">
                <a class="btn btn-sm btn-outline-primary" target="_blank" href="${r.viewer_url}">Lihat</a>
                <button class="btn btn-sm btn-danger btn-del" 
                        data-id="${r.id}" 
                        data-url="${r.destroy_url}">Hapus</button>
              </td>
            </tr>`;
          }).join('');
        })
        .catch(() => {
          tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Belum Kirim Dokumen Final.</td></tr>`;
        });
    });
  });
})();
</script>
<script>
  document.querySelectorAll('form.status-toggle input[type="checkbox"]').forEach(cb=>{
    cb.addEventListener('change', ()=> {
      cb.form.submit();
    });
  });
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
document.querySelectorAll('.modal[data-url]').forEach(modal=>{
  modal.addEventListener('click', async (e)=>{
    const btn = e.target.closest('.btn-del');
    if(!btn) return;

    if(!confirm('Yakin hapus file ini?')) return;

    const fd = new FormData();
    fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    fd.append('_method','DELETE');

    try{
      const res = await fetch(btn.dataset.url, {
        method: 'POST',
        headers: {'X-Requested-With':'XMLHttpRequest'},
        body: fd
      });
      if(!res.ok) throw new Error('HTTP '+res.status);
      const json = await res.json();
      if(json.ok){
        btn.closest('tr')?.remove();
      } else {
        alert('Gagal menghapus.');
      }
    }catch(err){
      alert('Terjadi kesalahan saat menghapus.');
    }
  });
});
</script>

<script>
(function(){
  document.querySelectorAll('form.status-toggle').forEach(function(form){
    let t=null;
    form.querySelectorAll('input.form-check-input[type="checkbox"]').forEach(function(cb){
      cb.addEventListener('change', function(){
        form.style.opacity = .6;
        clearTimeout(t);
        t = setTimeout(function(){
          form.submit();
        }, 250); 
      });
    });
  });
})();
</script>

{{-- ===== SCRIPT MODAL PREVIEW + EDIT ===== --}}
<script>
(function () {
  /**
   * Fungsi untuk reset modal ke mode Preview
   * dipanggil saat modal ditutup agar kembali ke state awal
   */
  function resetToPreview(id) {
    const previewSection  = document.getElementById('previewSection' + id);
    const editSection     = document.getElementById('editSection' + id);
    const footerPreview   = document.getElementById('footerPreview' + id);
    const footerEdit      = document.getElementById('footerEdit' + id);
    const badge           = document.getElementById('modeBadge' + id);

    if (!previewSection) return;

    previewSection.classList.remove('d-none');
    editSection.classList.add('d-none');
    footerPreview.classList.remove('d-none');
    footerEdit.classList.add('d-none');

    badge.textContent = 'Preview';
    badge.className   = 'modal-mode-badge bg-secondary';
  }

  /**
   * Fungsi untuk beralih ke mode Edit
   */
  function switchToEdit(id) {
    const previewSection  = document.getElementById('previewSection' + id);
    const editSection     = document.getElementById('editSection' + id);
    const footerPreview   = document.getElementById('footerPreview' + id);
    const footerEdit      = document.getElementById('footerEdit' + id);
    const badge           = document.getElementById('modeBadge' + id);

    previewSection.classList.add('d-none');
    editSection.classList.remove('d-none');
    footerPreview.classList.add('d-none');
    footerEdit.classList.remove('d-none');

    badge.textContent = 'Mode Edit';
    badge.className   = 'modal-mode-badge bg-warning text-dark';

    // Scroll ke atas modal body
    const modalBody = editSection.closest('.modal-body');
    if (modalBody) modalBody.scrollTop = 0;
  }

  // ---- Tombol "Edit" (masuk mode edit) ----
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-toggle-edit');
    if (!btn) return;
    const id = btn.dataset.id;
    switchToEdit(id);
  });

  // ---- Tombol "Kembali ke Preview" (batalkan edit) ----
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-cancel-edit');
    if (!btn) return;
    const id = btn.dataset.id;
    resetToPreview(id);
  });

  // ---- Tombol "Simpan Perubahan" (submit form) ----
  document.addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-submit-edit');
      if (!btn) return;
      const id   = btn.dataset.id;
      const form = document.getElementById('editForm' + id);
      if (!form) return;

      // Disable tombol agar tidak double-submit
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

      // Kumpulkan semua reviewer_ids[] yang terisi (tidak kosong)
      const container = document.getElementById('reviewerContainer' + id);
      let reviewerSelects = [];
      if (container) {
          reviewerSelects = container.querySelectorAll('select[name="reviewer_ids[]"]');
      } else {
          reviewerSelects = form.querySelectorAll('select[name="reviewer_ids[]"]');
      }

      const reviewerIds = [];
      reviewerSelects.forEach(function(select) {
          if (select.value && select.value !== '') {
              reviewerIds.push(select.value);
          }
      });

      console.log('reviewer_ids yang akan dikirim:', reviewerIds);

      // Disable semua select reviewer agar tidak ikut submit default
      reviewerSelects.forEach(s => s.disabled = true);

      // Hapus hidden input lama dulu kalau ada
      form.querySelectorAll('input[name="reviewer_ids[]"].hidden-reviewer').forEach(el => el.remove());

      reviewerIds.forEach(function(rid) {
          const hidden = document.createElement('input');
          hidden.type  = 'hidden';
          hidden.name  = 'reviewer_ids[]';
          hidden.value = rid;
          hidden.classList.add('hidden-reviewer');
          form.appendChild(hidden);
      });

      form.submit();
  });

  // ---- Reset ke Preview saat modal ditutup ----
  document.querySelectorAll('[id^="previewModal"]').forEach(function (modal) {
    modal.addEventListener('hidden.bs.modal', function () {
      const id = modal.id.replace('previewModal', '');
      resetToPreview(id);
    });
  });

  // ---- Tambah Reviewer di dalam modal edit ----
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.add-reviewer-modal');
    if (!btn) return;

    const containerId = btn.dataset.target;
    const docId       = btn.dataset.id;
    const container   = document.getElementById(containerId);
    if (!container) return;

    const count = container.querySelectorAll('.reviewer-row').length + 1;
    const div   = document.createElement('div');
    div.classList.add('reviewer-row');

    const existingSelect = container.querySelector('select');
    let optionsHtml = '<option value="">-- pilih reviewer (opsional) --</option>';
    if (existingSelect) {
      Array.from(existingSelect.options).forEach(function (opt) {
        if (opt.value) {
          optionsHtml += `<option value="${opt.value}">${opt.text}</option>`;
        }
      });
    }

    div.innerHTML = `
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="text-muted reviewer-num" style="min-width:90px;font-size:13px;">Reviewer ${count}</span>
        <select name="reviewer_ids[]" class="form-control" style="flex:1;">${optionsHtml}</select>
        <button type="button" class="btn btn-sm btn-danger remove-reviewer-modal">Hapus</button>
      </div>
    `;
    container.appendChild(div);
  });

  // ---- Hapus Reviewer di dalam modal edit ----
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.remove-reviewer-modal');
    if (!btn) return;

    const row       = btn.closest('.reviewer-row');
    const container = row?.parentElement;
    row?.remove();

    // Renumber
    if (container) {
      container.querySelectorAll('.reviewer-row').forEach(function (el, idx) {
        const label = el.querySelector('.reviewer-num');
        if (label) label.textContent = 'Reviewer ' + (idx + 1);
      });
    }
  });

})();
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('mainTable');
    const tableParent = document.getElementById('tableScrollContainer');
    const zoomValue = document.getElementById('zoomValue');
    const zoomFitBtn = document.getElementById('zoomFitBtn');
    const slider = document.getElementById('zoomSlider');

    let currentZoom = 100;

    function applyZoom(value) {
        currentZoom = parseInt(value);
        
        table.classList.remove('zoom-fit-active');
        tableParent.classList.remove('is-fit-active-parent');
        
        table.style.transform = `scale(${currentZoom / 100})`;
        table.style.width = "auto";
        
        zoomValue.innerText = currentZoom + "%";
        slider.value = currentZoom;
    }

    slider.addEventListener('input', (e) => applyZoom(e.target.value));
    document.getElementById('zoomIn').addEventListener('click', () => {
        if(currentZoom < 150) applyZoom(currentZoom + 5);
    });
    document.getElementById('zoomOut').addEventListener('click', () => {
        if(currentZoom > 50) applyZoom(currentZoom - 5);
    });

    zoomFitBtn.addEventListener('click', function () {
        const isCurrentlyFit = table.classList.contains('zoom-fit-active');

        if (!isCurrentlyFit) {
            table.classList.add('zoom-fit-active');
            tableParent.classList.add('is-fit-active-parent');
            table.style.transform = "none";
            table.style.width = "100%";
            zoomValue.innerText = "Fit";
            tableParent.scrollLeft = 0;
        } else {
            applyZoom(100);
        }
    });
});
</script>

@endpush