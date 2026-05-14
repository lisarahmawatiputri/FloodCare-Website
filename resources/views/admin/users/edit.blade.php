@extends('layouts.admin')

@section('title', 'Edit Profil — ' . $user->nama_lengkap)

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets_admin/css/user.css') }}">
@endsection

@section('content')

{{-- Breadcrumb --}}
<!-- <div class="fc-breadcrumb">
    <a href="{{ route('admin.users.index') }}">Kelola User</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.users.show', $user->id) }}">{{ $user->nama_lengkap }}</a>
    <span class="sep">/</span>
    <span>Edit Profil</span>
</div> -->

{{-- Header --}}
<div class="fc-page-header">
    <div>
        <h1 class="fc-page-title">Edit Profil</h1>
        <p class="fc-page-subtitle">Ubah informasi akun {{ $user->nama_lengkap }}</p>
    </div>
    <a href="{{ route('admin.users.show', $user->id) }}" class="fc-btn fc-btn-ghost">
        <i class="mdi mdi-arrow-left"></i> Kembali
    </a>
</div>

@php
    $colors = ['#ff6600','#2a7de8','#2abe8a','#e8a82a','#9b59b6'];
    $color  = $colors[crc32($user->email) % count($colors)];
@endphp

<div class="user-create-layout">

    {{-- Form Card --}}
    <div class="user-create-card fc-table-card">

        {{-- Mini profile preview --}}
        <div class="user-edit-preview">
            <div class="user-profile-avatar" style="background:{{ $color }}; width:52px; height:52px; font-size:18px; margin:0;">
                {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
            </div>
            <div>
                <div class="user-edit-preview-name">{{ $user->nama_lengkap }}</div>
                <div class="user-edit-preview-meta">
                    <span class="user-role-badge user-role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                    <span class="user-status-badge user-status-{{ $user->status ?? 'aktif' }}">{{ ucfirst($user->status ?? 'Aktif') }}</span>
                </div>
            </div>
        </div>

        <div class="user-create-card-header" style="margin-top: 0; padding-top: 0; border-top: 1px solid var(--border); padding-top: 20px;">
            <i class="mdi mdi-pencil-outline"></i>
            <div>
                <div class="user-create-card-title">Informasi Akun</div>
                <div class="user-create-card-sub">Perbarui data profil pengguna</div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

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
                            value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                            required autofocus>
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
                            value="{{ old('email', $user->email) }}"
                            required>
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
                            value="{{ old('no_telepon', $user->no_telepon) }}"
                            placeholder="08xxxxxxxxxx">
                    </div>
                    @error('no_telepon')
                        <span class="fc-hint-error"><i class="mdi mdi-alert-circle-outline"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="user-create-divider">
                    <span>Ubah Password</span>
                </div>

                {{-- Password Baru --}}
                <div class="fc-form-group">
                    <label class="fc-label">Password baru
                        <span class="fc-label-optional">(kosongkan jika tidak diubah)</span>
                    </label>
                    <div class="fc-input-password-wrap">
                        <input type="password" name="password" id="edit-password"
                            class="fc-input @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password">
                        <button type="button" class="fc-input-password-toggle"
                            onclick="togglePassword('edit-password', this)">
                            <i class="mdi mdi-eye-outline"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="fc-hint-error"><i class="mdi mdi-alert-circle-outline"></i> {{ $message }}</span>
                    @enderror
                </div>

            </div>{{-- end form-body --}}

            {{-- Footer actions --}}
            <div class="user-create-footer">
                <a href="{{ route('admin.users.show', $user->id) }}" class="fc-btn fc-btn-ghost">
                    Batal
                </a>
                <button type="submit" class="fc-btn fc-btn-primary">
                    <i class="mdi mdi-content-save-outline"></i> Simpan perubahan
                </button>
            </div>

        </form>
    </div>

    {{-- Info sidebar --}}
    <div class="user-create-info">
        <div class="fc-table-card user-create-info-card">
            <div class="user-create-info-icon" style="background: #e8f4ff; color: #2a7de8;">
                <i class="mdi mdi-information-outline"></i>
            </div>
            <div class="user-create-info-title">Catatan Penting</div>
            <p class="user-create-info-text">
                Perubahan yang disimpan akan langsung berlaku. Pastikan data yang diisi sudah benar.
            </p>
            <div class="user-create-info-divider"></div>
            <ul class="user-create-info-list">
                <li><i class="mdi mdi-check-circle-outline"></i> Email wajib aktif</li>
                <li><i class="mdi mdi-check-circle-outline"></i> Password min. 8 karakter</li>
                <li><i class="mdi mdi-information-outline" style="color:#2a7de8"></i> Kosongkan password jika tidak diubah</li>
            </ul>
        </div>

        {{-- Meta info --}}
        <div class="fc-table-card" style="padding: 16px; margin-top: 0;">
            <div class="user-create-card-title" style="margin-bottom: 12px;">Info Akun</div>
            <div class="user-info-row" style="margin-bottom: 10px;">
                <div class="user-info-icon"><i class="mdi mdi-calendar-outline"></i></div>
                <div class="user-info-content">
                    <div class="user-info-label">Bergabung</div>
                    <div class="user-info-value">{{ $user->created_at?->format('d F Y') ?? '—' }}</div>
                </div>
            </div>
            <div class="user-info-row">
                <div class="user-info-icon"><i class="mdi mdi-clock-outline"></i></div>
                <div class="user-info-content">
                    <div class="user-info-label">Terakhir diperbarui</div>
                    <div class="user-info-value">{{ $user->updated_at?->format('d F Y, H:i') ?? '—' }} WIB</div>
                </div>
            </div>
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