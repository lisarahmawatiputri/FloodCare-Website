<footer class="bg-slate-50 border-t border-slate-200 pt-14 pb-8">
  <div class="max-w-7xl mx-auto px-5 lg:px-8">

    {{-- Grid: Brand lebar, Produk & Kontak rapat ke kanan --}}
    <div class="flex flex-col lg:flex-row lg:items-start gap-12 lg:gap-0">

      {{-- Brand — kiri --}}
      <div class="lg:w-[38%] lg:pr-16">
        <a href="#home" class="flex items-center gap-2.5">
          <img
            src="{{ asset('assets/img/FloodCare.svg') }}"
            alt="FloodCare Logo"
            class="w-10 h-10 object-contain"
          >
          <span class="font-extrabold text-lg tracking-tight">
            Flood<span class="text-primary">Care</span>
          </span>
        </a>
        <p class="mt-4 text-slate-500 text-sm leading-relaxed max-w-xs">
          Platform pelaporan banjir untuk membangun masyarakat yang tanggap, terinformasi, dan saling membantu.
        </p>
      </div>

      {{-- Kanan: Produk + Kontak berdampingan --}}
      <div class="flex flex-col sm:flex-row gap-12 lg:gap-20 lg:flex-1">

        {{-- Produk --}}
        <div class="min-w-[120px]">
          <h4 class="font-bold text-ink text-sm uppercase tracking-wider mb-5">Produk</h4>
          <ul class="space-y-3 text-sm text-slate-500">
            <li><a href="#features" class="hover:text-primary transition">Fitur</a></li>
            <li><a href="#edukasi"  class="hover:text-primary transition">Edukasi</a></li>
            <li><a href="#donasi"   class="hover:text-primary transition">Donasi</a></li>
            <li><a href="#faq"      class="hover:text-primary transition">FAQ</a></li>
          </ul>
        </div>

        {{-- Kontak --}}
        <div>
          <h4 class="font-bold text-ink text-sm uppercase tracking-wider mb-5">Kontak</h4>
          <ul class="space-y-3.5 text-sm text-slate-500">
            <li class="flex items-center gap-2.5">
              <svg class="shrink-0 text-primary" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              FloodCaree@gmail.com
            </li>
            <li class="flex items-center gap-2.5">
              <svg class="shrink-0 text-primary" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
              +62 812 3456 7890
            </li>
            <li class="flex items-center gap-2.5">
              <svg class="shrink-0 text-primary" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              Jember, Indonesia
            </li>
          </ul>
        </div>

      </div>
    </div>

    <div class="divider my-10"></div>

    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-slate-400">
      <p>&copy; {{ date('Y') }} FloodCare. All rights reserved.</p>
      <div class="flex gap-6">
        <a href="#" class="hover:text-primary transition">Privacy Policy</a>
        <a href="#" class="hover:text-primary transition">Terms of Service</a>
      </div>
    </div>

  </div>
</footer>