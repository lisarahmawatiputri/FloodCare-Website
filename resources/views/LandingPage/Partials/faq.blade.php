@php
  $faqs = [
    ['q' => 'Bagaimana cara melaporkan banjir?',         'a' => 'Buka aplikasi FloodCare, tekan kamera, ambil foto dan deskripsi singkat, lalu kirim. Isi ketinggian air. Lokasi akan terdeteksi otomatis melalui laman lokasi.'],
    ['q' => 'Apakah lokasi otomatis terdeteksi?',         'a' => 'FloodCare menggunakan Flutter Map untuk menentukan lokasi secara otomatis. Kamu juga dapat mengubah titik lokasi secara manual jika diperlukan.'],
    ['q' => 'Apakah aplikasi gratis?',                    'a' => 'FloodCare sepenuhnya gratis untuk digunakan oleh seluruh masyarakat. Tidak ada biaya tambahan.'],
    ['q' => 'Bagaimana sistem donasi bekerja?',           'a' => 'Donasi disalurkan kepada warga terdampak melalui mitra resmi. Seluruh transaksi terdokumentasi dengan baik. Rekening yang digunakan untuk donasi merupakan rekening resmi milik yayasan terpercaya.'],
    ['q' => 'Apakah laporan diverifikasi?',               'a' => 'Setiap laporan diverifikasi oleh petugas dengan mengecek bukti yang dilampirkan untuk menjaga akurasi informasi.'],
  ];
@endphp

<section id="faq" class="py-24 lg:py-32 relative overflow-hidden">
  <div class="blob blob-soft w-[420px] h-[420px] -right-40 top-20 opacity-40"></div>

  <div class="relative max-w-4xl mx-auto px-5 lg:px-8">
    <div class="text-center reveal">
      <span class="inline-block px-4 py-1.5 rounded-full bg-primary-soft text-primary text-sm font-semibold">FAQ</span>
      <h2 class="mt-5 text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight">
        Pertanyaan yang sering diajukan
      </h2>
      <p class="mt-4 text-slate-600 text-lg">Tidak menemukan jawabanmu? Hubungi tim kami.</p>
    </div>

    <div class="mt-12 space-y-4">
      @foreach($faqs as $i => $f)
        <div class="faq-item reveal" style="transition-delay: {{ $i * 60 }}ms">
          <button class="faq-trigger">
            <span>{{ $f['q'] }}</span>
            <span class="faq-icon">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </span>
          </button>
          <div class="faq-content"><div>{{ $f['a'] }}</div></div>
        </div>
      @endforeach
    </div>
  </div>
</section>
