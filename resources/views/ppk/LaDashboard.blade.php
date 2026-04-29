@extends('layouts.main')

@section('content')
<div class="container">

  
  <div class="card mb-3 ">
    <div class="card-body d-flex justify-content-between align-items-center">
      <h5 class="mb-4 fw-bold">LAPORAN AUDIT</h5>
      <a href="{{ route('ppk.createLa') }}" class="btn btn-success"
                    style="font-weight: 500; font-size: 12px; padding: 6px 12px; display: inline-flex; align-items: center; gap: 5px;">
                    <i class="fa fa-plus" style="font-size: 14px;"></i> Laporan Audit
      </a>
      <form method="GET" action="{{ route('laporan.index') }}" class="d-flex" role="search">
        <input class="form-control form-control-sm me-2" type="search" name="keyword"
               value="{{ request('keyword') }}" placeholder="Cari nomor dokumen…">
        <button class="btn btn-sm btn-outline-primary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>
      
    </div>
  </div>
  
  @if($laporans->isEmpty())
    <div class="alert alert-warning">Tidak ada data.</div>
  @else
    <div class="card">
      <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0 align-middle">
          <thead class="table-light">
            <tr class="text-center">
              <th style="width:7%">No</th>
              <th>Register PPK</th>
              <th>Nomor PPK LA</th>
              <th style="width:12%">TGL. Register</th>
              <th style="width:12%">PIC / Lead Auditor </th>
              <th style="width:12%">OPEN </th>
              <th style="width:12%">CLOSE </th>
              <th style="width:12%">Auditee </th>
              <th style="width:12%">Auditor</th>
              <th style="width:12%">View</th>
            </tr>
          </thead>
          <tbody>
           @foreach ($laporans as $i => $laporan)
           <tr>
                <td class="text-center">{{ $laporans->firstItem() + $i }}</td>
                <td class="text-center">{{ $laporan->divisi->nama_divisi ?? '—' }}</td>
                <td class="text-center">
                  <a href="{{ route('laporan.show', $laporan->id) }}">
                    {{ $laporan->nomor_dokumen ?? '-' }}
                  </a>
                </td>
                <td class="text-center">{{ $laporan->created_at ?? '—' }}</td>
                <td class="text-center">{{  $laporan->leadAuditor->nama_user ?? '—'  }}</td>
                <td class="text-center">{{   '—'  }}</td>
                <td class="text-center">{{   '—'  }}</td>
                <td class="text-center">{{ $laporan->auditees_nama ?? '—'}}</td> 
                <td class="text-center">{{ $laporan->auditors_nama ?? '—'}}</td>
                
                <td class="text-center">
                  <a href="{{ route('laporan.show', $laporan->id) }}"
                     class="btn btn-outline-dark btn-sm" title="Lihat detail">
                    <i class="bi bi-eye-fill"></i> 
                  </a>
                  <form action="{{ route('laporan.destroy', $laporan->id) }}"
                        method="POST" class="d-inline"
                        onsubmit="return confirm('Hapus laporan ini beserta semua temuan & evidence?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                      <i class="bi bi-trash"></i> 
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer bg-white">
        <div class="d-flex justify-content-end">
          {{ $laporans->links() }}
        </div>
      </div>
    </div>
  @endif

</div>
@endsection
