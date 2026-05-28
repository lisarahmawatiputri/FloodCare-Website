<section id="home" class="relative pt-32 lg:pt-40 pb-20 lg:pb-28 overflow-hidden">

  {{-- Blobs --}}
  <div class="blob blob-orange w-[420px] h-[420px] -top-32 -left-32"></div>
  <div class="blob blob-soft   w-[520px] h-[520px] top-40 -right-40"></div>

  <div class="relative max-w-7xl mx-auto px-5 lg:px-8 grid lg:grid-cols-2 gap-14 items-center">

    {{-- Left --}}
    <div class="reveal">
      <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary-soft text-primary text-sm font-semibold">
        <span class="w-2 h-2 rounded-full bg-primary pulse-glow"></span>
        Sigap dan Cepat Lapor Banjir di Sekitarmu
      </span>

      <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.08] tracking-tight">
        Laporkan Banjir di Sekitarmu,
        <span class="text-gradient">Lebih Cepat & Lebih Sigap</span>
      </h1>

      <p class="mt-6 text-lg text-slate-600 max-w-xl leading-relaxed">
        FloodCare membantu masyarakat melaporkan, memantau, dan merespons banjir
        secara <strong class="text-ink">realtime</strong> terintegrasi dengan lokasi otomatis.
      </p>

      <div class="mt-9 flex flex-wrap gap-3">
       <a href="https://github.com/lisarahmawatiputri/FloodCare-Mobile/releases/latest/download/floodcare.apk"
        class="btn-primary"
        target="_blank"
        rel="noopener">
        Download 
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.4"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14"/>
            <path d="m19 12-7 7-7-7"/>
        </svg>
        </a>
        <a href="#features" class="btn-ghost">
          Lihat Fitur
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
      </div>

      {{-- Stats --}}
      <div class="mt-12 grid grid-cols-3 gap-6 max-w-md">
        <div>
          <p class="text-2xl lg:text-3xl font-extrabold text-ink">100+</p>
          <p class="text-sm text-slate-500 mt-1">Laporan</p>
        </div>
        <div>
          <p class="text-2xl lg:text-3xl font-extrabold text-ink">100+</p>
          <p class="text-sm text-slate-500 mt-1">Pengguna Aktif</p>
        </div>
        <div>
          <p class="text-2xl lg:text-3xl font-extrabold text-ink">98%</p>
          <p class="text-sm text-slate-500 mt-1">Akurasi</p>
        </div>
      </div>
    </div>

    {{-- Right: mockup --}}
    <div class="relative reveal flex items-center justify-center">
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="w-[420px] h-[420px] rounded-full bg-gradient-to-br from-primary/30 to-primary-light/10 blur-3xl"></div>
      </div>

      <img src="{{ asset('assets/img/db-left.png') }}"
           alt="FloodCare mobile app mockup"
           class="relative z-10 w-[220px] sm:w-[280px] lg:w-[320px] floaty drop-shadow-2xl"
           onerror="this.style.display='none'">

      {{-- Floating cards --}}
      <div class="hidden sm:flex absolute z-20 top-10 -left-2 lg:-left-6 bg-white rounded-2xl shadow-soft px-4 py-3 items-center gap-3 floaty" style="animation-delay:-2s">
        <div class="w-10 h-10 rounded-xl bg-primary-soft text-primary flex items-center justify-center">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
          <p class="text-xs text-slate-500">Lokasi terdeteksi</p>
          <p class="text-sm font-semibold">Sumbersari, Jember</p>
        </div>
      </div>

      <div class="hidden sm:flex absolute z-20 bottom-12 -right-2 lg:-right-4 bg-white rounded-2xl shadow-soft px-4 py-3 items-center gap-3 floaty" style="animation-delay:-4s">
        <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
          <p class="text-xs text-slate-500">Laporan terverifikasi</p>
          <p class="text-sm font-semibold">+2 hari ini</p>
        </div>
      </div>
    </div>
  </div>
</section>
