<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FloodCare Reset Password</title>
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

    <!-- <svg class="wave-wrap" viewBox="0 0 800 180" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,90 C180,20 380,160 580,90 C690,55 750,110 800,90 L800,180 L0,180 Z" fill="#ff6600"/>
      <path d="M0,110 C140,55 340,165 540,100 C670,58 740,120 800,100 L800,180 L0,180 Z" fill="#ff6600" opacity="0.35"/>
    </svg> -->

    <div class="left-logo">
      <img src="{{ asset('assets/img/FloodCare.svg') }}" alt="FloodCare Logo" class="logo-img">
      <div class="wordmark">Flood<span>Care</span></div>
    </div>

    <div class="left-hero">
      <div class="badge">
        <span class="dot"></span>
        Password Baru
      </div>
      <h1>Buat password<br><em>yang kuat.</em></h1>
      <p>Pilih password baru yang aman dan mudah diingat untuk melindungi akun FloodCare kamu.</p>
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
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
      </div>

      <div class="card-header" style="margin-bottom: 24px;">
        <div class="eyebrow">Password Baru</div>
        <h2>Atur Ulang Password</h2>
        <p>Masukkan password baru kamu di bawah ini.</p>
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

      <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                   value="{{ old('email', $request->email) }}"
                   placeholder="email@example.com"
                   required autofocus autocomplete="username">
          </div>
        </div>

        {{-- Password baru --}}
        <div class="field">
          <label for="password">Password Baru</label>
          <div class="input-wrap">
            <span class="ico">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
            </span>
            <input type="password" id="password" name="password"
                   placeholder="Min. 8 karakter"
                   required autocomplete="new-password">
            <button type="button" class="toggle-pw" id="toggleNewPw" aria-label="Tampilkan password">
              <svg id="newEyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                   stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        {{-- Konfirmasi password --}}
        <div class="field">
          <label for="password_confirmation">Konfirmasi Password</label>
          <div class="input-wrap">
            <span class="ico">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
            </span>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   placeholder="Ulangi password baru"
                   required autocomplete="new-password">
            <button type="button" class="toggle-pw" id="toggleConfirmPw" aria-label="Tampilkan password">
              <svg id="confirmEyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                   stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-login" style="margin-top: 8px;">
          <div class="spinner"></div>
          <span class="btn-text">Simpan Password Baru</span>
        </button>

      </form>

      <div class="card-footer">
        Ingat password lama? <a href="{{ route('login') }}">Login Kembali</a>
      </div>

    </div>
  </div>

</div>

<script src="{{ asset('assets/js/login.js') }}" defer></script>
</body>
</html>