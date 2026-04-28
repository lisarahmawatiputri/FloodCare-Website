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
        <span class="fc-filter-count">{{ $artikels->count() }} artikel</span>
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
                @forelse($artikels as $artikel)
                    <tr>
                        <td>
                            <div class="fc-thumb">
                                @if($artikel->thumbnail)
                                    <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="thumbnail" style="width:100%; height:100%; object-fit:cover; border-radius:6px;">
                                @else
                                    <i class="mdi mdi-image-outline"></i>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="fc-table-title">{{ $artikel->judul }}</div>
                            <div class="fc-table-meta">{{ Str::limit($artikel->konten, 60) }}</div>
                        </td>
                        <td><span class="fc-table-meta">{{ optional($artikel->user)->nama_lengkap ?? 'Admin' }}</span></td>
                        <td><span class="fc-table-meta">{{ optional($artikel->created_at)->format('d M Y') ?? '-' }}</span></td>
                        <td>
                            <span class="fc-badge-status fc-badge-{{ $artikel->status }}">
                                {{ $artikel->status === 'published' ? 'Dipublikasi' : ($artikel->status === 'draft' ? 'Draft' : 'Diarsip') }}
                            </span>
                        </td>
                        <td><div class="fc-views"><i class="mdi mdi-eye-outline"></i> {{ $artikel->views ? number_format($artikel->views) : '—' }}</div></td>
                        <td>
                            <div class="fc-action-group">
                                <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="fc-action-btn" title="Edit">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a>
                                <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="fc-action-btn fc-action-btn-danger" title="Hapus">
                                        <i class="mdi mdi-trash-can-outline"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500">Belum ada artikel. Buat artikel baru untuk menampilkannya di sini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
