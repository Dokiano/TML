@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3> Tambah Jenis SWOT Baru</h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('swot.store') }}">
                        @csrf 
                        <div class="mb-3">
                            <label for="jenis_swot" class="form-label">Jenis SWOT</label>
                            <input 
                                type="text" class="form-control @error('jenis_swot') is-invalid @enderror" id="jenis_swot" name="jenis_swot" value="{{ old('jenis_swot') }}"  required autofocus
                            >
                            @error('jenis_swot')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                         <label for="sifat_swot_id" class="form-label">Isu SWOT</label>
                         <select name="sifat_swot_id" id="sifat_swot_id"
                                 class="form-select @error('sifat_swot_id') is-invalid @enderror">
                             <option value="" selected disabled>Pilih isu SWOT</option>
                             @foreach($sifatSwots as $sifat)
                                 <option value="{{ $sifat->id }}">{{ $sifat->isu_swot }}</option>
                             @endforeach
                         </select>
                         @error('sifat_swot_id')
                             <div class="invalid-feedback">{{ $message }}</div>
                         @enderror

                        <button type="submit" class="btn btn-primary">Simpan Jenis SWOT</button>
                        
                        {{-- Tombol kembali --}}
                        <a href="{{ route('kriteriaSwot.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection