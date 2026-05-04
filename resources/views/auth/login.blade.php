<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FloodCare - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #f0f4ff 0%, #fde8e0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrapper {
            width: 850px;
            min-height: 520px;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.15);
            overflow: hidden;
            display: flex;
            background: white;
            position: relative;
        }

        /* ── PANEL (orange side) ── */
        .panel-side {
            width: 45%;
            background: linear-gradient(135deg, #e8562a 0%, #f4845f 60%, #f9a87e 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 36px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
            order: 2; /* default: panel di kanan */
            transition: order 0s; /* order tidak bisa di-animate, pakai transform */
            flex-shrink: 0;
        }
        .panel-side::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
            top: -80px; right: -80px;
        }
        .panel-side::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
            bottom: -60px; left: -60px;
        }

        /* Saat register: panel pindah ke kiri */
        .wrapper.show-register .panel-side { order: 1; }
        .wrapper.show-register .forms-side { order: 2; }

        .panel-content { position: relative; z-index: 1; }
        .panel-logo {
            width: 80px; height: 80px;
            margin: 0 auto 16px;
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .panel-logo img { width: 100%; filter: brightness(0) invert(1); }
        .panel-logo-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            color: white;
            letter-spacing: -1px;
        }
        .panel-title { font-size: 24px; font-weight: 700; margin-bottom: 10px; line-height: 1.3; }
        .panel-desc { font-size: 13px; opacity: 0.88; line-height: 1.7; margin-bottom: 28px; }
        .btn-switch {
            padding: 10px 28px;
            background: white;
            color: #e8562a;
            border: none;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            font-family: 'Open Sans', sans-serif;
        }
        .btn-switch:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }

        /* ── FORMS SIDE ── */
        .forms-side {
            width: 55%;
            position: relative;
            overflow: hidden;
            order: 1;
        }

        .form-box {
            position: absolute;
            width: 100%;
            height: 100%;
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: transform 0.55s cubic-bezier(.77,0,.18,1), opacity 0.55s ease;
        }

        /* LOGIN: default tampil dari kiri */
        .form-box.login {
            transform: translateX(0);
            opacity: 1;
        }
        /* LOGIN saat register aktif: keluar ke kiri */
        .wrapper.show-register .form-box.login {
            transform: translateX(-100%);
            opacity: 0;
        }

        /* REGISTER: default tersembunyi di kanan */
        .form-box.register {
            transform: translateX(100%);
            opacity: 0;
        }
        /* REGISTER saat register aktif: masuk dari kanan */
        .wrapper.show-register .form-box.register {
            transform: translateX(0);
            opacity: 1;
        }

        /* ── FORM ELEMENTS ── */
        h2 {
            font-size: 22px;
            font-weight: 700;
            color: #2d2d2d;
            margin-bottom: 4px;
        }
        .subtitle { color: #999; font-size: 13px; margin-bottom: 24px; }

        .form-group { margin-bottom: 14px; }
        label { display: block; font-size: 12px; font-weight: 600; color: #555; margin-bottom: 5px; }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e8e8e8;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: border 0.2s;
            font-family: 'Open Sans', sans-serif;
        }
        input:focus { border-color: #e8562a; }

        .row-2 { display: flex; gap: 12px; }
        .row-2 .form-group { flex: 1; }

        .forgot { text-align: right; margin-top: 4px; }
        .forgot a { font-size: 11px; color: #e8562a; text-decoration: none; }

        .remember { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #666; margin-bottom: 18px; }
        .remember input { width: auto; }

        .btn-main {
            width: 100%;
            padding: 11px;
            background: #e8562a;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            font-family: 'Open Sans', sans-serif;
        }
        .btn-main:hover { background: #cf4520; transform: translateY(-1px); }

        .error-msg {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 14px;
        }
    </style>
</head>
<body>

<div class="wrapper" id="wrapper">

    <!-- FORMS SIDE -->
    <div class="forms-side">

        <!-- LOGIN FORM -->
        <div class="form-box login">
            <h2>Selamat Datang!</h2>
            <p class="subtitle">Masuk ke akun FloodCare milikmu</p>

            @if ($errors->any() && old('_form') != 'register')
                <div class="error-msg">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required autofocus>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                    <div class="forgot"><a href="{{ route('password.request') }}">Lupa password?</a></div>
                </div>
                <div class="remember">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </div>
                <button type="submit" class="btn-main">Masuk </button>
            </form>
        </div>

        <!-- REGISTER FORM -->
        <div class="form-box register">
            <h2>Buat Akun Baru </h2>
            <p class="subtitle">Daftar dan mulai gunakan FloodCare</p>

            @if ($errors->any() && old('_form') == 'register')
                <div class="error-msg">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="_form" value="register">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap kamu" required>
                </div>
                <div class="row-2">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx" maxlength="12">
                    </div>
                </div>
                <div class="row-2">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Min. 8 karakter" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                </div>
                <button type="submit" class="btn-main">Daftar</button>
            </form>
        </div>
    </div>

    <!-- PANEL SIDE -->
    <div class="panel-side">
        <div class="panel-content" id="panelContent">
            <div class="panel-logo">
               <img src="{{ asset('assets/img/FloodCare.svg') }}" alt="FloodCare" onerror="this.style.display='none'">
                <div class="panel-logo-fallback" style="display:none;">FC</div>
            </div>
            <div class="panel-title" id="panelTitle">Belum punya akun?</div>
            <div class="panel-desc" id="panelDesc">Bergabunglah bersama FloodCare dan bantu masyarakat lebih siap menghadapi banjir.</div>
            <button class="btn-switch" id="switchBtn" onclick="toggleForm()">Daftar Sekarang →</button>
        </div>
    </div>

</div>

<script>
    const wrapper   = document.getElementById('wrapper');
    const title     = document.getElementById('panelTitle');
    const desc      = document.getElementById('panelDesc');
    const btn       = document.getElementById('switchBtn');
    const content   = document.getElementById('panelContent');

    let isLogin = true;

    // Kalau ada error dari register, langsung buka form register
    @if ($errors->any() && old('_form') == 'register')
        isLogin = false;
        wrapper.classList.add('show-register');
        updatePanelText(false);
    @endif

    function toggleForm() {
        isLogin = !isLogin;

        if (!isLogin) {
            wrapper.classList.add('show-register');
        } else {
            wrapper.classList.remove('show-register');
        }

        // Fade teks panel
        content.style.opacity = '0';
        content.style.transition = 'opacity 0.25s ease';
        setTimeout(() => {
            updatePanelText(isLogin);
            content.style.opacity = '1';
        }, 250);
    }

    function updatePanelText(showingLogin) {
        if (showingLogin) {
            title.textContent = 'Belum punya akun?';
            desc.textContent  = 'Bergabunglah bersama FloodCare dan bantu masyarakat lebih siap menghadapi banjir.';
            btn.textContent   = 'Daftar';
        } else {
            title.textContent = 'Sudah punya akun?';
            desc.textContent  = 'Masuk dan pantau informasi banjir terkini di wilayah kamu bersama FloodCare.';
            btn.textContent   = 'Masuk';
        }
    }
</script>
</body>
</html>