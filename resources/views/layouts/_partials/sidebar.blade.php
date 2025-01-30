    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">

            <div class="sidebar-brand-text mx-3">BRILIAN</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            DATA MASTER
        </div>

        <!-- Nav Item - Tables -->
        <li class="nav-item {{ request()->Is('kriteria*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kriteria.index') }}">
                <i class="fas fa-fw fa-list"></i>
                <span>Data Kriteria</span></a>
        </li>
        <li class="nav-item {{ request()->Is('guru*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Data Guru</span></a>
        </li>




        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            ANALISA METODE SAW
        </div>

        <li class="nav-item {{ request()->Is('penilaian*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('penilaian.index') }}">
                <i class="fa fa-star"></i>
                <span>Penilaian Guru</span></a>
        </li>
        <li class="nav-item {{ request()->Is('analisa*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('analisa.index') }}">
                <i class="fa fa-file"></i>
                <span>Analisa Data</span></a>
        </li>

        {{-- <li class="nav-item {{ request()->Is('perhitungan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('perhitungan.index') }}">
                <i class="fas fa-fw fa-book"></i>
                <span>Hasil Perhitungan</span></a>
        </li> --}}

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            RIWAYAT LAPORAN
        </div>
        <li class="nav-item {{ request()->Is('laporan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laporan.index') }}">
                <i class="fas fa-folder"></i>
                <span>Laporan</span></a>
        </li>
        {{-- <li class="nav-item {{ request()->Is('keputusan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('keputusan.index') }}">
                <i class="fas fa-folder-plus"></i>
                <span>Keputusan Pemilihan</span></a>
        </li> --}}

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <li class="nav-item {{ request()->Is('user*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fas fa-fw fa-user-circle"></i>
                <span>Data Pengguna</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>


    </ul>
