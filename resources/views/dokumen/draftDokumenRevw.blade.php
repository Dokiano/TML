@extends('layouts.main')

@section('content')
<style>
  .doc-box { border:2px solid #000; }
  .doc-box th, .doc-box td { border:1px solid #000; padding:.55rem .75rem; vertical-align:middle; }
  .section-title { font-weight:700; margin:1rem 0 .5rem; }
</style>
<style>
  .sig-wrap { 
    max-width: 520px; 
    margin: 0 auto; 
  }
  .sig-wrap .sigpad { 
    display: block; 
  }
</style>

<section class="section">
  <div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Form Dokumen Review</h5>
        
      <div class="d-flex gap-2 ms-auto">
        <a href="{{ route('dokumenReview.index') }}" class="btn btn-sm btn-secondary">
          Kembali
        </a>
        <a href="{{ route('dokumenReview.exportPdf', $dr->id) }}" class="btn btn-sm btn-outline-primary">
          Export PDF
        </a>
      </div>
    </div>
    
    {{-- I. Document Information --}}
    <div class="section-title mt-3">I. Document Information</div>
      @csrf
      @method('PUT')
    <table class="table table-sm doc-box w-100">
      <tr>
        <th style="width:25%">No. DR</th>
        <td>: {{ $meta['no_dr'] ?? '-' }}</td>
      </tr>
      <tr>
        <th>No. Dokumen</th>
        <td>:
          @php
            $noDokumen = $meta['no_dokumen'] ?? '-';
            $noRevisi = isset($meta['no_revisi']) ?  str_pad($meta['no_revisi'], 2, '0', STR_PAD_LEFT)  : '';
          @endphp
          {{ $noDokumen }}.{{ $noRevisi }}
        </td>
      </tr>
      <tr>
        <th>Judul Dokumen</th>
        <td>: {{ $meta['judul_dokumen'] ?? '-' }}</td>
      </tr>
      <tr>
        <th>Pembuat</th>
        <td>: {{ $meta['pembuat'] ?? '-' }}</td>
      </tr>
      <tr>
        <th>Tanggal Diedarkan</th>
        <td>: {{ $meta['tanggal_diedarkan'] ?? '-' }}</td>
      </tr>
        @php
          // Ambil approval main dan support
          $apprMainCheck = ($dr->approvals ?? collect())->where('kind', 'main')->first();
          $apprSuppCheck = ($dr->approvals ?? collect())->where('kind', 'support')->first();

          // Hitung tanggal kembali otomatis jika kedua approval ada
          $tanggalKembaliOtomatis = null;
          if ($apprMainCheck && $apprSuppCheck) {
            // Ambil tanggal yang lebih akhir dari kedua approval
            $tglMain = $apprMainCheck->signed_at ?? $apprMainCheck->updated_at ?? $apprMainCheck->created_at;
            $tglSupp = $apprSuppCheck->signed_at ?? $apprSuppCheck->updated_at ?? $apprSuppCheck->created_at;

            if ($tglMain && $tglSupp) {
              $tanggalKembaliOtomatis = max($tglMain, $tglSupp);
            }
          }

          $tanggalKembaliValue = $tanggalKembaliOtomatis 
            ? $tanggalKembaliOtomatis->format('Y-m-d')
            : ($dr->tanggal_kembali ?? \Carbon\Carbon::now()->format('Y-m-d'));
        @endphp
       <tr>
        <th>Tanggal Kembali</th>
        <td>: {{ $tanggalKembaliOtomatis ? $tanggalKembaliOtomatis->format('d/m/Y') : ($dr->tanggal_kembali ? \Carbon\Carbon::parse($dr->tanggal_kembali)->format('d/m/Y') : '-') }}</td>
      </tr> 
      <tr>
        <th>Alasan / Tujuan Pembuatan / Revisi</th>
        <td>: {!! $meta['keterangan'] ? nl2br(e($meta['keterangan'])) : '-' !!}</td >
      </tr>
    </table>
    
    {{-- II. List of Reviewer --}}
    <div class="section-title">II. List Of Reviewer</div>
    <table class="table table-sm doc-box w-100">
      <thead>
        <tr>
          <th style="width:50px;text-align:center">No</th>
          <th style="width:35%">Nama</th>
          <th style="width:25%;text-align:center">Tanda Tangan</th>
          <th style="width:20%;text-align:center">Tanggal</th>
          <th style="width:10%;text-align:center">Catatan (Ya/Tidak)</th>
        </tr>
      </thead>
      <tbody>
        @php
          
          $allIds = collect($dr->reviewer_ids ?? [])->filter()->values();

          $approverId = $allIds->count() ? $allIds->last() : null;

          $revIds = $allIds;

          $approvals = $dr->approvals ?? collect();
        @endphp

        @forelse($revIds as $i => $uid)
          @php
            $nama = $userMap[$uid] ?? ('User ID '.$uid);
              
            $apprRev = ($approvals ?? collect())->first(
              fn($a) => (int)($a->user_id ?? 0) === (int)$uid && ($a->kind ?? null) === 'reviewer'
            );
              
            $ttdUrl = $apprRev ? route('approvals.signature', $apprRev->id) : null;
            $tgl    = $apprRev ? optional($apprRev->signed_at ?? $apprRev->updated_at ?? $apprRev->created_at)->format('d/m/Y') : null;
            $yaTidak = $apprRev ? (($apprRev->action ?? null) === 'approved' ? 'Ya' : 'Tidak') : '';
          @endphp
        
          <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td>{{ $nama }}</td>
          
            <td class="text-center">
              @if($ttdUrl)
                <a href="{{ $ttdUrl }}" target="_blank">
                  <img src="{{ $ttdUrl }}" alt="TTD" class="img-thumbnail" style="max-height:80px;object-fit:contain">
                </a>
              @endif
              
              
                <div class="d-flex flex-column align-items-center gap-1 mt-2">
                  <button class="btn btn-sm {{ $ttdUrl ? 'btn-warning' : 'btn-success' }}"
                          data-bs-toggle="modal"
                          data-bs-target="#rev{{ $dr->id }}_u{{ $uid }}">
                    {{ $ttdUrl ? 'Edit' : 'Input' }}
                  </button>
                </div>
            </td>
          
            <td class="text-center">{{ $tgl ?: '—' }}</td>
            <td class="text-center">{{ $yaTidak ?: '—' }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted">Tidak ada reviewer.</td></tr>
        @endforelse

      </tbody>
    </table>

    <div class="row mb-3">
        <label for="tanggal_penyelesaian" class="col-sm-4 col-form-label">Tanggal Penyelesaian</label>
        <div class="col-sm-8">
            <input 
                type="date" 
                class="form-control bg-light" 
                id="tanggal_penyelesaian" 
                name="tanggal_penyelesaian" 
                value="{{ optional($dr->tanggal_penyelesaian)->format('Y-m-d') }}"
                readonly
            >
            <small class="text-muted">Tanggal otomatis terisi saat Admin mengunggah File Final Dokumen.</small>
        </div>
    </div>
  
    <div class="row mb-3">
        <label for="tanggal_diterima_dokumen_kontrol" class="col-sm-4 col-form-label">Tanggal Diterima Doc. Control</label>
        <div class="col-sm-8">
            <input 
                type="date" 
                class="form-control bg-light" 
                id="tanggal_diterima_dokumen_kontrol" 
                name="tanggal_diterima_dokumen_kontrol" 
                value="{{ optional($dr->tanggal_diterima_dokumen_kontrol)->format('Y-m-d') }}"
                readonly
            >
            <small class="text-muted">Tanggal otomatis terisi saat Dokumen Diterbitkan.</small>
        </div>
    </div>
    @php
        $apprMain = ($dr->approvals ?? collect())->where('kind', 'main')->first();
        $apprSupp = ($dr->approvals ?? collect())->where('kind', 'support')->first();

        $approverName   = $apprMain?->user?->nama_user;
        $approverSigUrl = $apprMain ? route('approvals.signature', $apprMain->id) : null;

        $supporterName  = $apprSupp?->user?->nama_user;
        $supportSigUrl  = $apprSupp ? route('approvals.signature', $apprSupp->id) : null;
    @endphp
      
    <table class="table table-sm doc-box w-100" style="max-width:520px;margin:24px auto 0;">
      <thead>
        <tr>
          <th class="text-center" style="width:50%;">Menyetujui</th>
          <th class="text-center" style="width:50%;">Didukung<br><small>(Sesuai Kebutuhan)</small></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center" style="height:110px;">
            @if($approverSigUrl)
              <img src="{{ $approverSigUrl }}" style="max-height:90px;object-fit:contain" alt="">
            @else
              <span class="text-muted">—</span>
            @endif
          </td>
          <td class="text-center" style="height:110px;">
            @if($supportSigUrl)
              <img src="{{ $supportSigUrl }}" style="max-height:90px;object-fit:contain" alt="">
            @else
              <span class="text-muted">—</span>
            @endif
          </td>
        </tr>
        <tr>
          <td class="text-center">
            <div class="fw-bold text-uppercase mb-2">{{ $approverName ?? '—' }}</div>
            @if(!$apprMain)
              <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#appr{{ $dr->id }}">
                Input
              </button>
            @endif
          </td>
          <td class="text-center">
            <div class="fw-bold text-uppercase mb-2">{{ $supporterName ?? '—' }}</div>
            @if(!$apprSupp)
              <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#supp{{ $dr->id }}">
                Input
              </button>
            @endif
          </td>
        </tr>
      </tbody>
    </table>

   {{-- === III. Catatan Reviewer & Status (SATU SECTION SAJA) === --}}
    @php
      // Urut berdasarkan reviewer_ids (reviewer 1, 2, 3 dst)
      $all = collect($dr->reviewer_ids ?? [])
        ->filter()
        ->map(fn($uid) => [
            'user_id'  => $uid,
            'comments' => collect($annotations)
                ->filter(fn($a) => (int)$a->user_id === (int)$uid && filled(data_get($a->data, 'comment')))
                ->sortBy('id')  // urut dari komentar pertama
                ->map(fn($a) => [
                    'comment' => data_get($a->data, 'comment'),
                    'status'  => $a->status ?? null,
                    'images'  => $a->images ?? collect(),
                ])
                ->values(),
        ])
        ->values();
      
      // Minimal 10 baris
      $rowsPerTable = max(10, $all->count());
    @endphp
      
    <div class="mt-3 mb-1 fw-bold">III. Catatan Reviewer & Status</div>
    <table class="tbl-catatan mb-3" style="width:100%; border-collapse:collapse;">
      <thead>
        <tr>
          <th style="width:50px; text-align:center; border:1px solid #000; padding:6px 8px;">No.</th>
          <th style="border:1px solid #000; padding:6px 8px; text-align:center;">Catatan</th>
          <th style="width:120px; text-align:center; border:1px solid #000; padding:6px 8px;">Status</th>
        </tr>
      </thead>
      <tbody>
        @for ($i = 0; $i < $rowsPerTable; $i++)
          @php $row = $all[$i] ?? null; @endphp
          <tr>
            <td style="border:1px solid #000; padding:6px 8px; text-align:center;">{{ $i + 1 }}</td>
            <td style="border:1px solid #000; padding:6px 8px;">
              @if($row && $row['comments']->isNotEmpty())
                @foreach($row['comments'] as $c)
                  {{-- Teks komentar --}}
                  <div>{!! nl2br(e($c['comment'])) !!}</div>
            
                  {{-- Gambar (jika ada), langsung di bawah komentarnya --}}
                  @if(!empty($c['images']) && $c['images']->count() > 0)
                    <div class="d-flex flex-wrap gap-1 mb-2">
                      @foreach($c['images'] as $img)
                        <a href="{{ route('annotation.images.stream', $img->id) }}" target="_blank">
                          <img src="{{ route('annotation.images.stream', $img->id) }}"
                               style="width:72px;height:56px;object-fit:cover;border-radius:5px;border:1px solid #dee2e6;">
                        </a>
                      @endforeach
                    </div>
                  @else
                    <div class="mb-2"></div>
                  @endif
                @endforeach
              @else
                &nbsp;
              @endif
            </td>
            <td style="border:1px solid #000; padding:6px 8px; text-align:center;">
              @if($row && $row['comments']->isNotEmpty())
                {{-- Gabung semua status yang tidak kosong --}}
                {{ $row['comments']->pluck('status')->filter()->implode(', ') }}
              @endif
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
    @if ($dr->status?->is_approved && is_null($dr->tanggal_terbit))
      @if(!empty($dr->file_final_dr))
        <form action="{{ route('dokumenReview.publish', $dr) }}" method="POST"
              onsubmit="return confirm('Apakah Anda yakin ingin MENERBITKAN dokumen ini? Aksi ini akan memindahkan dokumen ke Master List.')">
            @csrf
            @if(empty($isTerbit) || !$isTerbit)
              <button class="btn btn-sm btn-primary" type="submit">
                Terbit
              </button>
            @endif
        </form>
      @else
        <div class="alert alert-warning py-2 mb-0 d-inline-block">
          <strong>Perhatian:</strong> Dokumen telah disetujui penuh. Silakan unggah File Dokumen Final (PDF) di halaman Master List terlebih dahulu untuk memunculkan tombol Terbit.
        </div>
      @endif
    @elseif(!is_null($dr->tanggal_terbit))
      <div class="mt-3">
        <span class="badge bg-success">
          Dokumen telah Terbit pada:
          {{ optional($dr->tanggal_terbit)->format('d M Y H:i') }}
        </span>
      </div>
    @endif


    {{-- ===== MODAL APPROVAL (MAIN) ===== --}}
    <div class="modal fade" id="appr{{ $dr->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form class="modal-content" action="{{ route('approvals.store', $dr->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="kind" value="main">
          
          <div class="modal-header">
            <h5 class="modal-title">Tanda Tangan Approval (Menyetujui)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Aksi</label>
              <select class="form-select form-select-sm" name="action" required>
                <option value="" selected disabled>— Pilih —</option>
                <option value="approved">Setujui</option>
                <option value="rejected">Tolak</option>
              </select>
            </div>
            
            <ul class="nav nav-pills mb-3" role="tablist">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#sigpad-main" type="button" role="tab">Gambar</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#upload-main" type="button" role="tab">Upload</button>
              </li>
            </ul>
            
            <div class="tab-content">
              <div class="tab-pane fade show active" id="sigpad-main">
                <div class="border rounded p-2">
                  <div class="small text-muted mb-1">Tanda tangan langsung di bawah ini:</div>
                  <canvas class="sigpad w-100 h-100" style="background:#fff; border:1px dashed #ccc; border-radius:.5rem; min-height:200px;"></canvas>
                </div>
                <div class="d-flex gap-2 mt-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary sig-clear">Bersihkan</button>
                </div>
                <input type="hidden" name="signature_json">
              </div>
              
              <div class="tab-pane fade" id="upload-main">
                <div class="mb-2">
                  <label class="form-label">Upload gambar tanda tangan</label>
                  <input type="file" name="signature_file" accept="image/*" class="form-control form-control-sm">
                  <small class="text-muted">Opsional: gunakan ini jika tidak ingin menggambar.</small>
                </div>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    {{-- ===== MODAL MENDUKUNG (SUPPORT) ===== --}}
    <div class="modal fade" id="supp{{ $dr->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form class="modal-content" action="{{ route('approvals.store', $dr->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="kind" value="support">
          
          <div class="modal-header">
            <h5 class="modal-title">Tanda Tangan Mendukung</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Aksi</label>
              <select class="form-select form-select-sm" name="action" required>
                <option value="" selected disabled>— Pilih —</option>
                <option value="approved">Setujui</option>
                <option value="rejected">Tidak</option>
              </select>
            </div>
            
            <ul class="nav nav-pills mb-3" role="tablist">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#sigpad-supp" type="button" role="tab">Gambar</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#upload-supp" type="button" role="tab">Upload</button>
              </li>
            </ul>
            
            <div class="tab-content">
              <div class="tab-pane fade show active" id="sigpad-supp">
                <div class="border rounded p-2 sig-wrap">
                  <div class="small text-muted mb-1">Tanda tangan langsung di bawah ini:</div>
                  <canvas class="sigpad" style="background:#fff; border:1px dashed #ccc; border-radius:.5rem; width:100%; height:170%;"></canvas>
                </div>
                <div class="d-flex gap-2 mt-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary sig-clear">Bersihkan</button>
                </div>
                <input type="hidden" name="signature_json">
              </div>
              
              <div class="tab-pane fade" id="upload-supp">
                <div class="mb-2">
                  <label class="form-label">Upload gambar tanda tangan</label>
                  <input type="file" name="signature_file" accept="image/*" class="form-control form-control-sm">
                  <small class="text-muted">Opsional: gunakan ini jika tidak ingin menggambar.</small>
                </div>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          </div>
        </form>
      </div>
    </div>
     {{-- ===== MODAL INPUT TTD REVIEWER (KIND: REVIEWER) ===== --}}
    @foreach($revIds as $uid)
      <div class="modal fade" id="rev{{ $dr->id }}_u{{ $uid }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="--bs-modal-width: 680px;">
          <form class="modal-content" action="{{ route('approvals.store', $dr->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- penting: supaya disimpan ke baris reviewer yang benar --}}
            <input type="hidden" name="kind" value="reviewer">
            <input type="hidden" name="as_user_id" value="{{ $uid }}">
          
            <div class="modal-header">
              <h5 class="modal-title">Tanda Tangan Reviewer — {{ $userMap[$uid] ?? 'User ID '.$uid }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
          
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Catatan</label>
                <select class="form-select form-select-sm" name="action" required>
                  <option value="" selected disabled>— Pilih —</option>
                  <option value="approved">Ya</option>
                  <option value="rejected">Tidak</option>
                </select>
              </div>
            
              <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#sigpad-tab-{{ $uid }}" type="button" role="tab">Gambar</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="pill" data-bs-target="#upload-tab-{{ $uid }}" type="button" role="tab">Upload</button>
                </li>
              </ul>
            
              <div class="tab-content">
                {{-- TAB GAMBAR --}}
                <div class="tab-pane fade show active" id="sigpad-tab-{{ $uid }}">
                  <div class="border rounded p-2">
                    <div class="small text-muted mb-1">Tanda tangan langsung di bawah ini:</div>
                    <canvas class="sigpad w-100 h-100" style="background:#fff; border:1px dashed #ccc; border-radius:.5rem; min-height:200px;"></canvas>
                  </div>
                  <div class="d-flex gap-2 mt-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary sig-clear">Bersihkan</button>
                  </div>
                  <input type="hidden" name="signature_json">
                </div>
              
                {{-- TAB UPLOAD --}}
                <div class="tab-pane fade" id="upload-tab-{{ $uid }}">
                  <div class="mb-2">
                    <label class="form-label">Upload gambar tanda tangan</label>
                    <input type="file" name="signature_file" accept="image/*" class="form-control form-control-sm">
                    <small class="text-muted">Opsional: gunakan ini jika tidak ingin menggambar.</small>
                  </div>
                </div>
              </div>
            </div>
          
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    @endforeach
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
@push('scripts')
<script>
(function(){
  function setupSigPad(canvas){
    if (!window.SignaturePad || !canvas) return;

    // Elemen kontekstual
    const root   = canvas.closest('.tab-pane') || canvas.parentElement;
    const modal  = canvas.closest('.modal');
    const form   = canvas.closest('form');
    const clear  = root.querySelector('.sig-clear');

    // Hidden input (buat kalau belum ada)
    let hidden = root.querySelector('input[name="signature_json"]');
    if (!hidden) {
      hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = 'signature_json';
      root.appendChild(hidden);
    }

    // Init SignaturePad
     const pad = new SignaturePad(canvas, {
     minWidth: 1.4,     // dari 0.8 -> 1.4
     maxWidth: 3.6,     // dari 2.5 -> 3.6
     penColor: '#000',
     velocityFilterWeight: 0.7  // garis lebih “penuh”, tidak terlalu menipis
    });

    // Resize kanvas ke DPI sebenarnya (fix: garis tidak muncul)
    function resizeCanvas(){
      const ratio = Math.max(window.devicePixelRatio || 1, 1);
      const rect  = canvas.getBoundingClientRect();
      const cssW = Math.max(1, rect.width);   // lebar ikut parent (maks 520px)
      const cssH = Math.max(1, rect.height);  // dari style height:170px

      canvas.width  = cssW * ratio;
      canvas.height = cssH * ratio;

      const ctx = canvas.getContext('2d');
      ctx.scale(ratio, ratio);
      // Background putih supaya toDataURL tidak transparan
      ctx.fillStyle = '#fff';
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      pad.clear();
    }

    // Panggil saat init
    resizeCanvas();

    // Panggil lagi saat modal/tab tampil (karena awalnya display:none -> size 0)
    if (modal) {
      modal.addEventListener('shown.bs.modal', resizeCanvas, { once:false });
    }
    // Bootstrap tab event
    document.addEventListener('shown.bs.tab', (e) => {
      const targetSel = e.target?.getAttribute?.('data-bs-target');
      if (targetSel && root.id && ('#'+root.id) === targetSel) {
        resizeCanvas();
      }
    });

    // Tombol bersih
    clear && clear.addEventListener('click', () => pad.clear());

    // Saat form submit: isi hidden input bila ada coretan
    form && form.addEventListener('submit', (ev) => {
      const fileInput = form.querySelector('input[name="signature_file"]');
      if (pad.isEmpty()) {
        hidden.value = '';
        // Kalau tidak ada upload file juga, cegah submit
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
          ev.preventDefault();
          alert('Gambarkan tanda tangan di kanvas atau unggah file tanda tangan.');
        }
      } else {
        hidden.value = canvas.toDataURL('image/png');
      }
    });
  }

  // Init semua canvas .sigpad setelah DOM siap
  function initAll(){
    document.querySelectorAll('canvas.sigpad').forEach(setupSigPad);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
  } else {
    initAll(); // DOM sudah siap → langsung jalan
  }
})();
</script>
@endpush
@endsection