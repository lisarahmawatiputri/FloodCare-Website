@extends('layouts.admin')

@section('title', 'Tambah Artikel')

@section('content')

<div class="fc-page-header">
    <div>
        <a href="{{ route('admin.artikel.index') }}" class="fc-breadcrumb-link">
            <i class="mdi mdi-arrow-left"></i> Kembali ke daftar artikel
        </a>
        <h1 class="fc-page-title" style="margin-top:6px;">Tambah Artikel</h1>
        <p class="fc-page-subtitle">Buat artikel edukasi banjir baru</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.artikel.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="fc-form-grid">

        {{-- Kolom Kiri --}}
        <div class="fc-form-main">
            <div class="fc-card fc-form-card">
                <h2 class="fc-form-section-title">Konten Artikel</h2>

                <div class="fc-form-group">
                    <label class="fc-label" for="judul">
                        Judul artikel <span class="fc-required">*</span>
                    </label>
                    <input type="text" id="judul" name="judul"
                           class="fc-input @error('judul') fc-input-error @enderror"
                           value="{{ old('judul') }}"
                           placeholder="Masukkan judul artikel...">
                    @error('judul')
                        <span class="fc-input-hint fc-hint-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="fc-form-group">
                    <label class="fc-label" for="url_link">
                        URL Link <span class="fc-required">*</span>
                    </label>
                    <div class="fc-input-prefix-wrap">
                        <span class="fc-input-prefix"><i class="mdi mdi-link-variant"></i></span>
                        <input type="url" id="url_link" name="url_link"
                               class="fc-input fc-input-prefixed @error('url_link') fc-input-error @enderror"
                               value="{{ old('url_link') }}"
                               placeholder="https://contoh.com/artikel/...">
                    </div>
                    <span class="fc-input-hint">Link artikel yang akan ditampilkan ke pengguna</span>
                    @error('url_link')
                        <span class="fc-input-hint fc-hint-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="fc-form-group" style="margin-bottom:0;">
                    <label class="fc-label" for="konten">
                        Konten <span class="fc-required">*</span>
                    </label>
                    <textarea id="konten" name="konten"
                              class="fc-input fc-textarea @error('konten') fc-input-error @enderror"
                              placeholder="Tulis isi artikel di sini...">{{ old('konten') }}</textarea>
                    @error('konten')
                        <span class="fc-input-hint fc-hint-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="fc-form-side">

            {{-- Thumbnail --}}
            <div class="fc-card fc-form-card">
                <h2 class="fc-form-section-title">Thumbnail</h2>
                <div class="fc-thumb-drop" onclick="document.getElementById('thumbnail').click()">
                    <img id="thumb-preview" src="" alt=""
                         style="display:none; width:100%; height:100%; object-fit:cover; border-radius:6px;">
                    <div id="thumb-placeholder">
                        <i class="mdi mdi-image-plus fc-thumb-icon"></i>
                        <span class="fc-thumb-label">Klik untuk unggah gambar</span>
                        <span class="fc-thumb-hint">JPG, PNG, WebP · maks 2MB</span>
                    </div>
                </div>
                <input type="file" id="thumbnail" name="thumbnail"
                       accept="image/jpeg,image/png,image/webp"
                       class="fc-file-hidden"
                       onchange="previewThumb(this)">
            </div>

            {{-- Status --}}
            @php $selectedStatus = old('status', 'draft'); @endphp
            <div class="fc-card fc-form-card">
                <h2 class="fc-form-section-title">Status</h2>
                <div class="fc-status-group">
                    <label class="fc-status-opt {{ $selectedStatus == 'draft' ? 'active' : '' }}">
                        <input type="radio" name="status" value="draft" {{ $selectedStatus == 'draft' ? 'checked' : '' }}
                               onchange="setStatus(this)">
                        <i class="mdi mdi-file-outline"></i> Draft
                    </label>
                    <label class="fc-status-opt {{ $selectedStatus == 'published' ? 'active' : '' }}">
                        <input type="radio" name="status" value="published" {{ $selectedStatus == 'published' ? 'checked' : '' }}
                               onchange="setStatus(this)">
                        <i class="mdi mdi-check-circle-outline"></i> Dipublikasi
                    </label>
                    <label class="fc-status-opt {{ $selectedStatus == 'archived' ? 'active' : '' }}">
                        <input type="radio" name="status" value="archived" {{ $selectedStatus == 'archived' ? 'checked' : '' }}
                               onchange="setStatus(this)">
                        <i class="mdi mdi-archive-outline"></i> Diarsip
                    </label>
                </div>
                @error('status')
                    <span class="fc-input-hint fc-hint-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Penulis --}}
            <div class="fc-card fc-form-card">
                <h2 class="fc-form-section-title">Penulis</h2>
                <select name="user_id" class="fc-input fc-select">
                    <option value="">Pilih penulis...</option>
                    <option value="1">Lisa Rahmawati</option>
                    <option value="2">Ahmad Fauzi</option>
                    <option value="3">Siti Aisyah</option>
                    <option value="4">Dr. Hendra K.</option>
                </select>
                @error('user_id')
                    <span class="fc-input-hint fc-hint-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="fc-form-actions">
                <button type="submit" class="fc-btn fc-btn-primary fc-btn-full">
                    <i class="mdi mdi-content-save-outline"></i>
                    Simpan Artikel
                </button>
                <a href="{{ route('admin.artikel.index') }}" class="fc-btn fc-btn-secondary fc-btn-full">
                    Batal
                </a>
            </div>

        </div>
    </div>
</form>

@push('scripts')
<script>
function previewThumb(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('thumb-preview').src = e.target.result;
        document.getElementById('thumb-preview').style.display = 'block';
        document.getElementById('thumb-placeholder').style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}

function setStatus(radio) {
    document.querySelectorAll('.fc-status-opt').forEach(el => el.classList.remove('active'));
    radio.closest('.fc-status-opt').classList.add('active');
}
</script>
@endpush

@endsection
