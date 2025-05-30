@extends('layouts.main')

@section('content')
    <div class="container">

        <!-- Menampilkan Nilai Actual jika tersedia -->
        @if (session('nilai_actual'))
            <div class="alert alert-success">
                <strong>Nilai Actual dari Realisasi:</strong> {{ session('nilai_actual') }}%
            </div>
        @endif

        <!-- Form untuk edit -->
        <form action="{{ route('resiko.update', $resiko->id) }}" method="POST">
            @csrf

            <!-- Judul Matriks Before -->
            <div class="row mb-3">
                <h1 class="card-title">TINGKATAN (Matriks Before)</h1>
                <label for="nama_resiko" class="col-sm-2 col-form-label"><strong>Resiko</strong></label>
                <div class="col-sm-10">
                    <textarea name="nama_resiko" class="form-control" rows="3">{{ old('nama_resiko', $resiko->nama_resiko) }}</textarea>
                </div>
            </div>

            <!-- Kriteria Dropdown -->
            <div class="row mb-3">
                <label for="kriteriaSelect" class="col-sm-2 col-form-label"><strong>Kriteria</strong></label>
                <div class="col-sm-4">
                    <select name="kriteria" class="form-control" id="kriteriaSelect" required>
                        <option value="">--Pilih Kriteria--</option>
                        @foreach ($kriteria as $k)
                            <option value="{{ $k->nama_kriteria }}"
                                {{ old('kriteria', $resiko->kriteria) == $k->nama_kriteria ? 'selected' : '' }}>
                                {{ $k->nama_kriteria }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Severity Before -->
            <div class="row mb-3">
                <label for="severity" class="col-sm-2 col-form-label"><strong>Severity/Dampak</strong></label>
                <div class="col-sm-4">
                    <select class="form-select" name="severity" id="severity">
                        <option value="">--Pilih Severity--</option>
                        @if (old('kriteria', $resiko->kriteria))
                            @foreach ($kriteria as $k)
                                @if ($k->nama_kriteria == old('kriteria', $resiko->kriteria))
                                    @php
                                        $vals = explode(',', str_replace(['[', ']', '"'], '', $k->nilai_kriteria));
                                        $descs = explode(',', str_replace(['[', ']', '"'], '', $k->desc_kriteria));
                                    @endphp
                                    @foreach ($vals as $i => $v)
                                        <option value="{{ trim($v) }}"
                                            {{ old('severity', $resiko->severity) == trim($v) ? 'selected' : '' }}>
                                            {{ trim($v) }} - {{ $descs[$i] ?? '' }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <!-- Probability Before -->
            <div class="row mb-3">
                <label for="probability" class="col-sm-2 col-form-label"><strong>Probability / Kemungkinan
                        Terjadi</strong></label>
                <div class="col-sm-4">
                    <select class="form-select" name="probability" id="probability" onchange="calculateTingkatan()">
                        <option value="">--Silahkan Pilih Probability--</option>
                        @foreach ([1 => 'Sangat jarang terjadi', 2 => 'Jarang terjadi', 3 => 'Dapat Terjadi', 4 => 'Sering terjadi', 5 => 'Selalu terjadi'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('probability', $resiko->probability) == $val ? 'selected' : '' }}>
                                {{ $val }}. {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tingkatan Before -->
            <div class="row mb-3">
                <label for="tingkatan" class="col-sm-2 col-form-label"><strong>Tingkatan</strong></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="tingkatan" id="tingkatan"
                        value="{{ old('tingkatan', $resiko->tingkatan) }}" readonly>
                </div>
            </div>

            <hr>
            <hr>

            <h1 class="card-title">ACTUAL RISK (Matriks After)</h1>

            <!-- Severity After -->
            <div class="row mb-3">
                <label for="severityrisk" class="col-sm-2 col-form-label"><strong>Severity/Dampak</strong></label>
                <div class="col-sm-4">
                    <select class="form-select" name="severityrisk" id="severityrisk">
                        <option value="">--Pilih Severity--</option>
                        @if (old('kriteria', $resiko->kriteria))
                            @foreach ($kriteria as $k)
                                @if ($k->nama_kriteria == old('kriteria', $resiko->kriteria))
                                    @php
                                        $vals = explode(',', str_replace(['[', ']', '"'], '', $k->nilai_kriteria));
                                        $descs = explode(',', str_replace(['[', ']', '"'], '', $k->desc_kriteria));
                                    @endphp
                                    @foreach ($vals as $i => $v)
                                        <option value="{{ trim($v) }}"
                                            {{ old('severityrisk', $resiko->severityrisk) == trim($v) ? 'selected' : '' }}>
                                            {{ trim($v) }} - {{ $descs[$i] ?? '' }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <!-- Probability After -->
            <div class="row mb-3">
                <label for="probabilityrisk" class="col-sm-2 col-form-label"><strong>Probability / Kemungkinan
                        Terjadi</strong></label>
                <div class="col-sm-4">
                    <select class="form-select" name="probabilityrisk" id="probabilityrisk" onchange="calculateRisk()">
                        <option value="">--Silahkan Pilih Probability--</option>
                        @foreach ([1 => 'Sangat jarang terjadi', 2 => 'Jarang terjadi', 3 => 'Dapat Terjadi', 4 => 'Sering terjadi', 5 => 'Selalu terjadi'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('probabilityrisk', $resiko->probabilityrisk) == $val ? 'selected' : '' }}>
                                {{ $val }}. {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Risk After -->
            <div class="row mb-3">
                <label for="risk" class="col-sm-2 col-form-label"><strong>Tingkatan</strong></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="risk" id="risk"
                        value="{{ old('risk', $resiko->risk) }}" readonly>
                </div>
            </div>

            <!-- Status (admin only) -->
            @if (auth()->user()->role == 'admin')
                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label"><strong>Status</strong></label>
                    <div class="col-sm-4">
                        <select name="status" class="form-control">
                            <option value="">--Pilih Status--</option>
                            <option value="OPEN" {{ $resiko->status == 'OPEN' ? 'selected' : '' }}>OPEN</option>
                            <option value="ON PROGRES" {{ $resiko->status == 'ON PROGRES' ? 'selected' : '' }}>ON PROGRES
                            </option>
                            <option value="CLOSE" {{ $resiko->status == 'CLOSE' ? 'selected' : '' }}>CLOSE</option>
                        </select>
                    </div>
                </div>
            @endif

            <!-- Buttons -->
            <a class="btn btn-danger" href="{{ route('riskregister.tablerisk', ['id' => $three]) }}">
                <i class="ri-arrow-go-back-line"></i>
            </a>
            <button type="submit" class="btn btn-success">
                Update <i class="ri-save-3-fill"></i>
            </button>
        </form>
    </div>

    <style>
        /* wrapping teks di severity dropdown */
        #severity option,
        #severityrisk option {
            white-space: normal;
            word-wrap: break-word;
        }
    </style>

    <script>
        const kriteriaData = @json($kriteria);

        function updateSeverityDropdown(targetId) {
            const selKrit = document.getElementById('kriteriaSelect').value;
            const sel = document.getElementById(targetId);
            sel.innerHTML = '<option value="">--Pilih Severity--</option>';
            if (!selKrit) return;
            kriteriaData
                .filter(k => k.nama_kriteria === selKrit)
                .forEach(k => {
                    const vals = k.nilai_kriteria.replace(/[\[\]"]+/g, '').split(',');
                    const desc = k.desc_kriteria.replace(/[\[\]"]+/g, '').split(',');
                    vals.forEach((v, i) => {
                        const o = document.createElement('option');
                        o.value = v.trim();
                        o.textContent = v.trim() + ' - ' + (desc[i] || '');
                        sel.appendChild(o);
                    });
                });
        }

        document.getElementById('kriteriaSelect').addEventListener('change', function() {
            updateSeverityDropdown('severity');
            updateSeverityDropdown('severityrisk');
            // reset probabilities
            document.getElementById('probability').value = '';
            document.getElementById('probabilityrisk').value = '';
            if (typeof calculateTingkatan === 'function') calculateTingkatan();
            if (typeof calculateRisk === 'function') calculateRisk();
        });

        document.getElementById('severity').addEventListener('change', function() {
            document.getElementById('probability').value = '';
            if (typeof calculateTingkatan === 'function') calculateTingkatan();
        });

        document.getElementById('severityrisk').addEventListener('change', function() {
            document.getElementById('probabilityrisk').value = '';
            if (typeof calculateRisk === 'function') calculateRisk();
        });

        function calculateTingkatan() {
            var p = +document.getElementById('probability').value;
            var s = +document.getElementById('severity').value;
            var t = '';
            if (p && s) {
                var score = p * s;
                if (score <= 2) t = 'LOW';
                else if (score <= 4) t = 'MEDIUM';
                else if (score <= 25) t = 'HIGH';
            }
            document.getElementById('tingkatan').value = t;
        }

        function calculateRisk() {
            var p = +document.getElementById('probabilityrisk').value;
            var s = +document.getElementById('severityrisk').value;
            var r = '';
            if (p && s) {
                var score = p * s;
                if (score <= 2) r = 'LOW';
                else if (score <= 4) r = 'MEDIUM';
                else if (score <= 25) r = 'HIGH';
            }
            document.getElementById('risk').value = r;
        }
    </script>
@endsection
