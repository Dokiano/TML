@extends('layouts.main')

@section('content')
@php
  $users      = $users      ?? collect();         
  $divisis    = $divisis    ?? collect();         
  $jenisList  = $jenisList  ?? collect();         
  $reviewers  = $reviewers  ?? $users;
  $jabatans   = $jabatans   ?? ['admin','staff','manajemen','manager','supervisor'];
  $nextRevisi = $nextRevisi ?? '01';
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
          <h5 class="card-title">Pengajuan Revisi Dokumen 
              <span class="text-muted fs-6">— {{ $dr->nomor_dokumen }} {{ $dr->nama_dokumen }}</span>
          </h5>

          {{-- Ganti route di bawah sesuai kebutuhan: mis. route('dokumen.pengajuan.store') --}}
          <form method="POST" action="{{ route('dokumen.pengajuan.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Nama Pembuat Suratnya--}}
            <div class="row mb-3">
              <label for="pembuat2_id" class="col-sm-2 col-form-label"><strong>Pembuat Dokumen</strong></label>
              <div class="col-sm-10">
                <select id="pembuat2_id" name="pembuat2_id" class="form-control" required>
                  <option value="">--Pilih Nama--</option>
                  @foreach($users as $u)
                    <option value="{{ $u->id }}" @selected(old('pembuat2_id')==$u->id)>{{ $u->nama_user ?? $u->name }}</option>
                  @endforeach
                </select>
                @error('pembuat2_id') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Nama Pembuat Form Pengajuan--}}
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label"><strong>Pengaju Nomor DR</strong></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" value="{{ auth()->user()->nama_user ?? auth()->user()->name }}" readonly>
                <input type="hidden" name="pembuat_id" value="{{ auth()->id() }}">
              </div>
            </div>

            {{-- Divisi --}}
            <div class="row mb-3">
                <label for="divisi_id" class="col-sm-2 col-form-label"><strong>Divisi</strong></label>
                <div class="col-sm-10">
                    <select id="divisi_id" name="divisi_id" class="form-control" required>
                        @foreach($divisis as $d)
                            {{-- Otomatis terpilih karena hanya ada 1 data divisi user --}}
                            <option value="{{ $d->id }}" selected>{{ $d->nama_divisi }}</option>
                        @endforeach
                    </select>
                    @error('divisi_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Jabatan --}}
            <div class="row mb-3">
              <label for="jabatan" class="col-sm-2 col-form-label"><strong>Jabatan </strong></label>
              <div class="col-sm-10">
                <select id="jabatan" name="jabatan" class="form-control" required>
                  <option value="">--Pilih Jabatan--</option>
                  @foreach($jabatans as $j)
                    <option value="{{ $j }}" @selected(old('jabatan')==$j)>{{ strtoupper($j) }}</option>
                  @endforeach
                </select>
                @error('jabatan') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

           {{-- Jenis Dokumen (diambil distinct dari tabel dokumen) --}}
            <div class="row mb-3">
                <label for="nama_jenis" class="col-sm-2 col-form-label"><strong>Jenis Dokumen</strong></label>
                <div class="col-sm-10">
                    <select id="nama_jenis" name="nama_jenis" class="form-control" required>
                        <option value="">--Pilih Jenis Dokumen--</option>
                        @foreach($jenisList as $jn)
                            <option value="{{ $jn }}" 
                                @selected(old('nama_jenis', $dr->nama_jenis) == $jn)>
                                {{ $jn }}
                            </option>
                        @endforeach
                    </select>
                    @error('nama_jenis') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Pilih Dokumen yang Direvisi
            <div class="row mb-3">
                <label for="dokumen_existing" class="col-sm-2 col-form-label"><strong>Pilih Dokumen</strong></label>
                <div class="col-sm-10">
                    <select id="dokumen_existing" class="form-control" required>
                        <option value="">-- Pilih Dokumen yang Direvisi --</option>
                        @foreach($dokumenExisting as $de)
                            <option value="{{ $de->nomor_dokumen }}"
                                    data-nama="{{ $de->nama_dokumen }}"
                                    data-jenis="{{ $de->nama_jenis }}">
                                {{ $de->nomor_dokumen }} — {{ $de->nama_dokumen }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Pilih dokumen yang ingin direvisi. Nomor dan revisi akan terisi otomatis.</small>
                </div>
            </div> --}}


            {{-- Nama Dokumen --}}
            <div class="row mb-3">
              <label for="nama_dokumen" class="col-sm-2 col-form-label"><strong>Nama Dokumen</strong></label>
              <div class="col-sm-10">
                <input id="nama_dokumen" name="nama_dokumen" class="form-control"
                        value="{{ old('nama_dokumen', $dr->nama_dokumen) }}" 
                        placeholder="Contoh: Nama dokumen" required>
                @error('nama_dokumen') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Nomor Dokumen --}}
            <div class="row mb-3">
              <label for="nomor_dokumen" class="col-sm-2 col-form-label"><strong>Nomor Dokumen</strong></label>
              <div class="col-sm-5">
               <input id="nomor_dokumen" name="nomor_dokumen" class="form-control"
                             value="{{ old('nomor_dokumen', $dr->nomor_dokumen) }}" 
                             placeholder="Contoh: MSP.IM.01">
                      <small class="text-muted">Nomor dokumen tetap sama saat revisi</small>

                @error('nomor_dokumen') <small class="text-danger">{{ $message }}</small> @enderror
              </div> 
              <label for="nomor_revisi" class="col-sm-2 col-form-label"><strong>No Revisi</strong></label>
              <div class="col-sm-3">
                <input id="no_revisi" name="no_revisi" class="form-control"
                            value="{{ old('no_revisi', $nextRevisi) }}">
                @error('nomor_revisi') <small class="text-danger">{{ $message }}</small> @enderror
              </div>     
            </div>

            {{-- Keterangan --}}
            <div class="row mb-3">
              <label for="keterangan" class="col-sm-2 col-form-label"><strong>Keterangan</strong></label>
              <div class="col-sm-10">
               <input id="keterangan" name="keterangan" class="form-control"
                      value="{{ old('keterangan', 'Revisi ' . (int)$nextRevisi) }}" 
                      placeholder="Baru / Revisi 1 / Revisi 2">
                @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Alasan Revisi --}}
            <div class="row mb-3">
              <label for="alasan_revisi" class="col-sm-2 col-form-label"><strong>Alasan Revisi</strong></label>
              <div class="col-sm-10">
                <textarea id="alasan_revisi" name="alasan_revisi" rows="3" class="form-control"
                          placeholder="Mengapa dokumen ini direvisi?">{{ old('alasan_revisi') }}</textarea>
                @error('alasan_revisi') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            {{-- Reviewer (dinamis) --}}
            <div class="row mb-2">
              <label class="col-sm-2 col-form-label"><strong>Reviewer</strong></label>
              <div class="col-sm-10">
                <div id="reviewer-container">
                  <div class="mb-2 d-flex align-items-center gap-2 reviewer-item">
                    <span class="text-muted reviewer-label" style="width:90px;">Reviewer 1</span>
                    <select name="reviewer_ids[]" class="form-control">
                      <option value="">-- pilih reviewer (opsional) --</option>
                      @foreach($reviewers as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
                      @endforeach
                    </select>
                    <button type="button" class="btn btn-sm btn-danger remove-reviewer d-none">Hapus</button>
                  </div>
                </div>
              
                <button type="button" class="btn btn-sm btn-primary mt-2" id="add-reviewer-btn">
                  + Tambah Reviewer
                </button>
              </div>
            </div>
 
            <div class="row mb-2">
              <label class="col-sm-2 col-form-label"><strong>Approval</strong></label>
              <div class="col-sm-10">
                <div class="mb-2 d-flex align-items-center gap-2">
                  
                  <select name="approver_main_id" class="form-control">
                    <option value="">-- pilih user (wajib) --</option>
                    @foreach($reviewers as $r)
                      <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
              
            <div class="row mb-2">
              <label class="col-sm-2 col-form-label"><strong>Mendukung</strong></label>
              <div class="col-sm-10">
                <div class="mb-2 d-flex align-items-center gap-2">
                 
                  <select name="approver_support_ids[]" class="form-control">
                    <option value="">-- pilih user (opsional) --</option>
                    @foreach($reviewers as $r)
                      <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <small class="text-muted">Biarkan kosong jika tidak diperlukan. Duplikat reviewer akan diabaikan saat simpan.</small>
             

            {{-- Upload Draft --}}
            <div class="row g-2 align-items-center mb-4">
                <label for="draft_dokumen" class="col-sm-2 col-form-label fw-bold">Upload Draft</label>
                <div class="col-sm-10">
                    <input type="file" name="draft_dokumen" id="draft_dokumen" class="form-control"
                        accept=".pdf" required>
                    <small class="text-muted">Format: .pdf maks 20MB</small>
                    @error('draft_dokumen') <small class="text-danger d-block">{{ $message }}</small> @enderror
                </div>
            </div>

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
document.addEventListener('DOMContentLoaded', function() {
    let reviewerCount = 1; 
    const container = document.getElementById('reviewer-container');
    const addBtn = document.getElementById('add-reviewer-btn');

    addBtn.addEventListener('click', function() {
        reviewerCount++;
        const newReviewer = document.createElement('div');
        newReviewer.classList.add('mb-2', 'd-flex', 'align-items-center', 'gap-2', 'reviewer-item');
        newReviewer.innerHTML = `
            <span class="text-muted reviewer-label" style="width:90px;">Reviewer ${reviewerCount}</span>
            <select name="reviewer_ids[]" class="form-control">
              <option value="">-- pilih reviewer (opsional) --</option>
              @foreach($reviewers as $r)
                <option value="{{ $r->id }}">{{ $r->nama_user ?? $r->name }}</option>
              @endforeach
            </select>
            <button type="button" class="btn btn-sm btn-danger remove-reviewer">Hapus</button>
        `;
        container.appendChild(newReviewer);
    });

    // Event delegation: hapus reviewer jika tombol diklik
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-reviewer')) {
            e.target.closest('.reviewer-item').remove();
            // Perbarui label reviewer
            reviewerCount = 0;
            document.querySelectorAll('.reviewer-item').forEach((el, idx) => {
                el.querySelector('.reviewer-label').textContent = `Reviewer ${idx + 1}`;
                reviewerCount++;
            });
        }
    });
});

</script>

@endsection

