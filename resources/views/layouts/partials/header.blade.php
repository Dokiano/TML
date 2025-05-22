<header id="header" class="header fixed-top d-flex align-items-center"
    style="background: linear-gradient(90deg, #6a9df2, #6abf69);">
    <div class="d-flex align-items-center justify-content-between px-4 w-100">


        <!-- Logo -->
        <a href="/" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block"
                style="color: white; font-size: 1.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">Tata
                Metal Lestari</span>
        </a>
        <!-- Sidebar Toggle Button (Left side) -->
        <i class="bi bi-list toggle-sidebar-btn text-white fs-3" title="Full Screen / Small Screen"></i>

        <!-- Center Text -->
        <div class="center-text mx-auto text-center">
            <span
                style="font-size: 1.5rem; font-weight: 700; color: white; text-transform: uppercase; letter-spacing: 2px; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                DOCUMENT CONTROL MANAGEMENT SYSTEM
            </span>
        </div>

    </div>

    <!-- Navbar -->
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <!-- Notifikasi -->
            @php
                $statusInvalid = ['CANCEL', 'IDENTIFIKASI ULANG', 'CLOSE (Tidak Efektif)'];
                $ppks = App\Models\Ppk::with(['formppk2', 'formppk3', 'pembuatUser', 'penerimaUser'])->get();

                $countPpk2 = App\Models\Ppk::with(['formppk2', 'formppk3', 'pembuatUser', 'penerimaUser'])
                    ->where('penerima', auth()->id())
                    ->whereNotIn('statusppk', $statusInvalid)
                    ->whereHas('formppk2', fn($q) => $q->whereNull('signaturepenerima'))
                    ->count();

                $pendingppk2 = App\Models\Ppk::with(['formppk2', 'formppk3', 'pembuatUser', 'penerimaUser'])
                    ->where('penerima', auth()->id())
                    ->whereNotIn('statusppk', $statusInvalid)
                    ->whereHas('formppk2', fn($q) => $q->whereNull('signaturepenerima'))
                    ->get();

                $pendingPpk3 = App\Models\Ppk::with(['formppk2', 'formppk3', 'pembuatUser', 'penerimaUser'])
                    ->where('pembuat', auth()->id())
                    ->whereNotIn('statusppk', $statusInvalid)
                    ->get();

                $ppk3Count = 0;

            @endphp

            @foreach ($pendingPpk3 as $ppk3)
                <?php
                // Ambil relasi formppk2, bisa null
                $form2 = $ppk3->formppk2;
                
                // Cek formppk2 ada dan tanggal pencegahan tidak null
                if ($form2 && $form2->tgl_pencegahan) {
                    // Pastikan ini instance Carbon
                    $tgl = $form2->tgl_pencegahan instanceof \Carbon\Carbon ? $form2->tgl_pencegahan : \Carbon\Carbon::parse($form2->tgl_pencegahan);
                    $isExpired = $tgl->diffInMonths(now()) >= 1;
                
                    if ($isExpired && $form2 && $form2->tgl_pencegahan && is_null($ppk3->formppk3->verifikasi)) {
                        $ppk3Count++;
                    }
                }
                ?>
            @endforeach

            <?php
            $unreadCount = $countPpk2 + $ppk3Count;
            ?>


            <div class="d-flex">
                <li class="nav-item dropdown" style="margin: 0 !important;">
                    <a class="nav-link d-flex align-items-center justify-content-center" href="#"
                        data-bs-toggle="dropdown">
                        <div class="position-relative">
                            <i class="bi bi-bell fs-4 text-white" style="margin: 0 !important;"></i>
                            @if ($unreadCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $unreadCount }}
                                    <span class="visually-hidden">unread notifications</span>
                                </span>
                            @endif
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
                        style="border-radius:10px; width: 300px;">
                        <li class="dropdown-header text-center">
                            <h6 class="mb-0">Notifikasi Baru</h6>
                            <small class="text-muted">Anda punya {{ $unreadCount }} tugas</small>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <div class="" style="max-height: 300px; overflow-y: scroll;">
                            @if ($unreadCount > 0)
                                @foreach ($pendingppk2 as $notification)
                                    <li
                                        class="notification-item px-3 py-2 d-flex align-items-center justify-content-between">
                                        <i class="bi bi-exclamation-circle-fill text-warning fs-3"></i>
                                        <div class="flex-grow-1">
                                            <p class="mb-1">{{ $notification->nomor_surat }}</p>
                                            <p class="text-dark">Segera jawab PPK</p>
                                        </div>
                                        <a href="/formidentifikasi/{{ $notification->id }}"
                                            class="px-2 py-1 btn btn-danger">
                                            <i class="bi fs-6 bi-bell text-white" style="margin: 0 !important;"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endforeach

                                @foreach ($pendingPpk3->filter(fn($ppk) => Carbon\Carbon::parse($ppk->formppk2->tgl_pencegahan)->diffInMonths(now()) >= 1 && is_null($ppk->formppk3?->verifikasi)) as $ppk3)
                                    <li
                                        class="notification-item px-3 py-2 d-flex align-items-center justify-content-between">
                                        <i class="bi bi-exclamation-circle-fill text-warning fs-3"></i>
                                        <div class="flex-grow-1">
                                            <p class="mb-1">{{ $ppk3->nomor_surat }}</p>
                                            <p class="text-dark">Segera verifikasi PPK</p>
                                        </div>
                                        <a href="/ppk/{{ $ppk3->id }}/edit3" class="px-2 py-1 btn btn-success">
                                            <i class="bi fs-6 bi-bell text-white" style="margin: 0 !important;"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center py-2 text-muted">Tidak ada notifikasi baru</li>
                            @endif
                        </div>

                        <hr class="dropdown-divider">
                        <li class="dropdown-footer text-center">

                            <a href="{{ route('ppk.dashboardPPK') }}">Lihat PPK</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown pe-3" style="margin: 0 !important;">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <!-- Profile Picture -->
                        <img src="{{ asset('admin/img/TML3LOGO.png') }}" alt="Profile" class="rounded-circle"
                            style="width: 40px; height: 40px; border: 2px solid #fff; transition: transform 0.3s;">
                        <span class="d-none d-md-block dropdown-toggle ps-2 text-light"
                            style="font-weight: 600; font-size: 1rem; letter-spacing: 0.5px;">{{ Auth::user()->nama_user }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                        style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <li class="dropdown-header text-center">
                            <h6 class="text-dark" style="font-weight: 600;">{{ Auth::user()->nama_user }}</h6>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ Auth::user()->role }}</p>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">Email: {{ Auth::user()->email }}</p>
                        </li>
                        <hr class="dropdown-divider">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="/password">
                                <i class="ri-lock-password-fill text-primary me-2"></i>
                                <span>Change Password</span>
                            </a>
                        </li>
                        <hr class="dropdown-divider">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="/logout">
                                <i class="bi bi-box-arrow-right text-danger me-2"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </div>
        </ul>
    </nav>
</header>

<!-- Add a Smooth Hover Animation for the Profile Picture -->
<style>
    .nav-profile img:hover {
        transform: scale(1.1);
    }

    .center-text {
        flex-grow: 1;
    }
</style>
