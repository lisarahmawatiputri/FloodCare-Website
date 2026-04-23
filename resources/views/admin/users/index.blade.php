@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
<style>
    /* Membuat baris tabel terlihat bisa diklik */
    .clickable-row {
        cursor: pointer;
    }
    .clickable-row:hover {
        background-color: rgba(232, 86, 42, 0.05) !important;
    }
    /* Ukuran khusus untuk tombol aksi agar lebih kecil */
    .btn-xs {
        padding: 0.25rem 0.4rem;
        font-size: 0.75rem;
        line-height: 1;
        border-radius: 0.2rem;
    }
    .btn-icon-xs {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-icon-xs i {
        font-size: 14px !important;
    }
</style>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-account-multiple"></i>
        </span> Kelola User
    </h3>
</div>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Akun Pengguna</h4>

                    <div class="search-field">
                        <form action="#" method="GET">
                            <div class="input-group border rounded px-2 bg-light shadow-sm">
                                <div class="input-group-prepend bg-transparent">
                                    <i class="input-group-text border-0 mdi mdi-magnify text-muted"></i>
                                </div>
                                <input type="text" class="form-control bg-transparent border-0" placeholder="Cari user...">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th class="font-weight-bold text-center" style="width: 50px;"> NO </th>
                                <th class="font-weight-bold"> NAMA LENGKAP </th>
                                <th class="font-weight-bold"> EMAIL </th>
                                <th class="font-weight-bold"> NO. TELEPON </th>
                                <th class="font-weight-bold text-center" style="width: 120px;"> AKSI </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                            <tr class="clickable-row" data-href="{{ route('admin.users.show', $user->id) }}">
                                <td class="text-center font-weight-bold text-muted small">
                                    {{ $index + 1 }}
                                </td>

                                <td class="py-3 font-weight-bold text-dark">
                                    {{ $user->nama_lengkap }}
                                </td>

                                <td class="text-muted"> {{ $user->email }} </td>

                                <td class="text-muted"> {{ $user->no_telepon ?? '-' }} </td>

                                <td class="text-center">
                                    {{-- Tombol Edit Kecil --}}
                                    <a href="#" class="btn btn-inverse-warning btn-icon-xs shadow-sm mx-1 action-btn" title="Edit User">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>

                                    {{-- Tombol Blokir Kecil --}}
                                    <form action="#" method="POST" class="d-inline action-btn" onsubmit="return confirm('Apakah Anda yakin ingin memblokir user ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-inverse-danger btn-icon-xs shadow-sm" title="Blokir User">
                                            <i class="mdi mdi-block-helper"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Tidak ada data pengguna ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rows = document.querySelectorAll(".clickable-row");
        rows.forEach(row => {
            row.addEventListener("click", function(e) {
                // Mencegah klik baris jika yang ditekan adalah tombol aksi (pensil/blokir)
                if (!e.target.closest('.action-btn')) {
                    window.location.href = this.dataset.href;
                }
            });
        });
    });
</script>
@endsection
