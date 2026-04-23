@extends('layouts.admin')

@section('title', 'Detail Laporan Banjir')

@section('content')
<div class="container py-4">

    <a href="{{ route('admin.laporan.index') }}"
       class="btn btn-sm mb-4"
       style="background-color:#ff6600; color:white;">
        ← Kembali
    </a>

    <div class="card shadow">
        <div class="card-header text-white" style="background-color:#ff6600;">
            <h5 class="mb-0">Detail Laporan Banjir</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Pelapor</th>
                    <td>{{ $laporan->nama_pelapor ?? 'Anonim' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $laporan->alamat_lokasi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tinggi Banjir</th>
                    <td>{{ $laporan->tinggi_banjir_cm ?? 0 }} cm</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-dark">
                            {{ ucfirst($laporan->status_laporan ?? '-') }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Latitude</th>
                    <td>{{ $laporan->latitude ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Longitude</th>
                    <td>{{ $laporan->longitude ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>
                        {{ $laporan->created_at ? $laporan->created_at->format('d M Y H:i') : '-' }}
                    </td>
                </tr>
            </table>

            <div class="text-center mt-4">
                @if($laporan->foto_laporan)
                    <img src="{{ asset('storage/' . $laporan->foto_laporan) }}"
                         class="img-fluid rounded shadow"
                         style="max-height:300px;">
                @else
                    <div class="text-muted">Tidak ada foto laporan</div>
                @endif
            </div>

            <hr>

            <div id="map" style="height:300px; border-radius:8px;"></div>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var lat = {{ $laporan->latitude ?? 0 }};
    var lng = {{ $laporan->longitude ?? 0 }};

    var map = L.map('map').setView([lat, lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    if(lat && lng){
        L.marker([lat, lng]).addTo(map);
    }
});
</script>
@endsection