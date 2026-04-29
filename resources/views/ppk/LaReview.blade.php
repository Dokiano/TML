@extends('layouts.main')
@section('content')
<style>
  .sheet { background:#fff; padding:24px; border:1px solid #e5e7eb; }
  .tbl { width:100%; border-collapse:collapse; table-layout: fixed; /* important */ }
  .tbl th,.tbl td { border:1px solid #111; padding:8px; vertical-align:top; word-break: break-word; overflow-wrap: break-word; white-space: normal; hyphens: auto; }
  .tbl th { text-align:center; }
  .col-no { width:40px; text-align:center; }
  .col-temuan { width:36%; }        /* ruang untuk temuan */
  .col-referensi { width:22%; }    /* tetap, jangan melebar */
  .col-evidence { width:26%; }     /* ruang evidence */
  .col-status { width:12%; text-align:center; }
  .evi-thumb{max-height:120px;display:block}
  .muted{color:#6b7280;font-size:12px}
  @media print {.no-print{display:none!important}.sheet{border:none;padding:0}@page{size:A4;margin:14mm 12mm}}
</style>

<div class="d-flex justify-content-between align-items-center mb-3 no-print">
  <a href="/laporan" class="btn btn-sm btn-secondary">← Kembali</a>
  <div>
    <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">🖨️ Print</button>
  </div>
</div>

<div class="sheet">
  <h5 class="mb-4 text-center">LAPORAN AUDIT INTERNAL</h5>

  <table class="mb-2" style="width:100%">
    <tr><td style="width:22%"><strong>NOMOR DOKUMEN</strong></td><td style="width:1%">:</td><td>{{ $laporan->nomor_dokumen ?? '—' }}</td></tr>
    <tr><td style="width:22%"><strong>PROSES YANG DIAUDIT</strong></td><td style="width:1%">:</td><td>{{ $laporan->divisi->nama_divisi ?? '—' }}</td></tr>
    <tr><td><strong>LEAD AUDITOR</strong></td><td>:</td><td>{{ $laporan->leadAuditor->nama_user ?? '—' }}</td></tr>
    <tr><td><strong>AUDITOR</strong></td><td>:</td><td>{{ $auditors->implode(', ') ?: '—' }}</td></tr>
    <tr><td><strong>AUDITEE</strong></td><td>:</td><td>{{ $auditees->implode(', ') ?: '—' }}</td></tr>
  </table>

  <table class="tbl">
    <colgroup>
      <col class="col-no">
      <col class="col-temuan">
      <col class="col-referensi">
      <col class="col-evidence">
      <col class="col-status">
    </colgroup>
    <thead>
      <tr>
        <th style="width:40px">NO.</th>
        <th>TEMUAN</th>
        <th style="width:22%">REFERENSI</th>
        <th style="width:26%">OBJECTIVE EVIDENCE<br><span class="muted">(file & deskripsi)</span></th>
        <th style="width:12%">STATUS</th>
      </tr>
    </thead>
    <tbody id="grid">
      @foreach($temuan as $i => $t)
        <tr data-id="{{ $t->id }}">
          <td style="text-align:center">{{ $i+1 }}</td>
          <td>{!! nl2br(e($t->deskripsi)) !!}</td>
          <td>{!! nl2br(e($t->referensi)) !!}</td>
          <td>
            @forelse($t->evidences as $ev)
              @php
                $src = route('evidence.show', $ev->id);
                $isImage = str_starts_with(strtolower((string)$ev->mime_type), 'image/');
              @endphp
              @if($isImage)
                <a href="{{ $src }}" target="_blank">
                  <img src="{{ $src }}" class="evi-thumb" alt="evidence">
                </a>
              @else
                <a href="{{ $src }}" target="_blank">📎 {{ basename($ev->file_path) }}</a>
              @endif
              <div class="muted">{!! nl2br(e($ev->desc)) !!}</div>
            @empty
              <span class="muted">— Tidak ada evidence —</span>
            @endforelse
          </td>
          <td style="text-align:center">{{ $statusMap[$t->status] ?? $t->status ?? '—' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{-- ===== Tanda Tangan Block (langsung di LaReview) ===== --}}
  <hr class="my-4">
  <h5>TANDA TANGAN</h5>

  @php $sudahTtd = $laporan->ttd_lead_path && $laporan->ttd_auditee_path; @endphp

  @if($sudahTtd)
        @php
        $leadFilename = basename($laporan->ttd_lead_path);
        $auditeeFilename = basename($laporan->ttd_auditee_path);
        @endphp

    <div class="row g-3">
      <div class="col-md-6">
        <img src="{{ route('signature.show', $leadFilename) }}" alt="TTD Lead" class="img-fluid border rounded" style="max-width: 150px; height: auto;"/>
        <div class="fw-semibold">Lead Auditor / Auditor</div>
          <div class="text-muted mt-1">Tanggal: {{ $laporan->tgl_ttd_lead ? \Carbon\Carbon::parse($laporan->tgl_ttd_lead)->format('d-m-Y') : '-' }}</div>
      </div>
      <div class="col-md-6">
        <img src="{{ route('signature.show', $auditeeFilename) }}" alt="TTD Auditee" class="img-fluid border rounded" style="max-width: 150px; height: auto;" />
        <div class="fw-semibold">Auditee</div>
        <div class="text-muted mt-1">Tanggal: {{ $laporan->tgl_ttd_auditee ? \Carbon\Carbon::parse($laporan->tgl_ttd_auditee)->format('d-m-Y') : '-' }}</div>
      </div>
      <div class="col-12 mt-2">Lembar ke: {{ $laporan->lembar_ke ?? '-' }}</div>
    </div>
  @else
    <form id="signForm" class="row g-3 no-print">
      @csrf
      <input type="hidden" name="laporan_id" value="{{ $laporan->id }}">

      <div class="col-md-6">
        <label class="form-label">Lead Auditor / Auditor</label>
        <div class="border rounded p-2">
          <canvas id="padLead" width="400" height="200" ></canvas>
        </div>
        <div class="d-flex flex-column gap-2">
          <button type="button" class="btn btn-sm btn-secondary" id="clearLead">Clear</button>
        </div>
        <div class="mt-2">
          <label class="form-label">Tanggal</label>
          <input type="date" class="form-control" name="tgl_ttd_lead" value="{{ now()->toDateString() }}">
        </div>
      </div>

      <div class="col-md-6">
        <label class="form-label">Auditee</label>
        <div class="border rounded p-2">
          <canvas id="padAuditee" width="400" height="200"></canvas>
        </div>
        <div class="d-flex flex-column gap-2">
          <button type="button" class="btn btn-sm btn-secondary" id="clearAuditee">Clear</button>
        </div>
        <div class="mt-2">
          <label class="form-label">Tanggal</label>
          <input type="date" class="form-control" name="tgl_ttd_auditee" value="{{ now()->toDateString() }}">
        </div>
      </div>

      <div class="col-12">
        <label class="form-label">Lembar ke</label>
        <input type="number" min="1" class="form-control" name="lembar_ke" placeholder="1">
      </div>

      <div class="col-12">
        <button type="button" id="saveSign" class="btn btn-primary">Simpan Tanda Tangan</button>
        <span class="ms-2 text-muted">(*disimpan sebagai PNG)</span>
      </div>
    </form>

    <script>
    (function(){
      // signature pad simple (vanilla) - dipakai untuk kedua canvas
      function makePad(canvas, clearBtn){
        const ctx = canvas.getContext('2d');
        ctx.lineWidth = 2; ctx.lineCap = 'round';
        let drawing=false, last=null;

        function resizeForDPR(){
          const ratio = Math.max(window.devicePixelRatio || 1, 1);
          const w = canvas.clientWidth;
          const h = canvas.clientHeight;
          canvas.width = Math.floor(w * ratio);
          canvas.height = Math.floor(h * ratio);
          ctx.scale(ratio, ratio);
        }
        // initial resize (in case CSS scales)
        resizeForDPR();
        window.addEventListener('resize', resizeForDPR);

        function getPoint(e){
          const r = canvas.getBoundingClientRect();
          const point = (e.touches && e.touches[0]) ? e.touches[0] : e;
          return {
            x: (point.clientX - r.left) * (canvas.width / r.width),
            y: (point.clientY - r.top) * (canvas.height / r.height)
          };
        }
        function start(e){ drawing=true; last = getPoint(e); }
        function move(e){ if(!drawing) return; const p = getPoint(e); ctx.beginPath(); ctx.moveTo(last.x, last.y); ctx.lineTo(p.x, p.y); ctx.stroke(); last = p; }
        function end(){ drawing=false; }

        canvas.addEventListener('mousedown', start);
        canvas.addEventListener('mousemove', move);
        window.addEventListener('mouseup', end);

        canvas.addEventListener('touchstart', (e)=>{ e.preventDefault(); start(e); }, {passive:false});
        canvas.addEventListener('touchmove',  (e)=>{ e.preventDefault(); move(e); }, {passive:false});
        canvas.addEventListener('touchend', end);

        clearBtn.addEventListener('click', ()=> ctx.clearRect(0,0,canvas.width,canvas.height));

        return {
          toDataURL(){ return canvas.toDataURL('image/png'); },
          isEmpty(){
            const blank = document.createElement('canvas');
            blank.width = canvas.width; blank.height = canvas.height;
            return canvas.toDataURL() === blank.toDataURL();
          }
        };
      }

      const leadPad = makePad(document.getElementById('padLead'), document.getElementById('clearLead'));
      const auditeePad = makePad(document.getElementById('padAuditee'), document.getElementById('clearAuditee'));

      document.getElementById('saveSign').addEventListener('click', async function(){
        const form = document.getElementById('signForm');
        // simple validation: kedua tanda tangan wajib diisi
        if (leadPad.isEmpty() || auditeePad.isEmpty()) {
          alert('Silakan isi kedua tanda tangan sebelum menyimpan.');
          return;
        }

        const payload = {
          tgl_ttd_lead: form.tgl_ttd_lead.value,
          tgl_ttd_auditee: form.tgl_ttd_auditee.value,
          lembar_ke: form.lembar_ke.value || null,
          sign_lead: leadPad.toDataURL(),
          sign_auditee: auditeePad.toDataURL()
        };

        try {
          const resp = await fetch("{{ url('/laporan/'.$laporan->id.'/signatures') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
          });
          const j = await resp.json().catch(()=>({}));
          if (!resp.ok) {
            alert(j.message || 'Gagal menyimpan tanda tangan');
            return;
          }
          // reload halaman setelah sukses (sesuai permintaan)
          location.reload();
        } catch (err) {
          alert('Koneksi bermasalah, silakan coba lagi.');
        }
      });
    })();
    </script>
  @endif
  {{-- ===== end TTD block ===== --}}

</div>
@endsection
