@extends('layouts.admin')

@section('title', 'Detail Donasi')

@section('content')
@php
    $statusColor = $donasi->status_color;
    $statusLabel = $donasi->status_label;
    $namaDonatur = $donasi->is_anonymous
        ? 'Anonim'
        : ($donasi->user->nama_lengkap ?? $donasi->user->name ?? '-');
@endphp

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Detail Donasi</h4>
        <a href="{{ route('admin.donasi.index') }}" class="btn text-white" style="background:#ff6600;">← Kembali</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header text-white" style="background:#ff6600;">
            <strong>Informasi Donasi</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Kode Transaksi:</strong><br>{{ $donasi->kode_transaksi ?? '-' }}</p>
                    <p><strong>Order ID Midtrans:</strong><br>{{ $donasi->midtrans_order_id ?? '-' }}</p>
                    <p><strong>Nama Donatur:</strong><br>{{ $namaDonatur }}</p>
                    <p><strong>Email:</strong><br>{{ $donasi->user->email ?? '-' }}</p>
                    <p><strong>Program:</strong><br>{{ $donasi->program->nama_program ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nominal:</strong><br>Rp {{ number_format((float) $donasi->nominal,0,',','.') }}</p>
                    <p><strong>Metode:</strong><br>{{ $donasi->metode_pembayaran ?? '-' }}</p>
                    <p><strong>Payment Type:</strong><br>{{ $donasi->payment_type ?? '-' }}</p>
                    <p><strong>Status:</strong><br><span class="badge bg-{{ $statusColor }}">{{ $statusLabel }}</span></p>
                    <p><strong>Dibayar pada:</strong><br>{{ $donasi->paid_at ? $donasi->paid_at->format('d M Y H:i') : '-' }}</p>
                </div>
            </div>

            @if($donasi->pesan)
                <div class="alert alert-light border mt-3">
                    <strong>Pesan donatur:</strong><br>{{ $donasi->pesan }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
