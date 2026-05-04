@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="fc-page-header">
    <h1>Dashboard</h1>
    <p>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon red"><i class="mdi mdi-alert-circle-outline"></i></div>
        <div class="stat-number">{{ $totalLaporan ?? 24 }}</div>
        <div class="stat-label">Laporan banjir masuk</div>
        <div class="stat-trend up"><i class="mdi mdi-trending-up"></i> +8% minggu ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="mdi mdi-play-circle-outline"></i></div>
        <div class="stat-number">{{ $totalVideo ?? 12 }}</div>
        <div class="stat-label">Video edukasi aktif</div>
        <div class="stat-trend up"><i class="mdi mdi-trending-up"></i> +2 bulan ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="mdi mdi-newspaper-variant-outline"></i></div>
        <div class="stat-number">{{ $totalArtikel ?? 38 }}</div>
        <div class="stat-label">Artikel dipublikasi</div>
        <div class="stat-trend up"><i class="mdi mdi-trending-up"></i> +5 bulan ini</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber"><i class="mdi mdi-account-group-outline"></i></div>
        <div class="stat-number">{{ $totalUser ?? 142 }}</div>
        <div class="stat-label">Total user terdaftar</div>
        <div class="stat-trend up"><i class="mdi mdi-trending-up"></i> +14 minggu ini</div>
    </div>
</div>

<div class="dash-row dash-row-2">

    <div class="dash-card">
        <div class="dash-card-header">
            <span class="dash-card-title">Laporan terbaru</span>
            <a href="{{ route('admin.laporan.index') }}" class="dash-card-link">Lihat semua</a>
        </div>
        @forelse($laporanTerbaru ?? [] as $lap)
        <div class="laporan-item">
            <span class="laporan-dot {{ $lap->tingkat_banjir }}"></span>
            <div class="laporan-body">
                <div class="laporan-lokasi">{{ $lap->lokasi }}</div>
                <div class="laporan-meta">{{ $lap->created_at->diffForHumans() }} &middot; {{ $lap->tinggi_air }}cm</div>
            </div>
            <span class="status-badge {{ $lap->tingkat_banjir }}">{{ ucfirst($lap->tingkat_banjir) }}</span>
        </div>
        @empty
        @php
        $dummies = [
            ['lokasi'=>'Jl. Mastrip, Jember',    'waktu'=>'2 jam lalu', 'tinggi'=>'60','tingkat'=>'tinggi'],
            ['lokasi'=>'Griya Indah, Bondowoso', 'waktu'=>'5 jam lalu', 'tinggi'=>'30','tingkat'=>'sedang'],
            ['lokasi'=>'Ds. Sukorambi, Jember',  'waktu'=>'Kemarin',    'tinggi'=>'15','tingkat'=>'rendah'],
            ['lokasi'=>'Jl. Kaliurang, Jember',  'waktu'=>'Kemarin',    'tinggi'=>'25','tingkat'=>'sedang'],
        ];
        @endphp
        @foreach($dummies as $d)
        <div class="laporan-item">
            <span class="laporan-dot {{ $d['tingkat'] }}"></span>
            <div class="laporan-body">
                <div class="laporan-lokasi">{{ $d['lokasi'] }}</div>
                <div class="laporan-meta">{{ $d['waktu'] }} &middot; {{ $d['tinggi'] }}cm</div>
            </div>
            <span class="status-badge {{ $d['tingkat'] }}">{{ ucfirst($d['tingkat']) }}</span>
        </div>
        @endforeach
        @endforelse
    </div>

    <div class="dash-card">
        <div class="dash-card-header">
            <span class="dash-card-title">Sebaran per kecamatan</span>
        </div>
        @php
        $sebaran = $sebaranKecamatan ?? collect([
            ['nama'=>'Sumbersari','jumlah'=>18],
            ['nama'=>'Kaliwates', 'jumlah'=>12],
            ['nama'=>'Patrang',   'jumlah'=>9],
            ['nama'=>'Ambulu',    'jumlah'=>5],
            ['nama'=>'Wuluhan',   'jumlah'=>3],
            ['nama'=>'Pakusari',  'jumlah'=>2],
        ]);
        $maxSebaran = collect($sebaran)->max('jumlah');
        @endphp
        @foreach($sebaran as $kec)
        @php
        $jumlah = is_array($kec) ? $kec['jumlah'] : $kec->jumlah;
        $nama   = is_array($kec) ? $kec['nama']   : $kec->nama;
        $persen = $maxSebaran > 0 ? round(($jumlah / $maxSebaran) * 100) : 0;
        @endphp
        <div class="kecamatan-row">
            <span class="kec-name">{{ $nama }}</span>
            <div class="kec-bar-wrap"><div class="kec-bar" style="width:{{ $persen }}%"></div></div>
            <span class="kec-count">{{ $jumlah }}</span>
        </div>
        @endforeach
    </div>

</div>

<div class="dash-row dash-row-3">
    <div class="summary-card">
        <div class="summary-icon-wrap pink"><i class="mdi mdi-heart"></i></div>
        <div class="summary-number">Rp {{ number_format($totalDonasi ?? 4200000, 0, ',', '.') }}</div>
        <div class="summary-label">Total donasi masuk</div>
        <div class="summary-sub">{{ $jumlahDonatur ?? 28 }} donatur &middot; bulan ini</div>
        <a href="{{ route('admin.donasi.index') }}" class="dl-btn" title="Lihat detail">
            <i class="mdi mdi-arrow-right"></i>
        </a>
    </div>
    <div class="summary-card">
        <div class="summary-icon-wrap red"><i class="mdi mdi-alert-outline"></i></div>
        <div class="summary-number">{{ $butuhValidasi ?? 7 }}</div>
        <div class="summary-label">Laporan butuh validasi</div>
        <div class="summary-sub">Perlu ditindaklanjuti segera</div>
    </div>
    <div class="summary-card">
        <div class="summary-icon-wrap green"><i class="mdi mdi-check-circle-outline"></i></div>
        <div class="summary-number">{{ $rendahBulanIni ?? 19 }}</div>
        <div class="summary-label">Laporan rendah bulan ini</div>
        <div class="summary-sub">Dari total {{ $totalLaporan ?? 24 }} laporan masuk</div>
    </div>
</div>

@endsection