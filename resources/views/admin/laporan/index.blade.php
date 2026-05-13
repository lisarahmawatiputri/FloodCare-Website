@extends('layouts.admin')

@section('title', 'Laporan Banjir')

@section('content')

<div class="fc-page-header">
    <div>
        <h1 class="fc-page-title">Laporan Banjir</h1>
    </div>
</div>

@if(session('success'))
<div class="fc-alert fc-alert-success">
    <i class="mdi mdi-check-circle-outline"></i> {{ session('success') }}
</div>
@endif

{{-- Stat cards --}}
<div class="flp-stat-row">
    <div class="flp-stat-card">
        <span class="flp-stat-dot flp-dot-gray"></span>
        <div>
            <div class="flp-stat-num">{{ $countMenunggu }}</div>
            <div class="flp-stat-label">Menunggu</div>
        </div>
    </div>
    <div class="flp-stat-card">
        <span class="flp-stat-dot flp-dot-green"></span>
        <div>
            <div class="flp-stat-num">{{ $countValid }}</div>
            <div class="flp-stat-label">Valid</div>
        </div>
    </div>
    <div class="flp-stat-card">
        <span class="flp-stat-dot flp-dot-red"></span>
        <div>
            <div class="flp-stat-num">{{ $countTidakValid }}</div>
            <div class="flp-stat-label">Tidak valid</div>
        </div>
    </div>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.laporan.index') }}">
<div class="fc-card fc-filter-card flp-filter-card-wrap">
    <div class="fc-filter-bar">
        <div class="fc-search-wrap">
            <i class="mdi mdi-magnify fc-search-icon"></i>
            <input type="text" name="search" class="fc-input fc-search-input"
                placeholder="Cari laporan..."
                value="{{ request('search') }}">
        </div>
        <div class="fc-status-select-wrap">
            <select name="status" class="fc-input fc-select fc-status-select" onchange="this.form.submit()">
                <option value="">Semua status</option>
                <option value="menunggu"    {{ request('status') == 'menunggu'    ? 'selected' : '' }}>Menunggu</option>
                <option value="valid"       {{ request('status') == 'valid'       ? 'selected' : '' }}>Valid</option>
                <option value="tidak_valid" {{ request('status') == 'tidak_valid' ? 'selected' : '' }}>Tidak valid</option>
            </select>
        </div>
        <div class="fc-status-select-wrap">
            <select name="risiko" class="fc-input fc-select fc-status-select" onchange="this.form.submit()">
                <option value="">Semua risiko</option>
                <option value="tinggi"  {{ request('risiko') == 'tinggi'  ? 'selected' : '' }}>Tinggi</option>
                <option value="sedang"  {{ request('risiko') == 'sedang'  ? 'selected' : '' }}>Sedang</option>
                <option value="rendah"  {{ request('risiko') == 'rendah'  ? 'selected' : '' }}>Rendah</option>
            </select>
        </div>
        <span class="fc-filter-count">{{ $totalLaporan }} laporan</span>
    </div>
</div>
</form>

{{-- Table --}}
<div class="fc-card fc-card-table">
    <div class="fc-table-wrap">
        <table class="fc-table">
            <thead>
                <tr>
                    <th class="flp-col-no">No</th>
                    <th>Pelapor & judul</th>
                    <th>Alamat</th>
                    <th>Tinggi air</th>
                    <th>Risiko</th>
                    <th class="flp-col-foto">Foto</th>
                    <th>Status</th>
                    <th class="flp-col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $i => $laporan)
                @php
                    $colors  = ['#ff6a3d','#3d9fff','#ff6600','#9b59b6','#2abe8a','#e8a82a'];
                    $inisial = strtoupper(substr(optional($laporan->pelapor)->nama_lengkap ?? 'U', 0, 2));
                    $color   = $colors[crc32(optional($laporan->pelapor)->email ?? '') % count($colors)];
                @endphp
                <tr>
                    <td class="flp-num">{{ $laporans->firstItem() + $i }}</td>
                    <td>
                        <div class="flp-pelapor-wrap">
                            <div class="flp-avatar" style="background:{{ $color }};">{{ $inisial }}</div>
                            <div>
                                <div class="fc-table-title">{{ $laporan->judul }}</div>
                                <div class="fc-table-meta">{{ optional($laporan->pelapor)->nama_lengkap ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($laporan->latitude && $laporan->longitude)
                            <a href="https://www.google.com/maps?q={{ $laporan->latitude }},{{ $laporan->longitude }}"
                               target="_blank" class="flp-alamat-link">
                                {{ $laporan->alamat_lokasi ?? 'Lihat lokasi' }}
                            </a>
                        @else
                            <span class="flp-alamat-text">{{ $laporan->alamat_lokasi ?? '—' }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="flp-water flp-water-{{ $laporan->tingkat_risiko ?? 'rendah' }}">
                            {{ $laporan->tinggi_banjir_cm ?? '—' }} cm
                        </span>
                    </td>
                    <td>
                        <span class="fc-badge-status flp-badge-{{ $laporan->tingkat_risiko ?? 'rendah' }}">
                            {{ ucfirst($laporan->tingkat_risiko ?? '—') }}
                        </span>
                    </td>
                    <td>
                        <div class="flp-foto-thumb">
                            @if($laporan->foto_laporan)
                                <img src="{{ asset('storage/'.$laporan->foto_laporan) }}"
                                     class="flp-foto-thumb-img">
                            @else
                                <i class="mdi mdi-image-outline"></i>
                            @endif
                        </div>
                    </td>
                    <td>
                        @php
                            $statusClass = [
                                'menunggu'    => 'flp-badge-menunggu',
                                'valid'       => 'flp-badge-valid',
                                'tidak_valid' => 'flp-badge-tidak-valid',
                                'diterima'    => 'flp-badge-diterima',
                            ][$laporan->status_laporan ?? 'menunggu'] ?? 'flp-badge-menunggu';
                            $statusLabel = [
                                'menunggu'    => 'Menunggu',
                                'valid'       => 'Valid',
                                'tidak_valid' => 'Tidak valid',
                                'diterima'    => 'Diterima',
                            ][$laporan->status_laporan ?? 'menunggu'] ?? 'Menunggu';
                        @endphp
                        <span class="fc-badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td>
                        <div class="fc-action-group">
                            <a href="{{ route('admin.laporan.show', $laporan->id) }}"
                               class="fc-action-btn" title="Detail">
                                <i class="mdi mdi-eye-outline"></i>
                            </a>
                            <form action="{{ route('admin.laporan.destroy', $laporan->id) }}"
                                  method="POST" class="flp-form-inline"
                                  onsubmit="return confirm('Hapus laporan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="fc-action-btn fc-action-btn-danger" title="Hapus">
                                    <i class="mdi mdi-trash-can-outline"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="fc-table-empty">
                        <i class="mdi mdi-water-off-outline"></i>
                        Belum ada laporan masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flp-pagination">
        <span class="flp-page-info">
            Menampilkan {{ $laporans->firstItem() }}–{{ $laporans->lastItem() }}
            dari {{ $laporans->total() }} laporan
        </span>
        <div class="flp-page-btns">
            @if($laporans->onFirstPage())
                <button class="flp-page-btn" disabled><i class="mdi mdi-chevron-left"></i></button>
            @else
                <a href="{{ $laporans->previousPageUrl() }}" class="flp-page-btn">
                    <i class="mdi mdi-chevron-left"></i>
                </a>
            @endif

            @foreach($laporans->getUrlRange(1, $laporans->lastPage()) as $page => $url)
                <a href="{{ $url }}"
                   class="flp-page-btn {{ $page == $laporans->currentPage() ? 'flp-page-active' : '' }}">
                    {{ $page }}
                </a>
            @endforeach

            @if($laporans->hasMorePages())
                <a href="{{ $laporans->nextPageUrl() }}" class="flp-page-btn">
                    <i class="mdi mdi-chevron-right"></i>
                </a>
            @else
                <button class="flp-page-btn" disabled><i class="mdi mdi-chevron-right"></i></button>
            @endif
        </div>
    </div>
</div>

@endsection