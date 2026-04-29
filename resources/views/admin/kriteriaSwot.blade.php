@extends('layouts.main') 

@section('title', 'Dashboard Kriteria SWOT')
@section('content')
<div class="container-fluid">
    <h2>Dashboard Isu Internal (SWOT)</h2>
    <p class="text-muted">Ringkasan dan Daftar Lengkap Kriteria SWOT yang sudah terinput.</p>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <div class="mb-4 d-flex justify-content-end">
        <a href="{{ route('kriteriaSwot.create') }}" class="btn btn-primary me-2">
            <i class="fas fa-plus"></i> Tambah Kriteria Baru
        </a>
         <a href="{{ route('admin.swotcreate') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Jenis Swot
        </a>
    </div>
    <div class="row mb-4">
        @php
            $countBySwotType = $kriteriaSwots->groupBy('swot.jenis_swot')->map->count();
           
        @endphp
        
        @foreach($countBySwotType as $jenis => $count)
            <div class="col-lg-3 col-md-6 mb-3 d-flex align-items-stretch"> 
                <div class="card bg-light h-100"> 
                    <div class="card-body text-center"> 
                        <h5 class="card-title">{{ $jenis }} </h5>
                        <p class="card-text fs-3">{{ $count }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card p-3 mb-4">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <label for="swot-dropdown-filter" class="form-label mb-2">Filter Berdasarkan Jenis SWOT:</label>
                <select class="form-select swot-filter" id="swot-dropdown-filter">
                    <option value="all" selected>Semua Strategi SWOT</option>
                    <option value="Strength Threat">Strength Threat</option>
                    <option value="Strength Opportunity">Strength Opportunity</option>
                    <option value="Weakness Threat">Weakness Threat</option>
                    <option value="Weakness Opportunity">Weakness Opportunity</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kriteria SWOT</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Strategi Swot</th>
                            <th>Kategori Swot</th>
                            <th>Kriteria SWOT</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kriteriaSwots as $kriteria)
                            <tr data-swot-type="{{ $kriteria->swot->jenis_swot ?? 'N/A' }}"> 
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary text-white">{{ $kriteria->kode_swot }}</span></td>
                                <td>
                                    <strong>{{ $kriteria->swot->jenis_swot ?? 'N/A' }}</strong>
                                </td> 
                                <td><span class="badge bg-secondary text-white">{{ $kriteria->kategori_swot }}</span></td>
                                <td>{{ $kriteria->kriteria_swot }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada Kriteria SWOT yang ditambahkan. Silakan <a href="{{ route('kriteriaSwot.create') }}">tambah baru</a>.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    
    // Fungsi untuk menerapkan filter
    function applySwotFilter() {
        // Ambil nilai yang dipilih dari dropdown
        var selectedSwotType = $('#swot-dropdown-filter').val();
        
        // Iterasi setiap baris di tabel
        $('#dataTable tbody tr').each(function() {
            var row = $(this);
            var swotType = row.data('swot-type');
            
            // Cek kondisi filter
            // Tampilkan jika nilai 'all' dipilih, ATAU jika jenis SWOT baris cocok dengan yang dipilih
            if (selectedSwotType === 'all' || swotType === selectedSwotType) {
                row.show(); // Tampilkan baris
            } else {
                row.hide(); // Sembunyikan baris
            }
        });
        
        // Opsional: Logika untuk pesan 'empty' bisa ditambahkan di sini jika diperlukan
    }

    // Panggil fungsi filter setiap kali dropdown diubah
    $('#swot-dropdown-filter').on('change', applySwotFilter);

    // Panggil sekali saat halaman dimuat (untuk menerapkan filter default 'all')
    applySwotFilter();
});
</script>
@endpush