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
        <p>Manajemen akun masyarakat, admin &amp; superadmin</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="#" class="fc-btn fc-btn-ghost">
            <i class="mdi mdi-download-outline"></i> Export
        </a>
        <a href="#" class="fc-btn fc-btn-primary">
            <i class="mdi mdi-plus"></i> Tambah admin
        </a>
    </div>
</div>

{{-- Summary --}}
<div class="user-summary-grid">
    <div class="user-summary-card">
        <span class="user-summary-dot" style="background:#ff6600;"></span>
        <div>
            <div class="user-summary-count">{{ $countSuperadmin ?? 2 }}</div>
            <div class="user-summary-label">Superadmin</div>
        </div>
    </div>
    <div class="user-summary-card">
        <span class="user-summary-dot" style="background:#2a7de8;"></span>
        <div>
            <div class="user-summary-count">{{ $countAdmin ?? 8 }}</div>
            <div class="user-summary-label">Admin</div>
        </div>
    </div>
    <div class="user-summary-card">
        <span class="user-summary-dot" style="background:#2abe8a;"></span>
        <div>
            <div class="user-summary-count">{{ $countMasyarakat ?? 132 }}</div>
            <div class="user-summary-label">Masyarakat</div>
        </div>
    </div>
    <div class="user-summary-card">
        <span class="user-summary-dot" style="background:#cc3300;"></span>
        <div>
            <div class="user-summary-count">{{ $countDiblokir ?? 5 }}</div>
            <div class="user-summary-label">Diblokir</div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="user-filter-bar">
    <div class="user-search-wrap">
        <i class="mdi mdi-magnify"></i>
        <input type="text" class="user-search-input" placeholder="Cari nama atau email...">
    </div>
    <select class="user-filter-select">
        <option value="">Semua role</option>
        <option value="superadmin">Superadmin</option>
        <option value="admin">Admin</option>
        <option value="masyarakat">Masyarakat</option>
    </select>
    <select class="user-filter-select">
        <option value="">Semua status</option>
        <option value="aktif">Aktif</option>
        <option value="nonaktif">Nonaktif</option>
        <option value="diblokir">Diblokir</option>
    </select>
    <select class="user-filter-select">
        <option value="">Semua provider</option>
        <option value="email">Email</option>
        <option value="google">Google</option>
    </select>
</div>

{{-- Table --}}
<div class="fc-table-card">
    <table class="fc-table">
        <thead>
            <tr>
                <th width="4%">#</th>
                <th width="30%">Nama &amp; email</th>
                <th width="18%">No. telepon</th>
                <th width="13%">Role</th>
                <th width="15%">Provider</th>
                <th width="10%">Status</th>
                <th width="10%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users ?? [] as $i => $user)
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
            {{-- Dummy data --}}
            @php
            $dummies = [
                ['no'=>1,'nama'=>'Lisa Rahmawati', 'email'=>'lisa@floodcare.id',      'telp'=>'0812-3456-7890','role'=>'superadmin','provider'=>'email', 'status'=>'aktif'],
                ['no'=>2,'nama'=>'Ahmad Fauzi',    'email'=>'fauzi@floodcare.id',     'telp'=>'0856-7890-1234','role'=>'admin',      'provider'=>'email', 'status'=>'aktif'],
                ['no'=>3,'nama'=>'Ahmad Rizki',    'email'=>'rizki.ahmad@gmail.com',  'telp'=>'0878-1234-5678','role'=>'masyarakat', 'provider'=>'google','status'=>'aktif'],
                ['no'=>4,'nama'=>'Dwi Novita',     'email'=>'dwi.novita@gmail.com',   'telp'=>'0821-9876-5432','role'=>'masyarakat', 'provider'=>'google','status'=>'aktif'],
                ['no'=>5,'nama'=>'Rudi Hartono',   'email'=>'rudi.h@yahoo.com',       'telp'=>'0895-5555-3333','role'=>'masyarakat', 'provider'=>'email', 'status'=>'aktif'],
            ];
            $avatarColors = [
                'lisa@floodcare.id'     => '#ff6600',
                'fauzi@floodcare.id'    => '#2a7de8',
                'rizki.ahmad@gmail.com' => '#2abe8a',
                'dwi.novita@gmail.com'  => '#e8a82a',
                'rudi.h@yahoo.com'      => '#9b59b6',
            ];
            @endphp
            @foreach($dummies as $d)
            <tr>
                <td class="user-no">{{ $d['no'] }}</td>
                <td>
                    <div class="user-identity-wrap">
                        <div class="user-avatar" style="background:{{ $avatarColors[$d['email']] }}">
                            {{ strtoupper(substr($d['nama'], 0, 2)) }}
                        </div>
                        <div>
                            <div class="user-nama">{{ $d['nama'] }}</div>
                            <div class="user-email">{{ $d['email'] }}</div>
                        </div>
                    </div>
                </td>
                <td class="user-phone">{{ $d['telp'] }}</td>
                <td>
                    <span class="user-role-badge user-role-{{ $d['role'] }}">{{ ucfirst($d['role']) }}</span>
                </td>
                <td>
                    @if($d['provider'] === 'google')
                    <div class="provider-google">
                        <svg class="provider-google-icon" viewBox="0 0 24 24">
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
                    <span class="user-status-badge user-status-{{ $d['status'] }}">{{ ucfirst($d['status']) }}</span>
                </td>
                <td>
                    <div class="user-aksi">
                        <a href="#" class="fc-btn fc-btn-ghost fc-btn-sm">
                            <i class="mdi mdi-eye-outline"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="user-pagination-wrap">
        <span class="user-pagination-info">
            @isset($users)
                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user
            @else
                Menampilkan 1–5 dari 142 user
            @endisset
        </span>
        <div class="user-pagination">
            <span class="user-page-btn user-page-disabled">‹</span>
            @isset($users)
                @foreach($users->getUrlRange(1, min($users->lastPage(), 5)) as $page => $url)
                <a href="{{ $url }}" class="user-page-btn {{ $page == $users->currentPage() ? 'user-page-active' : '' }}">
                    {{ $page }}
                </a>
                @endforeach
                @if($users->lastPage() > 5)
                <span class="user-page-ellipsis">...</span>
                <a href="{{ $users->url($users->lastPage()) }}" class="user-page-btn">{{ $users->lastPage() }}</a>
                @endif
            @else
                <a href="#" class="user-page-btn user-page-active">1</a>
                <a href="#" class="user-page-btn">2</a>
                <a href="#" class="user-page-btn">3</a>
                <span class="user-page-ellipsis">...</span>
                <a href="#" class="user-page-btn">29</a>
            @endisset
            <a href="#" class="user-page-btn">›</a>
        </div>
    </div>
</div>

@endsection