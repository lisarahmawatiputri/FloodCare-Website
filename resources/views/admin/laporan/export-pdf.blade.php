<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a1a; background: #fff; }

    .header { background: #ff6600; padding: 20px 28px; color: #fff; margin-bottom: 20px; }
    .header-top { display: flex; justify-content: space-between; align-items: center; }
    .header-logo { font-size: 18px; font-weight: 700; letter-spacing: 0.5px; }
    .header-sub { font-size: 11px; opacity: 0.85; margin-top: 2px; }
    .header-date { font-size: 10px; opacity: 0.8; text-align: right; }

    .stat-row { display: flex; gap: 12px; padding: 0 28px 16px; }
    .stat-card { flex: 1; border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 10px 14px; }
    .stat-num { font-size: 22px; font-weight: 700; color: #1a1a1a; }
    .stat-label { font-size: 10px; color: #6b7280; margin-top: 2px; }
    .stat-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 4px; }
    .dot-gray  { background: #9ca3af; }
    .dot-green { background: #22c55e; }
    .dot-red   { background: #ef4444; }

    .section-title { font-size: 12px; font-weight: 700; color: #374151; padding: 0 28px 10px; }

    table { width: calc(100% - 56px); margin: 0 28px; border-collapse: collapse; }
    thead tr { background: #fff7f4; }
    th { padding: 9px 10px; text-align: left; font-size: 10px; font-weight: 700;
         color: #6b7280; border-bottom: 2px solid #ff6600; white-space: nowrap; }
    td { padding: 9px 10px; border-bottom: 1px solid #f3f4f6; font-size: 10px; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:nth-child(even) td { background: #fafafa; }

    .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 9px; font-weight: 600; }
    .badge-menunggu  { background: #f3f4f6; color: #6b7280; }
    .badge-valid     { background: #dcfce7; color: #16a34a; }
    .badge-tidak_valid { background: #fee2e2; color: #dc2626; }
    .badge-tinggi    { background: #fee2e2; color: #dc2626; }
    .badge-sedang    { background: #fef9c3; color: #ca8a04; }
    .badge-rendah    { background: #dcfce7; color: #16a34a; }

    .water-tinggi { color: #dc2626; font-weight: 600; }
    .water-sedang { color: #ca8a04; font-weight: 600; }
    .water-rendah { color: #16a34a; font-weight: 600; }

    .footer { margin-top: 20px; padding: 12px 28px 0; border-top: 1px solid #e5e7eb;
              display: flex; justify-content: space-between; color: #9ca3af; font-size: 9px; }
</style>
</head>
<body>

{{-- Header --}}
<div class="header">
    <div class="header-top">
        <div>
            <div class="header-logo">FloodCare</div>
            <div class="header-sub">Rekapan Laporan Banjir</div>
        </div>
        <div class="header-date">
            Dicetak pada<br>{{ $exportedAt }} WIB
        </div>
    </div>
</div>

{{-- Stat cards --}}
<!-- <div class="stat-row">
    <div class="stat-card">
        <span class="stat-dot dot-gray"></span>
        <span class="stat-num">{{ $countMenunggu }}</span>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-card">
        <span class="stat-dot dot-green"></span>
        <span class="stat-num">{{ $countValid }}</span>
        <div class="stat-label">Valid</div>
    </div>
    <div class="stat-card">
        <span class="stat-dot dot-red"></span>
        <span class="stat-num">{{ $countTidakValid }}</span>
        <div class="stat-label">Tidak Valid</div>
    </div>
    <div class="stat-card">
        <span class="stat-num">{{ $laporans->count() }}</span>
        <div class="stat-label">Total diexport</div>
    </div>
</div> -->

<div class="section-title">Daftar Laporan</div>

{{-- Table --}}
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Pelapor</th>
            <th>Alamat</th>
            <th>Tinggi Air</th>
            <th>Risiko</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($laporans as $i => $laporan)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $laporan->judul }}</td>
            <td>{{ optional($laporan->pelapor)->nama_lengkap ?? '—' }}</td>
            <td>{{ $laporan->alamat_lokasi ?? '—' }}</td>
            <td class="water-{{ $laporan->tingkat_risiko ?? 'rendah' }}">
                {{ $laporan->tinggi_banjir_cm ?? '—' }} cm
            </td>
            <td>
                <span class="badge badge-{{ $laporan->tingkat_risiko ?? 'rendah' }}">
                    {{ ucfirst($laporan->tingkat_risiko ?? '—') }}
                </span>
            </td>
            <td>
                <span class="badge badge-{{ $laporan->status_laporan ?? 'menunggu' }}">
                    {{ ['menunggu'=>'Menunggu','valid'=>'Valid','tidak_valid'=>'Tidak Valid'][$laporan->status_laporan] ?? 'Menunggu' }}
                </span>
            </td>
            <td>{{ $laporan->created_at ? $laporan->created_at->format('d M Y') : '—' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center; color:#9ca3af; padding:20px;">
                Tidak ada data laporan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- Footer --}}
<div class="footer">
    <span>FloodCare — Sistem Informasi Banjir</span>
    <span>Total {{ $laporans->count() }} laporan</span>
</div>

</body>
</html>