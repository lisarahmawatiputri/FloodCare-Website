@extends('layouts.admin')

@section('title', 'Detail User')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('assets_admin/css/user.css') }}">
@endsection

@section('content')

{{-- Header --}}
<div class="fc-page-header">
    <div>
        <h1 class="fc-page-title">Detail User</h1>
    </div>
    <a href="{{ route('admin.users.index') }}" class="fc-btn fc-btn-ghost">
        <i class="mdi mdi-arrow-left"></i> Kembali
    </a>
</div>

@php
$initials = strtoupper(substr($user->nama_lengkap, 0, 2));
$colors   = ['#ff6600','#2a7de8','#2abe8a','#e8a82a','#9b59b6'];
$color    = $colors[crc32($user->email) % count($colors)];
@endphp

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="user-show-grid">

    {{-- KOLOM KIRI --}}
    <div>

        {{-- Profile Card --}}
        <div class="user-profile-card">
            <div class="user-profile-avatar" style="background:{{ $color }}">
                {{ $initials }}
            </div>
            <div class="user-profile-name">{{ $user->nama_lengkap }}</div>
            <div class="user-profile-email">{{ $user->email }}</div>

            <div class="user-profile-tags">
                <span class="user-tag tag-role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                <span class="user-tag tag-{{ $user->status ?? 'aktif' }}">{{ ucfirst($user->status ?? 'Aktif') }}</span>
                <span class="user-tag tag-{{ $user->provider ?? 'email' }}">{{ ucfirst($user->provider ?? 'Email') }}</span>
            </div>

            <hr class="user-profile-divider">

            <div class="user-info-list">
                <div class="user-info-row">
                    <div class="user-info-icon"><i class="mdi mdi-phone-outline"></i></div>
                    <div class="user-info-content">
                        <div class="user-info-label">No. telepon</div>
                        <div class="user-info-value">{{ $user->no_telepon ?? '—' }}</div>
                    </div>
                </div>
                <div class="user-info-row">
                    <div class="user-info-icon"><i class="mdi mdi-calendar-outline"></i></div>
                    <div class="user-info-content">
                        <div class="user-info-label">Bergabung</div>
                        <div class="user-info-value">
                            {{ $user->created_at ? $user->created_at->format('d F Y') : '—' }}
                        </div>
                    </div>
                </div>
                <div class="user-info-row">
                    <div class="user-info-icon"><i class="mdi mdi-clock-outline"></i></div>
                    <div class="user-info-content">
                        <div class="user-info-label">Terakhir update</div>
                        <div class="user-info-value">
                            {{ $user->updated_at ? $user->updated_at->format('d F Y, H:i') . ' WIB' : '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aksi Card --}}
        <div class="user-aksi-card">
            <div class="user-aksi-title">Aksi akun</div>
            <div class="user-aksi-actions">

                {{-- Edit Profil --}}
                <a href="{{ route('admin.users.edit', $user->id) }}" class="fc-btn fc-btn-ghost fc-btn-full">
                    <i class="mdi mdi-pencil-outline"></i> Edit profil
                </a>

                {{-- Blokir / Sudah diblokir --}}
                @if($user->status !== 'diblokir')
                <form method="POST" action="{{ route('admin.users.blokir', $user->id) }}" class="fc-btn-full"
                    onsubmit="return confirm('Yakin ingin memblokir user ini?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="fc-btn fc-btn-danger fc-btn-full">
                        <i class="mdi mdi-cancel"></i> Blokir akun
                    </button>
                </form>
                @else
                <div class="fc-btn fc-btn-danger fc-btn-full" style="opacity:0.5; cursor:not-allowed; justify-content:center;">
                    <i class="mdi mdi-cancel"></i> User diblokir
                </div>
                @endif

            </div>
        </div>

    </div>

    {{-- KOLOM KANAN --}}
    <div>

        {{-- ========== SUPERADMIN: stat keduanya + tab laporan & konfirmasi ========== --}}
        @if($user->role === 'superadmin')

        <div class="user-stat-mini-grid">
            <div class="user-stat-mini">
                <div class="user-stat-mini-icon red">
                    <i class="mdi mdi-alert-circle-outline"></i>
                </div>
                <div>
                    <div class="user-stat-mini-num">{{ $totalLaporan }}</div>
                    <div class="user-stat-mini-label">Total laporan</div>
                </div>
            </div>
            <div class="user-stat-mini">
                <div class="user-stat-mini-icon green">
                    <i class="mdi mdi-check-circle-outline"></i>
                </div>
                <div>
                    <div class="user-stat-mini-num">{{ $totalKonfirmasi }}</div>
                    <div class="user-stat-mini-label">Konfirmasi laporan</div>
                </div>
            </div>
        </div>

        <div class="user-tab-card">
            <div class="user-tab-header">
                <button class="user-tab-btn active" data-tab="laporan">Laporan banjir</button>
                <button class="user-tab-btn" data-tab="konfirmasi">Konfirmasi</button>
            </div>
            <div class="user-tab-content">

                <div class="user-tab-pane active" id="tab-laporan">
                    <table class="user-inner-table">
                        <thead>
                            <tr>
                                <th width="6%">No</th>
                                <th>Judul laporan</th>
                                <th width="14%">Tinggi air</th>
                                <th width="14%">Risiko</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanUser as $i => $lap)
                            @php $risiko = $lap->tingkat_risiko ?? 'rendah'; @endphp
                            <tr>
                                <td class="user-no">{{ $i + 1 }}</td>
                                <td class="user-nama">{{ $lap->judul }}</td>
                                <td>
                                    <span class="user-tinggi-{{ $risiko }}">{{ $lap->tinggi_air ?? '—' }} cm</span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $risiko }}">{{ ucfirst($risiko) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="fc-table-empty">Belum ada laporan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="user-tab-pane" id="tab-konfirmasi">
                    <table class="user-inner-table">
                        <thead>
                            <tr>
                                <th width="6%">No</th>
                                <th>Laporan dikonfirmasi</th>
                                <th width="20%">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($konfirmasiUser as $i => $k)
                            <tr>
                                <td class="user-no">{{ $i + 1 }}</td>
                                <td class="user-nama">{{ $k->laporan->judul ?? '—' }}</td>
                                <td class="user-email">{{ $k->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="fc-table-empty">Belum ada konfirmasi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        @elseif($user->role === 'masyarakat')

        <div class="user-stat-mini-grid">
            <div class="user-stat-mini">
                <div class="user-stat-mini-icon red">
                    <i class="mdi mdi-alert-circle-outline"></i>
                </div>
                <div>
                    <div class="user-stat-mini-num">{{ $totalLaporan }}</div>
                    <div class="user-stat-mini-label">Total laporan</div>
                </div>
            </div>
        </div>

        <div class="user-tab-card">
            <div class="user-tab-header">
                <button class="user-tab-btn active" data-tab="laporan">Laporan banjir</button>
            </div>
            <div class="user-tab-content">

                <div class="user-tab-pane active" id="tab-laporan">
                    <table class="user-inner-table">
                        <thead>
                            <tr>
                                <th width="6%">No</th>
                                <th>Judul laporan</th>
                                <th width="14%">Tinggi air</th>
                                <th width="14%">Risiko</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanUser as $i => $lap)
                            @php $risiko = $lap->tingkat_risiko ?? 'rendah'; @endphp
                            <tr>
                                <td class="user-no">{{ $i + 1 }}</td>
                                <td class="user-nama">{{ $lap->judul }}</td>
                                <td>
                                    <span class="user-tinggi-{{ $risiko }}">{{ $lap->tinggi_air ?? '—' }} cm</span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $risiko }}">{{ ucfirst($risiko) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="fc-table-empty">Belum ada laporan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        {{-- ========== ADMIN: stat konfirmasi + tab konfirmasi ========== --}}
       @else

<div class="user-stat-mini-grid">
    <div class="user-stat-mini">
        <div class="user-stat-mini-icon red">
            <i class="mdi mdi-check-decagram-outline"></i>
        </div>
        <div>
            <div class="user-stat-mini-num">{{ $totalLaporan }}</div>
            <div class="user-stat-mini-label">Laporan divalidasi</div>
        </div>
    </div>
    <div class="user-stat-mini">
        <div class="user-stat-mini-icon green">
            <i class="mdi mdi-check-circle-outline"></i>
        </div>
        <div>
            <div class="user-stat-mini-num">{{ $totalKonfirmasi }}</div>
            <div class="user-stat-mini-label">Konfirmasi laporan</div>
        </div>
    </div>
</div>

<div class="user-tab-card">
    <div class="user-tab-header">
        <button class="user-tab-btn active" data-tab="validasi">Laporan divalidasi</button>
        <button class="user-tab-btn" data-tab="konfirmasi">Konfirmasi</button>
    </div>
    <div class="user-tab-content">

        {{-- Tab laporan divalidasi --}}
        <div class="user-tab-pane active" id="tab-validasi">
            <table class="user-inner-table">
                <thead>
                    <tr>
                        <th width="6%">No</th>
                        <th>Judul laporan</th>
                        <th width="14%">Status</th>
                        <th width="18%">Tanggal validasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanUser as $i => $lap)
                    <tr>
                        <td class="user-no">{{ $i + 1 }}</td>
                        <td class="user-nama">{{ $lap->judul }}</td>
                        <td>
                            <span class="fc-badge-status flp-badge-{{ $lap->status_laporan ?? 'menunggu' }}">
                                {{ ['menunggu'=>'Menunggu','valid'=>'Valid','tidak_valid'=>'Tidak Valid'][$lap->status_laporan] ?? '—' }}
                            </span>
                        </td>
                        <td class="user-email">
                            {{ $lap->updated_at ? $lap->updated_at->format('d M Y, H:i') : '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="fc-table-empty">Belum ada laporan divalidasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tab konfirmasi --}}
        <div class="user-tab-pane" id="tab-konfirmasi">
            <table class="user-inner-table">
                <thead>
                    <tr>
                        <th width="6%">No</th>
                        <th>Laporan dikonfirmasi</th>
                        <th width="20%">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($konfirmasiUser as $i => $k)
                    <tr>
                        <td class="user-no">{{ $i + 1 }}</td>
                        <td class="user-nama">{{ $k->laporan->judul ?? '—' }}</td>
                        <td class="user-email">{{ $k->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="fc-table-empty">Belum ada konfirmasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endif

    </div>
</div>


@endsection
