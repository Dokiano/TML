<header id="header" class="header fixed-top" style="background: linear-gradient(135deg, #6a9df2 0%, #6abf69 100%); padding: 0; height: auto;">

  {{-- ── BARIS 1: Logo kiri + Notifikasi & Profil kanan ── --}}
  <div class="header-top d-flex align-items-center justify-content-between" style="padding: 0 16px; height: 52px; border-bottom: 1px solid rgba(255,255,255,0.2);">

    {{-- Logo --}}
    <a href="/" class="logo d-flex flex-column align-items-start text-decoration-none">
      <span style="color:#fff;font-size:1.2rem;font-weight:700;letter-spacing:1px;line-height:1;text-shadow:1px 1px 3px rgba(0,0,0,0.25);">DCMS</span>
      <span class="d-none d-md-block" style="color:rgba(255,255,255,0.8);font-size:0.42rem;letter-spacing:1.5px;text-transform:uppercase;">Document Control Management System</span>
    </a>

    {{-- Notifikasi + Profil --}}
    <nav class="header-nav d-flex align-items-center">
      <ul class="d-flex align-items-center mb-0 ps-0 list-unstyled gap-1">

        {{-- Notifikasi: hanya tampil jika sudah login --}}
        @auth
        @php
          $statusInvalid = ['CANCEL', 'IDENTIFIKASI ULANG', 'CLOSE (Tidak Efektif)'];
          $countPpk2 = App\Models\Ppk::with(['formppk2','formppk3','pembuatUser','penerimaUser'])
            ->where('penerima', auth()->id())
            ->whereNotIn('statusppk', $statusInvalid)
            ->whereHas('formppk2', fn($q) => $q->whereNull('signaturepenerima'))
            ->count();
          $pendingppk2 = App\Models\Ppk::with(['formppk2','formppk3','pembuatUser','penerimaUser'])
            ->where('penerima', auth()->id())
            ->whereNotIn('statusppk', $statusInvalid)
            ->whereHas('formppk2', fn($q) => $q->whereNull('signaturepenerima'))
            ->get();
          $pendingPpk3 = App\Models\Ppk::with(['formppk2','formppk3','pembuatUser','penerimaUser'])
            ->where('pembuat', auth()->id())
            ->whereNotIn('statusppk', $statusInvalid)
            ->get();
          $ppk3Count = 0;
        @endphp
        @foreach($pendingPpk3 as $ppk3)
          @php
            $form2 = $ppk3->formppk2;
            if ($form2 && $form2->tgl_pencegahan) {
              $tgl = $form2->tgl_pencegahan instanceof \Carbon\Carbon
                ? $form2->tgl_pencegahan
                : \Carbon\Carbon::parse($form2->tgl_pencegahan);
              if ($tgl->diffInMonths(now()) >= 1 && is_null($ppk3->formppk3->verifikasi ?? null)) {
                $ppk3Count++;
              }
            }
          @endphp
        @endforeach
        @php $unreadCount = $countPpk2 + $ppk3Count; @endphp

        <li class="nav-item dropdown">
          <a class="nav-link d-flex align-items-center px-2" href="#" data-bs-toggle="dropdown">
            <div class="position-relative">
              <i class="bi bi-bell fs-5 text-white"></i>
              @if($unreadCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:9px;">
                  {{ $unreadCount }}
                </span>
              @endif
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end notifications" style="border-radius:10px;width:300px;">
            <li class="dropdown-header text-center">
              <h6 class="mb-0">Notifikasi Baru</h6>
              <small class="text-muted">Anda punya {{ $unreadCount }} tugas</small>
            </li>
            <li><hr class="dropdown-divider"></li>
            <div style="max-height:300px;overflow-y:auto;">
              @if($unreadCount > 0)
                @foreach($pendingppk2 as $notification)
                  <li class="notification-item px-3 py-2 d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-circle-fill text-warning fs-4 flex-shrink-0"></i>
                    <div class="flex-grow-1">
                      <p class="mb-0 fw-500" style="font-size:13px;">{{ $notification->nomor_surat }}</p>
                      <p class="text-muted mb-0" style="font-size:11px;">Segera jawab PPK</p>
                    </div>
                    <a href="/formidentifikasi/{{ $notification->id }}" class="btn btn-danger btn-sm py-1 px-2">
                      <i class="bi bi-bell-fill text-white"></i>
                    </a>
                  </li>
                  <li><hr class="dropdown-divider my-0"></li>
                @endforeach
                @foreach($pendingPpk3->filter(fn($ppk) => \Carbon\Carbon::parse($ppk->formppk2->tgl_pencegahan)->diffInMonths(now()) >= 1 && is_null($ppk->formppk3?->verifikasi)) as $ppk3item)
                  <li class="notification-item px-3 py-2 d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-circle-fill text-warning fs-4 flex-shrink-0"></i>
                    <div class="flex-grow-1">
                      <p class="mb-0 fw-500" style="font-size:13px;">{{ $ppk3item->nomor_surat }}</p>
                      <p class="text-muted mb-0" style="font-size:11px;">Segera verifikasi PPK</p>
                    </div>
                    <a href="/ppk/{{ $ppk3item->id }}/edit3" class="btn btn-success btn-sm py-1 px-2">
                      <i class="bi bi-bell-fill text-white"></i>
                    </a>
                  </li>
                  <li><hr class="dropdown-divider my-0"></li>
                @endforeach
              @else
                <li class="text-center py-3 text-muted" style="font-size:13px;">Tidak ada notifikasi baru</li>
              @endif
            </div>
            <hr class="dropdown-divider">
            <li class="text-center py-1">
              <a href="{{ route('ppk.dashboardPPK') }}" style="font-size:13px;">Lihat semua PPK</a>
            </li>
          </ul>
        </li>

        {{-- Profile Dropdown (sudah login) --}}
        <li class="nav-item dropdown pe-1">
          <a class="nav-link d-flex align-items-center gap-2 pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ asset('admin/img/TML3LOGO.png') }}" alt="Profile" class="rounded-circle"
                 style="width:30px;height:30px;border:2px solid rgba(255,255,255,0.8);transition:transform 0.3s;">
            <div class="d-none d-md-flex flex-column align-items-start" style="line-height:1.15;">
              <span style="color:#fff;font-weight:600;font-size:0.83rem;">{{ Auth::user()->nama_user }}</span>
              <span style="color:rgba(255,255,255,0.72);font-size:0.62rem;">PT Tata Metal Lestari</span>
            </div>
            <i class="bi bi-chevron-down text-white ms-1" style="font-size:0.62rem;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end profile" style="border-radius:10px;box-shadow:0 6px 20px rgba(0,0,0,0.12);min-width:210px;">
            <li class="px-3 py-2 text-center">
              <div class="fw-600 text-dark">{{ Auth::user()->nama_user }}</div>
              <div class="text-muted" style="font-size:0.82rem;">{{ Auth::user()->role }}</div>
              <div class="text-muted" style="font-size:0.78rem;">{{ Auth::user()->email }}</div>
            </li>
            <li><hr class="dropdown-divider my-1"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="/password">
                <i class="ri-lock-password-fill text-primary"></i> Change Password
              </a>
            </li>
            <li><hr class="dropdown-divider my-1"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center gap-2" href="/logout">
                <i class="bi bi-box-arrow-right text-danger"></i> Sign Out
              </a>
            </li>
          </ul>
        </li>

        @else
        {{-- Tombol Login untuk tamu --}}
        <li class="nav-item pe-1">
          <a href="{{ route('login') }}" class="nav-link d-flex align-items-center gap-2"
             style="color:#fff;font-weight:600;font-size:0.83rem;border:1px solid rgba(255,255,255,0.6);border-radius:8px;padding:5px 14px;">
            <i class="bi bi-box-arrow-in-right"></i>
            <span class="d-none d-md-inline">Login</span>
          </a>
        </li>
        @endauth

      </ul>
    </nav>
  </div>

  {{-- ── BARIS 2: Navigation Menu Dropdowns ── --}}
  <div class="header-bottom" style="padding: 0 12px; height: 42px; background: rgba(0,0,0,0.12); display:flex; align-items:center; overflow: visible;">
    <nav class="header-app-nav d-flex align-items-center gap-1">

      {{-- Dashboard --}}
      <a href="/" class="nav-top-item">
        <i class="ri-home-4-fill"></i>
        <span>Dashboard</span>
      </a>

      {{-- Risk & Opportunity Register --}}
      <div class="nav-top-dropdown">
        <button class="nav-top-item">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>Risk Register</span>
          <i class="bi bi-chevron-down nav-chevron"></i>
        </button>
        <div class="nav-top-menu">
          <div class="nav-top-menu-header">Risk &amp; Opportunity Register</div>
          @auth
            <a href="/riskregister" class="nav-top-menu-item">
              <i class="bi bi-plus-circle text-primary"></i>
              <span>Create Risk &amp; Opportunity</span>
            </a>
          @else
            <a href="{{ route('login') }}" class="nav-top-menu-item">
              <i class="bi bi-lock text-secondary"></i>
              <span>Login untuk Create Risk</span>
            </a>
          @endauth
          {{-- Report publik - semua bisa lihat --}}
          <a href="/bigrisk" class="nav-top-menu-item">
            <i class="bi bi-bar-chart text-success"></i>
            <span>Report ISO 9001/45001</span>
          </a>
          <a href="/bigrisk-iso37001" class="nav-top-menu-item">
            <i class="bi bi-bar-chart-steps text-info"></i>
            <span>Report ISO 37001</span>
          </a>
        </div>
      </div>

      {{-- PPK --}}
      <div class="nav-top-dropdown">
        <button class="nav-top-item">
          <i class="bi bi-file-earmark-bar-graph"></i>
          <span>PPK</span>
          <i class="bi bi-chevron-down nav-chevron"></i>
        </button>
        <div class="nav-top-menu">
          <div class="nav-top-menu-header">Mekanisme Pencegahan &amp; Peningkatan</div>
          <a href="/ppk" class="nav-top-menu-item">
            <i class="bi bi-plus-circle text-primary"></i>
            <span>Create PPK</span>
          </a>
          <a href="/adminppk" class="nav-top-menu-item">
            <i class="bi bi-list-ul text-secondary"></i>
            <span>All PPK</span>
          </a>
        </div>
      </div>

      {{-- Dokumen TML --}}
      <div class="nav-top-dropdown">
        <button class="nav-top-item">
          <i class="bi bi-folder-fill"></i>
          <span>Dokumen</span>
          <i class="bi bi-chevron-down nav-chevron"></i>
        </button>
        <div class="nav-top-menu">
          <div class="nav-top-menu-header">Dokumen TML</div>
          <a href="{{ route('dok.dashboard') }}" class="nav-top-menu-item">
            <i class="bi bi-collection text-primary"></i>
            <span>Master List Dokumen</span>
          </a>
          <a href="{{ route('dokumenReview.index') }}" class="nav-top-menu-item">
            <i class="bi bi-file-earmark-check text-success"></i>
            <span>Dokumen Review</span>
          </a>
          <a href="{{ route('dokumenReview.masterListDR') }}" class="nav-top-menu-item">
            <i class="bi bi-card-list text-info"></i>
            <span>Master List DR</span>
          </a>
        </div>
      </div>

      {{-- Admin / Manajemen Only - hanya tampil jika sudah login dan role sesuai --}}
      @auth
        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'manajemen')
          <div class="nav-top-dropdown">
            <button class="nav-top-item">
              <i class="bx bx-run"></i>
              <span>Action</span>
              <i class="bi bi-chevron-down nav-chevron"></i>
            </button>
            <div class="nav-top-menu">
              <div class="nav-top-menu-header">Admin &amp; Manajemen</div>
              <a href="/divisi" class="nav-top-menu-item">
                <i class="bi bi-diagram-3 text-primary"></i>
                <span>Kelola Departemen</span>
              </a>
              <a href="/kelolaakun" class="nav-top-menu-item">
                <i class="bi bi-people text-success"></i>
                <span>Kelola Akun</span>
              </a>
              <a href="/kriteria" class="nav-top-menu-item">
                <i class="bi bi-sliders text-warning"></i>
                <span>Kelola Kriteria</span>
              </a>
              <a href="{{ route('kriteriaSwot.index') }}" class="nav-top-menu-item">
                <i class="bi bi-grid-3x3 text-info"></i>
                <span>Kelola Swot</span>
              </a>
              <a href="{{ route('iso.create') }}" class="nav-top-menu-item">
                <i class="bi bi-award text-danger"></i>
                <span>Kelola ISO</span>
              </a>
              <a href="/statusppk" class="nav-top-menu-item">
                <i class="bi bi-toggles text-secondary"></i>
                <span>Kelola Status PPK</span>
              </a>
              <a href="{{ route('dokumen.index') }}" class="nav-top-menu-item">
                <i class="bi bi-folder2-open text-primary"></i>
                <span>Kelola Dokumen</span>
              </a>
            </div>
          </div>
        @endif
      @endauth

    </nav>
  </div>

</header>

<style>
/* ══════════════════════════════
   HEADER LAYOUT
══════════════════════════════ */
#header {
  overflow: visible !important;
}

/* ── Baris nav bawah ── */
.header-app-nav {
  overflow: visible;
  white-space: nowrap;
  scrollbar-width: none;
  -ms-overflow-style: none;
}
.header-app-nav::-webkit-scrollbar { display: none; }

/* Base nav item */
.nav-top-item {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 5px 12px;
  border-radius: 6px;
  color: rgba(255,255,255,0.92);
  font-size: 0.82rem;
  font-weight: 500;
  border: none;
  background: transparent;
  cursor: pointer;
  white-space: nowrap;
  text-decoration: none;
  transition: background 0.18s ease;
  line-height: 1;
}
.nav-top-item:hover,
.nav-top-dropdown.open > .nav-top-item {
  background: rgba(255,255,255,0.22);
  color: #fff;
}

.nav-chevron {
  font-size: 0.58rem;
  margin-left: 1px;
  transition: transform 0.2s ease;
}
.nav-top-dropdown.open .nav-chevron {
  transform: rotate(180deg);
}

/* Dropdown panel */
.nav-top-dropdown {
  position: relative;
  display: inline-block;
}
.nav-top-menu {
  display: none;
  position: absolute;
  top: calc(100% + 6px);
  left: 0;
  min-width: 220px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.14);
  border: 1px solid #e8eef5;
  overflow: hidden;
  z-index: 9999;
  animation: navFadeIn 0.15s ease;
}
.nav-top-dropdown.open .nav-top-menu { display: block; }

@keyframes navFadeIn {
  from { opacity:0; transform:translateY(-5px); }
  to   { opacity:1; transform:translateY(0); }
}

.nav-top-menu-header {
  padding: 8px 14px 7px;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  color: #94a3b8;
  background: #f8fafc;
  border-bottom: 1px solid #f0f4f8;
}

.nav-top-menu-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 14px;
  font-size: 0.83rem;
  color: #374151;
  text-decoration: none;
  transition: background 0.13s ease;
  border-bottom: 1px solid #f8f9fa;
}
.nav-top-menu-item:last-child { border-bottom: none; }
.nav-top-menu-item:hover {
  background: #eff6ff;
  color: #1d4ed8;
}
.nav-top-menu-item i {
  font-size: 1rem;
  width: 18px;
  text-align: center;
  flex-shrink: 0;
}

/* ── MOBILE ── */
@media (max-width: 768px) {
  .nav-top-item span   { display: none !important; }
  .nav-top-item        { padding: 5px 8px; }
  .nav-chevron         { display: none !important; }
  .nav-top-menu        { left: auto; right: 0; min-width: 200px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const dropdowns = document.querySelectorAll('.nav-top-dropdown');

  dropdowns.forEach(function (dropdown) {
    const trigger = dropdown.querySelector('.nav-top-item');

    trigger.addEventListener('click', function (e) {
      e.stopPropagation();
      const isOpen = dropdown.classList.contains('open');

      // Tutup semua dropdown lain
      dropdowns.forEach(function (d) { d.classList.remove('open'); });

      // Toggle yang diklik
      if (!isOpen) {
        dropdown.classList.add('open');
      }
    });
  });

  // Klik di luar → tutup semua
  document.addEventListener('click', function () {
    dropdowns.forEach(function (d) { d.classList.remove('open'); });
  });

  // Klik di dalam menu tidak menutup dropdown
  document.querySelectorAll('.nav-top-menu').forEach(function (menu) {
    menu.addEventListener('click', function (e) {
      e.stopPropagation();
    });
  });
});
</script>