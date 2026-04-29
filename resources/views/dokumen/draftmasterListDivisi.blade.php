@extends('layouts.main')

@section('content')
<div class="container">

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">ARSIP REVISI DOKUMEN — {{ $divisi->nama_divisi }}</h5>

    <div class="d-flex gap-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <a href="{{ route('dokumen.exportExcelDraftDivisi', array_merge(
                ['id' => $divisi->id],
                request()->only('jenis')
            )) }}"
           class="btn btn-success btn-sm">
            <i class="fas fa-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(session('danger'))
    <div class="alert alert-danger">{{ session('danger') }}</div>
  @endif

  {{-- Filter Jenis Dokumen --}}
  <div class="card mb-3">
    <div class="card-body py-2">
      <form method="GET" class="d-flex gap-2 align-items-center">
        <select name="jenis" class="form-select form-select-sm" style="max-width:250px">
          <option value="ALL">Semua Jenis Dokumen</option>
          @foreach($jenisList as $j)
            <option value="{{ $j }}" {{ ($activeJenis ?? 'ALL') === $j ? 'selected' : '' }}>
              {{ $j }}
            </option>
          @endforeach
        </select>
        <button class="btn btn-sm btn-primary">Filter</button>
        @if(($activeJenis ?? 'ALL') !== 'ALL')
          <a href="{{ request()->url() }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        @endif
      </form>
    </div>
  </div>

  {{-- Tabel Arsip --}}
  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
          <thead class="table-light text-center">
            <tr>
              <th style="width:50px">No</th>
              <th style="min-width:120px">No. Dokumen</th>
              <th style="min-width:100px">Jenis</th>
              <th style="min-width:250px">Nama Dokumen</th>
              <th style="width:80px">Revisi</th>
              <th style="min-width:120px">No. DR</th>
              <th style="width:120px">Tanggal Terbit</th>
              <th style="width:100px">Keterangan</th>
              <th style="width:120px">Alasan Revisi</th>
              <th style="width:120px">File</th>
              @if(auth()->user()->role === 'admin')
              <th style="width:100px">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @forelse($dokumens as $i => $d)
              <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td class="text-center">{{ $d->nomor_dokumen ?? '-' }}</td>
                <td class="text-center">
                  <span class="badge bg-secondary">{{ $d->nama_jenis ?? '-' }}</span>
                </td>
                <td>{{ $d->nama_dokumen ?? '-' }}</td>
                <td class="text-center">{{ $d->no_revisi ?? '-' }}</td>
                <td class="text-center">{{ $d->dr_no ?? '-' }}</td>
                <td class="text-center">
                  {{ optional($d->tanggal_terbit)->format('d M Y') ?? '-' }}
                </td>
                <td class="text-center">{{ $d->keterangan ?? '-' }}</td>
                <td>
                  <small class="text-muted">{{ $d->alasan_revisi ?? '-' }}</small>
                </td>
                <td class="text-center">
                  @php
                    $finalFile = optional($d->files)->first(fn($f) => 
                      strcasecmp(trim($f->type), 'final') === 0
                    );
                  @endphp
                  @if($finalFile)
                    <a href="{{ route('dokumenFile.stream', $finalFile->id) }}" 
                       target="_blank" class="btn btn-sm btn-outline-danger">
                      <i class="fas fa-file-pdf"></i> Lihat
                    </a>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                @if(auth()->user()->role === 'admin')
                <td class="text-center">
                  {{-- Hapus permanen --}}
                  <form action="{{ route('dokumenReview.destroy', $d->id) }}" 
                        method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus permanen dokumen arsip ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </form>
                </td>
                @endif
              </tr>
            @empty
              <tr>
                <td colspan="{{ auth()->user()->role === 'admin' ? 11 : 10 }}" 
                    class="text-center text-muted py-4">
                  Belum ada dokumen arsip revisi.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Pagination --}}
  <div class="mt-3">
    {{ $dokumens->links() }}
  </div>

</div>
@endsection