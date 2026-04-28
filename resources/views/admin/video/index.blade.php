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

{{-- Success Message --}}
@if(session('success'))
<div class="fc-alert fc-alert-success" style="margin-bottom:16px;">
    <i class="mdi mdi-check-circle-outline"></i>
    <div>
        <strong>Sukses!</strong>
        <p>{{ session('success') }}</p>
    </div>
</div>
@endif

{{-- Filter bar --}}
<div class="fc-card fc-filter-card" style="margin-bottom:16px;">
    <div class="fc-filter-bar">
        <div class="fc-search-wrap">
            <i class="mdi mdi-magnify fc-search-icon"></i>
            <input type="text" class="fc-input fc-search-input" placeholder="Cari judul video..." id="searchInput">
        </div>
        <div class="fc-status-select-wrap">
            <select class="fc-input fc-select fc-status-select" id="statusFilter">
                <option value="">Semua status</option>
                <option value="published">Publik</option>
                <option value="draft">Draft</option>
            </select>
        </div>
        <span class="fc-filter-count">{{ count($videos) }} video</span>
    </div>
</div>

{{-- Grid video - YouTube style --}}
<div class="fcv-grid" id="videoGrid">
    @forelse($videos as $video)
    <div class="fcv-card" data-title="{{ strtolower($video->judul) }}" data-status="{{ $video->status }}">
        {{-- Thumbnail 16:9 --}}
        <a href="#" class="fcv-thumb-wrap">
            <div class="fcv-thumb">
                @if($video->thumbnail)
                    <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->judul }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <i class="mdi mdi-play-circle-outline fcv-play-icon"></i>
                @endif
            </div>
            @if($video->durasi_detik)
                @php
                    $minutes = intval($video->durasi_detik / 60);
                    $seconds = $video->durasi_detik % 60;
                    $duration = str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);
                @endphp
                <span class="fcv-duration">{{ $duration }}</span>
            @endif
        </a>
        <div class="fcv-info">
            <div class="fcv-title">{{ $video->judul }}</div>
            <div class="fcv-meta">
                <span class="fcv-views"><i class="mdi mdi-eye-outline"></i> Ditonton</span>
                <span class="fc-badge-status {{ $video->status == 'published' ? 'fc-badge-published' : 'fc-badge-draft' }}">
                    {{ $video->status == 'published' ? 'Publik' : 'Draft' }}
                </span>
            </div>
            <div class="fcv-actions">
                <a href="{{ route('admin.video.edit', $video->id) }}" class="fc-btn fc-btn-ghost fc-btn-sm">
                    <i class="mdi mdi-pencil-outline"></i> Edit
                </a>
                <form action="{{ route('admin.video.destroy', $video->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="fc-btn fc-btn-danger-ghost fc-btn-sm">
                        <i class="mdi mdi-trash-can-outline"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
        <i class="mdi mdi-video-outline" style="font-size: 48px; color: #ccc;"></i>
        <p style="color: #666; margin-top: 16px;">Belum ada video. <a href="{{ route('admin.video.create') }}">Buat video baru</a></p>
    </div>
    @endforelse
</div>

<script>
// Search & Filter functionality
document.getElementById('searchInput').addEventListener('keyup', filterVideos);
document.getElementById('statusFilter').addEventListener('change', filterVideos);

function filterVideos() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const videos = document.querySelectorAll('.fcv-card');

    videos.forEach(video => {
        const title = video.dataset.title;
        const status = video.dataset.status;

        const matchSearch = title.includes(searchTerm);
        const matchStatus = statusFilter === '' || status === statusFilter;

        if (matchSearch && matchStatus) {
            video.style.display = '';
        } else {
            video.style.display = 'none';
        }
    });
}
</script>

@endsection
