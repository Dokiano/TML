@extends('layouts.main')

@section('content')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Kriteria</h5>
                        <a href="{{ route('admin.kriteriacreate') }}" style="border-radius: 0px"title="Buat Kriteria"
                            class="btn btn-sm btn-success mb-3">
                            <i class="bi bi-plus-square"></i> Add Kriteria
                        </a>

                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('admin.kriteria') }}" class="mb-4" id="filterForm">
                            <div class="row g-2">

                                {{-- 1. Dropdown Divisi --}}
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold mb-1">Divisi</label>
                                    <select name="divisi_id" class="form-select" style="border-radius: 0px"
                                        onchange="document.getElementById('filterForm').submit()">
                                        <option value="">-- Pilih Divisi --</option>
                                        @foreach ($divisiList as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ request('divisi_id') == $id ? 'selected' : '' }}>
                                                {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 2. Dropdown Jenis ISO --}}
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold mb-1">Jenis ISO</label>
                                    <select name="jenis_iso_id" class="form-select" style="border-radius: 0px"
                                        onchange="document.getElementById('filterForm').submit()">
                                        <option value="">-- Pilih Jenis ISO --</option>
                                        @foreach ($jenisIsoList as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ request('jenis_iso_id') == $id ? 'selected' : '' }}>
                                                {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 3. Dropdown Nama Kriteria (kosong jika belum pilih divisi & iso) --}}
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold mb-1">Nama Kriteria</label>
                                    <select name="nama_kriteria" class="form-select" style="border-radius: 0px"
                                        {{ (!request('divisi_id') || !request('jenis_iso_id')) ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Nama Kriteria --</option>
                                        @foreach ($namaKriteriaList as $nama)
                                            <option value="{{ $nama }}"
                                                {{ request('nama_kriteria') == $nama ? 'selected' : '' }}>
                                                {{ $nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 4. Tombol Filter & Reset --}}
                                <div class="col-md-3 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-primary" style="border-radius: 0px">
                                        <i class="bi bi-search"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.kriteria') }}" class="btn btn-secondary"
                                        style="border-radius: 0px">
                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                    </a>
                                </div>

                            </div>
                        </form>
                        <!-- End Filter Form -->

                        <!-- Tampilkan pesan sukses atau error -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('danger'))
                            <div class="alert alert-danger">
                                {{ session('danger') }}
                            </div>
                        @endif

                        <!-- Kriteria Data Table -->
                        <table class="table table-striped table-bordered" style="font-size: 15px;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 80px;">No</th>
                                    <th scope="col">Nama Kriteria</th>
                                    <th scope="col">Deskripsi & Nilai</th>
                                    <th scope="col" style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kriteria as $k)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $k->nama_kriteria }}</td>

                                        <!-- Tampilkan Deskripsi dan Nilai -->
                                        <td>
                                            <table class="table table-bordered table-sm">
                                                <tbody>
                                                    @php
                                                        // Pisahkan string menggunakan tanda koma
                                                        $descArray = explode(',', $k->desc_kriteria);
                                                        $nilaiArray = explode(',', $k->nilai_kriteria);
                                                    @endphp

                                                    @foreach ($descArray as $index => $desc)
                                                        <tr>
                                                            <td style="width: 70%;">{{ $desc }}</td>
                                                            <td style="width: 30%;  text-align: center;">
                                                                {{ $nilaiArray[$index] ?? 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>

                                        <td style="display: flex; align-items: center; gap: 5px;">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.kriteriaedit', $k->id) }}"
                                                class="btn btn-sm btn-success" title="Edit" style="border-radius: 0px">
                                                <i class="bx bx-edit"></i>
                                            </a>

                                            <!-- Form Hapus -->
                                            <form action="{{ route('admin.kriteriadestroy', $k->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                    style="border-radius: 0px">
                                                    <i class="ri ri-delete-bin-fill"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data kriteria</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- End Kriteria Data Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection