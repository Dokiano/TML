<div class="row mb-3 align-items-center">
    <label class="col-sm-2 col-form-label mt-2"><strong>Pihak yang Berkepentingan</strong></label>
    <div class="col-sm-10">
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button"
                id="dropdownDivisiAkses" data-bs-toggle="dropdown" aria-expanded="false">
                @if (old('pihak') || $selectedDivisi)
                    {{ implode(', ', old('pihak', $selectedDivisi ?? [])) }}
                @else
                    Pilih Pihak Berkepentingan
                @endif
            </button>
            <ul class="dropdown-menu checkbox-group" aria-labelledby="dropdownDivisiAkses">

                {{-- Select All --}}
                <li class="px-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="select-all">
                        <label class="form-check-label" for="select-all">Pilih Semua</label>
                    </div>
                </li>

                {{-- Opsi Divisi --}}
                @foreach ($divisi as $d)
                    <li class="px-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pihak[]" value="{{ $d->nama_divisi }}"
                                id="divisi{{ $d->id }}" data-id="{{ $d->id }}"
                                @if (in_array($d->nama_divisi, old('pihak', $selectedDivisi ?? []))) checked @endif>
                            <label class="form-check-label" for="divisi{{ $d->id }}">
                                {{ $d->nama_divisi }}
                            </label>
                        </div>
                        <div class="mt-2 ps-4" id="ketDivisi{{ $d->id }}" style="display: none;">
                            <input type="text" class="form-control" name="keterangan[{{ $d->nama_divisi }}]"
                                id="keteranganInput-{{ $d->id }}" placeholder="Keterangan {{ $d->nama_divisi }}"
                                value="{{ old('keterangan.' . $d->nama_divisi) }}">
                        </div>
                    </li>
                @endforeach

                {{-- Opsi Other --}}
                <li class="px-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pihak[]" value="Other" id="otherCheckbox"
                            @if (in_array('Other', old('pihak', []))) checked @endif>
                        <label class="form-check-label" for="otherCheckbox">Other</label>
                    </div>
                    <div class="mt-2 ps-4" id="otherInputContainer" style="display: none;">
                        <input type="text" class="form-control mb-2" name="pihak_other" id="pihakOther"
                            placeholder="Masukkan Pihak Lainnya" value="{{ old('pihak_other') }}">
                        <input type="text" class="form-control" name="keterangan_other" id="keteranganOther"
                            placeholder="Keterangan Other" value="{{ old('keterangan_other') }}">
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
