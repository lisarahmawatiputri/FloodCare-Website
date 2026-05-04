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

@if(session('success'))
<div class="fc-alert fc-alert-success" style="margin-bottom:16px;">
    <i class="mdi mdi-check-circle-outline"></i> {{ session('success') }}
</div>
@endif

{{-- Filter bar --}}
<form method="GET" action="{{ route('admin.video.index') }}">
<div class="fc-card fc-filter-card" style="margin-bottom:16px;">
    <div class="fc-filter-bar">
        <div class="fc-search-wrap">
            <i class="mdi mdi-magnify fc-search-icon"></i>
            <input type="text" name="search" class="fc-input fc-search-input"
                placeholder="Cari judul video..."
                value="{{ request('search') }}">
        </div>
        <div class="fc-status-select-wrap">
            <select name="status" class="fc-input fc-select fc-status-select" onchange="this.form.submit()">
                <option value="">Semua status</option>
                <option value="dipublikasi" {{ request('status') == 'dipublikasi' ? 'selected' : '' }}>Publik</option>
                <option value="draft"       {{ request('status') == 'draft'       ? 'selected' : '' }}>Draft</option>
                <option value="diarsip"     {{ request('status') == 'diarsip'     ? 'selected' : '' }}>Diarsip</option>
            </select>
        </div>
        <span class="fc-filter-count">{{ $totalVideo }} video</span>
    </div>
</div>
</form>

{{-- Grid video --}}
@if($videos->count() > 0)
<div class="fcv-grid">
    @foreach($videos as $video)
    <div class="fcv-card">
        <a href="{{ $video->file_video ? asset('storage/'.$video->file_video) : '#' }}"
           class="fcv-thumb-wrap" target="_blank">
            @if($video->thumbnail)
                <img src="{{ asset('storage/'.$video->thumbnail) }}"
                     alt="{{ $video->judul }}"
                     style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
            @else
                <div class="fcv-thumb">
                    <i class="mdi mdi-play-circle-outline fcv-play-icon"></i>
                </div>
            @endif
            <span class="fcv-duration">{{ $video->durasi_format }}</span>
        </a>
        <div class="fcv-info">
            <div class="fcv-title">{{ $video->judul }}</div>
            <div class="fcv-meta">
                <span class="fcv-views">
                    <i class="mdi mdi-eye-outline"></i>
                    {{ $video->dilihat ? number_format($video->dilihat) : '0' }} ditonton
                </span>
                @if($video->status === 'dipublikasi')
                    <span class="fc-badge-status fc-badge-published">Publik</span>
                @elseif($video->status === 'draft')
                    <span class="fc-badge-status fc-badge-draft">Draft</span>
                @else
                    <span class="fc-badge-status fc-badge-archived">Diarsip</span>
                @endif
            </div>
            <div class="fcv-actions">
                <a href="{{ route('admin.video.edit', $video->id) }}"
                   class="fc-btn fc-btn-ghost fc-btn-sm">
                    <i class="mdi mdi-pencil-outline"></i> Edit
                </a>
                <form action="{{ route('admin.video.destroy', $video->id) }}"
                      method="POST" style="display:inline;"
                      onsubmit="return confirm('Hapus video ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="fc-btn fc-btn-ghost fc-btn-sm"
                            style="color:#c0392b;">
                        <i class="mdi mdi-trash-can-outline"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="fc-card" style="padding:48px;text-align:center;color:#888;">
    <i class="mdi mdi-video-off-outline" style="font-size:48px;display:block;margin-bottom:12px;opacity:.3;"></i>
    Belum ada video. Tambah video baru!
</div>
@endif

@endsection