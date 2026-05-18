<header class="navbar fixed top-0 inset-x-0 z-50">
  <nav class="max-w-7xl mx-auto px-5 lg:px-8 h-[72px] flex items-center justify-between">

    {{-- Logo (ganti src dengan logo kamu) --}}
    <a href="#home" class="flex items-center gap-2.5 group">
            <img 
                src="{{ asset('assets/img/FloodCare.svg') }}" 
                alt="FloodCare Logo"
                class="w-full h-full object-contain"
            >
        <span class="font-extrabold text-2xl tracking-tight">
            Flood<span class="text-primary">Care</span>
        </span>
    </a>

    {{-- Desktop menu --}}
    <ul class="hidden lg:flex items-center gap-9">
      <li><a href="#home"     data-target="home"     class="nav-link active">Home</a></li>
      <li><a href="#features" data-target="features" class="nav-link">Features</a></li>
      <li><a href="#edukasi"  data-target="edukasi"  class="nav-link">Edukasi</a></li>
      <li><a href="#donasi"   data-target="donasi"   class="nav-link">Donasi</a></li>
      <li><a href="#faq"      data-target="faq"      class="nav-link">FAQ</a></li>
    </ul>

    <div class="hidden lg:flex items-center gap-3">
      <!-- <a href="#cta" class="btn-primary text-sm">
        Download Gratis
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
      </a> -->
    </div>

    {{-- Burger --}}
    <button id="burger" aria-label="Toggle menu" aria-expanded="false"
      class="lg:hidden w-11 h-11 rounded-xl border border-slate-200 flex items-center justify-center text-ink hover:text-primary hover:border-primary transition">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
    </button>
  </nav>

  {{-- Mobile menu --}}
  <div id="mobileMenu" class="mobile-menu lg:hidden bg-white/95 backdrop-blur border-t border-slate-100">
    <ul class="px-5 py-5 space-y-1">
      <li><a href="#home"     class="block px-3 py-3 rounded-lg hover:bg-primary-soft hover:text-primary font-medium">Home</a></li>
      <li><a href="#features" class="block px-3 py-3 rounded-lg hover:bg-primary-soft hover:text-primary font-medium">Features</a></li>
      <li><a href="#edukasi"  class="block px-3 py-3 rounded-lg hover:bg-primary-soft hover:text-primary font-medium">Edukasi</a></li>
      <li><a href="#donasi"   class="block px-3 py-3 rounded-lg hover:bg-primary-soft hover:text-primary font-medium">Donasi</a></li>
      <li><a href="#faq"      class="block px-3 py-3 rounded-lg hover:bg-primary-soft hover:text-primary font-medium">FAQ</a></li>
      <li class="pt-2"><a href="#cta" class="btn-primary w-full">Download Gratis</a></li>
    </ul>
  </div>
</header>
