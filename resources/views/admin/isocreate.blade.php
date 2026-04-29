@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3> Tambah Jenis ISO</h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('iso.store') }}">
                        @csrf 
                        <div class="mb-3">
                            <label for="jenis_iso" class="form-label">Jenis ISO</label>
                            <input 
                                type="text" class="form-control @error('jenis_iso') is-invalid @enderror" id="jenis_iso" name="jenis_iso" value="{{ old('jenis_iso') }}"  required autofocus
                            >
                            @error('jenis_iso')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                         <button type="submit" class="btn btn-primary">Simpan Jenis iSO</button>
                        
                        {{-- Tombol kembali --}}
                        <a href="#" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
             <div class="card">
        <div class="card-header">
            Data Jenis ISO
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Jenis ISO</th>
                        <th width="15%">Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisIso as $index => $iso)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $iso->jenis_iso }}</td>
                            <td>{{ $iso->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                Belum ada data ISO
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection