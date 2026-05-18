<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FloodCare — Verifikasi Email</title>
  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>

<div class="page">

  <div class="left">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="ring"></div>
    <div class="ring"></div>
    <div class="ring"></div>

    <svg class="wave-wrap" viewBox="0 0 800 180" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,90 C180,20 380,160 580,90 C690,55 750,110 800,90 L800,180 L0,180 Z" fill="#ff6600"/>
      <path d="M0,110 C140,55 340,165 540,100 C670,58 740,120 800,100 L800,180 L0,180 Z" fill="#ff6600" opacity="0.35"/>
    </svg>

    <div class="left-logo">
      <img src="{{ asset('assets/img/FloodCare.svg') }}" alt="FloodCare Logo" class="logo-img">
      <div class="wordmark">Flood<span>Care</span></div>
    </div>

    <div class="left-hero">
      <div class="badge">
        <span class="dot"></span>
        Verifikasi Email
      </div>
      <h1>Satu langkah<br><em>lagi!</em></h1>
      <p>Cek inbox kamu dan klik link verifikasi yang kami kirim untuk mulai menggunakan FloodCare.</p>
    </div>

    <div class="left-footer">
      &copy; {{ date('Y') }} FloodCare. All rights reserved.
    </div>
  </div>

  <div class="right">
    <div class="card">

      <div class="icon-box">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
          <polyline points="22,6 12,13 2,6"/>
        </svg>
      </div>

      <div class="card-header" style="margin-bottom: 24px;">
        <div class="eyebrow">Hampir Selesai</div>
        <h2>Verifikasi Email</h2>
        <p>Kami telah mengirimkan link verifikasi ke email kamu. Klik link tersebut untuk mengaktifkan akun.</p>
      </div>

      @if (session('status') == 'verification-link-sent')
        <div class="alert-success">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
          </svg>
          <div>Link verifikasi baru telah dikirim ke email kamu.</div>
        </div>
      @endif

      <div class="verify-actions">

        <form method="POST" action="{{ route('verification.send') }}">
          @csrf
          <button type="submit" class="btn-login" id="resendBtn">
            <div class="spinner"></div>
            <span class="btn-text">Kirim Ulang Email Verifikasi</span>
          </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-secondary">
            Keluar dari akun
          </button>
        </form>

      </div>

      <div class="card-footer" style="margin-top: 24px;">
        Tidak menerima email? Cek folder <strong>Spam</strong> atau coba kirim ulang.
      </div>

    </div>
  </div>

</div>

<script src="{{ asset('assets/js/login.js') }}" defer></script>
</body>
</html>