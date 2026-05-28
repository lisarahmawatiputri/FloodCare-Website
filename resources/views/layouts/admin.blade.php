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

    {{-- Bootstrap utilities --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- FloodCare Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets_admin/css/floodcare.css') }}">

    @yield('extra-css')
    @stack('styles')
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

    
    <div id="fc-delete-modal" class="flp-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="fc-delete-modal-title">
        <div class="flp-modal">
            <div class="flp-modal-icon">
                <i class="mdi mdi-trash-can-outline"></i>
            </div>
            <div class="flp-modal-title" id="fc-delete-modal-title">Hapus Data</div>
            <div class="flp-modal-desc" id="fc-delete-modal-msg">Yakin ingin menghapus data ini?</div>
            <div class="flp-modal-actions">
                <button type="button" class="fc-btn fc-btn-ghost" onclick="closeFcDeleteModal()">
                    Batal
                </button>
                <button type="button" class="fc-btn fc-btn-danger" id="fc-delete-modal-confirm">
                    <i class="mdi mdi-trash-can-outline"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    {{-- jQuery --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

     <script>
        window.APP = {
            notifUrl: "{{ url('/notifications/count') }}"
};
    </script>


    {{-- FloodCare Custom JS --}}
    <script src="{{ asset('assets_admin/js/floodcare.js') }}"></script>

    @yield('extra-js')
    @stack('scripts')

</body>
</html>