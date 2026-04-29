<aside id="sidebar" class="sidebar"
    style="background: linear-gradient(90deg, #c6d9f1, #c9f6d6); border-right: 2px solid #ddd;">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="ri-home-4-fill"></i>
                <span class="text-dark">Dashboard</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->

        <!-- Risk & Opportunity Register Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span class="text-dark">Risk & Opportunity
                    Register</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/riskregister">
                        <i class="bi bi-circle"></i><span>Create Risk & Opportunity Register </span>
                    </a>
                    @if (in_array(auth()->user()->role, ['admin', 'manager', 'manajemen', 'supervisor']))
                        <a href="/bigrisk">
                            <i class="bi bi-circle"></i><span>Report ISO 9001/45001</span>
                        </a>
                         <a href="/bigrisk-iso37001">
                            <i class="bi bi-circle"></i><span>Report ISO 37001</span>
                        </a>
                    @endif
                    

                </li>
            </ul>
        </li>
        <!-- End Risk & Opportunity Register Nav -->

        <!-- Proses Peningkatan Kinerja Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-bar-graph"></i><span class="text-dark">Mekanisme Pencegahan dan Peningkatan (PPK)</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/ppk">
                        <i class="bi bi-circle"></i><span>Create Proses Peningkatan Kinerja (PPK)</span>
                    </a>
                    <a href="/adminppk">
                        <i class="bi bi-circle"></i><span>All Proses Peningkatan Kinerja (PPK)</span>
                    </a>
                </li>
            </ul>
        </li>


        <!-- Admin/Management Actions -->
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'manajemen')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx bx-run"></i><span class="text-dark">Action</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/divisi">
                            <i class="bi bi-circle"></i><span>Kelola Departemen</span>
                        </a>
                        <a href="/kelolaakun">
                            <i class="bi bi-circle"></i><span>Kelola Akun</span>
                        </a>
                        <a href="/kriteria">
                            <i class="bi bi-circle"></i><span>Kelola Kriteria Risk & Opportunity Register</span>
                        </a>
                        <a href="{{ route('kriteriaSwot.index') }}">
                            <i class="bi bi-circle"></i><span>Kelola Swot</span>
                        </a>
                        <a href="{{ route('iso.create') }}">
                            <i class="bi bi-circle"></i><span>Kelola ISO</span>
                        </a>
                        <a href="/statusppk">
                            <i class="bi bi-circle"></i><span>Kelola Status Proses Peningkatan Kinerja</span>
                        </a>
                        <a href="{{ route('dokumen.index') }}">
                            <i class="bi bi-circle"></i><span>Kelola Dokumen</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
       

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#document-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-folder-fill"></i><span class="text-dark">Dokumen TML</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="document-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('dok.dashboard') }}">
                        <i class="bi bi-circle"></i><span>Master List</span>
                    </a>
                    <a href="{{ route('dokumenReview.index') }}">
                        <i class="bi bi-circle"></i><span>Dokumen Review</span>
                    </a>
                    {{-- <a href="{{ route('dokumen.pengajuan') }}">
                        <i class="bi bi-circle"></i><span>Tes Pengajuan</span>
                    </a>  --}}
                    <a href="{{ route('dokumenReview.masterListDR') }}">
                        <i class="bi bi-circle"></i><span>Master List Dokumen Review</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>

</aside>

<style>
    /* Sidebar Styling */
    .sidebar {
        background: linear-gradient(90deg, #c6d9f1, #c9f6d6);
        border-right: 2px solid #ddd;
        transition: all 0.3s ease;
    }

    .sidebar-nav {
        padding-top: 20px;
    }

    .nav-item {
        margin-bottom: 15px;
    }

    .nav-link {
        font-size: 1rem;
        font-weight: 500;
        color: #4f4f4f;
        display: flex;
        align-items: center;
        padding: 10px 20px;
        border-radius: 10px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover {
        background-color: #5b9bd5;
        color: #fff;
    }

    .nav-content a {
        padding-left: 40px;
        font-size: 0.95rem;
    }

    .nav-content a:hover {
        background-color: #8ebdf5;
    }

    .nav-item i {
        margin-right: 10px;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    .nav-link:hover i {
        color: #fff;
    }

    /* Collapse icon animation */
    .bi-chevron-down {
        transition: transform 0.3s ease;
    }

    .collapse.show+.bi-chevron-down {
        transform: rotate(180deg);
    }

    .collapse .nav-link {
        padding-left: 40px;
    }

    .text-dark {
        color: #4f4f4f;
    }
</style>
