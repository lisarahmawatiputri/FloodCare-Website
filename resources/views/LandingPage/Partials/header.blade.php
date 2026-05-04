<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto">
      <img src="{{ asset('assets/img/FloodCare.svg') }}" alt="FloodCare Logo">
      <h1 class="sitename">FloodCare</h1> </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('home') }}#hero" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>

        <li><a href="{{ route('home') }}#about">About</a></li>

        <li><a href="{{ route('service') }}#services" class="{{ request()->routeIs('service') ? 'active' : '' }}">Services</a></li>
        <li><a href="{{ route('portfolio') }}#portfolio" class="{{ request()->routeIs('portfolio') ? 'active' : '' }}">Portfolio</a></li>

        <li><a href="{{ route('home') }}#team">Team</a></li>

        <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a></li>
        <li><a href="{{ route('home') }}#contact">Contact</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <a class="btn-getstarted flex-md-shrink-0" href="{{ route('login') }}">Get Started</a>

  </div>
</header>
