@extends('layouts.admin')

@section('title', 'Tambah Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets_admin/css/user.css') }}">
@endsection

@section('content')

{{-- Breadcrumb --}}
<!-- <div class="fc-breadcrumb">
    <a href="{{ route('admin.users.index') }}">Kelola User</a>
    <span class="sep">/</span>
    <span>Tambah Admin</span>
</div> -->

{{-- Header --}}
<div class="fc-page-header">
    <div>
        <h1 class="fc-page-title">Tambah Admin</h1>
        <p class="fc-page-subtitle">Buat akun admin baru untuk sistem FloodCare</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="fc-btn fc-btn-ghost">
        <i class="mdi mdi-arrow-left"></i> Kembali
    </a>
</div>

<div class="user-create-layout">

    {{-- Form Card --}}
    <div class="user-create-card fc-table-card">

        <div class="user-create-card-header">
            <i class="mdi mdi-account-plus-outline"></i>
            <div>
                <div class="user-create-card-title">Informasi Akun</div>
                <div class="user-create-card-sub">Lengkapi data berikut untuk membuat akun admin baru</div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="user-create-form-body">

                {{-- Nama Lengkap --}}
                <div class="fc-form-group">
                    <label class="fc-label">
                        Nama lengkap <span class="fc-required">*</span>
                    </label>
                    <div class="fc-input-prefix-wrap">
                        <span class="fc-input-prefix">
                            <i class="mdi mdi-account-outline"></i>
                        </span>
                        <input type="text" name="nama_lengkap"
                            class="fc-input fc-input-prefixed @error('nama_lengkap') is-invalid @enderror"
                            value="{{ old('nama_lengkap') }}"
                            placeholder="Masukkan nama lengkap" required autofocus>
                    </div>
                    @error('nama_lengkap')
                        <span class="fc-hint-error"><i class="mdi mdi-alert-circle-outline"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="fc-form-group">
                    <label class="fc-label">
                        Email <span class="fc-required">*</span>
                    </label>
                    <div class="fc-input-prefix-wrap">
                        <span class="fc-input-prefix">
                            <i class="mdi mdi-email-outline"></i>
                        </span>
                        <input type="email" name="email"
                            class="fc-input fc-input-prefixed @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="admin@example.com" required>
                    </div>
                    @error('email')
                        <span class="fc-hint-error"><i class="mdi mdi-alert-circle-outline"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- No. Telepon --}}
                <div class="fc-form-group">
                    <label class="fc-label">No. telepon
                    </label>
                    <div class="fc-input-prefix-wrap">
                        <span class="fc-input-prefix">
                            <i class="mdi mdi-phone-outline"></i>
                        </span>
                        <input type="text" name="no_telepon"
                            class="fc-input fc-input-prefixed @error('no_telepon') is-invalid @enderror"
                            value="{{ old('no_telepon') }}"
                            placeholder="08xxxxxxxxxx">
                    </div>
                    @error('no_telepon')
                        <span class="fc-hint-error"><i class="mdi mdi-alert-circle-outline"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="user-create-divider"></div>

                {{-- Password --}}
                <div class="fc-form-group">
                    <label class="fc-label">
                        Password <span class="fc-required">*</span>
                    </label>
                    <div class="fc-input-password-wrap">
                        <input type="password" name="password" id="create-password"
                            class="fc-input @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter" required>
                        <button type="button" class="fc-input-password-toggle"
                            onclick="togglePassword('create-password', this)">
                            <i class="mdi mdi-eye-outline"></i>
                        </button>
                    </div>
                    <span class="fc-input-hint">Password minimal 8 karakter</span>
                    @error('password')
                        <span class="fc-hint-error"><i class="mdi mdi-alert-circle-outline"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="fc-form-group">
                    <label class="fc-label">
                        Konfirmasi password <span class="fc-required">*</span>
                    </label>
                    <div class="fc-input-password-wrap">
                        <input type="password" name="password_confirmation" id="create-password-confirm"
                            class="fc-input"
                            placeholder="Ulangi password" required>
                        <button type="button" class="fc-input-password-toggle"
                            onclick="togglePassword('create-password-confirm', this)">
                            <i class="mdi mdi-eye-outline"></i>
                        </button>
                    </div>
                </div>

            </div>{{-- end form-body --}}

            {{-- Footer actions --}}
            <div class="user-create-footer">
                <a href="{{ route('admin.users.index') }}" class="fc-btn fc-btn-ghost">
                    Batal
                </a>
                <button type="submit" class="fc-btn fc-btn-primary">
                    <i class="mdi mdi-account-plus-outline"></i> Buat akun admin
                </button>
            </div>

        </form>
    </div>

    {{-- Info sidebar --}}
    <div class="user-create-info">
        <div class="fc-table-card user-create-info-card">
            <div class="user-create-info-icon">
                <i class="mdi mdi-shield-account-outline"></i>
            </div>
            <div class="user-create-info-title">Akun Admin</div>
            <p class="user-create-info-text">
                Akun yang dibuat melalui form ini akan memiliki role <strong>admin</strong>
                dan dapat mengakses fitur manajemen laporan banjir.
            </p>
            <div class="user-create-info-divider"></div>
            <ul class="user-create-info-list">
                <li><i class="mdi mdi-check-circle-outline"></i> Konfirmasi laporan banjir</li>
                <li><i class="mdi mdi-check-circle-outline"></i> Kelola konten edukasi</li>
                <li><i class="mdi mdi-check-circle-outline"></i> Lihat statistik laporan</li>
                <li><i class="mdi mdi-close-circle-outline" style="color:#ffb3b3"></i> Tidak bisa kelola user lain</li>
            </ul>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('mdi-eye-outline', 'mdi-eye-off-outline');
    } else {
        input.type = 'password';
        icon.classList.replace('mdi-eye-off-outline', 'mdi-eye-outline');
    }
}
</script>
@endpush