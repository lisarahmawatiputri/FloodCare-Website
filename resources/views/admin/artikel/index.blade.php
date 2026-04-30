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
<form method="GET" action="{{ route('admin.artikel.index') }}" id="filter-form">
    <div class="fc-card fc-filter-card" style="margin-bottom: 12px;">
        <div class="fc-filter-bar">

            {{-- Search --}}
            <div class="fc-search-wrap">
                <i class="mdi mdi-magnify fc-search-icon"></i>
                <input type="text" name="search" class="fc-input fc-search-input"
                       placeholder="Cari judul artikel..."
                       value="{{ request('search') }}"
                       oninput="debounceSearch()">
            </div>

            {{-- Divider --}}
            <div class="fc-filter-divider"></div>

            {{-- Status dropdown --}}
            <div class="fc-status-select-wrap">
                <select name="status" class="fc-input fc-select fc-status-select" onchange="this.form.submit()">
                    <option value="">Semua status</option>
                    <option value="dipublikasi" {{ request('status') == 'dipublikasi' ? 'selected' : '' }}>Dipublikasi</option>
                    <option value="draft"       {{ request('status') == 'draft'       ? 'selected' : '' }}>Draft</option>
                    <option value="diarsip"     {{ request('status') == 'diarsip'     ? 'selected' : '' }}>Diarsip</option>
                </select>
            </div>

            {{-- Divider --}}
            <div class="fc-filter-divider"></div>

            {{-- Count --}}
            <span class="fc-filter-count">{{ $artikels->total() }} artikel</span>

        </div>
    </div>
</form>

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
                    <th style="width:90px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artikels as $artikel)
                <tr>
                    <td>
                        <div class="fc-thumb">
                            @if($artikel->thumbnail)
                                <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="thumbnail"
                                     style="width:100%; height:100%; object-fit:cover; border-radius:6px;">
                            @else
                                <i class="mdi mdi-image-outline"></i>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="fc-table-title">{{ $artikel->judul }}</div>
                        <div class="fc-table-meta">{{ Str::limit($artikel->konten, 60) }}</div>
                    </td>
                    <td>
                        <div class="fc-table-title">{{ $artikel->penulis ?? '—' }}</div>
                        <div class="fc-table-meta">Diupload: {{ optional($artikel->uploader)->nama_lengkap ?? '—' }}</div>
                    </td>
                    <td><span class="fc-table-meta">{{ $artikel->created_at->format('d M Y') }}</span></td>
                    <td>
                        <span class="fc-badge-status fc-badge-{{ $artikel->status }}">
                            {{ $artikel->status === 'dipublikasi' ? 'Dipublikasi' : ($artikel->status === 'draft' ? 'Draft' : 'Diarsip') }}
                        </span>
                    </td>
                    <td>
                        <div class="fc-views">
                            <i class="mdi mdi-eye-outline"></i>
                            {{ $artikel->dilihat ? number_format($artikel->dilihat) : '—' }}
                        </div>
                    </td>
                    <td>
                        <div class="fc-action-group">
                            <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="fc-action-btn" title="Edit">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus artikel ini?');">
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
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        Belum ada artikel. Buat artikel baru untuk menampilkannya di sini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($artikels->hasPages())
        <div style="padding: 16px 20px;">
            {{ $artikels->links() }}
        </div>
    @endif
</div>

@endsection