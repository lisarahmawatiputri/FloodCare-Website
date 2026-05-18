@extends('layouts.admin')

@section('title', 'Detail Laporan')

@section('content')

<div class="fc-page-header">
    <div>
        <h1 class="fc-page-title">Detail Laporan</h1>
    </div>

    <a href="{{ route('admin.laporan.index') }}"
       class="fc-btn fc-btn-secondary">
        <i class="mdi mdi-arrow-left"></i> Kembali
    </a>
</div>

@if(session('success'))
<div class="fc-alert fc-alert-success">
    <i class="mdi mdi-check-circle-outline"></i>
    {{ session('success') }}
</div>
@endif

<div class="flp-detail-grid">

    {{-- KOLOM KIRI --}}
    <div class="flp-detail-left">

        {{-- FOTO --}}
        <div class="fc-card fc-form-card">

            <h2 class="fc-form-section-title">
                Info laporan
            </h2>

            <div class="flp-foto-box">

                @if($laporan->foto_laporan)

                    <img src="{{ asset('storage/' . $laporan->foto_laporan) }}"
                         class="flp-foto-box-img">

                @else

                    <i class="mdi mdi-image-outline flp-foto-placeholder-icon"></i>

                    <span class="flp-foto-placeholder-label">
                        Foto laporan
                    </span>

                @endif

            </div>

        </div>

        {{-- INFO --}}
        <div class="fc-card fc-form-card">

            <div class="flp-info-grid">

                <div class="flp-info-cell">

                    <div class="flp-info-label">
                        Pelapor
                    </div>

                    <div class="flp-info-value">
                        {{ optional($laporan->pelapor)->nama_lengkap ?? '—' }}
                    </div>

                </div>

                <div class="flp-info-cell">

                    <div class="flp-info-label">
                        Tanggal lapor
                    </div>

                    <div class="flp-info-value">
                        {{ $laporan->created_at ? $laporan->created_at->format('d M Y, H:i') : '—' }}
                    </div>

                </div>

                <div class="flp-info-cell">

                    <div class="flp-info-label">
                        Tinggi banjir
                    </div>

                    <div class="flp-info-value">
                        {{ $laporan->tinggi_banjir_cm ?? 0 }} cm
                    </div>

                </div>

                <div class="flp-info-cell">

                    <div class="flp-info-label">
                        Tingkat risiko
                    </div>

                    <div class="flp-info-value">

                        <span class="fc-badge-status flp-badge-{{ $laporan->tingkat_risiko }}">

                            {{ ucfirst(str_replace('_', ' ', $laporan->tingkat_risiko)) }}

                        </span>

                    </div>

                </div>

            </div>

            <div class="flp-info-cell flp-info-cell-mt">

                <div class="flp-info-label">
                    Alamat
                </div>

                <div class="flp-info-value">

                    {{ $laporan->alamat_lokasi ?? '-' }}

                </div>

            </div>

        </div>

    </div>

    {{-- KOLOM KANAN --}}
    <div class="flp-detail-right">

        <div class="fc-card fc-form-card">

            <h2 class="fc-form-section-title">
                Validasi laporan
            </h2>

            <form action="{{ route('admin.laporan.validasi', $laporan->id) }}"
                  method="POST">

                @csrf
                @method('PATCH')

                {{-- STATUS --}}
                <div class="fc-form-group">

                    <label class="fc-label">
                        Status laporan
                    </label>

                    <select name="status_laporan"
                            class="fc-input fc-select">

                        <option value="menunggu"
                            {{ $laporan->status_laporan == 'menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>

                        <option value="valid"
                            {{ $laporan->status_laporan == 'valid' ? 'selected' : '' }}>
                            Valid
                        </option>

                        <option value="tidak_valid"
                            {{ $laporan->status_laporan == 'tidak_valid' ? 'selected' : '' }}>
                            Tidak Valid
                        </option>

                    </select>

                </div>

                {{-- RISIKO --}}
                <div class="fc-form-group">

                    <label class="fc-label">
                        Tingkat risiko
                    </label>

                    <select name="tingkat_risiko"
                            class="fc-input fc-select">

                        <option value="rendah"
                            {{ $laporan->tingkat_risiko == 'rendah' ? 'selected' : '' }}>
                            Rendah
                        </option>

                        <option value="sedang"
                            {{ $laporan->tingkat_risiko == 'sedang' ? 'selected' : '' }}>
                            Sedang
                        </option>

                        <option value="tinggi"
                            {{ $laporan->tingkat_risiko == 'tinggi' ? 'selected' : '' }}>
                            Tinggi
                        </option>

                        <option value="sangat_tinggi"
                            {{ $laporan->tingkat_risiko == 'sangat_tinggi' ? 'selected' : '' }}>
                            Sangat Tinggi
                        </option>

                    </select>

                </div>

                {{-- CATATAN --}}
                <div class="fc-form-group">

                    <label class="fc-label">
                        Catatan admin
                    </label>

                    <textarea
                        name="catatan_admin"
                        class="fc-input fc-textarea flp-textarea-catatan"
                        placeholder="Tulis catatan validasi...">{{ $laporan->catatan_admin }}</textarea>

                </div>

                <button type="submit"
                        class="fc-btn fc-btn-primary fc-btn-full">

                    <i class="mdi mdi-check-circle-outline"></i>

                    Simpan validasi

                </button>

            </form>

        </div>

    </div>

</div>

@endsection