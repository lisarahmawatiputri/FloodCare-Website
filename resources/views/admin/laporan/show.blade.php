@extends('layouts.admin')

@section('title', 'Detail Laporan')

@section('content')

<div class="fc-page-header">
    <div>
        <!-- <div class="flp-breadcrumb-wrap">
            <span class="flp-breadcrumb-text">
                Laporan Banjir /
                <span class="flp-breadcrumb-current">{{ $laporan->judul }}</span>
            </span>
        </div> -->
        <h1 class="fc-page-title">Detail Laporan</h1>
    </div>
    <a href="{{ route('admin.laporan.index') }}" class="fc-btn fc-btn-secondary">
        <i class="mdi mdi-arrow-left"></i> Kembali
    </a>
</div>

@if(session('success'))
<div class="fc-alert fc-alert-success">
    <i class="mdi mdi-check-circle-outline"></i> {{ session('success') }}
</div>
@endif

<div class="flp-detail-grid">

    {{-- KOLOM KIRI --}}
    <div class="flp-detail-left">

        {{-- Foto laporan --}}
        <div class="fc-card fc-form-card">
            <h2 class="fc-form-section-title">Info laporan</h2>
            <div class="flp-foto-box">
                @if($laporan->foto_laporan)
                    <img src="{{ asset('storage/'.$laporan->foto_laporan) }}" class="flp-foto-box-img">
                @else
                    <i class="mdi mdi-image-outline flp-foto-placeholder-icon"></i>
                    <span class="flp-foto-placeholder-label">Foto laporan</span>
                @endif
            </div>
        </div>

        {{-- Info grid --}}
        <div class="fc-card fc-form-card">
            <div class="flp-info-grid">
                <div class="flp-info-cell">
                    <div class="flp-info-label">Pelapor</div>
                    <div class="flp-info-value">
                        {{ optional($laporan->pelapor)->nama_lengkap ?? '—' }}
                    </div>
                </div>
                <div class="flp-info-cell">
                    <div class="flp-info-label">Tanggal lapor</div>
                    <div class="flp-info-value">
                        {{ $laporan->created_at ? $laporan->created_at->format('d M Y, H:i') : '—' }}
                    </div>
                </div>
                <div class="flp-info-cell">
                    <div class="flp-info-label">Tinggi banjir</div>
                    <div class="flp-info-value flp-water-{{ $laporan->tingkat_risiko ?? 'rendah' }}">
                        {{ $laporan->tinggi_banjir_cm ?? '—' }} cm
                    </div>
                </div>
                <div class="flp-info-cell">
                    <div class="flp-info-label">Tingkat risiko</div>
                    <div class="flp-info-value">
                        <span class="fc-badge-status flp-badge-{{ $laporan->tingkat_risiko ?? 'rendah' }}">
                            {{ ucfirst($laporan->tingkat_risiko ?? '—') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flp-info-cell flp-info-cell-mt">
                <div class="flp-info-label">Alamat</div>
                <div class="flp-info-value">
                    @if($laporan->latitude && $laporan->longitude)
                        <a href="https://www.google.com/maps?q={{ $laporan->latitude }},{{ $laporan->longitude }}"
                           target="_blank" class="flp-alamat-link">
                            {{ $laporan->alamat_lokasi ?? 'Lihat lokasi' }}
                        </a>
                    @else
                        {{ $laporan->alamat_lokasi ?? '—' }}
                    @endif
                </div>
            </div>
            @if($laporan->jumlah_konfirmasi)
            <div class="flp-info-cell flp-info-cell-mt">
                <div class="flp-info-label">Jumlah konfirmasi warga</div>
                <div class="flp-info-value">{{ $laporan->jumlah_konfirmasi }} warga</div>
            </div>
            @endif
        </div>

        {{-- Deskripsi --}}
        @if($laporan->deskripsi)
        <div class="fc-card fc-form-card">
            <h2 class="fc-form-section-title">Deskripsi</h2>
            <p class="flp-deskripsi">{{ $laporan->deskripsi }}</p>
        </div>
        @endif

        {{-- Konfirmasi warga --}}
        @if($konfirmasis->count() > 0)
        <div class="fc-card fc-form-card">
            <h2 class="fc-form-section-title">
                Konfirmasi Warga
                <span class="flp-konfirmasi-count">({{ $konfirmasis->count() }} konfirmasi)</span>
            </h2>
            @foreach($konfirmasis as $k)
            <div class="flp-konfirmasi-item">
                <div class="flp-konfirmasi-avatar">
                    {{ strtoupper(substr(optional($k->user)->nama_lengkap ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <div class="flp-konfirmasi-nama">
                        {{ optional($k->user)->nama_lengkap ?? 'Anonim' }}
                        <span class="flp-konfirmasi-akurat">
                            {{ $k->is_akurat ? '✓ Akurat' : '✗ Tidak akurat' }}
                        </span>
                    </div>
                    @if($k->komentar)
                    <div class="flp-konfirmasi-komentar">{{ $k->komentar }}</div>
                    @endif
                    <div class="flp-konfirmasi-time">
                        {{ $k->created_at ? \Carbon\Carbon::parse($k->created_at)->format('d M Y, H:i') : '—' }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Hapus --}}
        <form action="{{ route('admin.laporan.destroy', $laporan->id) }}"
              method="POST" onsubmit="return confirm('Hapus laporan ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="fc-btn fc-btn-danger fc-btn-full">
                <i class="mdi mdi-trash-can-outline"></i> Hapus Laporan
            </button>
        </form>

    </div>

    {{-- KOLOM KANAN --}}
    <div class="flp-detail-right">

        {{-- Validasi --}}
        <div class="fc-card fc-form-card">
            <h2 class="fc-form-section-title">Validasi laporan</h2>

            @php
                $pillClass = [
                    'menunggu'    => 'flp-pill-menunggu',
                    'valid'       => 'flp-pill-valid',
                    'tidak_valid' => 'flp-pill-invalid',
                ][$laporan->status_laporan ?? 'menunggu'] ?? 'flp-pill-menunggu';
                $pillIcon = [
                    'menunggu'    => 'mdi-clock-outline',
                    'valid'       => 'mdi-check-circle-outline',
                    'tidak_valid' => 'mdi-close-circle-outline',
                ][$laporan->status_laporan ?? 'menunggu'] ?? 'mdi-clock-outline';
                $pillLabel = [
                    'menunggu'    => 'Menunggu validasi',
                    'valid'       => 'Valid',
                    'tidak_valid' => 'Tidak valid',
                ][$laporan->status_laporan ?? 'menunggu'] ?? 'Menunggu validasi';
            @endphp

            <div class="flp-status-pill {{ $pillClass }} flp-status-pill-mb">
                <i class="mdi {{ $pillIcon }}"></i> {{ $pillLabel }}
            </div>

            <form action="{{ route('admin.laporan.validasi', $laporan->id) }}" method="POST">
                @csrf @method('PATCH')

                <div class="fc-form-group">
                    <label class="fc-label">Ubah status laporan</label>
                    <select name="status_laporan" class="fc-input fc-select">
                        <option value="menunggu"    {{ $laporan->status_laporan == 'menunggu'    ? 'selected' : '' }}>Menunggu</option>
                        <option value="valid"       {{ $laporan->status_laporan == 'valid'       ? 'selected' : '' }}>Valid</option>
                        <option value="tidak_valid" {{ $laporan->status_laporan == 'tidak_valid' ? 'selected' : '' }}>Tidak valid</option>
                    </select>
                </div>

                <div class="fc-form-group">
                    <label class="fc-label">Tingkat risiko</label>
                    <select name="tingkat_risiko" class="fc-input fc-select">
                        <option value="sangat_tinggi" {{ $laporan->tingkat_risiko == 'sangat_tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
                        <option value="tinggi" {{ $laporan->tingkat_risiko == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        <option value="sedang" {{ $laporan->tingkat_risiko == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="rendah" {{ $laporan->tingkat_risiko == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    </select>
                </div>

                <div class="fc-form-group">
                    <label class="fc-label">Catatan admin</label>
                    <textarea name="catatan_admin" class="fc-input fc-textarea flp-textarea-catatan"
                              placeholder="Tulis catatan validasi...">{{ $laporan->catatan_admin }}</textarea>
                </div>

                <button type="submit" class="fc-btn fc-btn-primary fc-btn-full">
                    <i class="mdi mdi-check-circle-outline"></i> Simpan validasi
                </button>
            </form>
        </div>

        {{-- Riwayat status --}}
        <div class="fc-card fc-form-card">
            <h2 class="fc-form-section-title">Riwayat status</h2>
            <div class="flp-timeline">
                <div class="flp-timeline-item">
                    <div class="flp-tl-dot flp-tl-gray"></div>
                    <div class="flp-tl-line"></div>
                    <div class="flp-tl-content">
                        <div class="flp-tl-title">Laporan masuk</div>
                        <div class="flp-tl-time">
                            {{ $laporan->created_at ? $laporan->created_at->format('d M · H:i') . ' WIB' : '—' }}
                        </div>
                    </div>
                </div>

                @if($laporan->status_laporan !== 'menunggu')
                <div class="flp-timeline-item">
                    <div class="flp-tl-dot flp-tl-orange"></div>
                    <div class="flp-tl-line"></div>
                    <div class="flp-tl-content">
                        <div class="flp-tl-title">{{ $pillLabel }}</div>
                        <div class="flp-tl-time">
                            {{ $laporan->updated_at ? $laporan->updated_at->format('d M · H:i') . ' WIB' : '—' }}
                            @if($laporan->validator)
                                · {{ $laporan->validator->nama_lengkap }}
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection