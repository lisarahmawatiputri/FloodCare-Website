@extends('layouts.admin')

@section('title', 'Kelola Program Donasi')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"> Kelola Program Donasi</h4>
        <h4 class="fw-bold">📦 Kelola Program Donasi</h4>

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
                        <th>Nama Program</th>
                        <th>Target</th>
                        <th>Terkumpul</th>
                        <th>Progress</th>
                        <th>Aksi</th>
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
                            <td>{{ $p->nama_program }}</td>
                            <td>Rp {{ number_format($p->target_dana,0,',','.') }}</td>
                            <td>Rp {{ number_format($p->terkumpul,0,',','.') }}</td>

                            <td>
                                <div class="progress" style="height:10px;">
                                    <div class="progress-bar"
                                         style="width: {{ $persen }}%; background:#ff6600;">
                                    </div>
                                </div>
                                <small>{{ number_format($persen,0) }}%</small>
                            </td>

                            <td>
                                {{-- DELETE --}}
                                <form action="{{ route('admin.donasi.destroy',$p->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus program?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada program
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
