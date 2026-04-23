@extends('layouts.admin')

@section('title', 'Laporan Banjir')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark">📋 Daftar Laporan Banjir</h4>
        <a href="{{ route('dashboard') }}" class="btn btn-sm" style="background-color:#ff6600; color:white;">
            ← Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">
                
                {{-- HEADER OREN --}}
                <thead style="background-color:#FF6600; color:white;">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Pelapor</th>
                        <th>Alamat</th>
                        <th>Tinggi Air</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($laporan as $l)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>{{ $l->nama_pelapor ?? 'Anonim' }}</td>

                            <td>{{ $l->alamat_lokasi ?? '-' }}</td>

                            <td class="text-center">
                                {{ $l->tinggi_banjir_cm ?? 0 }} cm
                            </td>

                            <td class="text-center">
                                @php
                                    $status = $l->status_laporan ?? 'menunggu';
                                    $warna = match($status) {
                                        'menunggu' => 'secondary',
                                        'valid' => 'success',
                                        'tidak_valid' => 'danger',
                                        'diterima' => 'info',
                                        default => 'dark',
                                    };
                                @endphp
                                <span class="badge bg-{{ $warna }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if($l->foto_laporan)
                                    <img src="{{ asset('storage/' . $l->foto_laporan) }}"
                                         width="60" height="60"
                                         style="object-fit:cover; border-radius:6px;">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.laporan.show', $l->id) }}"
                                   class="btn btn-sm btn-info text-white">Detail</a>

                                <a href="#" class="btn btn-sm btn-warning text-white">Edit</a>

                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin hapus data?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada laporan banjir
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>
@endsection