@extends('layouts.main')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Edit Jenis Surat per Divisi</h5>

          <form method="POST" action="{{ route('dokumen.update', $dokumen->id) }}">
            @csrf
            @method('PUT')

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Nama Jenis Surat</label>
              <div class="col-sm-9">
                <input name="nama_jenis" class="form-control" value="{{ old('nama_jenis', $dokumen->nama_jenis) }}" required>
                @error('nama_jenis') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            <div class="row mb-4">
              <label class="col-sm-3 col-form-label">Divisi</label>
              <div class="col-sm-9">
                <select name="divisi_id" class="form-control" required>
                  <option value="">- Pilih Divisi -</option>
                  @foreach($divisis as $d)
                    <option value="{{ $d->id }}" @selected(old('divisi_id', $dokumen->divisi_id)==$d->id)>{{ $d->nama_divisi }}</option>
                  @endforeach
                </select>
                @error('divisi_id') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
            </div>

            <div class="text-end">
              <a href="{{ route('dokumen.index') }}" class="btn btn-secondary">Kembali</a>
              <button class="btn btn-primary" type="submit">Update</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
