@extends('layouts.admin')

@section('title', 'Donasi')

@section('content')
<div class="container-fluid py-4">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Donasi</h4>

        <a href="{{ route('admin.donasi.create') }}"
           class="btn text-white"
           style="background:#ff6600;">
            + Program Baru
        </a>
    </div>


    <div class="row mb-4">

        {{-- TOTAL TERKUMPUL --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center">

                    <div class="me-3 d-flex align-items-center justify-content-center"
                         style="width:55px;height:55px;background:#fdecea;border-radius:12px;">
                        <span style="color:#ff6600;font-size:22px;">$</span>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">
                            Rp {{ number_format($totalDonasi,0,',','.') }}
                        </h5>
                        <small class="text-muted">Total terkumpul</small>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center">

                    <div class="me-3 d-flex align-items-center justify-content-center"
                         style="width:55px;height:55px;background:#e6f4ea;border-radius:12px;">
                        <span style="color:#28a745;font-size:22px;">▶</span>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">{{ $programAktif }}</h5>
                        <small class="text-muted">Program aktif</small>
                    </div>

                </div>
            </div>
        </div>

        {{-- TOTAL DONATUR --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center">

                    <div class="me-3 d-flex align-items-center justify-content-center"
                         style="width:55px;height:55px;background:#eef2f7;border-radius:12px;">
                        <span style="color:#6c757d;font-size:22px;">👥</span>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">{{ $totalDonatur }}</h5>
                        <small class="text-muted">Total donatur</small>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="row">


        <div class="col-md-4">
            <div class="card shadow-sm border-0">

                <div class="card-header d-flex justify-content-between">
                    <strong>Program donasi</strong>

                    <a href="{{ route('admin.donasi.program') }}" style="color:#ff6600;">
                        Kelola semua
                    </a>
                </div>

                <div class="card-body">

                    @forelse($program as $p)

                        @php
                            $persen = $p->target_dana > 0
                                ? min(100, ($p->terkumpul / $p->target_dana) * 100
                                ): 0;

                            $warna = '#ff6600';
                            if($persen >= 100) {
                                $warna = 'green';

                            } elseif($persen >= 50) {
                                $warna = '#ffc107';
                            }
                        @endphp

                        <div class="mb-3 border-bottom pb-2">

                            {{-- FOTO --}}
                            @if($p->foto)
                                <img src="{{ asset('storage/'.$p->foto) }}"
                                     class="img-fluid rounded mb-2"
                                     style="height:120px; object-fit:cover;">
                            @endif

                            <strong>{{ $p->nama_program }}</strong>

                            {{-- STATUS --}}
                            <span class="badge bg-{{ $p->status == 'aktif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($p->status) }}
                            </span>

                            {{-- PROGRESS --}}
                            <div class="progress mt-2 mb-2" style="height:10px;">
                                <div class="progress-bar"
                                     style="width: {{ $persen }}%; background:{{ $warna }};">
                                </div>
                            </div>

                            <small>
                                {{ number_format($persen,0) }}%
                                - Rp {{ number_format($p->terkumpul,0,',','.') }}
                                / Rp {{ number_format($p->target_dana,0,',','.') }}
                            </small>

                        </div>

                    @empty
                        <p class="text-muted">Belum ada program</p>
                    @endforelse

                </div>

            </div>
        </div>


        <div class="col-md-8">
            <div class="card shadow-sm border-0">

                <div class="card-header d-flex justify-content-between">
                    <strong>Riwayat Transaksi terbaru</strong>

                    <a href="{{ route('admin.donasi.transaksi') }}" style="color:#ff6600;">
                        Lihat semua
                    </a>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">
                        <thead style="background:#ff6600; color:white;">
                            <tr>
                                <th>Donatur</th>
                                <th>Program</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($donasi as $d)

                                @php
                                    $warna = $d->status_color;
                                    $labelStatus = $d->status_label;
                                @endphp

                                <tr>
                                    <td>{{ $d->is_anonymous ? 'Anonim' : ($d->user->nama_lengkap ?? $d->user->name ?? '-') }}</td>
                                    <td>{{ $d->program->nama_program ?? '-' }}</td>
                                    <td>Rp {{ number_format($d->nominal,0,',','.') }}</td>

                                    <td>
                                        <span class="badge bg-{{ $warna }}">
                                            {{ $labelStatus ?? $d->status_label }}
                                        </span>
                                    </td>

                                    <td>

                                        <a href="{{ route('admin.donasi.show',$d->id) }}"
                                           class="btn btn-sm text-white mb-1"
                                           style="background:#ff6600;">
                                            Detail
                                        </a>

                                        <form action="{{ route('admin.donasi.updateStatus',[$d->id,'sukses']) }}"
                                              method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-success">Sukses</button>
                                        </form>

                                        <form action="{{ route('admin.donasi.updateStatus',[$d->id,'menunggu']) }}"
                                              method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-warning">Menunggu</button>
                                        </form>

                                        <form action="{{ route('admin.donasi.updateStatus',[$d->id,'gagal']) }}"
                                              method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-danger">Gagal</button>
                                        </form>

                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $donasi->links() }}

                </div>

            </div>
        </div>

    </div>

</div>
@endsection
