@extends('layouts.admin')

@section('title', 'Laporan Banjir')

@section('content')

<div class="fc-page-header">
    <div>
        <h1 class="fc-page-title">Laporan Banjir</h1>
        <!-- <p class="fc-page-subtitle">Kelola & validasi laporan masuk dari masyarakat</p> -->
    </div>
    <div style="display:flex; gap:8px;">
        <button class="fc-btn fc-btn-secondary" onclick="exportLaporan()">
            <i class="mdi mdi-download-outline"></i> Export
        </button>
        <a href="#" class="fc-btn fc-btn-primary">
            <i class="mdi mdi-plus"></i> Tambah
        </a>
    </div>
</div>

{{-- Stat cards --}}
<div class="flp-stat-row">
    <div class="flp-stat-card">
        <span class="flp-stat-dot flp-dot-gray"></span>
        <div>
            <div class="flp-stat-num">7</div>
            <div class="flp-stat-label">Menunggu</div>
        </div>
    </div>
    <div class="flp-stat-card">
        <span class="flp-stat-dot flp-dot-green"></span>
        <div>
            <div class="flp-stat-num">10</div>
            <div class="flp-stat-label">Valid</div>
        </div>
    </div>
    <div class="flp-stat-card">
        <span class="flp-stat-dot flp-dot-red"></span>
        <div>
            <div class="flp-stat-num">4</div>
            <div class="flp-stat-label">Tidak valid</div>
        </div>
    </div>
    <div class="flp-stat-card">
        <span class="flp-stat-dot flp-dot-blue"></span>
        <div>
            <div class="flp-stat-num">3</div>
            <div class="flp-stat-label">Diterima</div>
        </div>
    </div>
</div>

{{-- Filter bar --}}
<div class="fc-card fc-filter-card" style="margin-bottom:12px;">
    <div class="fc-filter-bar">
        <div class="fc-search-wrap">
            <i class="mdi mdi-magnify fc-search-icon"></i>
            <input type="text" class="fc-input fc-search-input" placeholder="Cari laporan...">
        </div>
        <div class="fc-status-select-wrap">
            <select class="fc-input fc-select fc-status-select">
                <option value="">Semua status</option>
                <option value="menunggu">Menunggu</option>
                <option value="valid">Valid</option>
                <option value="tidak_valid">Tidak valid</option>
                <option value="diterima">Diterima</option>
            </select>
        </div>
        <div class="fc-status-select-wrap">
            <select class="fc-input fc-select fc-status-select">
                <option value="">Semua risiko</option>
                <option value="tinggi">Tinggi</option>
                <option value="sedang">Sedang</option>
                <option value="rendah">Rendah</option>
            </select>
        </div>
        <span class="fc-filter-count">24 laporan</span>
    </div>
</div>

{{-- Table --}}
<div class="fc-card fc-card-table">
    <div class="fc-table-wrap">
        <table class="fc-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Pelapor & judul</th>
                    <th>Alamat</th>
                    <th>Tinggi air</th>
                    <th>Risiko</th>
                    <th style="width:60px;">Foto</th>
                    <th>Status</th>
                    <th style="width:100px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td class="flp-num">1</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="flp-avatar" style="background:#ff6a3d;">AR</div>
                            <div>
                                <div class="fc-table-title">Banjir Jl. Mastrip</div>
                                <div class="fc-table-meta">Ahmad Rizki</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="fc-table-meta">Jl. Mastrip, Jember</span></td>
                    <td><span class="flp-water flp-water-tinggi">60 cm</span></td>
                    <td><span class="fc-badge-status flp-badge-tinggi">Tinggi</span></td>
                    <td><div class="flp-foto-thumb"><i class="mdi mdi-image-outline"></i></div></td>
                    <td><span class="fc-badge-status flp-badge-menunggu">Menunggu</span></td>
                    <td>
                        <div class="fc-action-group">
                            <a href="#" class="fc-action-btn" title="Detail">
                                <i class="mdi mdi-eye-outline"></i>
                            </a>
                            <a href="#" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <button class="fc-action-btn fc-action-btn-danger" title="Hapus" onclick="confirmDelete(1)">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="flp-num">2</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="flp-avatar" style="background:#3d9fff;">SW</div>
                            <div>
                                <div class="fc-table-title">Genangan Griya Indah</div>
                                <div class="fc-table-meta">Siti Wahyuni</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="fc-table-meta">Griya Indah, Bondowoso</span></td>
                    <td><span class="flp-water flp-water-sedang">30 cm</span></td>
                    <td><span class="fc-badge-status flp-badge-sedang">Sedang</span></td>
                    <td><div class="flp-foto-thumb"><i class="mdi mdi-image-outline"></i></div></td>
                    <td><span class="fc-badge-status flp-badge-valid">Valid</span></td>
                    <td>
                        <div class="fc-action-group">
                            <a href="#" class="fc-action-btn" title="Detail">
                                <i class="mdi mdi-eye-outline"></i>
                            </a>
                            <a href="#" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <button class="fc-action-btn fc-action-btn-danger" title="Hapus" onclick="confirmDelete(2)">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="flp-num">3</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="flp-avatar" style="background:#ff6600;">BP</div>
                            <div>
                                <div class="fc-table-title">Banjir Ds. Sukorambi</div>
                                <div class="fc-table-meta">Budi Prasetyo</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="fc-table-meta">Ds. Sukorambi, Jember</span></td>
                    <td><span class="flp-water flp-water-rendah">15 cm</span></td>
                    <td><span class="fc-badge-status flp-badge-rendah">Rendah</span></td>
                    <td><div class="flp-foto-thumb"><i class="mdi mdi-image-outline"></i></div></td>
                    <td><span class="fc-badge-status flp-badge-diterima">Diterima</span></td>
                    <td>
                        <div class="fc-action-group">
                            <a href="#" class="fc-action-btn" title="Detail">
                                <i class="mdi mdi-eye-outline"></i>
                            </a>
                            <a href="#" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <button class="fc-action-btn fc-action-btn-danger" title="Hapus" onclick="confirmDelete(3)">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="flp-num">4</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="flp-avatar" style="background:#9b59b6;">DN</div>
                            <div>
                                <div class="fc-table-title">Genangan Kaliurang</div>
                                <div class="fc-table-meta">Dwi Novita</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="fc-table-meta">Jl. Kaliurang, Jember</span></td>
                    <td><span class="flp-water flp-water-sedang">25 cm</span></td>
                    <td><span class="fc-badge-status flp-badge-sedang">Sedang</span></td>
                    <td><div class="flp-foto-thumb"><i class="mdi mdi-image-outline"></i></div></td>
                    <td><span class="fc-badge-status flp-badge-tidak-valid">Tidak valid</span></td>
                    <td>
                        <div class="fc-action-group">
                            <a href="#" class="fc-action-btn" title="Detail">
                                <i class="mdi mdi-eye-outline"></i>
                            </a>
                            <a href="#" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <button class="fc-action-btn fc-action-btn-danger" title="Hapus" onclick="confirmDelete(4)">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flp-pagination">
        <span class="flp-page-info">Menampilkan 1–4 dari 24 laporan</span>
        <div class="flp-page-btns">
            <button class="flp-page-btn" disabled><i class="mdi mdi-chevron-left"></i></button>
            <button class="flp-page-btn flp-page-active">1</button>
            <button class="flp-page-btn">2</button>
            <button class="flp-page-btn">3</button>
            <button class="flp-page-btn"><i class="mdi mdi-chevron-right"></i></button>
        </div>
    </div>
</div>

{{-- Modal konfirmasi hapus --}}
<div class="flp-modal-overlay" id="deleteModal">
    <div class="flp-modal">
        <div class="flp-modal-icon">
            <i class="mdi mdi-trash-can-outline"></i>
        </div>
        <h3 class="flp-modal-title">Hapus laporan?</h3>
        <p class="flp-modal-desc">Laporan yang dihapus tidak dapat dikembalikan.</p>
        <div class="flp-modal-actions">
            <button class="fc-btn fc-btn-secondary" onclick="closeModal()">Batal</button>
            <button class="fc-btn fc-btn-danger" onclick="doDelete()">Hapus</button>
        </div>
    </div>
</div>

@endsection