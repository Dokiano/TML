<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDENTIFIKASI, PENILAIAN, DAN PENGENDALIAN RISIKO PENYUAPAN</title>
    <style>
        h2 {
            text-align: center;
            background-color: #56dbc5;
            padding: 10px;
            page-break-after: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7px;
            page-break-inside: auto;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 3px;
            text-align: left;
            word-wrap: break-word;
            /* Allow text to wrap if it's too long */
        }

        th {
            background-color: #a6f119;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        /* Align specific columns to the top */
        .align-top {
            vertical-align: top;
        }

        .align-bottom {
            vertical-align: bottom;
        }

        .align-left {
            text-align: left;
        }

        .align-center {
            text-align: center;
        }

        .separator {
            border: none;
            border-top: 1px solid black;
            margin: 0;
            padding: 0;
        }

        /* Adjust column widths */
        .col-int-ext {
            width: 30px;
            text-align: center;
        }

        .col-tindakan {
            width: 150px;
            text-align: left;
        }

        .col-risiko {
            width: 80px;
        }

        .col-pihak {
            width: 150px;
            text-align: center;
        }

        .col-target-pic {
            width: 60px;
        }

        .col-pihakk {
            width: 50px;
            text-align: center;
        }


        /* Allow for flexible column width */
        .col-flexible {
            width: auto;
            /* This will allow the column to adjust width based on content */
            min-width: 100px;
            /* Optional: Set a minimum width for flexibility */
        }
    </style>
</head>

<body>
    

    <table style="width:100%; border-collapse:collapse; margin-bottom:5px;">
        <tr>
           <td style="width:15%; border:1px solid black; text-align:center; padding: 5px; vertical-align: middle;">
            {{-- Mengarah ke public/admin/img/logobg-ic.png --}}
                <img src="{{ public_path('admin/img/tatalogamgroup.png') }}" alt="Logo" style="width: 60px; height: auto;">
            </td>
           
            <td style="width:70%; border:1px solid black;">
                <div style="text-align:center; font-weight:bold; font-size:14px; padding:10px; background:#56dbc5;">
                    IDENTIFIKASI, PENILAIAN, DAN PENGENDALIAN RISIKO PENYUAPAN
                </div>
            </td>
           {{--  <td style="width:30%; border:1px solid black; padding:0;">
                <table style="width:100%; border-collapse:collapse; font-size:8px;">
                    <tr>
                        <td style="border:1px solid black; width:40%;">No Dokumen</td>
                        <td style="border:1px solid black;">MJC-MR-MR-MAP-F03</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid black;">Tanggal Efektif</td>
                        <td style="border:1px solid black;">02-Aug-21</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid black;">Revisi</td>
                        <td style="border:1px solid black;">00</td>
                    </tr>
                </table>
            </td> --}}
        </tr>
    </table>
   <div style="width: 100%; text-align: right;">
    FM.IM.39.00
</div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2" class="col-bagian">Bagian</th>
                <th rowspan="2" style="width: 300px;">Nama Proses</th>
                <th rowspan="2" style="width: 250px">Aktifitas Kunci</th>
                <th rowspan="2" style="width: 250px;">Potensi Risk Penyuapan</th>
                <th rowspan="2" style="width: 300px;">Skema Penyuapan / Modus Operandi</th>
                <th rowspan="2">*S</th>
                <th rowspan="2">*P</th>
                <th rowspan="2">Level</th>
                <th colspan="2">Tindakan Terhadap Risiko</th>
                <th colspan="3">Sisa Risiko</th>  
                <th rowspan="2">Rencana Tindakan / Mitigasi</th>  
            </tr>
            <tr>
                <th class="col-tindakan">Tindakan</th>
                <th class="col-acuan">Acuan</th>
                <th>*S</th>
                <th>*P</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($formattedData as $index => $data)
            @php
              $tindak = is_array($data['tindak_lanjut'] ?? null) ? $data['tindak_lanjut'] : array_filter([(string)($data['tindak_lanjut'] ?? '')]);
              $acuan  = is_array($data['acuan'] ?? null) ? $data['acuan'] : array_filter([(string)($data['acuan'] ?? '')]);
              $preLevel = $data['scores'] ?? (($data['severity'] ?? 0) * ($data['probability'] ?? 0));
              $postLevel = ($data['severityrisk'] ?? 0) * ($data['probabilityrisk'] ?? 0);
            @endphp
                <tr>
                    <td class="align-top">{{ $index + 1 }}</td>
                    <td class="align-top">{{ $data['bagian'] ?? '' }}</td>
                    <td class="align-top">{{ $data['issue'] }}</td>
                    <td class="align-top">{{ $data['aktifitas_kunci'] ?? '' }}</td>
                    <td class="col-risiko align-top">{{ $data['risiko'] }}</td>
                    <td class="align-top">{{ $data['before'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['severity'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['probability'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['score'] }}</td>
                    <td class="align-top">
                      <div class="list-line">
                        @forelse($tindak as $i => $t)
                          <div>{{ $i+1 }}. {{ $t }}</div>
                        @empty
                          <div>-</div>
                        @endforelse
                      </div>
                    </td>
                    <td class="align-top">
                      <div class="list-line">
                        @forelse($acuan as $i => $a)
                          <div>{{ $i+1 }}. {{ $a }}</div>
                        @empty
                          <div>-</div>
                        @endforelse
                      </div>
                    </td>
                    <td class="col-int-ext align-top">{{ $data['severityrisk'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['probabilityrisk'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['scorerisk'] }}</td>
                    <td class="align-top">{{ $data['after'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- ===== TABEL RESUME ===== --}}
{{-- ===== TABEL RESUME ===== --}}
@php
    $resumeBefore = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];
    $resumeAfter  = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];

    foreach ($formattedData as $item) {
        // Di PDF: tingkatan & risk adalah STRING langsung (bukan array)
        $levelBefore = strtoupper($item['tingkatan'] ?? '');
        if (isset($resumeBefore[$levelBefore])) {
            $resumeBefore[$levelBefore]++;
        }

        $levelAfter = strtoupper($item['risk'] ?? '');
        if (!isset($resumeAfter[$levelAfter]) || $levelAfter === '') {
            $levelAfter = $levelBefore; // fallback ke before
        }
        if (isset($resumeAfter[$levelAfter])) {
            $resumeAfter[$levelAfter]++;
        }
    }

    $totalBefore = array_sum($resumeBefore);
    $totalAfter  = array_sum($resumeAfter);
@endphp

<br>
<table style="width: auto; min-width: 350px; border-collapse: collapse; font-size: 8px; margin-top: 10px;">
    <thead>
        <tr style="background-color: #a6f119; text-align: center;">
            <th style="border: 1px solid black; padding: 4px; width: 30px;">No</th>
            <th style="border: 1px solid black; padding: 4px;">Kriteria Level Risiko</th>
            <th style="border: 1px solid black; padding: 4px;">Jumlah Risk (Awal)</th>
            <th style="border: 1px solid black; padding: 4px;">Jumlah Risk (Setelah Mitigasi)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">1</td>
            <td style="border: 1px solid black; padding: 4px;">
                <span style="background-color: #92d050; padding: 2px 8px; font-weight: bold;">
                    Risiko Rendah (1 - 3)
                </span>
            </td>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ $resumeBefore['LOW'] }}</td>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ $resumeAfter['LOW'] }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">2</td>
            <td style="border: 1px solid black; padding: 4px;">
                <span style="background-color: #ffff00; padding: 2px 8px; font-weight: bold;">
                    Risiko Sedang (4 - 12)
                </span>
            </td>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ $resumeBefore['MEDIUM'] }}</td>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ $resumeAfter['MEDIUM'] }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">3</td>
            <td style="border: 1px solid black; padding: 4px;">
                <span style="background-color: #ff0000; color: white; padding: 2px 8px; font-weight: bold;">
                    Risiko Tinggi (13- 25)
                </span>
            </td>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ $resumeBefore['HIGH'] }}</td>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ $resumeAfter['HIGH'] }}</td>
        </tr>
        <tr style="background-color: #e0e0e0; font-weight: bold;">
            <td colspan="2" style="border: 1px solid black; padding: 4px; text-align: right;">Total</td>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ $totalBefore }}</td>
            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ $totalAfter }}</td>
        </tr>
    </tbody>
</table>
{{-- ===== END TABEL RESUME ===== --}}
</body>

</html>