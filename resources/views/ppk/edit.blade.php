@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="card shadow-lg border-0">
            <div class="border border-2 border-dark">
                <h5 class="card-title text-center text-uppercase fw-bold text-dark">Edit Proses Peningkatan Kinerja
                </h5>
                <div class="mb-2 border-dark" style="border: 1px solid;"></div>
                <div class="px-4">

                    <form method="POST" action="{{ route('ppk.update', $ppk->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-4">
                                    <strong>KEPADA</strong>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="penerima" class="form-label fw-bold">Penerima</label>
                                    </div>
                                    <div class="col">
                                        <select id="penerima" name="penerima" class="form-select">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" data-email="{{ $user->email }}"
                                                    data-divisi="{{ $user->divisi }}"
                                                    {{ old('penerima', $ppk->penerima) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->nama_user }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="divisipenerima" class="form-label fw-bold">Departemen</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" id="divisipenerima" name="divisipenerima" class="form-control"
                                            value="{{ old('divisipenerima', $ppk->divisipenerima) }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-4">
                                    <span class="form-label">PPK NO.
                                        {{ old('nomor_surat', $ppk->nomor_surat) }}</span>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="pembuat" class="form-label fw-bold">Pembuat / Inisiator</label>
                                    </div>
                                    <div class="col-md-6">
                                        <select id="pembuat" name="pembuat" class="form-select"
                                            {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" data-email="{{ $user->email }}"
                                                    data-divisi="{{ $user->divisi }}"
                                                    {{ old('pembuat', $ppk->pembuat) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->nama_user }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if (auth()->user()->role !== 'admin')
                                            <select id="pembuat" name="pembuat" class="form-select d-none">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" data-email="{{ $user->email }}"
                                                        data-divisi="{{ $user->divisi }}"
                                                        {{ old('pembuat', $ppk->pembuat) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->nama_user }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="divisipembuat" class="form-label fw-bold">Departemen</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="divisipembuat" name="divisipembuat" class="form-control"
                                            value="{{ old('divisipembuat', $ppk->divisipembuat) }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="divisipembuat" class="form-label fw-bold">Tanggal terbit</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="created_at" name="created_at" class="form-control"
                                            value="{{ \Carbon\Carbon::parse(old('created_at', $ppk->created_at))->format('d/m/Y') }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-none">
                            <div class="col-md-6">
                                <label for="emailpembuat" class="form-label fw-bold">Email Inisiator</label>
                                <input type="email" id="emailpembuat" name="emailpembuat" class="form-control"
                                    value="{{ old('emailpembuat', $ppk->emailpembuat) }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="emailpenerima" class="form-label fw-bold">Email Penerima</label>
                                <input type="email" id="emailpenerima" name="emailpenerima" class="form-control"
                                    value="{{ old('emailpenerima', $ppk->emailpenerima) }}" readonly>
                            </div>
                        </div>

                        <!-- Judul PPK -->
                        <div class="mb-3">
                            <label for="inputJudul" class="form-label fw-bold">1. Jelaskan ketidaksesuaian yang terjadi atau
                                peningkatan yang akan dibuat</label>
                            <div class="mb-3">
                                <label class="form-label">Jenis</label>
                                @php
                                    $selectedJenis = explode(',', $ppk->jenisketidaksesuaian ?? '');
                                @endphp
                                <div class="row">
                                    @foreach (['SISTEM', 'PROSES', 'PRODUK', 'AUDIT'] as $jenis)
                                        <div class="col d-flex justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="jenisketidaksesuaian[]" value="{{ $jenis }}"
                                                    {{ in_array($jenis, $selectedJenis) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $jenis }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <textarea id="judul" name="judul" class="form-control" placeholder="Masukkan Judul PPK" rows="3">{{ old('judul', $ppk->judul) }}</textarea>

                            {{-- Auto resizing textarea --}}
                            <script>
                                // Mendapatkan elemen textarea
                                const textarea = document.getElementById('judul');

                                // Fungsi untuk mengubah tinggi textarea sesuai dengan isi
                                function autoResizeTextarea() {
                                    textarea.style.height = 'auto'; // Reset tinggi terlebih dahulu
                                    textarea.style.height = (textarea.scrollHeight) + 'px'; // Set tinggi sesuai dengan scrollHeight
                                }

                                // Menambahkan event listener untuk input
                                textarea.addEventListener('input', autoResizeTextarea);

                                // Panggil fungsi untuk mengatur tinggi saat halaman pertama kali dimuat
                                autoResizeTextarea();
                            </script>
                        </div>

                        <div class="mb-3" id="pic1-other">
                            <input type="hidden" name="signature" id="signature" class="form-control"
                                value="{{ old('signature', $ppk->signature) }}">
                        </div>

                        <div class="row">
                            <!-- Evidence -->
                            <div class="col-md-7">
                                <label for="evidence" class="form-label fw-bold">Evidence</label>
                                @php
                                    $evidences = json_decode($ppk->evidence ?? '[]', true);
                                @endphp

                                @if (is_array($evidences) && count($evidences) > 0)
                                    <div id="evidencePreviewContainer"
                                        class="d-flex flex-wrap justify-content-between mt-3">
                                        @foreach ($evidences as $index => $evidence)
                                            @php
                                                $filePath = asset('storage/' . $evidence);
                                                $fileExtension = pathinfo($evidence, PATHINFO_EXTENSION);
                                            @endphp
                                            <div class="evidence-item text-center me-3 mb-2">
                                                @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png']))
                                                    <img src="{{ $filePath }}" alt="Evidence Image"
                                                        class="img-thumbnail" style="max-width: 150px; height: auto;">
                                                @else
                                                    <a href="{{ $filePath }}" target="_blank"
                                                        title="{{ basename($evidence) }}"
                                                        style="display: inline-block; max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                                        {{ basename($evidence) }}
                                                    </a>
                                                @endif
                                                <br>
                                                <a href="{{ $filePath }}" download="{{ basename($evidence) }}"
                                                    title="Download Image" class="btn btn-sm btn-primary mt-2">
                                                    <i class="bi bi-cloud-download"></i> Download
                                                </a>
                                                <br>
                                                <input type="checkbox" name="delete_evidence[]"
                                                    value="{{ $evidence }}" id="delete_{{ $index }}">
                                                <label for="delete_{{ $index }}" class="text-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>No evidence uploaded.</p>
                                @endif
                            </div>

                            <div class="col">
                                <div class="row mt-5">
                                    <div class="col">
                                        <p>Tanda Tangan :<br />Inisiator/Auditor</p>
                                        <strong>{{ $ppk->pembuatUser->nama_user }}</strong>
                                    </div>
                                    <div class="col">
                                        <img src="{{ asset('admin/img/' . $ppk->signature) }}" alt="Signature"
                                            class="img-fluid" style="max-width: 150px; max-height: 70px;">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <p>Tanda Tangan :<br />Proses Owner/Auditee</p>
                                        <strong>{{ $ppk->penerimaUser->nama_user }}</strong>
                                    </div>
                                    <div class="col">
                                        @if (!is_null($ppkkedua->signaturepenerima))
                                            <img src="{{ asset('admin/img/' . $ppkkedua->signaturepenerima) }}"
                                                alt="Signature" class="img-fluid"
                                                style="max-width: 150px; height: auto;">
                                        @else
                                            <small class="text-secondary fst-italic">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                No signature yet
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for=""><strong>Tambah Evidence (jika ada)</strong></label>
                            <input type="file" name="evidence[]" id="evidence" class="form-control" multiple
                                onchange="previewEvidenceImages()" accept="image,xls,xlsx,pdf">
                        </div>

                        <div id="evidencePreview" class="d-flex flex-wrap mt-3">
                            <!-- Preview images will appear here -->
                        </div>

                        <script>
                            function previewEvidenceImages() {
                                const fileInput = document.getElementById('evidence');
                                const previewContainer = document.getElementById('evidencePreview');

                                // Clear previous previews
                                previewContainer.innerHTML = '';

                                // Loop through the selected files
                                const files = fileInput.files;
                                for (let i = 0; i < files.length; i++) {
                                    const file = files[i];
                                    const reader = new FileReader();

                                    // Preview the image
                                    reader.onload = function(e) {
                                        const imgElement = document.createElement('img');
                                        imgElement.src = e.target.result;
                                        imgElement.classList.add('img-thumbnail');
                                        imgElement.style.maxWidth = '150px';
                                        imgElement.style.height = 'auto';
                                        previewContainer.appendChild(imgElement);
                                    };

                                    // Read the file as a data URL
                                    reader.readAsDataURL(file);
                                }
                            }
                        </script>

                        <script>
                            // Mengisi data pembuat
                            document.getElementById("pembuat").addEventListener("change", function() {
                                const selectedOption = this.options[this.selectedIndex];
                                document.getElementById("emailpembuat").value = selectedOption.getAttribute("data-email");
                                document.getElementById("divisipembuat").value = selectedOption.getAttribute("data-divisi");
                            });

                            // Mengisi data penerima
                            document.getElementById("penerima").addEventListener("change", function() {
                                const selectedOption = this.options[this.selectedIndex];
                                document.getElementById("emailpenerima").value = selectedOption.getAttribute("data-email");
                                document.getElementById("divisipenerima").value = selectedOption.getAttribute("data-divisi");
                            });
                        </script>

                        <!-- CC Email -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">CC Email</label>
                            <div id="cc-email-container" class="w-100">
                                @php
                                    // Mengambil cc_email yang sudah ada, atau set default jika kosong
                                    $ccEmails = explode(',', $ppk->cc_email ?? '');
                                @endphp

                                @foreach ($ccEmails as $cc)
                                    @php
                                        // Tentukan apakah email cc ada dalam daftar user->email
                                        $isEmailValid = $users->contains('email', $cc); // Cek apakah cc ada di user email
                                    @endphp

                                    @if ($cc)
                                        <div class="cc-email-row mb-2">
                                            <div class="input-group">
                                                @if ($isEmailValid)
                                                    <!-- Jika email ada di user->email, tampilkan dropdown -->
                                                    <select name="cc_email[]" class="form-select">
                                                        <option value="">Pilih Email</option> <!-- Opsi default -->
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->email }}"
                                                                {{ $user->email == $cc ? 'selected' : '' }}>
                                                                {{ $user->email }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <!-- Jika email tidak ada di user->email, tampilkan text input -->
                                                    <input type="email" name="cc_email[]" value="{{ $cc }}"
                                                        class="form-control" placeholder="Masukkan email CC">
                                                @endif
                                                <button type="button" class="btn btn-outline-danger remove-cc-email ms-2"
                                                    aria-label="Remove CC">-
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>


                            <div style="text-align: left;">
                                <button type="button" class="btn btn-outline-primary add-cc-email"><i
                                        class="fa fa-plus"></i></button>
                            </div>

                            <div class="d-none">
                                <label for="statusppk" class="form-label"><strong>Status PPK</strong></label>
                                <select name="statusppk" class="form-select" required>
                                    <option value="">--Pilih Status--</option>
                                    @foreach ($status as $s)
                                        <option value="{{ $s->nama_statusppk }}"
                                            {{ old('statusppk') == $s->nama_statusppk || $ppk->statusppk == $s->nama_statusppk ? 'selected' : '' }}>
                                            {{ $s->nama_statusppk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update <i
                                        class="ri-save-3-fill"></i></button>
                            </div>

                        </div>

                        <script>
                            // Add CC Email functionality
                            document.querySelector('.add-cc-email').addEventListener('click', function() {
                                const container = document.getElementById('cc-email-container');

                                // Prevent adding more than 5 CC emails
                                if (container.querySelectorAll('.input-group').length < 10) {
                                    const inputGroup = document.createElement('div');
                                    inputGroup.className = 'cc-email-row mb-2';
                                    inputGroup.innerHTML = `
                <div class="form-check mb-1">
                    <input type="checkbox" class="form-check-input cc-toggle-checkbox">
                    <label class="form-check-label">Input Manual</label>
                </div>
                <div class="input-group">
                    <select name="cc_email[]" class="form-select cc-email-select">
                        <option value="">Pilih CC Email</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->email }}">{{ $user->email }}</option>
                        @endforeach
                    </select>
                    <input type="email" name="" class="form-control cc-email-input" placeholder="Masukkan CC Email" style="display: none;">
            <button type="button" class="btn btn-outline-danger remove-cc-email ms-2"
                                                aria-label="Remove CC">-
                                            </button>
                                            </div>
                                `;
                                    container.appendChild(inputGroup);

                                    // Add event listener to the remove button
                                    inputGroup.querySelector('.remove-cc-email').addEventListener('click', function() {
                                        container.removeChild(inputGroup);
                                    });
                                } else {
                                    alert('You can add a maximum of 10 CC emails.');
                                }
                            });
                            document.addEventListener("DOMContentLoaded", function() {
                                $(document).on('change', '.cc-toggle-checkbox', function() {
                                    var rowContainer = $(this).closest('.cc-email-row');
                                    if ($(this).is(':checked')) {
                                        // Jika dicentang, tampilkan input email dan hapus name dari select
                                        rowContainer.find('.cc-email-select').hide().removeAttr('name');
                                        rowContainer.find('.cc-email-input').show().attr('name', 'cc_email[]');
                                    } else {
                                        // Jika tidak dicentang, tampilkan select dan hapus name dari input email
                                        rowContainer.find('.cc-email-select').show().attr('name', 'cc_email[]');
                                        rowContainer.find('.cc-email-input').hide().removeAttr('name');
                                    }
                                });
                            });
                            // Attach event listener to existing remove buttons (for CC emails pre-loaded into the form)
                            document.querySelectorAll('.remove-cc-email').forEach(function(button) {
                                button.addEventListener('click', function() {
                                    // Pilih elemen terdekat dengan tombol yang diklik (input-group)
                                    const rowContainer = button.closest('.cc-email-row');

                                    // Hapus baris .cc-email-row yang sesuai dengan tombol yang diklik
                                    rowContainer.remove();
                                });
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
