@extends('layouts.admin')

@section('title', 'Kelola User')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets_admin/css/user.css') }}">
@endsection

@section('content')

{{-- Header --}}
<div class="fc-page-header" style="display:flex; align-items:flex-start; justify-content:space-between;">
    <div>
        <h1>Kelola User</h1>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="#" class="fc-btn fc-btn-ghost">
            <i class="mdi mdi-download-outline"></i> Export
        </a>
        <!-- <a href="#" class="fc-btn fc-btn-primary">
            <i class="mdi mdi-plus"></i> Tambah admin
        </a> -->
    </div>
</div>

{{-- Alert --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Summary --}}
<div class="user-summary-grid">
    <div class="user-summary-card">
        <span class="user-summary-dot" style="background:#ff6600;"></span>
        <div>
            <div class="user-summary-count">{{ $countSuperadmin }}</div>
            <div class="user-summary-label">Superadmin</div>
        </div>
    </div>
    <div class="user-summary-card">
        <span class="user-summary-dot" style="background:#2a7de8;"></span>
        <div>
            <div class="user-summary-count">{{ $countAdmin }}</div>
            <div class="user-summary-label">Admin</div>
        </div>
    </div>
    <div class="user-summary-card">
        <span class="user-summary-dot" style="background:#2abe8a;"></span>
        <div>
            <div class="user-summary-count">{{ $countMasyarakat }}</div>
            <div class="user-summary-label">Masyarakat</div>
        </div>
    </div>
    <div class="user-summary-card">
        <span class="user-summary-dot" style="background:#cc3300;"></span>
        <div>
            <div class="user-summary-count">{{ $countDiblokir }}</div>
            <div class="user-summary-label">Diblokir</div>
        </div>
    </div>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.users.index') }}">
<div class="user-filter-bar">
    <div class="user-search-wrap">
        <i class="mdi mdi-magnify"></i>
        <input type="text" name="search" class="user-search-input"
            placeholder="Cari nama atau email..."
            value="{{ request('search') }}">
    </div>
    <select name="role" class="user-filter-select" onchange="this.form.submit()">
        <option value="">Semua role</option>
        <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
        <option value="admin"      {{ request('role') == 'admin'      ? 'selected' : '' }}>Admin</option>
        <option value="masyarakat" {{ request('role') == 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
    </select>
    <select name="status" class="user-filter-select" onchange="this.form.submit()">
        <option value="">Semua status</option>
        <option value="aktif"    {{ request('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        <option value="diblokir" {{ request('status') == 'diblokir' ? 'selected' : '' }}>Diblokir</option>
    </select>
    <select name="provider" class="user-filter-select" onchange="this.form.submit()">
        <option value="">Semua provider</option>
        <option value="email"  {{ request('provider') == 'email'  ? 'selected' : '' }}>Email</option>
        <option value="google" {{ request('provider') == 'google' ? 'selected' : '' }}>Google</option>
    </select>
</div>
</form>

{{-- Table --}}
<div class="fc-table-card">
    <table class="fc-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="30%">Nama &amp; email</th>
                <th width="18%">No. telepon</th>
                <th width="13%">Role</th>
                <th width="15%">Provider</th>
                <th width="10%">Status</th>
                <th width="10%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            @php
                $colors = ['#ff6600','#2a7de8','#2abe8a','#e8a82a','#9b59b6','#e84393'];
                $color  = $colors[crc32($user->email) % count($colors)];
            @endphp
            <tr>
                <td class="user-no">{{ $users->firstItem() + $i }}</td>
                <td>
                    <div class="user-identity-wrap">
                        <div class="user-avatar" style="background:{{ $color }}">
                            {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                        </div>
                        <div>
                            <div class="user-nama">{{ $user->nama_lengkap }}</div>
                            <div class="user-email">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="user-phone">{{ $user->no_telepon ?? '—' }}</td>
                <td>
                    <span class="user-role-badge user-role-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    @if($user->provider === 'google')
                    <div class="provider-google">
                        <svg class="provider-google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Google
                    </div>
                    @else
                    <div class="user-provider-wrap">
                        <i class="mdi mdi-email-outline"></i> Email
                    </div>
                    @endif
                </td>
                <td>
                    <span class="user-status-badge user-status-{{ $user->status ?? 'aktif' }}">
                        {{ ucfirst($user->status ?? 'Aktif') }}
                    </span>
                </td>
                <td>
                    <div class="user-aksi">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="fc-btn fc-btn-ghost fc-btn-sm">
                            <i class="mdi mdi-eye-outline"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="fc-table-empty text-center py-4">
                    <i class="mdi mdi-account-off mdi-36px d-block mb-2"></i>
                    Tidak ada user ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="user-pagination-wrap">
        <span class="user-pagination-info">
            Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
        </span>
        <div class="user-pagination">
            {{-- Prev --}}
            @if($users->onFirstPage())
                <span class="user-page-btn user-page-disabled">‹</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="user-page-btn">‹</a>
            @endif

            {{-- Pages --}}
            @foreach($users->getUrlRange(1, min($users->lastPage(), 5)) as $page => $url)
                <a href="{{ $url }}" class="user-page-btn {{ $page == $users->currentPage() ? 'user-page-active' : '' }}">
                    {{ $page }}
                </a>
            @endforeach

            @if($users->lastPage() > 5)
                <span class="user-page-ellipsis">...</span>
                <a href="{{ $users->url($users->lastPage()) }}" class="user-page-btn">
                    {{ $users->lastPage() }}
                </a>
            @endif

            {{-- Next --}}
            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="user-page-btn">›</a>
            @else
                <span class="user-page-btn user-page-disabled">›</span>
            @endif
        </div>
    </div>
</div>

@endsection