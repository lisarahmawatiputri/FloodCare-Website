@extends('layouts.admin')

@section('title', 'Tambah Program Donasi')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Tambah Program Donasi</h4>

        <a href="{{ route('admin.donasi.index') }}"
           class="btn text-white"
           style="background:#ff6600;">
            ← Kembali
        </a>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada kesalahan input:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="card shadow-sm border-0" style="max-width:800px;margin:auto;">
        <div class="card-body p-4">

            <form action="{{ route('admin.donasi.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Judul Program
                    </label>
                    <input type="text"
                           name="nama_program"
                           class="form-control"
                           placeholder="Masukkan judul program"
                           value="{{ old('nama_program') }}"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi"
                              rows="4"
                              class="form-control"
                              placeholder="Masukkan deskripsi program"
                              required>{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Target Nominal
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="number"
                               name="target_dana"
                               class="form-control no-spinner"
                               placeholder="Contoh: 1000000"
                               value="{{ old('target_dana') }}"
                               required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Foto Program
                    </label>

                    <input type="file"
                           name="foto"
                           class="form-control"
                           accept="image/*"
                           onchange="previewImage(event)">

                    <small class="text-muted">
                        Upload gambar (jpg, jpeg, png, max 2MB)
                    </small>

                    <div class="mt-3">
                        <img id="preview"
                             src="#"
                             style="display:none; width:100%; max-height:200px; object-fit:cover; border-radius:10px;">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn text-white px-4"
                            style="background:#ff6600;">
                        Simpan Program
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<style>
.no-spinner::-webkit-outer-spin-button,
.no-spinner::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.no-spinner {
    -moz-appearance: textfield;
}
</style>


<script>
function previewImage(event) {
    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function(e) {
        const img = document.getElementById('preview');
        img.src = e.target.result;
        img.style.display = 'block';
    }

    reader.readAsDataURL(file);
}
</script>

@endsection