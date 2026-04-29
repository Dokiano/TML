@extends('layouts.main')

@section('content')
@php
  $users     = $users     ?? collect();
  $reviewers = $reviewers ?? $users;
@endphp

@if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
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

{{-- <div class="card text-center shadow-sm border-0 rounded-lg mb-3">
  <div class="card-body py-0">
    <h1 class="card-title" style="font-size:20px;font-weight:700;letter-spacing:1px;">
      EDIT DOKUMEN REVIEW
    </h1>
  </div>
</div> --}}

<section class="section">
  <div class="row">
    <div class="col-lg-10">
      <div class="card">
        <div class="card-body">

          <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="card-title mb-0">No. DR: {{ $dr->dr_no ?? '-' }}</h5>
            <h5 class="card-title mb-0">EDIT DOKUMEN BARU</h5>
            <a href="{{ route('dokumenReview.index') }}" class="btn btn-sm btn-outline-secondary">
              <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
          </div>

          <form method="POST"
                action="{{ route('dokumenReview.update', $dr->id) }}"
                enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Pembuat Dokumen (EDITABLE) --}}
            <div class="row mb-3">
              <label for="pembuat2_id" class="col-sm-2 col-form-label"><strong>Pembuat Dokumen</strong></label>
              <div class="col-sm-10">
                <select id="pembuat2_id" name="pembuat2_id" class="form-control">
                  <option value="">-- Pilih Pembuat --</option>
                  @foreach($users as $u)
                    <option value="{{ $u->id }}"
                      @selected(old('pembuat2_id', $dr->pembuat2_id) == $u->id)>
                      {{ $u->nama_user ?? $u->name }}
                    </option>
                  @endforeach
                </select>
                @error('pembuat2_id') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Divisi (READONLY) --}}
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"><strong>Divisi</strong></label>
              <div class="col-sm-10">
                <input type="text" class="form-control bg-light"
                       value="{{ optional($dr->divisi)->nama_divisi ?? '-' }}" readonly>
              </div>
            </div>

            {{-- Jabatan (READONLY) --}}
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"><strong>Jabatan</strong></label>
              <div class="col-sm-10">
                <input type="text" class="form-control bg-light"
                       value="{{ strtoupper($dr->jabatan ?? '-') }}" readonly>
              </div>
            </div>

            {{-- Jenis Dokumen (READONLY) --}}
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"><strong>Jenis Dokumen</strong></label>
              <div class="col-sm-10">
                <input type="text" class="form-control bg-light"
                       value="{{ $dr->nama_jenis ?? $dr->jenis_dokumen ?? '-' }}" readonly>
              </div>
            </div>

            {{-- Nama Dokumen (EDITABLE) --}}
            <div class="row mb-3">
              <label for="nama_dokumen" class="col-sm-2 col-form-label"><strong>Nama Dokumen</strong></label>
              <div class="col-sm-10">
                <input id="nama_dokumen" name="nama_dokumen" type="text" class="form-control"
                       value="{{ old('nama_dokumen', $dr->nama_dokumen ?? '') }}"
                       placeholder="Nama dokumen...">
                @error('nama_dokumen') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Nomor Dokumen & No Revisi (READONLY) --}}
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"><strong>Nomor Dokumen</strong></label>
              <div class="col-sm-5">
                <input type="text" class="form-control bg-light"
                       value="{{ $dr->nomor_dokumen ?? $dr->no_dokumen ?? '-' }}" readonly>
              </div>
              <label class="col-sm-2 col-form-label"><strong>No Revisi</strong></label>
              <div class="col-sm-3">
                <input type="text" class="form-control bg-light"
                       value="{{ $dr->no_revisi ?? '-' }}" readonly>
              </div>
            </div>

            {{-- Keterangan (READONLY) --}}
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"><strong>Keterangan</strong></label>
              <div class="col-sm-10">
                <input type="text" class="form-control bg-light"
                       value="{{ $dr->keterangan ?? '-' }}" readonly>
              </div>
            </div>

            {{-- Alasan Revisi (EDITABLE) --}}
            <div class="row mb-3">
              <label for="alasan_revisi" class="col-sm-2 col-form-label"><strong>Alasan Revisi</strong></label>
              <div class="col-sm-10">
                <textarea id="alasan_revisi" name="alasan_revisi"
                          rows="3" class="form-control"
                          placeholder="Alasan revisi dokumen...">{{ old('alasan_revisi', $dr->alasan_revisi ?? '') }}</textarea>
                @error('alasan_revisi') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Reviewer (EDITABLE) --}}
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"><strong>Reviewer</strong></label>
              <div class="col-sm-10">
                <div id="reviewer-container">
                  @php
                    $existingReviewerIds = collect($dr->reviewer_ids ?? [])->filter()->values();
                  @endphp

                  @forelse($existingReviewerIds as $i => $rid)
                    <div class="mb-2 d-flex align-items-center gap-2 reviewer-item">
                      <span class="text-muted reviewer-label" style="width:90px;">Reviewer {{ $i + 1 }}</span>
                      <select name="reviewer_ids[]" class="form-control">
                        <option value="">-- pilih reviewer --</option>
                        @foreach($reviewers as $r)
                          <option value="{{ $r->id }}" @selected($r->id == $rid)>
                            {{ $r->nama_user ?? $r->name }}
                          </option>
                        @endforeach
                      </select>
                      <button type="button" class="btn btn-sm btn-danger remove-reviewer">Hapus</button>
                    </div>
                  @empty
                    <div class="mb-2 d-flex align-items-center gap-2 reviewer-item">
                      <span class="text-muted reviewer-label" style="width:90px;">Reviewer 1</span>
                      <select name="reviewer_ids[]" class="form-control">
                        <option value="">-- pilih reviewer (opsional) --</option>
                        @foreach($reviewers as $r)
                          <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
                        @endforeach
                      </select>
                      <button type="button" class="btn btn-sm btn-danger remove-reviewer">Hapus</button>
                    </div>
                  @endforelse
                </div>

                <button type="button" class="btn btn-sm btn-primary mt-2" id="add-reviewer-btn">
                  + Tambah Reviewer
                </button>
                <small class="d-block text-muted mt-1">Duplikat reviewer akan diabaikan saat simpan.</small>
                @error('reviewer_ids') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Ganti File Draft (EDITABLE) --}}
            <div class="row mb-4">
              <label for="draft_dokumen" class="col-sm-2 col-form-label"><strong>Ganti File Draft</strong></label>
              <div class="col-sm-10">
                @if(!empty($dr->draft_path))
                  <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="bx bxs-file-pdf text-danger" style="font-size:18px;"></i>
                    <span class="text-muted" style="font-size:13px;">
                      File saat ini: <strong>{{ basename($dr->draft_path) }}</strong>
                    </span>
                    <a href="{{ route('dokumenReview.pdf', $dr->id) }}"
                       target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="bx bx-show me-1"></i> Lihat
                    </a>
                  </div>
                @else
                  <p class="text-muted mb-2" style="font-size:13px;">Belum ada file draft.</p>
                @endif

                <input type="file" id="draft_dokumen" name="draft_dokumen"
                       class="form-control" accept=".pdf">
                <small class="text-muted">Format: .pdf, maks 20MB. Kosongkan jika tidak ingin mengganti.</small>
                @error('draft_dokumen') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Tombol --}}
            <div class="text-end d-flex justify-content-end gap-2">
              <a href="{{ route('dokumenReview.index') }}" class="btn btn-secondary">Batal</a>
              <button type="submit" class="btn btn-warning"
                      onclick="this.disabled=true; this.form.submit();">
                <i class="bx bx-save me-1"></i> Simpan Perubahan
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('reviewer-container');
  const addBtn    = document.getElementById('add-reviewer-btn');

  addBtn.addEventListener('click', function () {
    const count = container.querySelectorAll('.reviewer-item').length + 1;
    const div   = document.createElement('div');
    div.classList.add('mb-2', 'd-flex', 'align-items-center', 'gap-2', 'reviewer-item');
    div.innerHTML = `
      <span class="text-muted reviewer-label" style="width:90px;">Reviewer ${count}</span>
      <select name="reviewer_ids[]" class="form-control">
        <option value="">-- pilih reviewer (opsional) --</option>
        @foreach($reviewers as $r)
          <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
        @endforeach
      </select>
      <button type="button" class="btn btn-sm btn-danger remove-reviewer">Hapus</button>
    `;
    container.appendChild(div);
  });

  container.addEventListener('click', function (e) {
    if (!e.target.classList.contains('remove-reviewer')) return;
    e.target.closest('.reviewer-item').remove();
    container.querySelectorAll('.reviewer-item').forEach(function (el, idx) {
      el.querySelector('.reviewer-label').textContent = 'Reviewer ' + (idx + 1);
    });
  });
});
</script>
@endsection