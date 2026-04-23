<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/FloodCare.svg') }}" alt="FloodCare" style="filter: brightness(0) invert(1); height: 36px;">
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/FloodCare.svg') }}" alt="FloodCare" style="filter: brightness(0) invert(1); height: 28px;">
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <div class="nav-profile-img">
                        <img src="{{ asset('assets_admin/images/faces/face1.jpg') }}" alt="profile">
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">{{ Auth::user()->nama_lengkap }}</p>
                        <p class="mb-0 text-muted" style="font-size:11px;">{{ Auth::user()->role }}</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown">
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="mdi mdi-logout me-2 text-primary"></i> Logout
                        </a>
                    </form>
                </div>
            </li>
            <li class="nav-item nav-logout d-none d-lg-block">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="mdi mdi-power"></i>
                    </a>
                </form>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>