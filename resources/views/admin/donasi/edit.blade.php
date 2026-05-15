@extends('layouts.admin')

@section('title','Edit Program Donasi')

@section('content')
<div class="container py-4">

    <h2 class="fw-bold mb-4">Edit Program Donasi</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('admin.donasi.update',$program->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Nama Program</label>
                    <input type="text"
                           name="nama_program"
                           class="form-control"
                           value="{{ $program->nama_program }}"
                           required>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi"
                              class="form-control"
                              rows="4"
                              required>{{ $program->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Target Dana</label>
                    <input type="number"
                           name="target_dana"
                           class="form-control"
                           value="{{ $program->target_dana }}"
                           required>
                </div>

                <div class="mb-3">
                    <label>Foto Program</label><br>

                    @if($program->foto)
                        <img src="{{ asset('storage/'.$program->foto) }}"
                             width="150"
                             class="mb-2 rounded">
                    @endif

                    <input type="file"
                           name="foto"
                           class="form-control">
                </div>

                <button class="btn btn-warning">
                    Update Program
                </button>

                <a href="{{ route('admin.donasi.program') }}"
                   class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>
    </div>

</div>
@endsection