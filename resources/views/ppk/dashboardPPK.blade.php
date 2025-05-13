@extends('layouts.main')

@section('content')
    <style>
        .w-button {
            min-width: 100px;
        }

        .h-button {
            min-height: 30px;
        }

        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            /* Shadow lebih lebar saat hover */
        }
    </style>

    <section class="section dashboard mb-3 fw-bolder">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="row justify-content-center">
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a href="{{ route('ppk.index') }}" class="text-decoration-none">
                            <div class="hover-scale rounded-3 px-3 py-2 " style="background-color: white;">
                                <div class="d-flex flex-row gap-3 align-items-center fs-3" style="color: #4154f1;">
                                    <div class="d-flex justify-content-center align-items-center"
                                        style="width: 50px; height: 50px; border-radius: 50%; background-color: #F6F9FF;">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>
                                    <span style="color: #00286F;">PPK-MFG</span>
                                </div>
                            </div>
                        </a>

                        <!-- Card 2 -->
                        <a href="{{ route('ppk.indexppk2') }}" class="text-decoration-none">
                            <div class="hover-scale rounded-3 px-3 py-2 " style="background-color: white;">
                                <div class="d-flex flex-row gap-3 align-items-center fs-3" style="color: #4154f1;">
                                    <div class="d-flex justify-content-center align-items-center"
                                        style="width: 50px; height: 50px; border-radius: 50%; background-color: #F6F9FF;">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>
                                    <span style="color: #00286F;">PPK-IQA</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
