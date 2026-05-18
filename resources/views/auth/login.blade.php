<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FloodCare- Login Admin</title>
  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>

<div class="page">

  <div class="left">

    {{-- Decorative elements --}}
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="ring"></div>
    <div class="ring"></div>
    <div class="ring"></div>

    <svg class="wave-wrap" viewBox="0 0 800 180" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,90 C180,20 380,160 580,90 C690,55 750,110 800,90 L800,180 L0,180 Z" fill="#ff6600"/>
      <path d="M0,110 C140,55 340,165 540,100 C670,58 740,120 800,100 L800,180 L0,180 Z" fill="#ff6600" opacity="0.35"/>
    </svg>

    {{-- Logo --}}
    <div class="left-logo">
        <img 
            src="{{ asset('assets/img/FloodCare.svg') }}" 
            alt="FloodCare Logo"
            class="logo-img">
        <div class="wordmark">Flood<span>Care</span></div>
    </div>

    {{-- Hero --}}
    <div class="left-hero">
      <div class="badge">
        <span class="dot"></span>
        Admin Dashboard
      </div>

      <h1>Pantau banjir<br>secara <em>real-time.</em></h1>
      <p>Kelola laporan, verifikasi data, dan koordinasi respons darurat dari satu panel terpusat.</p>

      <div class="stats">
        <div class="stat-item">
          <div class="num">10<span>+</span></div>
          <div class="lbl">Laporan masuk</div>
        </div>
        <div class="stat-item">
          <div class="num">98<span>%</span></div>
          <div class="lbl">Akurasi data</div>
        </div>
        <div class="stat-item">
           <div class="num">25<span>+</span></div>
          <div class="lbl">Jangkauan Daerah Jember</div>
        </div>
      </div>
    </div>

    <div class="left-footer">
      &copy; {{ date('Y') }} FloodCare. All rights reserved.
    </div>

  </div>

  <div class="right">
    <div class="card">

      <div class="card-header">
        <div class="eyebrow">Portal Admin</div>
        <h2>Selamat datang!</h2>
        <p>Masuk untuk mengakses dashboard FloodCare</p>
      </div>

      @if ($errors->any())
        <div class="alert">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <div>
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </div>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        {{-- Email --}}
        <div class="field">
          <label for="email">Alamat Email</label>
          <div class="input-wrap">
            <span class="ico">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
              </svg>
            </span>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="admin@floodcare.id"
                   required autofocus>
          </div>
        </div>

        {{-- Password --}}
        <div class="field">
          <label for="password">Password</label>
          <div class="input-wrap">
            <span class="ico">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
            </span>
            <input type="password" id="password" name="password"
                   placeholder="••••••••" required>
            <button type="button" class="toggle-pw" id="togglePw" aria-label="Tampilkan password">
              <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                   stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        {{-- Remember & Forgot --}}
        <div class="row-meta">
          <label class="remember">
            <input type="checkbox" name="remember">
            <span>Ingat saya</span>
          </label>
          <a href="{{ route('password.request') }}" class="forgot">Lupa password?</a>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-login" id="loginBtn">
          <div class="spinner" id="spinner"></div>
          <span id="btnText">Masuk ke Dashboard</span>
          <!-- <svg id="btnArrow" width="16" height="16" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14"/>
            <path d="m12 5 7 7-7 7"/>
          </svg> -->
        </button>

      </form>

      <!-- <div class="card-footer">
        Butuh bantuan? <a href="mailto:FloodCaree@gmail.com">Hubungi tim kami</a>
      </div> -->

    </div>
  </div>

</div>

<script src="{{ asset('assets/js/login.js') }}" defer></script>
</body>
</html>