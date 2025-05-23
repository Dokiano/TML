@extends('layouts.main')

@section('content')
    <!-- Pie Chart Library CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8, #e2e2e2);
        }

        .animate-card {
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .animate-card:hover {
            transform: scale(1.05);
            background-color: #ffffff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .animate-card:active {
            transform: scale(0.95);
        }

        .clicked {
            animation: clickEffect 0.3s forwards;
        }

        @keyframes clickEffect {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(0.95);
            }

            100% {
                transform: scale(1);
            }
        }

        .card-icon {
            background-color: #007bff;
            padding: 12px;
            border-radius: 50%;
            font-size: 32px;
            color: white;
        }

        h6 {
            margin: 0;
            font-weight: bold;
            color: #333;
            line-height: 1.5;
        }

        .alert {
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>

    <section class="section dashboard">
        {{-- <?php
        dd($ppk);
        ?> --}}
        @foreach ($ppk as $item)
            @php
                $nomor_surat = $item->nomor_surat;
                $pembuatUser = App\Models\User::find($item->pembuat);
                $penerimaUser = App\Models\User::find($item->penerima);

                $updated_at = \Carbon\Carbon::parse($item->formppk2->tgl_pencegahan);
                $isExpired = $updated_at->diffInMonths(now()) >= 1;
                $months = $updated_at->diffInDays(now());
                $currentMonth = 30 - $months;
                $daysPassed = $updated_at->diffInDays(now());

                // Cek apakah email sudah dikirim (menggunakan status di database)
                $emailSent = $item->emailverifikasi;

                // Perbaiki deklarasi array dengan tanda '=>'
                $data_email = [
                    'judul' => 'Verifikasi PPK',
                    'sender_name' => "{$item->pembuatUser->email}, {$item->divisipembuat}",
                    'subject' => "Segera verifikasi PPK No. {$nomor_surat}",
                    'senderView' => "$penerimaUser->nama_user, {$item->divisipenerima}",
                    'paragraf1' => "Dear {$pembuatUser->nama_user}, {$item->divisipembuat}", // Menggunakan nama_user dari model User
                    'paragraf2' => 'Segera lakukan verifikasi PPK dengan nomor surat :',
                    'paragraf3' => $nomor_surat,
                    'paragraf4' => $item->formppk2->identifikasi,
                    'paragraf5' => 'yang telah diidentifikasi oleh :',
                    'paragraf7' => 'Untuk menambahkan Evidence dan update progress silahkan klik link di bawah ini',
                ];
            @endphp
            @php
                $statusInvalid = in_array($item->statusppk, ['CANCEL', 'IDENTIFIKASI ULANG', 'CLOSE (Tidak Efektif)']);
                $form2 = $item->formppk2 ?? null;
                $signaturePenerima = $form2?->signaturepenerima;
                $form3 = $item->formppk3 ?? null;
                $form2Valid =
                    !empty($form2?->pencegahan) && !empty($form2?->penanggulangan) && !empty($form2?->identifikasi);
            @endphp

            @if (!$statusInvalid && $signaturePenerima && is_null($form3?->verifikasi) && $form2Valid && $isExpired && !$emailSent)
                @php
                    // Kirim email jika expired dan email belum dikirim
                    Mail::to($item->emailpembuat)
                        ->cc(array_merge((array) $item->cc_email, [$item->emailpenerima]))
                        ->send(new \App\Mail\KirimEmail($data_email));

                    // Update status email sudah terkirim di database
                    $item->emailverifikasi = true;
                    $item->save();
                @endphp
            @endif
        @endforeach


        <br>
        <div class="container-fluid">
            <div class="row justify-content-center">

                @if (session('success'))
                    <div class="alert alert-success" style="border-radius: 0">
                        {{ session('success') }} {{ Auth::user()->nama_user }} 👋
                    </div>
                @endif

                <!-- Card Container -->
                <div class="d-flex flex-wrap justify-content-center align-items-start">

                    <!-- Risk & Opportunity Card -->
                    <div class="col-xxl-4 col-md-6 mb-4">
                        <div class="card info-card sales-card">
                            <button class="card-body btn btn-light animate-card"
                                style="border: none; padding: 0; text-align: left;"
                                onclick="window.location.href='{{ route('dashboard.index') }}'">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon">
                                        <i class="bi bi-file-text-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>Risk & Opportunity <br>Register</h6>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <!-- End Risk & Opportunity Card -->

                    <!-- PPK Card -->
                    <!-- HAPUS TEKS: d-none untuk menampilkan PPK PERSIS DIBAWAH -->
                    <div class="col-xxl-4 col-md-6 mb-4">
                        <div class="card info-card sales-card">
                            <button class="card-body btn btn-light animate-card"
                                style="border: none; padding: 0; text-align: left;"
                                onclick="window.location.href='{{ route('ppk.dashboardPPK') }}'">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon">
                                        <i class="bi bi-bar-chart-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>Proses Peningkatan <br>Kinerja (PPK)</h6>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <!-- End PPK Card -->
                </div><!-- End Card Container -->




                <!-- Include Chart.js -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Pass the PHP variables to JavaScript as JSON
                        const statusDetails = @json($statusDetails);
                        const tingkatanDetails = @json($tingkatanDetails);

                        // Status Pie Chart
                        const statusPieChart = new Chart(document.getElementById('statusPieChart'), {
                            type: 'pie',
                            data: {
                                labels: @json($statusCounts->keys()),
                                datasets: [{
                                    data: @json($statusCounts->values()),
                                    backgroundColor: ['#FFD700', '#FF6347', '#32CD32']
                                }]
                            },
                            options: {
                                onClick: (event, elements) => {
                                    if (elements.length > 0) {
                                        const segmentIndex = elements[0].index;
                                        const selectedStatus = statusPieChart.data.labels[segmentIndex];

                                        // Filter data by selected status
                                        fetchFilteredData('status', selectedStatus);
                                    }
                                }
                            }
                        });

                        // Tingkatan Pie Chart
                        const tingkatanPieChart = new Chart(document.getElementById('tingkatanPieChart'), {
                            type: 'pie',
                            data: {
                                labels: @json($tingkatanCounts->keys()),
                                datasets: [{
                                    data: @json($tingkatanCounts->values()),
                                    backgroundColor: ['#FF6347', '#FFD700', '#32CD32']
                                }]
                            },
                            options: {
                                onClick: (event, elements) => {
                                    if (elements.length > 0) {
                                        const segmentIndex = elements[0].index;
                                        const selectedTingkatan = tingkatanPieChart.data.labels[segmentIndex];

                                        // Filter data by selected tingkatan
                                        fetchFilteredData('tingkatan', selectedTingkatan);
                                    }
                                }
                            }
                        });

                        // Function to fetch filtered data
                        function fetchFilteredData(filterType, filterValue) {
                            let filteredData = [];

                            // Check which chart was clicked and filter the data accordingly
                            if (filterType === 'status') {
                                filteredData = statusDetails[filterValue] || [];
                            } else if (filterType === 'tingkatan') {
                                filteredData = tingkatanDetails[filterValue] || [];
                            }

                            displayDataInModal(filteredData, filterType, filterValue);
                        }

                        // Function to display data in modal
                        function displayDataInModal(data, filterType, filterValue) {
                            const modalId = filterType === 'status' ? '#statusModal' : '#tingkatanModal';
                            const modalTitle = filterType === 'status' ? 'Status Data' : 'Tingkatan Data';

                            const modalBody = document.querySelector(`${modalId} .modal-body`);
                            modalBody.innerHTML = `
                <h5>${modalTitle} - ${filterValue}</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Issue</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.map((resiko, index) => `<tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${index + 1}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${resiko.nama_resiko}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>`
                        ).join('')}
                    </tbody>
                </table>
            `;

                            // Show the modal
                            $(modalId).modal('show');
                        }
                    });
                </script>
            @endsection
