@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span>Overview</span>
            </li>
        </ul>
    </nav>
</div>

{{-- Stats Cards --}}
<div class="row">
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets_admin/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Total Laporan <i class="mdi mdi-water mdi-24px float-end"></i></h4>
                <h2 class="mb-5">0</h2>
                <h6 class="card-text">Laporan banjir masuk</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets_admin/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Total Donasi <i class="mdi mdi-heart mdi-24px float-end"></i></h4>
                <h2 class="mb-5">0</h2>
                <h6 class="card-text">Donasi terkumpul</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets_admin/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Total Artikel <i class="mdi mdi-newspaper mdi-24px float-end"></i></h4>
                <h2 class="mb-5">0</h2>
                <h6 class="card-text">Artikel dipublikasi</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-warning card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets_admin/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Total User <i class="mdi mdi-account-multiple mdi-24px float-end"></i></h4>
                <h2 class="mb-5">0</h2>
                <h6 class="card-text">User terdaftar</h6>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Statistik Laporan Banjir</h4>
                <div style="position:relative; height:250px; width:100%;">
                    <canvas id="laporan-bar-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Status Laporan</h4>
                <div style="position:relative; height:250px; width:100%;">
                    <canvas id="status-doughnut-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Area Chart --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tren Donasi Per Bulan</h4>
                <div style="position:relative; height:250px; width:100%;">
                    <canvas id="donasi-area-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Laporan Banjir Terbaru</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Pelapor</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="mdi mdi-water-off mdi-36px d-block mb-2"></i>
                                    Belum ada laporan masuk
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra-js')
<script src="{{ asset('assets_admin/vendors/chart.js/chart.umd.js') }}"></script>
<script>
$(function() {
    // Bar Chart
    if ($("#laporan-bar-chart").length) {
        new Chart(document.getElementById('laporan-bar-chart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags'],
                datasets: [
                    {
                        label: 'Laporan Masuk',
                        data: [5, 8, 3, 12, 7, 15, 9, 6],
                        backgroundColor: 'rgba(232, 86, 42, 0.6)',
                        borderColor: '#e8562a',
                        borderWidth: 1
                    },
                    {
                        label: 'Laporan Selesai',
                        data: [3, 5, 2, 8, 5, 10, 7, 4],
                        backgroundColor: 'rgba(42, 186, 232, 0.6)',
                        borderColor: '#2abae8',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // Doughnut Chart
    if ($("#status-doughnut-chart").length) {
        new Chart(document.getElementById('status-doughnut-chart'), {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'],
                datasets: [{
                    data: [10, 5, 20, 3],
                    backgroundColor: ['#e8562a', '#2abae8', '#2abe8a', '#e8c42a'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // Area Chart
    if ($("#donasi-area-chart").length) {
        new Chart(document.getElementById('donasi-area-chart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags'],
                datasets: [{
                    label: 'Jumlah Donasi (Rp)',
                    data: [500000, 1200000, 800000, 2000000, 1500000, 3000000, 2500000, 1800000],
                    backgroundColor: 'rgba(232, 86, 42, 0.2)',
                    borderColor: '#e8562a',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#e8562a',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    }
});
</script>
@endsection