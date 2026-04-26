<aside class="fc-sidebar">

    {{-- User Card --}}
    <div class="fc-user-card">
        <div class="fc-user-avatar">
            {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 2)) }}
        </div>
        <div>
            <div class="fc-user-name">{{ Auth::user()->nama_lengkap }}</div>
            <div class="fc-user-role">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
    </div>

    {{-- UTAMA --}}
    <div class="fc-nav-section">Utama</div>

    <a href="{{ route('admin.dashboard') }}"
       class="fc-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="mdi mdi-view-dashboard-outline"></i>
        Dashboard
    </a>

    <a href="{{ route('admin.laporan.index') }}"
       class="fc-nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
        <i class="mdi mdi-water-outline"></i>
        Laporan Banjir
        @if(isset($laporanBaru) && $laporanBaru > 0)
        <span class="fc-nav-badge">{{ $laporanBaru }}</span>
        @endif
    </a>

    {{-- KONTEN --}}
    <div class="fc-nav-section">Konten</div>

    <a href="{{ route('admin.artikel.index') }}"
       class="fc-nav-link {{ request()->routeIs('admin.artikel*') ? 'active' : '' }}">
        <i class="mdi mdi-newspaper-variant-outline"></i>
        Artikel
        @if(isset($artikelBaru) && $artikelBaru > 0)
        <span class="fc-nav-badge">{{ $artikelBaru }}</span>
        @endif
    </a>

    <a href="{{ route('admin.video.index') }}"
       class="fc-nav-link {{ request()->routeIs('admin.video*') ? 'active' : '' }}">
        <i class="mdi mdi-play-circle-outline"></i>
        Video Edukasi
    </a>

    {{-- LAINNYA --}}
    <div class="fc-nav-section">Lainnya</div>

    <a href="{{ route('admin.donasi.index') }}"
       class="fc-nav-link {{ request()->routeIs('admin.donasi*') ? 'active' : '' }}">
        <i class="mdi mdi-heart-outline"></i>
        Donasi
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="fc-nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <i class="mdi mdi-account-group-outline"></i>
        Kelola User
    </a>

</aside>