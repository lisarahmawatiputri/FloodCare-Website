<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto">
      <img src="{{ asset('assets/img/logo.png') }}" alt="">
      <h1 class="sitename">FlexStart</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('home') }}#hero" class="active">Home</a></li>
        <li><a href="{{ route('home') }}#about">About</a></li>
        <li><a href="{{ route('service') }}#services">Services</a></li>
        <li><a href="{{ route('portfolio') }}#portfolio">Portfolio</a></li>
        <li><a href="{{ route('home') }}#team">Team</a></li>
        <li><a href="{{ route('blog') }}" class="active">Blog</a></li>
        <li><a href="{{ route('home') }}#contact">Contact</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <a class="btn-getstarted flex-md-shrink-0" href="{{ route('home') }}#about">Get Started</a>

  </div>
</header>