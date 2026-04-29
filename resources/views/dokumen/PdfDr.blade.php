<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    @page { margin:100px 22px 18px 22px; }
    body  { font-family: 'DejaVu Serif', serif; font-size: 12px; }
    .h5   { font-size: 16px; margin: 0; }
    .section-title { font-weight:700; margin:12px 0 6px; }
    .doc-box { border:2px solid #000; width:100%; border-collapse:collapse; }
    .doc-box th, .doc-box td { border:1px solid #000; padding:6px 8px; vertical-align:middle; }
    .text-center { text-align:center; }
    .w-100{ width:100%; }
    .img-ttd { max-height:55px; display:block; margin:0 auto; }
    .tbl-catatan { width:100%; border-collapse:collapse; }
    .tbl-catatan th, .tbl-catatan td { border:1px solid #000; padding:6px 8px; }
    .mb-0{ margin-bottom:0; }
    .mb-2{ margin-bottom:8px; }
    .mb-3{ margin-bottom:12px; }
    .mt-3{ margin-top:12px; }
    .fw-bold{ font-weight:700; }
    .text-muted{ color:#666; }
    .small{ font-size: 11px; }
    .tanggal { width:100%;  }
    .tanggal th, .tanggal td { padding:4px 6px; text-align:left; vertical-align:middle; }
    .tanggal td { padding-left:2px; }
    #header {
      position: fixed;
      top: -100px; /* nilai negatif = masuk ke area margin @page */
      left: 0;
      right: 0;
      height: 90px;
      background: #fff;
      padding-top: 10px;
    }
    
    #content {
      margin-top: 0; /* tidak perlu margin-top lagi */
    }
    #footer {
      position: fixed;
      bottom: -18px;
      left: 0;
      right: 0;
      height: 30px;
      text-align: right;
      font-size: 11px;
    }

    .pagenum:before {
      content: counter(page);
      font-weight: 700;
    }
    .pagecount:before {
      content: counter(pages);
      font-weight: 700;
    }
  </style>
</head>
<body>  
  <div id="footer">
    Halaman <span class="pagenum"></span> dari <strong>{{ $totalHalaman }}</strong>
  </div>
 {{-- HEADER TETAP DI SETIAP HALAMAN --}}
  <div id="header">
    <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
      <tr>
        <td style="width:20%; vertical-align:middle;">
          <img src="{{ public_path('admin/img/logobg-ic.png') }}" alt="Logo" style="width:70px; height:auto;">
        </td>
        <td style="width:20%; text-align:right; vertical-align:middle;">
          <div style="font-weight:700;">FM.IM.10.00</div>
        </td>
      </tr>
    </table>
  </div>
  
  {{-- I. Document Information --}}
  <div id="content">
    <div style="width:100%; text-align:center; vertical-align:middle;">
      <div style="font-size:16px; font-weight:700; text-decoration:underline;">DOCUMENT REVIEW</div>
  </div>
    <div class="section-title mt-3">I. Document Information</div>
    <table class="doc-box">
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
        <td style="padding:0;">
          <table style="width:100%; border-collapse:collapse;">
            <tr>
              <td style="padding:6px 8px; width:40%; border:none;">: {{ $meta['tanggal_diedarkan'] ?? '-' }}</td>
              <td style="padding:6px 8px; width:25%; border-top:none; border-bottom:none; border-left:1px solid #000; border-right:none; font-weight:700;">Tanggal Kembali</td>
              <td style="padding:6px 8px; border-top:none; border-bottom:none; border-left:1px solid #000; border-right:none;">:
                @if($tanggalKembaliOtomatis)
                  {{ $tanggalKembaliOtomatis->format('d/m/Y') }}
                @elseif($dr->tanggal_kembali)
                  {{ \Carbon\Carbon::parse($dr->tanggal_kembali)->format('d/m/Y') }}
                @else
                  -
                @endif
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="padding:6px 8px;">
          <span style="font-weight:700;">Alasan / Tujuan Pembuatan / Revisi:</span>&nbsp;
          <span style="text-decoration:underline; font-style:italic;">
            {!! $meta['keterangan'] ? nl2br(e($meta['keterangan'])) : '-' !!}
          </span>
        </td>
      </tr>
    </table>

    {{-- II. List Of Reviewer --}}
    <div class="section-title">II. List Of Reviewer</div>
    <table class="doc-box">
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
          $revIds = collect($dr->reviewer_ids ?? [])->filter()->values();
        @endphp
        @forelse($revIds as $i => $uid)
          @php $rv = $revSigMap[$uid] ?? null; @endphp
          <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td>{{ $userMap[$uid] ?? ('User ID '.$uid) }}</td>
            <td class="text-center" style="height:60px;">
              @if($rv && $rv['sig'])
                <img class="img-ttd" src="{{ $rv['sig'] }}" alt="TTD">
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td class="text-center">{{ $rv['date'] ?? '—' }}</td>
            <td class="text-center">{{ $rv['action'] ?? '—' }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center">Tidak ada reviewer.</td></tr>
        @endforelse
      </tbody>
    </table>

    {{-- Tanggal Penyelesaian & Tanggal Diterima Doc Control (ditampilkan sebagai teks) --}}
    <table class="tanggal" style="margin-top:10px;">
      <tr>
        <th style="width:40%">Tanggal Penyelesaian</th>
        <td style="padding-left:4px;">: {{ optional($dr->tanggal_penyelesaian)->format('d/m/Y') ?? '—' }}</td>
      </tr>
      <tr>
        <th>Tanggal Diterima Doc. Control</th>
        <td style="padding-left:4px;">: {{ optional($dr->tanggal_diterima_dokumen_kontrol)->format('d/m/Y') ?? '—' }}</td>
      </tr>
    </table>

    {{-- TANDA TANGAN APPROVAL (MAIN) & SUPPORT --}}
    @php
      $apprMain = ($dr->approvals ?? collect())->first(fn($a) => ($a->kind ?? null) === 'main');
      $apprSupp = ($dr->approvals ?? collect())->first(fn($a) => ($a->kind ?? null) === 'support');
    @endphp

    <table class="doc-box" style="width:340px; margin:18px 0 0 auto;">
      <thead>
        <tr>
          <th class="text-center" style="width:50%;">Menyetujui</th>
          <th class="text-center" style="width:50%;">Didukung<br><span class="small">(Sesuai Kebutuhan)</span></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center" style="height:90px;">
            @if($approverSigDataUrl)
              <img class="img-ttd" src="{{ $approverSigDataUrl }}" alt="TTD Approver">
            @else
              <span class="text-muted">—</span>
            @endif
          </td>
          <td class="text-center" style="height:90px;">
            @if($supportSigDataUrl)
              <img class="img-ttd" src="{{ $supportSigDataUrl }}" alt="TTD Support">
            @else
              <span class="text-muted">—</span>
            @endif
          </td>
        </tr>
        <tr>
          <td class="text-center">
            <div class="fw-bold text-uppercase">{{ $apprMain?->user?->nama_user ?? '—' }}</div>
          </td>
          <td class="text-center">
            <div class="fw-bold text-uppercase">{{ $apprSupp?->user?->nama_user ?? '—' }}</div>
          </td>
        </tr>
      </tbody>
    </table>

    @php
      $all = collect($annotations)
        ->filter(fn($a) => filled(data_get($a->data,'comment')) || ($a->images && $a->images->count() > 0))
        ->sortBy([['user_id','asc'], ['id','asc']])
        ->map(fn($a) => [
          'comment' => data_get($a->data,'comment'),
          'status'  => $a->status ?? null,
          'images'  => $a->images ?? collect(),
        ])->values();
      $rowsPerTable = max(10, $all->count());
    @endphp

    <div class="section-title" style="margin-top:12px;">III. Catatan Reviewer & Status</div>
    <table class="tbl-catatan">
      <thead>
        <tr>
          <th style="width:50px; text-align:center;">No.</th>
          <th style="text-align:center;">Catatan</th>
          <th style="width:120px; text-align:center;">Status</th>
        </tr>
      </thead>
      <tbody>
        @for ($i=0; $i < $rowsPerTable; $i++)
          @php $row = $all[$i] ?? null; @endphp
          <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td>{!! $row ? nl2br(e($row['comment'])) : '&nbsp;' !!}
              @if($row && !empty($row['images']) && $row['images']->count() > 0)
                <br>
                @foreach($row['images'] as $img)
                  @php $dataUrl = $img->data_url; @endphp
                  @if($dataUrl)
                    <img src="{{ $dataUrl }}"
                         style="width:80px;height:60px;object-fit:cover;border:1px solid #ccc;margin:2px;">
                  @endif
                @endforeach
              @endif
            </td>
            <td class="text-center">{{ $row['status'] ?? ' ' }}</td>
          </tr>
        @endfor
      </tbody>
    </table>
  </div>
</body>
</html>
