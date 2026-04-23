<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FloodCare Admin - @yield('title')</title>

    <!-- CSS Template -->
    <link rel="stylesheet" href="{{ asset('assets_admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/css/style.css') }}">

    <!-- Custom FloodCare Color Override -->
    <style>
        :root {
            --floodcare-primary: #e8562a;
            --floodcare-light: #f4845f;
        }
        .navbar .navbar-brand-wrapper {
            background: #e8562a !important;
        }
        .sidebar {
            background: #fff;
            border-right: 1px solid #f0f0f0;
        }
        .sidebar .nav .nav-item .nav-link.active,
        .sidebar .nav .nav-item:hover .nav-link {
            color: #e8562a !important;
        }
        .sidebar .nav .nav-item .nav-link .menu-icon {
            color: #e8562a;
        }
        .bg-gradient-primary {
            background: linear-gradient(to right, #e8562a, #f4845f) !important;
        }
        .nav-profile-img .availability-status.online,
        .login-status.online {
            background: #e8562a;
        }
    </style>

    @yield('extra-css')
</head>
<body>
<div class="container-scroller">

    {{-- NAVBAR --}}
    @include('admin.partials.navbar')

    <div class="container-fluid page-body-wrapper">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')

        {{-- MAIN CONTENT --}}
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>

            {{-- FOOTER --}}
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center d-block d-sm-inline-block">
                        Copyright © {{ date('Y') }} <strong>FloodCare</strong>. All rights reserved.
                    </span>
                </div>
            </footer>
        </div>
    </div>
</div>

<!-- JS Template -->
<script src="{{ asset('assets_admin/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets_admin/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets_admin/js/misc.js') }}"></script>
<script src="{{ asset('assets_admin/js/settings.js') }}"></script>
<script src="{{ asset('assets_admin/js/todolist.js') }}"></script>
<script src="{{ asset('assets_admin/js/jquery.cookie.js') }}"></script>

@yield('extra-js')
</body>
</html>