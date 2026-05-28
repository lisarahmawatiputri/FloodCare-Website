@extends('layouts.admin')

@section('title', 'Kelola Program Donasi')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold">Kelola Program Donasi</h4>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.donasi.create') }}"
               class="btn text-white"
               style="background:#ff6600;">
                + Tambah Program
            </a>

            <a href="{{ route('admin.donasi.index') }}"
               class="btn btn-secondary">
                ← Kembali
            </a>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead style="background:#ff6600; color:white;">

                    <tr>
                        <th>Foto</th>
                        <th>Nama Program</th>
                        <th>Target</th>
                        <th>Terkumpul</th>
                        <th>Progress</th>
                        <th width="180">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($program as $p)

                        @php
                            $persen = ($p->target_dana > 0)
                                ? min(100, ($p->terkumpul / $p->target_dana) * 100)
                                : 0;
                        @endphp

                        <tr>

                            <td width="120">

                                @if($p->foto)

                                    <img src="{{ asset('storage/'.$p->foto) }}"
                                         width="90"
                                         height="70"
                                         style="object-fit:cover; border-radius:10px;">

                                @else

                                    <span class="text-muted">
                                        Tidak ada foto
                                    </span>

                                @endif

                            </td>

                            <td>
                                <strong>{{ $p->nama_program }}</strong>
                            </td>

                            <td>
                                Rp {{ number_format($p->target_dana,0,',','.') }}
                            </td>

                            <td>
                                Rp {{ number_format($p->terkumpul,0,',','.') }}
                            </td>

                            <td width="220">

                                <div class="progress" style="height:12px;">

                                    <div class="progress-bar"
                                         style="width: {{ $persen }}%; background:#ff6600;">
                                    </div>

                                </div>

                                <small class="fw-semibold">
                                    {{ number_format($persen,0) }}%
                                </small>

                            </td>

                            <td>

                                <div class="d-flex gap-2">

                                    <a href="{{ route('admin.donasi.edit',$p->id) }}"
                                       class="btn btn-sm btn-warning text-white">
                                        Edit
                                    </a>

                                   <form action="{{ route('admin.donasi.destroy',$p->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            data-confirm="Yakin ingin menghapus program ini?">
                                        Hapus
                                    </button>
                                </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center text-muted py-4">

                                Belum ada program donasi

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection