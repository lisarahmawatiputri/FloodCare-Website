<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets_admin/images/faces/face1.jpg') }}" alt="profile" />
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->nama_lengkap }}</span>
                    <span class="text-secondary text-small">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </a>
        </li>

        {{-- Dashboard --}}
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        {{-- Laporan Banjir --}}
        <li class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                <span class="menu-title">Laporan Banjir</span>
                <i class="mdi mdi-water menu-icon"></i>
            </a>
        </li>

        {{-- Donasi --}}
        <li class="nav-item {{ request()->routeIs('admin.donasi*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.donasi.index') }}">
                <span class="menu-title">Donasi</span>
                <i class="mdi mdi-heart menu-icon"></i>
            </a>
        </li>

        {{-- Artikel --}}
        <li class="nav-item {{ request()->routeIs('admin.artikel*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.artikel.index') }}">
                <span class="menu-title">Artikel</span>
                <i class="mdi mdi-newspaper menu-icon"></i>
            </a>
        </li>

        {{-- Video Edukasi --}}
        <li class="nav-item {{ request()->routeIs('admin.video*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.video.index') }}">
                <span class="menu-title">Video Edukasi</span>
                <i class="mdi mdi-video menu-icon"></i>
            </a>
        </li>

        {{-- Kelola User --}}
        <li class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <span class="menu-title">Kelola User</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>