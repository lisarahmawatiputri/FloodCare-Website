<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="FloodCare — Laporkan banjir di sekitarmu, lebih cepat & lebih sigap. Aplikasi pelaporan dan edukasi banjir." />
    <title>@yield('title', 'FloodCare — Lapor & Pantau Banjir Realtime')</title>

    {{-- Tailwind via CDN (ganti dengan build asset Vite jika sudah disiapkan) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: { DEFAULT: '#ff6600', dark: '#e65a00', light: '#ff8533', soft: '#fff4ec' },
              ink: '#0f172a',
            },
            fontFamily: { sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'] },
            boxShadow: { soft: '0 10px 40px -15px rgba(15,23,42,.15)' },
          }
        }
      }
    </script>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Custom styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    @stack('head')
</head>
<body class="bg-white text-ink antialiased">

    @include('LandingPage.Partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('LandingPage.Partials.footer')

    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
