@extends('layouts.main')

@section('content')
@php
  // fallback kalau controller belum mengirimkan variabel-variabel ini
  $users      = $users      ?? collect();         
  $divisis    = $divisis    ?? collect();         
  $jenisList  = $jenisList  ?? collect();         
  $reviewers  = $reviewers  ?? $users;            // default reviewer = semua user (sesuaikan di controller)
  $jabatans   = $jabatans   ?? ['admin','staff','manajemen','manager','supervisor'];
@endphp

@if (session('danger'))
  <div class="alert alert-danger">{{ session('danger') }}</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif  


<section class="section">
  <div class="row">
    <div class="col-lg-10">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">PENGAJUAN LAPORAN INTERNAL</h5>
{{-- Debug sementara --}}
{{-- Users: {{ $users->count() }} | Reviewers: {{ $reviewers->count() }} | Divisi: {{ $divisis->count() }} --}}

          {{-- Ganti route di bawah sesuai kebutuhan: mis. route('dokumen.pengajuan.store') --}}
          <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
            @csrf
             <div class="row mb-3">
              <label for="nomor_dokumen" class="col-sm-2 col-form-label"><strong>NOMOR DOKUMEN</strong></label>
              <div class="col-sm-10">
                <input id="nomor_dokumen" name="nomor_dokumen" class="form-control"
                       value="{{ old('nomor_dokumen') }}" placeholder="Contoh: ">
                       <small class="text-muted"></small>
                @error('nomor_dokumen') <small class="text-danger">{{ $message }}</small> @enderror
              </div> 
            </div>

            {{-- Nama Pembuat Suratnya--}}
            <div class="row mb-3">
              <label for="pembuat2_id" class="col-sm-2 col-form-label"><strong>LEAD AUDITOR</strong></label>
              <div class="col-sm-10">
                <select id="pembuat2_id" name="pembuat2_id" class="form-control" required>
                  <option value="">--Pilih Nama Lead--</option>
                  @foreach($users as $u)
                    <option value="{{ $u->id }}" @selected(old('pembuat2_id')==$u->id)>{{ $u->nama_user ?? $u->name }}</option>
                  @endforeach
                </select>
                @error('pembuat2_id') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Nama Pembuat Form Pengajuan--}}
            <div class="row mb-2">
              <label class="col-sm-2 col-form-label"><strong>AUDITOR</strong></label>
              <div class="col-sm-10">
                <div id="auditor-container">
                  <div class="mb-2 d-flex align-items-center gap-2 auditor-item">
                    <span class="text-muted auditor-label" style="width:90px;">Auditor 1</span>
                    <select name="auditor_ids[]" class="form-control">
                      <option value="">-- Pilih Auditor --</option>
                      @foreach($reviewers as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
                      @endforeach
                    </select>
                    <button type="button" class="btn btn-sm btn-danger remove-auditor d-none">Hapus</button>
                  </div>
                </div>
              
                <button type="button" class="btn btn-sm btn-primary mt-2" id="add-auditor-btn">
                  + Tambah Auditor
                </button>
              </div>
            </div>
 
          
             <div class="row mb-2">
              <label class="col-sm-2 col-form-label"><strong>AUDITEE</strong></label>
              <div class="col-sm-10">
                <div id="auditee-container">
                  <div class="mb-2 d-flex align-items-center gap-2 auditee-item">
                    <span class="text-muted reviewer-label" style="width:90px;">Auditee 1</span>
                    <select name="auditee_ids[]" class="form-control">
                      <option value="">-- Pilih Auditee  --</option>
                      @foreach($reviewers as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
                      @endforeach
                    </select>
                    <button type="button" class="btn btn-sm btn-danger remove-auditee d-none">Hapus</button>
                  </div>
                </div>
              
                <button type="button" class="btn btn-sm btn-primary mt-2" id="add-auditee-btn">
                  + Tambah Auditee
                </button>
              </div>
            </div>
 

            {{-- Divisi --}}
            <div class="row mb-3">
              <label for="divisi_id" class="col-sm-2 col-form-label"><strong>PROSES YANG DIAUDIT</strong></label>
              <div class="col-sm-10">
                <select id="divisi_id" name="divisi_id" rows="3" class="form-control" required>
                  <option value="">--Pilih Divisi--</option>
                  @foreach($divisis as $d)
                    <option value="{{ $d->id }}" @selected(old('divisi_id')==$d->id)>{{ $d->nama_divisi }}</option>
                  @endforeach
                </select>
                @error('divisi_id') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- ===== Temuan (Repeater) ===== --}}
            <div class="row mb-2">
              <label class="col-sm-2 col-form-label"><strong>Daftar Temuan</strong></label>
              <div class="col-sm-10">
              
                <div id="temuan-container">
                  {{-- Row temuan pertama (index 0) --}}
                  <div class="card mb-3 temuan-item">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold temuan-label">Temuan 1</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-temuan d-none">Hapus</button>
                      </div>
                    
                      <div class="mb-3">
                        <label class="form-label">Uraian Temuan</label>
                        <textarea name="temuan[0][deskripsi]" rows="3" class="form-control"
                          placeholder="Apa yang ditemui?">{{ old('temuan.0.deskripsi') }}</textarea>
                        @error('temuan.0.deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                      </div>
                    
                      <div class="mb-3">
                        <label class="form-label">Referensi</label>
                        <textarea name="temuan[0][referensi]" rows="2" class="form-control"
                          placeholder="Standar/prosedur/IK/pasal yang dijadikan acuan">{{ old('temuan.0.referensi') }}</textarea>
                        @error('temuan.0.referensi') <small class="text-danger">{{ $message }}</small> @enderror
                      </div>
                    
                      <div class="mb-3">
                         <label class="form-label">Objective Evidence</label>       
                         <div class="evidence-container">
                           <!-- baris pertama -->
                           <div class="row g-2 align-items-start evidence-item mb-2">
                             <div class="col-md-5">
                               <input type="file" class="form-control evidence-file"
                                      name="temuan[0][evidence][0][file]"
                                      accept=".jpg,.jpeg,.png,.pdf" required>
                               <small class="text-muted">JPG/PNG/PDF, maks 20MB.</small>
                             </div>
                             <div class="col-md-6">
                               <textarea class="form-control evidence-desc" rows="2"
                                         name="temuan[0][evidence][0][desc]"
                                         placeholder="Tulis Evidence Disini" required></textarea>
                             </div>
                             <div class="col-md-1 text-end">
                               <button type="button" class="btn btn-sm btn-outline-danger remove-evidence d-none">Hapus</button>
                             </div>
                           </div>
                         </div>
                        
                         <button type="button" class="btn btn-sm btn-secondary add-evidence">+ Tambah Evidence</button>
                      </div>
                    
                      <div class="mb-1">
                        <label class="form-label">Status</label>
                        <select name="temuan[0][status]" class="form-control">
                          <option value="">-- Pilih Status --</option>
                          @foreach($statusPpk as $id => $nama)
                            <option value="{{ $id }}" @selected(old('temuan.0.status')==$id)>{{ $nama }}</option>
                          @endforeach
                        </select>
                        @error('temuan.0.status') <small class="text-danger">{{ $message }}</small> @enderror
                      </div>
                    </div>
                  </div>
                </div>
              
                <button type="button" class="btn btn-sm btn-primary" id="add-temuan-btn">+ Tambah Temuan</button>
              </div>
            </div>

            {{-- Template (tidak dirender) --}}
            <template id="temuan-template">
              <div class="card mb-3 temuan-item">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold temuan-label">Temuan {N}</span>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-temuan">Hapus</button>
                  </div>
              
                  <div class="mb-3">
                    <label class="form-label">Uraian Temuan</label>
                    <textarea name="temuan[{I}][deskripsi]" rows="3" class="form-control"
                      placeholder="Apa yang ditemui?"></textarea>
                  </div>
              
                  <div class="mb-3">
                    <label class="form-label">Referensi</label>
                    <textarea name="temuan[{I}][referensi]" rows="2" class="form-control"
                      placeholder="Standar/prosedur/IK/pasal yang dijadikan acuan"></textarea>
                  </div>
              
                  <div class="mb-3">
                    <label class="form-label">Objective Evidence</label>
                                  
                    <div class="evidence-container">
                      <!-- baris pertama -->
                      <div class="row g-2 align-items-start evidence-item mb-2">
                        <div class="col-md-5">
                          <input type="file" class="form-control evidence-file"
                                 name="temuan[0][evidence][0][file]"
                                 accept=".jpg,.jpeg,.png,.pdf" required>
                          <small class="text-muted">JPG/PNG/PDF, maks 20MB.</small>
                        </div>
                        <div class="col-md-6">
                          <textarea class="form-control evidence-desc" rows="2"
                                    name="temuan[0][evidence][0][desc]"
                                    placeholder="Jelaskan isi gambar/dokumen…" required></textarea>
                        </div>
                        <div class="col-md-1 text-end">
                          <button type="button" class="btn btn-sm btn-outline-danger remove-evidence d-none">Hapus</button>
                        </div>
                      </div>
                    </div>
                  
                    <button type="button" class="btn btn-sm btn-secondary add-evidence">+ Tambah Evidence</button>
                  </div>
                 

                  <div class="mb-1">
                    <label class="form-label">Status</label>
                    <select name="temuan[{I}][status]" class="form-control">
                      <option value="">-- Pilih Status --</option>
                      @foreach($statusPpk as $id => $nama)
                        <option value="{{ $id }}">{{ $nama }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </template>
             
                <!-- template item evidence -->
                <template id="evidence-template">
                    <div class="row g-2 align-items-start evidence-item mb-2">
                      <div class="col-md-5">
                        <input type="file" class="form-control evidence-file"
                               name="temuan[{I}][evidence][{J}][file]"
                               accept=".jpg,.jpeg,.png,.pdf" required>
                      </div>
                      <div class="col-md-6">
                        <textarea class="form-control evidence-desc" rows="2"
                                  name="temuan[{I}][evidence][{J}][desc]"
                                  placeholder="Jelaskan isi gambar/dokumen…" required></textarea>
                      </div>
                      <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-evidence">Hapus</button>
                      </div>
                    </div>
                </template>


            <div class="text-end mt-4">
              <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-primary"
                      onclick="this.disabled=true;this.form.submit();">Kirim Pengajuan</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
  /* ===========================
   *  AUDITOR
   * ===========================*/
  (function () {
    let auditorCount = document.querySelectorAll('#auditor-container .auditor-item').length || 1;
    const auditorContainer = document.getElementById('auditor-container');
    const addAuditorBtn    = document.getElementById('add-auditor-btn');

    if (addAuditorBtn && auditorContainer) {
      addAuditorBtn.addEventListener('click', function () {
        auditorCount++;
        const div = document.createElement('div');
        div.className = 'mb-2 d-flex align-items-center gap-2 auditor-item';
        div.innerHTML = `
          <span class="text-muted auditor-label" style="width:90px;">Auditor ${auditorCount}</span>
          <select name="auditor_ids[]" class="form-control">
            <option value="">-- Pilih Auditor --</option>
            @foreach($reviewers as $r)
              <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
            @endforeach
          </select>
          <button type="button" class="btn btn-sm btn-danger remove-auditor">Hapus</button>
        `;
        auditorContainer.appendChild(div);
      });

      auditorContainer.addEventListener('click', function (e) {
        if (!e.target.classList.contains('remove-auditor')) return;
        e.target.closest('.auditor-item').remove();
        // Renumber label
        auditorCount = 0;
        auditorContainer.querySelectorAll('.auditor-item').forEach((el, idx) => {
          el.querySelector('.auditor-label').textContent = `Auditor ${idx + 1}`;
          auditorCount++;
        });
      });
    }
  })();

  /* ===========================
   *  AUDITEE
   * ===========================*/
  (function () {
    let auditeeCount = document.querySelectorAll('#auditee-container .auditee-item').length || 1;
    const auditeeContainer = document.getElementById('auditee-container');
    const addAuditeeBtn    = document.getElementById('add-auditee-btn');

    if (addAuditeeBtn && auditeeContainer) {
      addAuditeeBtn.addEventListener('click', function () {
        auditeeCount++;
        const div = document.createElement('div');
        div.className = 'mb-2 d-flex align-items-center gap-2 auditee-item';
        div.innerHTML = `
          <span class="text-muted auditee-label" style="width:90px;">Auditee ${auditeeCount}</span>
          <select name="auditee_ids[]" class="form-control">
            <option value="">-- Pilih Auditee --</option>
            @foreach($reviewers as $r)
              <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
            @endforeach
          </select>
          <button type="button" class="btn btn-sm btn-danger remove-auditee">Hapus</button>
        `;
        auditeeContainer.appendChild(div);
      });

      auditeeContainer.addEventListener('click', function (e) {
        if (!e.target.classList.contains('remove-auditee')) return;
        e.target.closest('.auditee-item').remove();
        // Renumber label (PASTIKAN pakai auditeeCount, bukan auditorCount)
        auditeeCount = 0;
        auditeeContainer.querySelectorAll('.auditee-item').forEach((el, idx) => {
          el.querySelector('.auditee-label').textContent = `Auditee ${idx + 1}`;
          auditeeCount++;
        });
      });
    }
  })();

  /* ===========================
   *  TEMUAN  (repeater kartu temuan)
   * ===========================*/
  const temuanContainer = document.getElementById('temuan-container');
  const addTemuanBtn    = document.getElementById('add-temuan-btn');
  const temuanTpl       = document.getElementById('temuan-template')?.innerHTML || '';
  let temuanIdx         = temuanContainer ? temuanContainer.querySelectorAll('.temuan-item').length : 0;

  function renumberTemuanLabel() {
    if (!temuanContainer) return;
    let n = 0;
    temuanContainer.querySelectorAll('.temuan-item').forEach(card => {
      n++;
      const label = card.querySelector('.temuan-label');
      if (label) label.textContent = `Temuan ${n}`;
      const rm = card.querySelector('.remove-temuan');
      if (rm) rm.classList.toggle('d-none', temuanContainer.children.length <= 1);
    });
  }

  /* ===========================
   *  EVIDENCE per-temuan (file + deskripsi)
   * ===========================*/
  const evidenceTpl = document.getElementById('evidence-template')?.innerHTML || '';

  function reindexEvidence(temuanCard, iTemuan) {
    const rows = temuanCard.querySelectorAll('.evidence-item');
    rows.forEach((row, j) => {
      const file = row.querySelector('.evidence-file');
      const desc = row.querySelector('.evidence-desc');
      if (file) file.setAttribute('name', `temuan[${iTemuan}][evidence][${j}][file]`);
      if (desc) desc.setAttribute('name', `temuan[${iTemuan}][evidence][${j}][desc]`);
    });
    temuanCard.querySelectorAll('.remove-evidence')
      .forEach(btn => btn.classList.toggle('d-none', rows.length <= 1));
  }

  function initEvidenceHandlers(temuanCard, iTemuan) {
    const evContainer = temuanCard.querySelector('.evidence-container');
    const addEvBtn    = temuanCard.querySelector('.add-evidence');
    if (!evContainer || !addEvBtn) return;

    addEvBtn.addEventListener('click', function () {
      const j    = evContainer.querySelectorAll('.evidence-item').length;
      const html = evidenceTpl.replaceAll('{I}', iTemuan).replaceAll('{J}', j);
      const wrap = document.createElement('div');
      wrap.innerHTML = html.trim();
      evContainer.appendChild(wrap.firstElementChild);
      reindexEvidence(temuanCard, iTemuan);
    });

    evContainer.addEventListener('click', function (e) {
      if (!e.target.classList.contains('remove-evidence')) return;
      e.target.closest('.evidence-item').remove();
      reindexEvidence(temuanCard, iTemuan);
    });

    // inisialisasi awal
    reindexEvidence(temuanCard, iTemuan);
  }

  // Inisialisasi evidence untuk semua temuan yang SUDAH ada saat page load
  document.querySelectorAll('.temuan-item').forEach((card, idx) => {
    card.setAttribute('data-temuan-index', idx);
    initEvidenceHandlers(card, idx);
  });

  // Tambah temuan baru
  if (addTemuanBtn && temuanContainer && temuanTpl) {
    addTemuanBtn.addEventListener('click', function () {
      const html = temuanTpl.replaceAll('{I}', temuanIdx).replaceAll('{N}', temuanIdx + 1);
      const host = document.createElement('div');
      host.innerHTML = html.trim();
      const card = host.firstElementChild;

      // set index dan pasang ke DOM
      card.setAttribute('data-temuan-index', temuanIdx);
      temuanContainer.appendChild(card);

      // INIT evidence untuk temuan baru (WAJIB)
      initEvidenceHandlers(card, temuanIdx);

      temuanIdx++;
      renumberTemuanLabel();
    });

    // Hapus temuan (delegation)
    temuanContainer.addEventListener('click', function (e) {
      if (!e.target.classList.contains('remove-temuan')) return;
      e.target.closest('.temuan-item').remove();
      // Catatan: kita hanya merapikan LABEL.
      // Index name[] temuan dibiarkan sebagaimana saat dibuat
      // (lebih aman untuk server parsing).
      renumberTemuanLabel();
    });

    // inisialisasi label awal
    renumberTemuanLabel();
  }
});
</script>


@endsection

