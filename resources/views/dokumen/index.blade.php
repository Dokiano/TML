@extends('layouts.main')

@section('content')

@if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('danger'))
  <div class="alert alert-danger">{{ session('danger') }}</div>
@endif

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Kelola Dokumen</h5>

          <a href="{{ route('dokumen.create') }}" class="btn btn-sm btn-success mb-3" title="Tambah Dokumen">
            <i class="fa fa-plus"></i> Add Dokumen
          </a>

       
          <form method="GET" action="{{ route('dokumen.index') }}" class="mb-4">
            <div class="row g-2">
              <div class="col-md-4">
                <input type="text" name="keyword" class="form-control"
                  placeholder="Cari nomor/nama/deskripsi" value="{{ request('keyword') }}">
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
              </div>
            </div>
          </form>

          <table class="table table-striped" style="font-size: 15px;">
            <thead>
              <tr>
                <th style="width:60px;">No</th>
                <th>Nama Jenis Surat</th>
                <th>Divisi</th>
                <th style="width:180px;">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($dokumens as $dok)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $dok->nama_jenis }}</td>
                  <td>{{ optional($dok->divisi)->nama_divisi ?? '-' }}</td>
                  <td class="d-flex gap-1">
                    <a href="{{ route('dokumen.edit', $dok->id) }}" class="btn btn-sm btn-success"><i class="bx bx-edit"></i></a>
                    <form action="{{ route('dokumen.destroy', $dok->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger"><i class="ri ri-delete-bin-fill"></i></button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada data.</td></tr>
              @endforelse
            </tbody>

          </table>
          

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
