<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FloodCare - Lupa Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #f9a87e 0%, #e8562a 100%);
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
        }

        /* PANEL SIDE */
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
        .panel-title { font-size: 24px; font-weight: 700; margin-bottom: 10px; line-height: 1.3; }
        .panel-desc { font-size: 13px; opacity: 0.88; line-height: 1.7; margin-bottom: 28px; }
        .btn-back {
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
            text-decoration: none;
            display: inline-block;
        }
        .btn-back:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }

        /* FORM SIDE */
        .form-side {
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
        }

        .icon-wrap {
            width: 56px; height: 56px;
            background: #fde8e0;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .icon-wrap svg { width: 28px; height: 28px; }

        h2 {
            font-size: 22px;
            font-weight: 700;
            color: #2d2d2d;
            margin-bottom: 4px;
        }
        .subtitle { color: #999; font-size: 13px; margin-bottom: 24px; line-height: 1.6; }

        .success-msg {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #16a34a;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 16px;
        }

        .error-msg {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 14px;
        }

        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 12px; font-weight: 600; color: #555; margin-bottom: 5px; }
        input[type="email"] {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e8e8e8;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: border 0.2s;
            font-family: 'Open Sans', sans-serif;
        }
        input[type="email"]:focus { border-color: #e8562a; }

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
    </style>
</head>
<body>

<div class="wrapper">

    <!-- PANEL SIDE -->
    <div class="panel-side">
        <div class="panel-content">
            <div class="panel-logo">
                <img src="{{ asset('assets/img/FloodCare.svg') }}" alt="FloodCare">
            </div>
            <div class="panel-title">Lupa password?</div>
            <div class="panel-desc">Tenang, masukkan email kamu dan kami akan kirimkan link untuk reset password.</div>
            <a href="{{ route('login') }}" class="btn-back">Login</a>
        </div>
    </div>

    <!-- FORM SIDE -->
    <div class="form-side">
        <div class="icon-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="#e8562a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>

        <h2>Reset Password</h2>
        <p class="subtitle">Masukkan email yang terdaftar, kami akan kirim link reset password ke email kamu.</p>

        @if (session('status'))
            <div class="success-msg">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-msg">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required autofocus>
            </div>
            <button type="submit" class="btn-main">Reset Password</button>
        </form>
    </div>

</div>

</body>
</html>