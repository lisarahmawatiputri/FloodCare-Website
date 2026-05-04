@extends('layouts.admin')

@section('title', 'Semua Transaksi Donasi')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">💳 Semua Transaksi Donasi</h4>

        <a href="{{ route('admin.donasi.index') }}"
           class="btn text-white"
           style="background:#ff6600;">
            ← Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-bordered">
                <thead style="background:#ff6600; color:white;">
                    <tr>
                        <th>Donatur</th>
                        <th>Program</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($donasi as $d)
                        <tr>
                            <td>{{ $d->is_anonymous ? 'Anonim' : ($d->user->nama_lengkap ?? $d->user->name ?? '-') }}</td>
                            <td>{{ $d->program->nama_program ?? '-' }}</td>
                            <td>Rp {{ number_format($d->nominal,0,',','.') }}</td>
                            <td><span class="badge bg-{{ $d->status_color }}">{{ $d->status_label }}</span></td>
                            <td>{{ $d->created_at->format('d M Y') }}</td>

                            <td>
                                <a href="{{ route('admin.donasi.show',$d->id) }}"
                                   class="btn btn-sm text-white"
                                   style="background:#ff6600;">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada transaksi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINATION --}}
            {{ $donasi->links() }}

        </div>
    </div>

</div>
@endsection