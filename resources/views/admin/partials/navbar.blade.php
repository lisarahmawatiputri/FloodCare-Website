<nav class="fc-navbar">
    {{-- Brand --}}
    <a href="{{ route('admin.dashboard') }}" class="fc-navbar-brand">
        <img src="{{ asset('assets/img/FloodCare.svg') }}" alt="FloodCare" class="fc-brand-logo">
        <span class="fc-brand-name">FloodCare</span>
    </a>

    {{-- Body --}}
    <div class="fc-navbar-body">
        <div class="fc-date">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </div>

        <div class="fc-navbar-actions">

            {{-- Notifikasi --}}
            <div class="fc-dropdown">
                <button class="fc-nav-btn" type="button">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="fc-badge"
                          id="notif-badge"
                          style="display:none;">
                    </span>
                </button> 

                 <div class="fc-dropdown-menu" style="min-width:240px;">
                    <div class="fc-dropdown-label">Notifikasi</div>
                    <div class="fc-dropdown-divider"></div>

                    <a class="fc-dropdown-item"
                       href="{{ route('admin.laporan.index') }}">
                        <span class="fc-notif-dot"></span>
                        <span id="notif-text">Memuat...</span>
                    </a>

                    <div class="fc-dropdown-divider"></div>

                    <a class="fc-dropdown-item center"
                       href="{{ route('admin.laporan.index') }}">
                        Lihat semua
                    </a>
                </div> 
            </div> 

            {{-- Globe --}}
            <!-- <button class="fc-nav-btn" type="button">
                <i class="mdi mdi-web"></i>
            </button> --> 

            {{-- Profile --}}
            <div class="fc-dropdown" style="margin-left:4px;">
            <a href="#" class="fc-profile-btn">

                @php
                    $nama = trim(Auth::user()->nama_lengkap ?? '');
                    $kata = array_filter(explode(' ', $nama));

                    if (count($kata) >= 2) {
                        $inisial = strtoupper(
                            substr($kata[0], 0, 1) .
                            substr(end($kata), 0, 1)
                        );
                    } elseif (count($kata) == 1) {
                        $inisial = strtoupper(substr($kata[0], 0, 1));
                    } else {
                        $inisial = '?';
                    }
                @endphp

                <div class="fc-avatar">
                    {{ $inisial }}
                </div>

                <div>
                    <div class="fc-profile-name">
                        {{ Auth::user()->nama_lengkap }}
                    </div>

                    <div class="fc-profile-role">
                        {{ ucfirst(Auth::user()->role) }}
                    </div>
                </div>

            </a>

            <div class="fc-dropdown-menu">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="fc-dropdown-item">
                        <i class="mdi mdi-logout"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        </div>
    </div>
</nav>