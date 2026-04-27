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
            <div class="user-aksi-grid">
                <a href="#" class="fc-btn fc-btn-ghost">
                    <i class="mdi mdi-pencil-outline"></i> Edit profil
                </a>
                <button type="button" class="fc-btn fc-btn-ghost"
                    onclick="document.getElementById('modal-role').style.display='flex'">
                    <i class="mdi mdi-account-convert-outline"></i> Ubah role
                </button>

                {{-- Nonaktifkan / Aktifkan --}}
                <form method="POST" action="{{ route('admin.users.status', $user->id) }}" class="fc-btn-full">
                    @csrf @method('PATCH')
                    <button type="submit" class="fc-btn fc-btn-warning">
                        <i class="mdi mdi-pause-circle-outline"></i>
                        {{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>

                {{-- Blokir --}}
                @if($user->status !== 'diblokir')
                <form method="POST" action="{{ route('admin.users.blokir', $user->id) }}" class="fc-btn-full"
                    onsubmit="return confirm('Yakin ingin memblokir user ini?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="fc-btn fc-btn-danger">
                        <i class="mdi mdi-cancel"></i> Blokir user ini
                    </button>
                </form>
                @else
                <div class="fc-btn fc-btn-danger" style="opacity:0.5; cursor:not-allowed;">
                    <i class="mdi mdi-cancel"></i> User diblokir
                </div>
                @endif

            </div>
        </div>

    </div>

    {{-- KOLOM KANAN --}}
    <div>

        {{-- Stat mini --}}
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
                    <div class="user-stat-mini-num">{{ $totalKonfirmasi ?? 0 }}</div>
                    <div class="user-stat-mini-label">Konfirmasi laporan</div>
                </div>
            </div>
        </div>

        {{-- Tab --}}
        <div class="user-tab-card">
            <div class="user-tab-header">
                <button class="user-tab-btn active" data-tab="laporan">Laporan banjir</button>
                <button class="user-tab-btn" data-tab="konfirmasi">Konfirmasi</button>
            </div>
            <div class="user-tab-content">

                {{-- Tab Laporan --}}
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
                            @php
                                $risiko = $lap->tingkat_risiko ?? 'rendah';
                            @endphp
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

                {{-- Tab Konfirmasi --}}
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
                            @forelse($konfirmasiUser ?? [] as $i => $k)
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

    </div>
</div>

{{-- Modal Ubah Role --}}
<div id="modal-role" class="fc-modal-backdrop" style="display:none;">
    <div class="fc-modal-box">
        <button type="button" class="fc-btn fc-btn-ghost"
            onclick="document.getElementById('modal-role').classList.add('open')">
            <i class="mdi mdi-account-convert-outline"></i> Ubah role
        </button>
        <p class="fc-modal-sub">Mengubah role untuk <strong>{{ $user->nama_lengkap }}</strong></p>
        <form method="POST" action="{{ route('admin.users.role', $user->id) }}">
            @csrf @method('PATCH')
            <div class="fc-form-group">
                <label class="fc-label">Role baru</label>
                <select name="role" class="fc-select">
                    <option value="masyarakat" {{ $user->role === 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                    <option value="admin"      {{ $user->role === 'admin'      ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ $user->role === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>
            </div>
            <div class="fc-modal-actions">
                <button type="button" class="fc-btn fc-btn-ghost fc-btn-full"
                    onclick="document.getElementById('modal-role').style.display='none'">
                    Batal
                </button>
                <button type="submit" class="fc-btn fc-btn-primary fc-btn-full">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets_admin/js/user.js') }}"></script>
@endpush