@extends('layouts.admin')

@section('title', 'Detail Artikel')

@section('content')

<div class="fc-page-header">
    <div>
        <h1 class="fc-page-title">Detail Artikel</h1>
        <p class="fc-page-subtitle">Pratinjau lengkap artikel</p>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="fc-btn fc-btn-primary">
            <i class="mdi mdi-pencil-outline"></i> Edit
        </a>
        <a href="{{ route('admin.artikel.index') }}" class="fc-btn fc-btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 300px; gap:20px; align-items:start;">

    {{-- Konten Utama --}}
    <div class="fc-card" style="padding:28px;">

        {{-- Thumbnail --}}
        @if($artikel->thumbnail)
        <div style="margin-bottom:24px;">
                <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="thumbnail"                 alt="Thumbnail"
                 style="width:100%; max-height:360px; object-fit:cover; border-radius:10px;">
        </div>
        @endif

        {{-- Judul --}}
        <h2 style="font-size:1.6rem; font-weight:700; color:var(--fc-text-primary); margin-bottom:12px; line-height:1.3;">
            {{ $artikel->judul }}
        </h2>

        {{-- Meta --}}
        <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid var(--fc-border);">
            <span style="display:flex; align-items:center; gap:6px; font-size:.85rem; color:var(--fc-text-secondary);">
                <i class="mdi mdi-account-outline"></i>
                {{ $artikel->penulis ?? '—' }}
            </span>
            <span style="display:flex; align-items:center; gap:6px; font-size:.85rem; color:var(--fc-text-secondary);">
                <i class="mdi mdi-upload-outline"></i>
                Diupload: {{ optional($artikel->uploader)->nama_lengkap ?? '—' }}
            </span>
            <span style="display:flex; align-items:center; gap:6px; font-size:.85rem; color:var(--fc-text-secondary);">
                <i class="mdi mdi-calendar-outline"></i>
                {{ $artikel->created_at->format('d M Y') }}
            </span>
            <span class="fc-badge-status fc-badge-{{ $artikel->status }}">
                {{ $artikel->status === 'dipublikasi' ? 'Dipublikasi' : ($artikel->status === 'draft' ? 'Draft' : 'Diarsip') }}
            </span>
        </div>

        {{-- Konten --}}
        <div style="font-size:.95rem; line-height:1.8; color:var(--fc-text-primary);">
            {!! $artikel->konten !!}
        </div>

    </div>

    {{-- Sidebar Info --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Info Artikel --}}
        <div class="fc-card" style="padding:20px;">
            <h3 style="font-size:.9rem; font-weight:600; color:var(--fc-text-secondary); text-transform:uppercase; letter-spacing:.05em; margin-bottom:16px;">
                Informasi Artikel
            </h3>
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <div style="font-size:.78rem; color:var(--fc-text-secondary); margin-bottom:2px;">Status</div>
                    <span class="fc-badge-status fc-badge-{{ $artikel->status }}">
                        {{ $artikel->status === 'dipublikasi' ? 'Dipublikasi' : ($artikel->status === 'draft' ? 'Draft' : 'Diarsip') }}
                    </span>
                </div>
                <div>
                    <div style="font-size:.78rem; color:var(--fc-text-secondary); margin-bottom:2px;">Penulis</div>
                    <div style="font-size:.9rem; font-weight:500;">{{ $artikel->penulis ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:.78rem; color:var(--fc-text-secondary); margin-bottom:2px;">Diupload oleh</div>
                    <div style="font-size:.9rem; font-weight:500;">{{ optional($artikel->uploader)->nama_lengkap ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:.78rem; color:var(--fc-text-secondary); margin-bottom:2px;">Tanggal Dibuat</div>
                    <div style="font-size:.9rem;">{{ $artikel->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div>
                    <div style="font-size:.78rem; color:var(--fc-text-secondary); margin-bottom:2px;">Terakhir Diupdate</div>
                    <div style="font-size:.9rem;">{{ $artikel->updated_at->format('d M Y, H:i') }}</div>
                </div>
                <div>
                    <div style="font-size:.78rem; color:var(--fc-text-secondary); margin-bottom:2px;">Slug</div>
                    <div style="font-size:.85rem; font-family:monospace; background:var(--fc-bg-soft, #f4f4f5); padding:4px 8px; border-radius:4px; word-break:break-all;">
                        {{ $artikel->slug }}
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="fc-card" style="padding:20px;">
            <h3 style="font-size:.9rem; font-weight:600; color:var(--fc-text-secondary); text-transform:uppercase; letter-spacing:.05em; margin-bottom:16px;">
                Aksi
            </h3>
            <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="fc-action-btn fc-action-btn-danger" title="Hapus"
                        data-confirm="Hapus artikel ini? Tindakan tidak dapat dibatalkan.">
                    <i class="mdi mdi-trash-can-outline"></i>
                </button>
            </form>
        </div> -->

    </div>
</div>

@endsection