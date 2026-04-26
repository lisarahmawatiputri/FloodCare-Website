@extends('layouts.admin')

@section('title', 'Detail Laporan')

@section('content')

<div class="fc-page-header">
    <div>
        <div class="fc-breadcrumb-link" style="margin-bottom:4px;">
            <span style="color:var(--text-muted); font-size:12px;">
                Laporan Banjir /
                <span style="color:var(--primary);">Banjir Jl. Mastrip</span>
            </span>
        </div>
        <h1 class="fc-page-title">Detail Laporan</h1>
    </div>
    <a href="#" class="fc-btn fc-btn-secondary">
        <i class="mdi mdi-arrow-left"></i> Kembali
    </a>
</div>

<div class="flp-detail-grid">

    {{-- ── Kolom Kiri: Info laporan ── --}}
    <div class="flp-detail-left">

        {{-- Foto laporan --}}
        <div class="fc-card fc-form-card">
            <h2 class="fc-form-section-title">Info laporan</h2>
            <div class="flp-foto-box">
                <i class="mdi mdi-image-outline flp-foto-placeholder-icon"></i>
                <span class="flp-foto-placeholder-label">Foto laporan</span>
            </div>
        </div>

        {{-- Grid info --}}
        <div class="fc-card fc-form-card">
            <div class="flp-info-grid">
                <div class="flp-info-cell">
                    <div class="flp-info-label">PELAPOR</div>
                    <div class="flp-info-value">Ahmad Rizki</div>
                </div>
                <div class="flp-info-cell">
                    <div class="flp-info-label">TANGGAL LAPOR</div>
                    <div class="flp-info-value">26 Apr 2026, 08:14</div>
                </div>
                <div class="flp-info-cell">
                    <div class="flp-info-label">TINGGI BANJIR</div>
                    <div class="flp-info-value flp-water-tinggi">60 cm</div>
                </div>
                <div class="flp-info-cell">
                    <div class="flp-info-label">TINGKAT RISIKO</div>
                    <div class="flp-info-value">
                        <span class="fc-badge-status flp-badge-tinggi">Tinggi</span>
                    </div>
                </div>
            </div>

            <div class="flp-info-cell" style="margin-top:2px;">
                <div class="flp-info-label">ALAMAT</div>
                <div class="flp-info-value">Jl. Mastrip No. 12, Sumbersari, Jember</div>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="fc-card fc-form-card">
            <p class="flp-deskripsi">
                Banjir mulai merendam halaman rumah warga sejak pukul 06.00 WIB.
                Air masuk ke dalam rumah setinggi lutut orang dewasa.
                Warga sekitar mulai mengungsi ke balai desa.
            </p>
        </div>

        {{-- Aksi hapus --}}
        <div style="display:flex; gap:8px;">
            <button class="fc-btn fc-btn-danger fc-btn-full" onclick="confirmDelete()">
                <i class="mdi mdi-trash-can-outline"></i> Hapus Laporan
            </button>
        </div>

    </div>

    {{-- ── Kolom Kanan: Validasi ── --}}
    <div class="flp-detail-right">

        {{-- Validasi --}}
        <div class="fc-card fc-form-card">
            <h2 class="fc-form-section-title">Validasi laporan</h2>

            <div class="flp-status-pill flp-pill-menunggu" style="margin-bottom:16px;">
                <i class="mdi mdi-clock-outline"></i> Menunggu validasi
            </div>

            <div class="fc-form-group">
                <label class="fc-label">Ubah status laporan</label>
                <select class="fc-input fc-select" id="statusSelect">
                    <option value="menunggu" selected>Menunggu</option>
                    <option value="valid">Valid</option>
                    <option value="tidak_valid">Tidak valid</option>
                    <option value="diterima">Diterima</option>
                </select>
            </div>

            <div class="fc-form-group">
                <label class="fc-label">Tingkat risiko</label>
                <select class="fc-input fc-select">
                    <option value="tinggi" selected>Tinggi</option>
                    <option value="sedang">Sedang</option>
                    <option value="rendah">Rendah</option>
                </select>
            </div>

            <div class="fc-form-group" style="margin-bottom:16px;">
                <label class="fc-label">Catatan admin</label>
                <textarea class="fc-input fc-textarea" style="min-height:100px;"
                          placeholder="Tulis catatan validasi...">Laporan dikonfirmasi oleh 12 warga sekitar.</textarea>
            </div>

            <button class="fc-btn fc-btn-primary fc-btn-full" style="margin-bottom:8px;">
                <i class="mdi mdi-check-circle-outline"></i> Simpan validasi
            </button>
            <button class="fc-btn fc-btn-danger-outline fc-btn-full" onclick="confirmInvalid()">
                <i class="mdi mdi-close-circle-outline"></i> Tandai tidak valid
            </button>
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
                        <div class="flp-tl-time">26 Apr · 08:14 WIB</div>
                    </div>
                </div>

                <div class="flp-timeline-item">
                    <div class="flp-tl-dot flp-tl-orange"></div>
                    <div class="flp-tl-line"></div>
                    <div class="flp-tl-content">
                        <div class="flp-tl-title">Sedang ditinjau</div>
                        <div class="flp-tl-time">26 Apr · 09:02 WIB · Lisa R.</div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Modal hapus --}}
<div class="flp-modal-overlay" id="deleteModal">
    <div class="flp-modal">
        <div class="flp-modal-icon">
            <i class="mdi mdi-trash-can-outline"></i>
        </div>
        <h3 class="flp-modal-title">Hapus laporan ini?</h3>
        <p class="flp-modal-desc">Data laporan yang dihapus tidak dapat dikembalikan.</p>
        <div class="flp-modal-actions">
            <button class="fc-btn fc-btn-secondary" onclick="closeModal('deleteModal')">Batal</button>
            <button class="fc-btn fc-btn-danger" onclick="doDelete()">Hapus</button>
        </div>
    </div>
</div>

{{-- Modal tandai tidak valid --}}
<div class="flp-modal-overlay" id="invalidModal">
    <div class="flp-modal">
        <div class="flp-modal-icon flp-modal-icon-warn">
            <i class="mdi mdi-alert-outline"></i>
        </div>
        <h3 class="flp-modal-title">Tandai tidak valid?</h3>
        <p class="flp-modal-desc">Laporan akan ditandai sebagai tidak valid dan pelapor akan diberitahu.</p>
        <div class="flp-modal-actions">
            <button class="fc-btn fc-btn-secondary" onclick="closeModal('invalidModal')">Batal</button>
            <button class="fc-btn fc-btn-danger" onclick="doInvalid()">Tandai tidak valid</button>
        </div>
    </div>
</div>

@endsection 