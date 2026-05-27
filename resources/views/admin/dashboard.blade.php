@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="fc-page-header">
    <h1>Dashboard</h1>
</div>

{{-- =========================
STATISTIK ATAS
========================= --}}
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-icon red">
            <i class="mdi mdi-alert-circle-outline"></i>
        </div>

        <div class="stat-number">
            {{ $totalLaporan ?? 0 }}
        </div>

        <div class="stat-label">
            Laporan banjir masuk
        </div>

        <div class="stat-trend up">
            <i class="mdi mdi-trending-up"></i>
            laporan masuk
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="mdi mdi-play-circle-outline"></i>
        </div>

        <div class="stat-number">
            {{ $totalVideo ?? 0 }}
        </div>

        <div class="stat-label">
            Video edukasi aktif
        </div>

        <div class="stat-trend up">
            <i class="mdi mdi-trending-up"></i>
            Total video tersedia
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="mdi mdi-newspaper-variant-outline"></i>
        </div>

        <div class="stat-number">
            {{ $totalArtikel ?? 0 }}
        </div>

        <div class="stat-label">
            Artikel dipublikasi
        </div>

        <div class="stat-trend up">
            <i class="mdi mdi-trending-up"></i>
            Artikel aktif
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon amber">
            <i class="mdi mdi-account-group-outline"></i>
        </div>

        <div class="stat-number">
            {{ $totalUser ?? 0 }}
        </div>

        <div class="stat-label">
            Total user terdaftar
        </div>

        <div class="stat-trend up">
            <i class="mdi mdi-trending-up"></i>
            Semua pengguna sistem
        </div>
    </div>

</div>

{{-- =========================
ROW 2
========================= --}}
<div class="dash-row dash-row-2">

    {{-- =========================
    LAPORAN TERBARU
    ========================= --}}
    <div class="dash-card">

        <div class="dash-card-header">

            <span class="dash-card-title">
                Laporan terbaru
            </span>

            <a href="{{ route('admin.laporan.index') }}"
               class="dash-card-link">
                Lihat semua
            </a>

        </div>

        @forelse($laporanTerbaru as $lap)

            <div class="laporan-item">

                {{-- TITIK WARNA --}}
                <span class="laporan-dot {{ $lap->tingkat_risiko }}"></span>

                <div class="laporan-body">

                    {{-- JUDUL --}}
                    <div class="laporan-lokasi">

                        {{ $lap->judul ?? 'Laporan Banjir' }}

                    </div>

                    {{-- DETAIL --}}
                    <div class="laporan-meta">

                        {{ $lap->alamat_lokasi ?? '-' }}

                        &middot;

                        {{ $lap->tinggi_banjir_cm ?? 0 }} cm

                        &middot;

                        {{ $lap->created_at->diffForHumans() }}

                    </div>

                </div>

                {{-- BADGE --}}
                <span class="status-badge {{ $lap->tingkat_risiko }}">

                    {{ ucfirst(str_replace('_', ' ', $lap->tingkat_risiko)) }}

                </span>

            </div>

        @empty

            <div class="text-muted">
                Belum ada laporan banjir
            </div>

        @endforelse

    </div>

    <div class="dash-card">

        <div class="dash-card-header">

            <span class="dash-card-title">
                Sebaran per wilayah
            </span>

        </div>

        @forelse($sebaranKecamatan as $kec)

            @php
                $max = $sebaranKecamatan->max('jumlah');
                $persen = $max > 0
                    ? ($kec->jumlah / $max) * 100
                    : 0;
            @endphp

            <div class="kecamatan-row">

                {{-- NAMA --}}
                <span class="kec-name">
                    {{ $kec->nama }}
                </span>

                {{-- BAR --}}
                <div class="kec-bar-wrap">

                    <div class="kec-bar"
                         style="width: {{ $persen }}%">
                    </div>

                </div>

                {{-- JUMLAH --}}
                <span class="kec-count">

                    {{ $kec->jumlah }}

                </span>

            </div>

        @empty

            <div class="text-muted">
                Belum ada data wilayah
            </div>

        @endforelse

    </div>

</div>

{{-- =========================
ROW 3
========================= --}}
<div class="dash-row dash-row-3">

    {{-- DONASI --}}
    <div class="summary-card">

        <div class="summary-icon-wrap pink">
            <i class="mdi mdi-heart"></i>
        </div>

        <div class="summary-number">

            Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') }}

        </div>

        <div class="summary-label">
            Total donasi masuk
        </div>

        <div class="summary-sub">

            {{ $jumlahDonatur ?? 0 }} donatur

        </div>

        <a href="{{ route('admin.donasi.index') }}"
           class="dl-btn"
           title="Lihat detail">

            <i class="mdi mdi-arrow-right"></i>

        </a>

    </div>

    {{-- VALIDASI --}}
    <div class="summary-card">

        <div class="summary-icon-wrap red">
            <i class="mdi mdi-alert-outline"></i>
        </div>

        <div class="summary-number">

           <span class="butuh-validasi">{{ $butuhValidasi ?? 0 }}</span>

        </div>

        <div class="summary-label">
            Laporan butuh validasi
        </div>

        <div class="summary-sub">
            Menunggu tindakan admin
        </div>

    </div>

    {{-- RENDAH --}}
    <div class="summary-card">

        <div class="summary-icon-wrap green">
            <i class="mdi mdi-check-circle-outline"></i>
        </div>

        <div class="summary-number">

            {{ $rendahBulanIni ?? 0 }}

        </div>

        <div class="summary-label">
            Laporan rendah bulan ini
        </div>

        <div class="summary-sub">

            Dari total {{ $totalLaporan ?? 0 }} laporan

        </div>


    </div>

</div>

@endsection