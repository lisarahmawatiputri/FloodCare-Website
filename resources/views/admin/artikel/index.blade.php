@extends('layouts.admin')

@section('title', 'Kelola Artikel')

@section('content')

<div class="fc-page-header">
    <div>
        <h1 class="fc-page-title">Kelola Artikel</h1>
        <p class="fc-page-subtitle">Buat dan kelola artikel edukasi banjir</p>
    </div>
    <a href="{{ route('admin.artikel.create') }}" class="fc-btn fc-btn-primary">
        <i class="mdi mdi-plus"></i>
        Tambah Artikel
    </a>
</div>

{{-- Filter & Search --}}
<div class="fc-card fc-filter-card" style="margin-bottom: 12px;">
    <div class="fc-filter-bar">
        {{-- Search --}}
        <div class="fc-search-wrap">
            <i class="mdi mdi-magnify fc-search-icon"></i>
            <input type="text" class="fc-input fc-search-input" placeholder="Cari judul artikel...">
        </div>

        {{-- Divider --}}
        <div class="fc-filter-divider"></div>

        {{-- Status dropdown --}}
        <div class="fc-status-select-wrap">
            <select class="fc-input fc-select fc-status-select">
                <option value="">Semua status</option>
                <option value="published">Dipublikasi</option>
                <option value="draft">Draft</option>
                <option value="archived">Diarsip</option>
            </select>
        </div>

        {{-- Divider --}}
        <div class="fc-filter-divider"></div>

        <!-- {{-- Filter button --}}
        <button class="fc-btn fc-btn-secondary fc-btn-filter">
            <i class="mdi mdi-filter-outline"></i> Filter
        </button> -->

        {{-- Count --}}
        <span class="fc-filter-count">38 artikel</span>
    </div>
</div>

{{-- Table --}}
<div class="fc-card fc-card-table">
    <div class="fc-table-wrap">
        <table class="fc-table">
            <thead>
                <tr>
                    <th style="width:52px"></th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Ditampilkan</th>
                    <th style="width:90px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td><div class="fc-thumb"><i class="mdi mdi-image-outline"></i></div></td>
                    <td>
                        <div class="fc-table-title">Cara evakuasi mandiri saat banjir melanda</div>
                        <div class="fc-table-meta">Panduan langkah demi langkah untuk evakuasi...</div>
                    </td>
                    <td><span class="fc-table-meta">Lisa Rahmawati</span></td>
                    <td><span class="fc-table-meta">24 Apr 2026</span></td>
                    <td><span class="fc-badge-status fc-badge-published">Dipublikasi</span></td>
                    <td><div class="fc-views"><i class="mdi mdi-eye-outline"></i> 1.200</div></td>
                    <td>
                        <div class="fc-action-group">
                            <a href="{{ route('admin.artikel.edit', 1) }}" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <button class="fc-action-btn fc-action-btn-danger" title="Hapus">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><div class="fc-thumb"><i class="mdi mdi-image-outline"></i></div></td>
                    <td>
                        <div class="fc-table-title">Kenali tanda-tanda banjir bandang sejak dini</div>
                        <div class="fc-table-meta">Tips mengenali potensi banjir bandang di sekitar...</div>
                    </td>
                    <td><span class="fc-table-meta">Ahmad Fauzi</span></td>
                    <td><span class="fc-table-meta">20 Apr 2026</span></td>
                    <td><span class="fc-badge-status fc-badge-published">Dipublikasi</span></td>
                    <td><div class="fc-views"><i class="mdi mdi-eye-outline"></i> 876</div></td>
                    <td>
                        <div class="fc-action-group">
                            <a href="{{ route('admin.artikel.edit', 2) }}" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <button class="fc-action-btn fc-action-btn-danger" title="Hapus">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><div class="fc-thumb"><i class="mdi mdi-image-outline"></i></div></td>
                    <td>
                        <div class="fc-table-title">Persiapan tas darurat untuk menghadapi banjir</div>
                        <div class="fc-table-meta">Barang-barang penting yang harus ada di tas darurat...</div>
                    </td>
                    <td><span class="fc-table-meta">Siti Aisyah</span></td>
                    <td><span class="fc-table-meta">18 Apr 2026</span></td>
                    <td><span class="fc-badge-status fc-badge-draft">Draft</span></td>
                    <td><div class="fc-views"><i class="mdi mdi-eye-outline"></i> —</div></td>
                    <td>
                        <div class="fc-action-group">
                            <a href="{{ route('admin.artikel.edit', 3) }}" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <button class="fc-action-btn fc-action-btn-danger" title="Hapus">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><div class="fc-thumb"><i class="mdi mdi-image-outline"></i></div></td>
                    <td>
                        <div class="fc-table-title">Dampak psikologis banjir pada anak-anak</div>
                        <div class="fc-table-meta">Memahami trauma dan cara mendampingi anak...</div>
                    </td>
                    <td><span class="fc-table-meta">Dr. Hendra K.</span></td>
                    <td><span class="fc-table-meta">12 Apr 2026</span></td>
                    <td><span class="fc-badge-status fc-badge-archived">Diarsip</span></td>
                    <td><div class="fc-views"><i class="mdi mdi-eye-outline"></i> 432</div></td>
                    <td>
                        <div class="fc-action-group">
                            <a href="{{ route('admin.artikel.edit', 4) }}" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <button class="fc-action-btn fc-action-btn-danger" title="Hapus">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><div class="fc-thumb"><i class="mdi mdi-image-outline"></i></div></td>
                    <td>
                        <div class="fc-table-title">Cara membersihkan rumah pasca banjir</div>
                        <div class="fc-table-meta">Langkah aman membersihkan hunian setelah banjir...</div>
                    </td>
                    <td><span class="fc-table-meta">Lisa Rahmawati</span></td>
                    <td><span class="fc-table-meta">5 Apr 2026</span></td>
                    <td><span class="fc-badge-status fc-badge-published">Dipublikasi</span></td>
                    <td><div class="fc-views"><i class="mdi mdi-eye-outline"></i> 2.100</div></td>
                    <td>
                        <div class="fc-action-group">
                            <a href="{{ route('admin.artikel.edit', 5) }}" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <button class="fc-action-btn fc-action-btn-danger" title="Hapus">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

@endsection