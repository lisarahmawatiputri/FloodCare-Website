<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FloodCare Admin — @yield('title')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap">

    {{-- Material Design Icons CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

    {{-- FloodCare Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets_admin/css/floodcare.css') }}">

    @yield('extra-css')
</head>
<body>

    {{-- NAVBAR --}}
    @include('admin.partials.navbar')

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="fc-main">
        @yield('content')
    </main>

    <footer class="fc-footer">
        Copyright &copy; {{ date('Y') }} <strong>FloodCare</strong>. All rights reserved.
    </footer>

    {{-- jQuery --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    {{-- FloodCare Custom JS --}}
    <script src="{{ asset('assets_admin/js/floodcare.js') }}"></script>

    @yield('extra-js')

</body>
</html>