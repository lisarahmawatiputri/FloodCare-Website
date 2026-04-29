@extends('layouts.admin')

@section('title', 'Edit Video')

@section('content')

<div class="fc-page-header">
    <div>
        <a href="{{ route('admin.video.index') }}" class="fc-breadcrumb-link">
            <i class="mdi mdi-arrow-left"></i> Kembali ke daftar video
        </a>
        <h1 class="fc-page-title" style="margin-top:6px;">Edit Video</h1>
        <p class="fc-page-subtitle">Edit video edukasi banjir yang sudah ada</p>
    </div>
</div>

{{-- Validation errors --}}
@if ($errors->any())
<div class="fc-alert fc-alert-error" style="margin-bottom:16px;">
    <i class="mdi mdi-alert-circle-outline"></i>
    <div>
        <strong>Terdapat kesalahan:</strong>
        <ul style="margin:4px 0 0 16px;padding:0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<form method="POST" action="{{ route('admin.video.update', $video->id) }}" enctype="multipart/form-data" id="videoForm">
    @csrf
    @method('PUT')

    <div class="fc-form-grid">

        {{-- ========================
             KOLOM KIRI - Konten utama
             ======================== --}}
        <div class="fc-form-main">

            {{-- Info Video --}}
            <div class="fc-card fc-form-card">
                <h2 class="fc-form-section-title">Informasi Video</h2>

                {{-- Judul --}}
                <div class="fc-form-group">
                    <label class="fc-label" for="judul">
                        Judul video <span class="fc-required">*</span>
                    </label>
                    <input type="text" id="judul" name="judul"
                           class="fc-input @error('judul') fc-input-error @enderror"
                           value="{{ old('judul', $video->judul) }}"
                           placeholder="Masukkan judul video..."
                           maxlength="50">
                    <div class="fc-input-row-below">
                        @error('judul')
                            <span class="fc-input-error-msg">{{ $message }}</span>
                        @else
                            <span></span>
                        @enderror
                        <span class="fc-char-count" id="judulCount">{{ strlen(old('judul', $video->judul)) }}/50</span>
                    </div>
                </div>

                {{-- Upload Video --}}
                <div class="fc-form-group">
                    <label class="fc-label" for="file_video">
                        File video <span class="fc-required">*</span>
                    </label>

                    {{-- Drop zone video --}}
                    <div class="fc-video-drop" id="videoDrop"
                         onclick="document.getElementById('file_video').click()"
                         ondragover="event.preventDefault();this.classList.add('fc-video-drop-hover')"
                         ondragleave="this.classList.remove('fc-video-drop-hover')"
                         ondrop="handleVideoDrop(event)">

                        {{-- Placeholder (sebelum ada file) --}}
                        <div id="video-placeholder" class="fc-video-placeholder">
                            <i class="mdi mdi-video-plus fc-video-drop-icon"></i>
                            <span class="fc-video-drop-label">Klik atau drag video ke sini</span>
                            <span class="fc-video-drop-hint">MP4, MOV, AVI · maks. 500MB</span>
                        </div>

                        {{-- Preview setelah file dipilih --}}
                        <div id="video-selected" style="display:none;width:100%;text-align:center;">
                            <video id="video-preview"
                                   controls
                                   style="width:100%;max-height:220px;border-radius:8px;background:#000;">
                            </video>
                            <div class="fc-video-info" id="videoInfo"></div>
                        </div>
                    </div>

                    {{-- Tombol ganti/hapus (muncul setelah ada file) --}}
                    <div id="videoActions" style="display:none;margin-top:8px;gap:6px;flex-direction:row;">
                        <button type="button" class="fc-btn fc-btn-ghost fc-btn-sm"
                                onclick="document.getElementById('file_video').click()">
                            <i class="mdi mdi-swap-horizontal"></i> Ganti video
                        </button>
                        <button type="button" class="fc-btn fc-btn-ghost fc-btn-sm"
                                onclick="clearVideo()" style="color:#c0392b;">
                            <i class="mdi mdi-trash-can-outline"></i> Hapus
                        </button>
                    </div>

                    <input type="file" id="file_video" name="file_video"
                           accept="video/mp4,video/quicktime,video/x-msvideo,video/*"
                           class="fc-file-hidden"
                           onchange="previewVideo(this)">

                    @error('file_video')
                        <span class="fc-input-error-msg">{{ $message }}</span>
                    @else
                        <span class="fc-input-hint" style="margin-top:6px;">
                            <i class="mdi mdi-information-outline"></i>
                            Format yang didukung: MP4, MOV, AVI. Maksimal 500MB.
                        </span>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="fc-form-group" style="margin-bottom:0;">
                    <label class="fc-label" for="deskripsi">
                        Deskripsi
                        <span class="fc-label-optional">(opsional)</span>
                    </label>
                    <textarea id="deskripsi" name="deskripsi"
                              class="fc-input fc-textarea @error('deskripsi') fc-input-error @enderror"
                              placeholder="Deskripsi singkat tentang isi video..."
                              rows="4">{{ old('deskripsi', $video->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <span class="fc-input-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </div>

        {{-- ========================
             KOLOM KANAN - Sidebar
             ======================== --}}
        <div class="fc-form-side">

            {{-- Thumbnail --}}
            <div class="fc-card fc-form-card">
                <h2 class="fc-form-section-title">Thumbnail</h2>
                <div class="fc-thumb-drop" id="thumbDrop"
                     onclick="document.getElementById('thumbnail').click()"
                     ondragover="event.preventDefault();this.classList.add('fc-thumb-drop-hover')"
                     ondragleave="this.classList.remove('fc-thumb-drop-hover')"
                     ondrop="handleThumbDrop(event)">

                    <img id="thumb-preview" src="" alt="Preview thumbnail"
                         style="display:none;position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:6px;">

                    <div id="thumb-placeholder" class="fc-thumb-placeholder">
                        <i class="mdi mdi-image-plus fc-thumb-icon"></i>
                        <span class="fc-thumb-label">Klik atau drag gambar</span>
                        <span class="fc-thumb-hint">JPG, PNG · maks. 2MB</span>
                    </div>
                </div>

                <div id="thumbActions" style="display:none;margin-top:8px;gap:6px;flex-direction:column;">
                    <button type="button" class="fc-btn fc-btn-ghost fc-btn-sm fc-btn-full"
                            onclick="document.getElementById('thumbnail').click()">
                        <i class="mdi mdi-image-edit-outline"></i> Ganti gambar
                    </button>
                    <button type="button" class="fc-btn fc-btn-ghost fc-btn-sm fc-btn-full"
                            onclick="clearThumb()" style="color:#c0392b;">
                        <i class="mdi mdi-trash-can-outline"></i> Hapus
                    </button>
                </div>

                <input type="file" id="thumbnail" name="thumbnail"
                       accept="image/jpeg,image/png,image/webp"
                       class="fc-file-hidden"
                       onchange="previewThumb(this)">

                @error('thumbnail')
                    <span class="fc-input-error-msg" style="margin-top:6px;display:block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Durasi —— auto-detect dari video, bisa manual juga --}}
            <div class="fc-card fc-form-card">
                <h2 class="fc-form-section-title">Durasi</h2>
                <div class="fc-form-group" style="margin-bottom:0;">
                    <label class="fc-label" for="durasi_detik">
                        Durasi (detik)
                        <span class="fc-label-optional">(otomatis terisi)</span>
                    </label>
                    <div class="fc-input-prefix-wrap">
                        <span class="fc-input-prefix"><i class="mdi mdi-clock-outline"></i></span>
                        <input type="number" id="durasi_detik" name="durasi_detik"
                               class="fc-input fc-input-prefixed @error('durasi_detik') fc-input-error @enderror"
                               value="{{ old('durasi_detik', $video->durasi_detik) }}"
                               placeholder="Otomatis dari video"
                               min="0">
                    </div>
                    <span class="fc-input-hint" id="durasiFormatted"></span>
                    @error('durasi_detik')
                        <span class="fc-input-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Status & Publikasi --}}
            <div class="fc-card fc-form-card">
                <h2 class="fc-form-section-title">Status publikasi</h2>
                <div class="fc-status-options">
                    <label class="fc-radio-card {{ old('status', $video->status) == 'draft' ? 'fc-radio-card-active' : '' }}">
                        <input type="radio" name="status" value="draft"
                               {{ old('status', $video->status) == 'draft' ? 'checked' : '' }}
                               onchange="updateStatusCard()">
                        <div class="fc-radio-card-content">
                            <i class="mdi mdi-file-outline fc-radio-icon" style="color:#856404;"></i>
                            <div>
                                <div class="fc-radio-title">Draft</div>
                                <div class="fc-radio-desc">Tidak ditampilkan ke publik</div>
                            </div>
                        </div>
                    </label>
                    <label class="fc-radio-card {{ old('status', $video->status) == 'published' ? 'fc-radio-card-active' : '' }}">
                        <input type="radio" name="status" value="published"
                               {{ old('status', $video->status) == 'published' ? 'checked' : '' }}
                               onchange="updateStatusCard()">
                        <div class="fc-radio-card-content">
                            <i class="mdi mdi-earth fc-radio-icon" style="color:#0F6E56;"></i>
                            <div>
                                <div class="fc-radio-title">Publik</div>
                                <div class="fc-radio-desc">Tampil di halaman edukasi</div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="fc-form-actions">
                <button type="submit" class="fc-btn fc-btn-primary fc-btn-full">
                    <i class="mdi mdi-check-circle-outline"></i>
                    Perbarui video
                </button>
                <a href="{{ route('admin.video.index') }}" class="fc-btn fc-btn-ghost fc-btn-full">
                    Batal
                </a>
            </div>

        </div>
    </div>
</form>

@endsection

