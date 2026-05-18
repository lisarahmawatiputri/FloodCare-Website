@php
  $features = [
    [
      'title' => 'Lapor Banjir Realtime',
      'desc'  => 'Kirim laporan banjir dalam hitungan detik lengkap dengan foto, lokasi, dan tingkat keparahan.',
      'icon'  => '<path d="M12 2v4"/><path d="M12 18v4"/><path d="m4.93 4.93 2.83 2.83"/><path d="m16.24 16.24 2.83 2.83"/><path d="M2 12h4"/><path d="M18 12h4"/><path d="m4.93 19.07 2.83-2.83"/><path d="m16.24 7.76 2.83-2.83"/>',
    ],
    [
      'title' => 'Integrasi Lokasi & Map',
      'desc'  => 'Visualisasi titik banjir di peta interaktif dengan deteksi lokasi otomatis dengan menggunakan Flutter Map.',
      'icon'  => '<polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/>',
    ],
    [
      'title' => 'Dashboard Informasi Banjir',
      'desc'  => 'Pantau status banjir di wilayahmu dengan dashboard ringkas dan peta interaktif.',
      'icon'  => '<rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/>',
    ],
    [
      'title' => 'Artikel & Video Edukasi',
      'desc'  => 'Pelajari mitigasi banjir lewat konten edukasi yang ringan, kredibel, dan mudah dipahami.',
      'icon'  => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
    ],
    [
      'title' => 'Donasi Korban Banjir',
      'desc'  => 'Salurkan donasi dengan aman dan transparan langsung ke warga terdampak banjir.',
      'icon'  => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>',
    ],
    [
      'title' => 'Notifikasi',
      'desc'  => 'Dapatkan notifikasi mengenai informasi banjir yang akurat dan tervalidasi.',
      'icon'  => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>',
    ],
  ];
@endphp

<section id="features" class="relative py-24 lg:py-32 overflow-hidden">
  <div class="blob blob-soft w-[480px] h-[480px] -left-40 top-1/3 opacity-40"></div>

  <div class="relative max-w-7xl mx-auto px-5 lg:px-8">
    <div class="max-w-2xl mx-auto text-center reveal">
      <span class="inline-block px-4 py-1.5 rounded-full bg-primary-soft text-primary text-sm font-semibold">Fitur Unggulan</span>
      <h2 class="mt-5 text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
        Semua yang kamu butuhkan untuk <span class="text-gradient">menghadapi banjir</span>
      </h2>
      <p class="mt-5 text-slate-600 text-lg">
        Dari pelaporan, pemantauan, hingga donasi. FloodCare dirancang untuk respons banjir yang lebih cepat dan kolaboratif.
      </p>
    </div>

    <div class="mt-16 grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-7">
      @foreach($features as $i => $f)
        <div class="feature-card reveal" style="transition-delay: {{ $i * 80 }}ms">
          <div class="feature-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
              {!! $f['icon'] !!}
            </svg>
          </div>
          <h3 class="mt-6 text-xl font-bold">{{ $f['title'] }}</h3>
          <p class="mt-3 text-slate-600 leading-relaxed">{{ $f['desc'] }}</p>
          <!-- <a href="#" class="mt-5 inline-flex items-center gap-1.5 text-primary font-semibold text-sm group">
            Pelajari lebih lanjut
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a> -->
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- Edukasi & Donasi anchor sections (lightweight strip) --}}
<section id="edukasi" class="py-16 lg:py-20">
  <div class="max-w-7xl mx-auto px-5 lg:px-8 grid lg:grid-cols-2 gap-10 items-center">
    <div class="reveal">
      <span class="inline-block px-4 py-1.5 rounded-full bg-primary-soft text-primary text-sm font-semibold">Edukasi</span>
      <h2 class="mt-5 text-3xl lg:text-4xl font-extrabold tracking-tight leading-tight">
        Belajar mitigasi banjir dari sumber terpercaya
      </h2>
      <p class="mt-4 text-slate-600 leading-relaxed">
        Akses artikel dan video edukasi seputar kesiapsiagaan, evakuasi, dan tanggap darurat banjir — gratis untuk semua pengguna.
      </p>
      <a href="#" class="mt-6 inline-flex btn-ghost">Jelajahi Edukasi</a>
    </div>
    <div class="reveal grid grid-cols-2 gap-4">
      @foreach(['Kesiapsiagaan','Evakuasi','Pasca Banjir','Lingkungan'] as $tag)
        <div class="rounded-2xl border border-slate-100 bg-white p-5 hover:border-primary/30 hover:shadow-soft transition">
          <div class="w-10 h-10 rounded-xl bg-primary-soft text-primary flex items-center justify-center mb-3">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
          </div>
          <p class="font-semibold">{{ $tag }}</p>
          <p class="text-sm text-slate-500 mt-1">Panduan ringkas & video</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section id="donasi" class="py-16 lg:py-20 bg-gradient-to-b from-white to-primary-soft/40">
  <div class="max-w-5xl mx-auto px-5 lg:px-8 text-center reveal">
    <span class="inline-block px-4 py-1.5 rounded-full bg-white text-primary text-sm font-semibold border border-primary/20">Donasi</span>
    <h2 class="mt-5 text-3xl lg:text-4xl font-extrabold tracking-tight">
      Bantu warga terdampak banjir, <span class="text-gradient">sekecil apa pun bermakna</span>
    </h2>
    <p class="mt-4 text-slate-600 max-w-2xl mx-auto">
      Donasi disalurkan secara transparan dan dapat dipantau langsung di aplikasi. Setiap kontribusi tercatat dan dilaporkan.
    </p>
    <div class="mt-7 flex flex-wrap justify-center gap-3">
      <a href="#cta" class="btn-primary">Donasi Sekarang</a>
      <!-- <a href="#" class="btn-ghost">Lihat Laporan</a> -->
    </div>
  </div>
</section>
