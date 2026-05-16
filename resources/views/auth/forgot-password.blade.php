<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FloodCare Lupa Password</title>
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
        Reset Password
      </div>
      <h1>Lupa<br>password<em>?</em></h1>
      <p>Tenang, masukkan email kamu dan kami kirimkan link untuk reset password dengan aman.</p>
    </div>

    <div class="left-footer">
      &copy; {{ date('Y') }} FloodCare. All rights reserved.
    </div>
  </div>

  <div class="right">
    <div class="card">

      <!-- <div class="icon-box">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
          <polyline points="22,6 12,13 2,6"/>
        </svg>
      </div> -->

      <div class="card-header" style="margin-bottom: 24px;">
        <div class="eyebrow">Pemulihan Akun</div>
        <h2>Reset Password</h2>
        <p>Masukkan email yang terdaftar, kami akan kirim link reset password ke inbox kamu.</p>
      </div>

      @if (session('status'))
        <div class="alert-success">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
          </svg>
          <div>{{ session('status') }}</div>
        </div>
      @endif

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

      <form method="POST" action="{{ route('password.email') }}">
        @csrf

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
                   placeholder="email@example.com"
                   required autofocus>
          </div>
        </div>

        <button type="submit" class="btn-login">
          <div class="spinner"></div>
          <span class="btn-text">Kirim Link Reset</span>
        </button>

      </form>

      <div class="card-footer">
        Sudah ingat password? <a href="{{ route('login') }}">Masuk sekarang</a>
      </div>

    </div>
  </div>

</div>

<script src="{{ asset('assets/js/login.js') }}" defer></script>
</body>
</html>