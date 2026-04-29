@extends('layouts.main')

@section('content')

    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <hr>

        <style>
            .form-control {
                min-height: 40px;
                /* Untuk input biasa */
            }

            textarea.form-control {
                height: auto;
                min-height: 100px;
                /* Minimal tinggi untuk textarea */
                resize: vertical;
                /* User bisa menyesuaikan tinggi jika diinginkan */
            }
        </style>
        @if(optional($form->riskregister)->jenis_iso_id != 2)
        <div
            style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 400px; margin: auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px; text-align: left; color: #333; line-height: 1.6;">
            <h1
                style="font-size: 16px; color: #2c3e50; border-bottom: 2px solid #2c3e50; padding-bottom: 8px; margin-bottom: 15px;">
                Track Record</h1>
            <p style="font-size: 20px; color: #555;">{{ $tindak }}</p>

            <div style="margin-top: 25px; border-top: 1px solid #ddd; padding-top: 15px;">
                <h2 style="font-size: 18px; color: #2c3e50;">PIC: {{ $pic }}</h2>
                
                    <p style="font-size: 16px; color: #555; margin-top: 8px;">Target Tanggal:
                        <strong>{{ $deadline }}</strong>
                    </p>
               
                <label for="nilai_akhir"><strong> Persentase Tindakan Lanjut:
                        {{ number_format($realisasiList->count() ? $realisasiList->sum('nilai_akhir') / $realisasiList->count() : 0, 0) }}%</strong></label>

            </div>
        </div>
         @endif


        <!-- Tabel Data Realisasi -->
        <table class="table table-striped mt-4" style="width: 100%; font-size: 13px;">
            <thead>
                <tr>
                    @if(optional($form->riskregister)->jenis_iso_id != 2)
                    <th scope="col">No</th>
                    @endif
                    <th class="text-center">
                        @if(optional($form->riskregister)->jenis_iso_id == 2)
                            Tindakan
                        @else
                            Activity
                        @endif
                    </th>
                    <th scope="col">PIC</th>
                    @if(optional($form->riskregister)->jenis_iso_id != 2)
                    <th scope="col">Noted</th>
                    @endif 
                    <th scope="col">Evidence</th>
                    <th scope="col">Tanggal Penyelesaian</th>
                    
                    @if(optional($form->riskregister)->jenis_iso_id != 2)
                        <th scope="col">Persentase</th>
                    @endif    
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp

                @foreach ($realisasiList as $realisasi)
                    <tr>
                        @if(optional($form->riskregister)->jenis_iso_id != 2)
                        <td>{{ $no++ }}</td>
                        @endif
                        <td>
                            @if(optional($form->riskregister)->jenis_iso_id == 2)
                                {{-- Untuk ISO 37001, tampilkan Nama Tindakan sebagai Nama Realisasi --}}
                                {{ $form->nama_tindakan }}
                            @else
                                {{-- Untuk ISO lain, tampilkan data realisasi yang diinput user --}}
                                {{ $realisasi->nama_realisasi ?? '-' }}
                            @endif
                        </td>
                        <!-- Dropdown PIC -->
                        <td>
                            <select name="target" class="form-control" required>
                                <option value="">--Pilih PIC--</option>
                                @foreach ($usersInDivisi as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $realisasi->target ? 'selected' : '' }}>
                                        {{ $user->nama_user }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        @if(optional($form->riskregister)->jenis_iso_id != 2)
                        <td>{{ $realisasi->desc ?? '-' }}</td>
                        @endif
                        <td>
                            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                                data-bs-target="#evidenceModal{{ $realisasi->id }}">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                        </td>
                        <td>{{ $realisasi->tgl_realisasi ?? '-' }}</td>
                        
                        @if(optional($form->riskregister)->jenis_iso_id != 2)
                            <td>{{ $realisasi->presentase ?? '-' }}%</td>
                         @endif
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#basicModal{{ $realisasi->id }}">
                                <i class="bx bx-edit"></i>
                            </button>
                            <form action="{{ route('realisasi.destroy', $realisasi->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this activity?');">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>

                            {{-- Modal Evidence --}}
                            <div class="modal fade" id="evidenceModal{{ $realisasi->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Evidence for {{ $realisasi->nama_realisasi }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if (is_array($realisasi->evidencerealisasi) && count($realisasi->evidencerealisasi) > 0)
                                                <div class="row">
                                                    @foreach ($realisasi->evidencerealisasi as $path)
                                                        <div class="col-md-4 mb-3">
                                                            <div class="card">
                                                                @php
                                                                    // Ekstrak ekstensi file, lowercase
                                                                    $ext = strtolower(
                                                                        pathinfo($path, PATHINFO_EXTENSION),
                                                                    );
                                                                @endphp

                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ basename($path) }}</h5>

                                                                    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                                                        {{-- Tampilkan gambar --}}
                                                                        <img src="{{ Storage::url($path) }}"
                                                                            alt="{{ basename($path) }}"
                                                                            class="img-fluid mb-2" />
                                                                        <div>
                                                                            <a href="{{ Storage::url($path) }}"
                                                                                target="_blank"
                                                                                class="btn btn-primary btn-sm me-1">
                                                                                View Image
                                                                            </a>
                                                                            <a href="{{ Storage::url($path) }}"
                                                                                download="{{ basename($path) }}"
                                                                                class="btn btn-secondary btn-sm">
                                                                                Download
                                                                            </a>
                                                                        </div>
                                                                    @else
                                                                        {{-- Link untuk PDF / Excel --}}
                                                                        <div class="mb-2">
                                                                            <i class="fa fa-file-alt fa-2x fs-6"></i>
                                                                            {{ strtoupper($ext) }} File
                                                                        </div>
                                                                        <a href="{{ Storage::url($path) }}"
                                                                            download="{{ basename($path) }}"
                                                                            class="btn btn-secondary btn-sm">
                                                                            Download
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p>No evidence available.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal untuk Edit Data -->
                            <div class="modal fade" id="basicModal{{ $realisasi->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Activity</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('realisasi.update', $realisasi->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="nama_realisasi" class="form-label">
                                                        <strong>{{ optional($form->riskregister)->jenis_iso_id == 2 ? 'Detail Tindakan' : 'Nama Realisasi' }}</strong>
                                                    </label>

                                                    <textarea name="nama_realisasi" class="form-control" rows="3" required
                                                     {{ optional($form->riskregister)->jenis_iso_id == 2 ? 'readonly' : '' }}>
                                                        @if(optional($form->riskregister)->jenis_iso_id == 2)
                                                            {{ old('nama_realisasi', $form->nama_tindakan) }}
                                                        @else
                                                            {{ old('nama_realisasi') }}
                                                        @endif
                                                    </textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="target" class="form-label"><strong>PIC</strong></label>
                                                    <select name="target" class="form-control" required>
                                                        <option value="">--Pilih PIC--</option>
                                                        @foreach ($usersInDivisi as $user)
                                                            <option value="{{ $user->id }}"
                                                                @if(optional($form->riskregister)->jenis_iso_id == 2)
                                                                    {{-- Otomatis pilih PIC dari Tindakan induk --}}
                                                                    {{ $user->id == $form->targetpic ? 'selected' : '' }}
                                                                @else
                                                                    {{-- Default logic (ISO 9001 dll) --}}
                                                                    {{ (isset($realisasi) && $user->id == $realisasi->target) ? 'selected' : '' }}
                                                                @endif
                                                            >
                                                                {{ $user->nama_user }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_realisasi" class="form-label"><strong>Tanggal
                                                            Penyelesaian</strong></label>
                                                    <input type="date" name="tgl_realisasi" class="form-control tgl-realisasi-input"
                                                         value="{{ $realisasi->tgl_realisasi }}"
                                                         id="tgl_realisasi_{{ $realisasi->id }}">
                                                    <small class="text-danger tgl-warning-{{ $realisasi->id }}"
                                                        style="{{ $realisasi->tgl_realisasi ? 'display:none' : '' }}">
                                                        Tanggal penyelesaian wajib diisi sebelum update.
                                                    </small>
                                                </div>
                                                {{-- Existing attachments --}}
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Existing Evidence</strong> <span
                                                            class="text-danger">*</span>centang yang ingin dihapus</label>
                                                    @if (is_array($realisasi->evidencerealisasi) && count($realisasi->evidencerealisasi) > 0)
                                                        <div class="form-check">
                                                            @foreach ($realisasi->evidencerealisasi as $path)
                                                                <div class="mb-1">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="delete_attachments[]"
                                                                        value="{{ $path }}"
                                                                        id="del_{{ md5($path) }}">
                                                                    <label class="form-check-label"
                                                                        for="del_{{ md5($path) }}">
                                                                        <a href="{{ Storage::url($path) }}"
                                                                            target="_blank">
                                                                            {{ basename($path) }}
                                                                        </a>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-muted font-italic">Tidak ada evidence yang
                                                            diupload.</p>
                                                    @endif
                                                </div>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        // Cek apakah ini ISO 37001 (kita oper variabel dari PHP ke JS)
                                                        const isISO37001 = {{ optional($form->riskregister)->jenis_iso_id == 2 ? 'true' : 'false' }};
                                                        const namaTindakan = "{{ $form->nama_tindakan }}";
                                                    
                                                        if (isISO37001) {
                                                            // Cari elemen textarea nama_realisasi di dalam modal
                                                            const realisasiInput = document.querySelector('textarea[name="nama_realisasi"]');

                                                            // Jika input kosong (saat tambah baru), otomatis isi dengan nama tindakan
                                                            if (realisasiInput && realisasiInput.value.trim() === "") {
                                                                realisasiInput.value = namaTindakan;
                                                            }
                                                        }
                                                        if (isISO37001) {
                                                            const targetPicId = "{{ $form->targetpic }}";
                                                            const selectPic = document.querySelector('select[name="target"]');
                                                            if (selectPic) {
                                                                selectPic.value = targetPicId;
                                                            }
                                                        }
                                                    });
                                                </script>
                                                {{-- Upload new files --}}
                                                
                                                <div class="mb-3">
                                                    <label for="attachments" class="form-label"><strong>Tambah
                                                            Evidence</strong></label>
                                                    <input type="file" name="attachments[]" class="form-control"
                                                        accept=".jpg,.jpeg,.png,.pdf,.xls,.xlsx" multiple>
                                                </div>
                                                @if(optional($form->riskregister)->jenis_iso_id != 2)
                                                <div class="mb-3">
                                                    <label for="desc"
                                                        class="form-label"><strong>Noted</strong></label>
                                                    <textarea name="desc" class="form-control">{{ $realisasi->desc }}</textarea>
                                                </div>
                                                @endif
                                                @if(optional($form->riskregister)->jenis_iso_id == 2)
                                                    {{-- Jika ISO 37001: presentase otomatis 100, input disembunyikan --}}
                                                    <input type="hidden" name="presentase" value="100">
                                                @else
                                                    <div class="mb-3">
                                                        <label for="presentase"
                                                            class="form-label"><strong>Presentase</strong></label>
                                                        <input type="number" name="presentase" class="form-control"
                                                            value="{{ $realisasi->presentase }}">
                                                    </div>
                                                @endif
                                                <div class="mb-3">
                                                    <label for="status" class="form-label"><strong></strong></label>
                                                    <input type="hidden" name="status" class="form-control"
                                                        value="ON PROGRES">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success btn-update-modal"
                                                        id="btnUpdate_{{ $realisasi->id }}"
                                                        {{ $realisasi->tgl_realisasi ? '' : 'disabled' }}>Update
                                                        <i class="ri-save-3-fill"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(optional($form->riskregister)->jenis_iso_id != 2)
            <!-- Button to Show/Hide Form -->
            <button type="button" id="toggleFormButton" class="btn btn-info mb-3">
                <i class="fa fa-eye"></i> Show
            </button>
        @endif
        <!-- Form for Adding New Realisasi -->
        <form id="realisasiForm" action="{{ route('realisasi.store') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="id_tindakan" value="{{ $id }}" required>

            <div class="row">
                {{-- AKTIVITY --}}
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for="nama_realisasi"><strong>Nama Activity</strong></label>
                    <textarea name="nama_realisasi[]" class="form-control" rows="3" placeholder="Masukan Aktivitas" required></textarea>
                </div>

                {{-- PIC --}}
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for="target"><strong>PIC</strong></label>
                    <select name="target[]" class="form-control" required>
                        <option value="">--Pilih PIC--</option>
                        @foreach ($usersInDivisi as $user)
                            <option value="{{ $user->id }}" {{ old('target') == $user->id ? 'selected' : '' }}>
                                {{ $user->nama_user }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- DESC --}}
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for="desc"><strong>Noted</strong></label>
                    <textarea name="desc[]" class="form-control" rows="3" placeholder="Masukan Catatan"></textarea>
                </div>
            </div>

            <div class="row">
                {{-- TANGGAL REALISASI --}}
                <div class="col-md-3 col-sm-12 mb-3">
                    <label for="tgl_realisasi"><strong>Tanggal Penyelesaian</strong></label>
                    <input type="date" name="tgl_realisasi[]" class="form-control">
                </div>

                {{-- PERSENTASE % --}}
                <div class="col-md-3 col-sm-12 mb-3">
                    <label for="presentase"><strong>Persentase</strong></label>
                    <input type="number" name="presentase[]" class="form-control" placeholder="%" step="0.01">
                </div>

            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Tambahkan Aktivitas
                    </button>
                </div>
            </div>
        </form>

        <!-- JavaScript to Toggle the Form Visibility -->
        <script>
            document.getElementById('toggleFormButton').addEventListener('click', function() {
                var form = document.getElementById('realisasiForm');
                if (form.style.display === "none") {
                    form.style.display = "block";
                    this.innerHTML = '<i class="fa fa-eye-slash"></i> Hide Form'; // Change button text to 'Hide Form'
                } else {
                    form.style.display = "none";
                    this.innerHTML = '<i class="fa fa-eye"></i> Show Form'; // Change button text back to 'Show Form'
                }
            });
        </script>


        <!-- Form untuk Mengupdate Status -->
        <form action="{{ route('realisasi.updateStatusByTindakan', $realisasiList->first()->id_tindakan ?? 0) }}"
            method="POST" class="mt-4">
            @csrf
            @method('PATCH')

            <input type="hidden" name="redirect_to" value="{{ route('resiko.edit', ['id' => $form->id_riskregister]) }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="status"><strong>Status</strong></label>
                    <div class="d-flex align-items-center">
                        <select name="status" class="form-control">
                            <option value="">--Pilih Status--</option>
                            <option value="ON PROGRES"
                                {{ old('status', $realisasiList->first()->status ?? '') == 'ON PROGRES' ? 'selected' : '' }}>
                                ON PROGRES
                            </option>
                            <option value="CLOSE"
                                {{ old('status', $realisasiList->first()->status ?? '') == 'CLOSE' ? 'selected' : '' }}>
                                CLOSE
                            </option>
                        </select>
                        @php
                            $adaTglKosong = $realisasiList->contains(fn($r) => empty($r->tgl_realisasi));
                        @endphp
                        <button type="submit" class="btn btn-primary ms-2"
                            id="btnUpdateStatus"
                            {{ $adaTglKosong ? 'disabled' : '' }}
                            title="{{ $adaTglKosong ? 'Semua tanggal penyelesaian harus diisi terlebih dahulu' : '' }}">
                            Update
                        </button>
                    </div>
                    @if($adaTglKosong)
                        <small class="text-danger d-block mt-1">
                            <i class="ri-error-warning-line"></i>
                            Semua aktivitas harus memiliki tanggal penyelesaian sebelum mengubah status.
                        </small>
                    @endif
                    </div>
                </div>
            </div>
        </form>

        <script>
            // Validasi dinamis: tombol Update di modal aktif/nonaktif sesuai isi tgl_realisasi
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.tgl-realisasi-input').forEach(function (input) {
                    const id = input.id.replace('tgl_realisasi_', '');
                    const btn = document.getElementById('btnUpdate_' + id);
                    const warning = document.querySelector('.tgl-warning-' + id);

                    function toggleBtn() {
                        if (input.value) {
                            if (btn) btn.disabled = false;
                            if (warning) warning.style.display = 'none';
                        } else {
                            if (btn) btn.disabled = true;
                            if (warning) warning.style.display = '';
                        }
                    }

                    input.addEventListener('change', toggleBtn);
                    toggleBtn(); // jalankan saat load
                });
            });
        </script>

        <div class="mt-3">
            @if(optional($form->riskregister)->jenis_iso_id == 2)
                <a class="btn btn-danger" href="{{ route('riskregister.tablerisk.iso37001', ['id' => $form->riskregister->id_divisi]) }}" title="Back">
                    <i class="ri-arrow-go-back-line"></i>
                </a>
            @else
                <a class="btn btn-danger" href="/riskregister" title="Back">
                    <i class="ri-arrow-go-back-line"></i>
                </a>
            @endif
        </div>
    </div>
@endsection