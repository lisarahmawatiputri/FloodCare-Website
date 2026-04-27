@extends('layouts.admin')

@section('title', 'Video Edukasi')

@section('content')

<div class="fc-page-header">
    <div>
        <h1 class="fc-page-title">Video Edukasi</h1>
        <p class="fc-page-subtitle">Kelola video edukasi penanggulangan banjir</p>
    </div>
    <a href="{{ route('admin.video.create') }}" class="fc-btn fc-btn-primary">
        <i class="mdi mdi-plus"></i> Tambah Video
    </a>
</div>

{{-- Filter bar --}}
<div class="fc-card fc-filter-card" style="margin-bottom:16px;">
    <div class="fc-filter-bar">
        <div class="fc-search-wrap">
            <i class="mdi mdi-magnify fc-search-icon"></i>
            <input type="text" class="fc-input fc-search-input" placeholder="Cari judul video...">
        </div>
        <div class="fc-status-select-wrap">
            <select class="fc-input fc-select fc-status-select">
                <option value="">Semua status</option>
                <option value="published">Publik</option>
                <option value="draft">Draft</option>
            </select>
        </div>
        <!-- <button class="fc-btn fc-btn-secondary fc-btn-filter">
            <i class="mdi mdi-filter-outline"></i> Filter
        </button> -->
        <span class="fc-filter-count">4 video</span>
    </div>
</div>

{{-- Grid video - YouTube style --}}
<div class="fcv-grid">

    <div class="fcv-card">
        {{-- Thumbnail 16:9 --}}
        <a href="#" class="fcv-thumb-wrap">
            <div class="fcv-thumb">
                <i class="mdi mdi-play-circle-outline fcv-play-icon"></i>
            </div>
            <span class="fcv-duration">04:32</span>
        </a>
        <div class="fcv-info">
            <div class="fcv-title">Cara membuat perahu darurat saat banjir</div>
            <div class="fcv-meta">
                <span class="fcv-views"><i class="mdi mdi-eye-outline"></i> 2.4rb ditonton</span>
                <span class="fc-badge-status fc-badge-published">Publik</span>
            </div>
            <div class="fcv-actions">
                <a href="#" class="fc-btn fc-btn-ghost fc-btn-sm">
                    <i class="mdi mdi-pencil-outline"></i> Edit
                </a>
                <button class="fc-btn fc-btn-danger-ghost fc-btn-sm">
                    <i class="mdi mdi-trash-can-outline"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <div class="fcv-card">
        <a href="#" class="fcv-thumb-wrap">
            <div class="fcv-thumb">
                <i class="mdi mdi-play-circle-outline fcv-play-icon"></i>
            </div>
            <span class="fcv-duration">07:15</span>
        </a>
        <div class="fcv-info">
            <div class="fcv-title">Pertolongan pertama korban tenggelam</div>
            <div class="fcv-meta">
                <span class="fcv-views"><i class="mdi mdi-eye-outline"></i> 1.8rb ditonton</span>
                <span class="fc-badge-status fc-badge-published">Publik</span>
            </div>
            <div class="fcv-actions">
                <a href="#" class="fc-btn fc-btn-ghost fc-btn-sm">
                    <i class="mdi mdi-pencil-outline"></i> Edit
                </a>
                <button class="fc-btn fc-btn-danger-ghost fc-btn-sm">
                    <i class="mdi mdi-trash-can-outline"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <div class="fcv-card">
        <a href="#" class="fcv-thumb-wrap">
            <div class="fcv-thumb">
                <i class="mdi mdi-play-circle-outline fcv-play-icon"></i>
            </div>
            <span class="fcv-duration">03:50</span>
        </a>
        <div class="fcv-info">
            <div class="fcv-title">Evakuasi warga lansia & anak-anak</div>
            <div class="fcv-meta">
                <span class="fcv-views"><i class="mdi mdi-eye-outline"></i> 990 ditonton</span>
                <span class="fc-badge-status fc-badge-draft">Draft</span>
            </div>
            <div class="fcv-actions">
                <a href="#" class="fc-btn fc-btn-ghost fc-btn-sm">
                    <i class="mdi mdi-pencil-outline"></i> Edit
                </a>
                <button class="fc-btn fc-btn-danger-ghost fc-btn-sm">
                    <i class="mdi mdi-trash-can-outline"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <div class="fcv-card">
        <a href="#" class="fcv-thumb-wrap">
            <div class="fcv-thumb">
                <i class="mdi mdi-play-circle-outline fcv-play-icon"></i>
            </div>
            <span class="fcv-duration">05:22</span>
        </a>
        <div class="fcv-info">
            <div class="fcv-title">Memilih lokasi pengungsian yang aman</div>
            <div class="fcv-meta">
                <span class="fcv-views"><i class="mdi mdi-eye-outline"></i> 1.1rb ditonton</span>
                <span class="fc-badge-status fc-badge-published">Publik</span>
            </div>
            <div class="fcv-actions">
                <a href="#" class="fc-btn fc-btn-ghost fc-btn-sm">
                    <i class="mdi mdi-pencil-outline"></i> Edit
                </a>
                <button class="fc-btn fc-btn-danger-ghost fc-btn-sm">
                    <i class="mdi mdi-trash-can-outline"></i> Hapus
                </button>
            </div>
        </div>
    </div>

</div>

@endsection