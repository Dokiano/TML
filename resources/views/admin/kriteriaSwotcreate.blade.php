@extends('layouts.main') 

@section('content')
<div class="container">
    <form method="POST" action="{{ route('kriteriaSwot.store') }}">
        @csrf 

        <div class="mb-3">
            <label for="swot_id" class="form-label">Pilih Jenis SWOT</label>
            {{-- Nama input sekarang adalah swot_id --}}
            <select class="form-select @error('swot_id') is-invalid @enderror" id="swot_id" name="swot_id" required>
                <option value="">-- Pilih --</option>
                {{-- Loop melalui data swots yang dikirim dari controller --}}
                @foreach ($swots as $swot)
                    <option value="{{ $swot->id }}" {{ old('swot_id') == $swot->id ? 'selected' : '' }}>
                        {{ $swot->jenis_swot }}
                    </option>
                @endforeach
            </select>
            @error('swot_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        
        {{-- Input kriteria tetap sama --}}
        <div class="mb-3">
            <label for="kriteria_swot" class="form-label">Deskripsi Kriteria</label>
            <textarea class="form-control @error('kriteria_swot') is-invalid @enderror" id="kriteria_swot" name="kriteria_swot" rows="3" required>{{ old('kriteria_swot') }}</textarea>
            @error('kriteria_swot')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        

        <button type="submit" class="btn btn-success">Simpan Kriteria & Buat Kode Otomatis</button>
    </form>
</div>
@endsection