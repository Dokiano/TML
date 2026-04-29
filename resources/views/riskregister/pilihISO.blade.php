@extends('layouts.main')

@section('content')
    <style>
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }

        .iso-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            min-width: 300px;
        }

        .iso-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #F6F9FF;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }

        .iso-title {
            color: #00286F;
            font-size: 24px;
            font-weight: 600;
            text-align: center;
        }

        .divisi-badge {
            font-size: 16px;
            padding: 8px 20px;
            margin-top: 15px;
        }
    </style>

    <section class="section dashboard mb-3">
        <div class="container-fluid">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3 class="fw-bold" style="color: #00286F;">PILIH JENIS ISO</h3>
                    <p class="text-muted">Departemen: <span class="badge bg-info">{{ $divisi->nama_divisi }}</span></p>
                </div>
            </div>

            <!-- Card ISO -->
            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="d-flex flex-wrap gap-4 justify-content-center">
                        
                        <!-- Card 1: ISO 9001/14001/45001 -->
                        <a href="{{ route('riskregister.tablerisk', ['id' => $divisi->id]) }}" 
                           class="text-decoration-none">
                            <div class="hover-scale iso-card">
                                <div class="iso-icon">
                                    <i class="bi bi-file-earmark-text" style="font-size: 40px; color: #4154f1;"></i>
                                </div>
                                <div class="iso-title">ISO 9001/14001/45001</div>
                                <br>
                                <a href="{{ route('riskregister.create', ['id' =>$divisi->id]) }}" 
                                   class="btn btn-success"
                                   style="font-weight: 500;border-radius: 0; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-plus" style="font-size: 14px;"></i> New Issue Resiko
                                </a>
                                <br>
                                <a href="{{ route('riskregister.create', ['id' => $divisi->id, 'type' => 'peluang',]) }}" 
                                   class="btn btn-warning"
                                   style="font-weight: 500;border-radius: 0; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-plus" style="font-size: 14px;"></i> New Issue Peluang
                                </a>
                            </div>
                            
                        </a>
                        
                        <!-- Card 2: ISO 37001 -->
                        <a href="{{ route('riskregister.tablerisk.iso37001', ['id' =>$divisi->id]) }}" 
                           class="text-decoration-none">
                            <div class="hover-scale iso-card">
                                <div class="iso-icon">
                                    <i class="bi bi-file-earmark-text" style="font-size: 40px; color: #28a745;"></i>
                                </div>
                                <div class="iso-title">ISO 37001</div>
                                <br>
                                <a href="{{ route('riskregister.create.iso', ['id' =>$divisi->id, 'iso37001' => $isISO37001 ?? 1]) }}" 
                                   class="btn btn-success"
                                   style="font-weight: 500;border-radius: 0; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-plus" style="font-size: 14px;"></i> New Issue Resiko
                                </a>
                                <br>
                               {{-- <a href="{{ route('riskregister.create', ['id' => $divisi->id, 'type' => 'peluang', 'iso37001' => $isISO37001 ?? 1]) }}" 
                                   class="btn btn-warning"
                                   style="font-weight: 500;border-radius: 0; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-plus" style="font-size: 14px;"></i> New Issue Peluang
                                </a>  --}}
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="{{ route('riskregister.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Pilih Departemen
                    </a>
                </div>
            </div>

        </div>
    </section>
@endsection