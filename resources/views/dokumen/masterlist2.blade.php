@extends('layouts.main')

@section('content')
<style>
  .page-title{font-weight:800;color:#0d6efd;letter-spacing:.3px}
  .divisi-card{width:260px;border-radius:20px;padding:28px 20px;background:#fff;box-shadow:0 8px 20px rgba(13,110,253,.08);transition:.2s;text-align:center}
  .divisi-card:hover{transform:translateY(-4px);box-shadow:0 12px 26px rgba(13,110,253,.12)}
  .divisi-icon{font-size:3rem;line-height:1}
</style>
@php
  $u = auth()->user();
  $isAdmin = (bool)($u->is_admin ?? false) || (($u->role ?? null)==='admin') || (($u->level ?? null)==='Admin')
            || (method_exists($u,'hasRole') && $u->hasRole('admin'));
@endphp

@forelse($divisis as $divisi)
  {{-- batasi non-admin hanya lihat divisinya --}}
  @continue(!$isAdmin && !empty($userDivisiId) && (int)$divisi->id !== (int)$userDivisiId)

@empty
  <div class="text-center text-muted">Belum ada divisi.</div>
@endforelse

@php

  $sdgNames    = [ 'QA SDG','PRODUCTION SDG','MTC MEC, ELC DAN UTL SDG','HR GA SDG','SUPPLY CHAIN DAN WAREHOUSE SDG','SAFETY SDG'
];
  $commonNames = [/* 'LEGAL','ISO' */];

  $u = auth()->user();
  $isAdmin = (bool)($u->is_admin ?? false)
          || (($u->role ?? null) === 'admin')
          || (($u->level ?? null) === 'Admin')
          || (method_exists($u,'hasRole') && $u->hasRole('admin'));
  $userDivisiId = $userDivisiId ?? null;

  $upper = fn($a)=>array_map('strtoupper',$a);
  $allowByName = function ($divName) use ($sdgNames,$commonNames,$upper) {
      $allowed = array_unique(array_merge($upper($sdgNames), $upper($commonNames)));
      return empty($allowed) ? true : in_array(strtoupper($divName), $allowed, true);
  };
@endphp

<section class="section container-fluid">
   <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="page-title text-center mb-4">Master List Dokumen – Sadang</h4>
      <a href="{{ route('dok.dashboard') }}" class="btn btn-sm btn-secondary d-flex align-items-center">
            <i class="fas fa-arrow-left me-1"></i> Kembali
       </a>
  </div>
  <div class="row g-4 justify-content-center">
    @forelse($divisis as $divisi)
      @php
        $tampil = $allowByName($divisi->nama_divisi);
      @endphp

      @continue(!$tampil)
      @continue(!$isAdmin && !empty($userDivisiId) && (int)$divisi->id !== (int)$userDivisiId)

      <div class="col-auto">
        <a href="{{ route('dok.master.sdg.divisi', ['id'=>$divisi->id]) }}" class="text-decoration-none text-dark">
          <div class="divisi-card">
            <div class="divisi-icon text-primary mb-3"><i class="bi bi-folder-fill"></i></div>
            <div class="fw-semibold">{{ strtoupper($divisi->nama_divisi) }}</div>
          </div>
        </a>
      </div>
    @empty
      <div class="text-center text-muted">Belum ada divisi.</div>
    @endforelse
  </div>
</section>
@endsection
