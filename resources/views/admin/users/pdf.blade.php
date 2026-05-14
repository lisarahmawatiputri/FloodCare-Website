<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Data User — FloodCare</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #ffffff;
        }

        /* ── HEADER ── */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #ff6600;
            padding-bottom: 12px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .brand {
            font-size: 20px;
            font-weight: 700;
            color: #ff6600;
            letter-spacing: -0.5px;
        }

        .brand-sub {
            font-size: 10px;
            color: #888;
            margin-top: 2px;
        }

        .doc-title {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .doc-meta {
            font-size: 10px;
            color: #888;
            margin-top: 3px;
        }

        /* ── SUMMARY BADGES ── */
        .summary-row {
            display: table;
            width: 100%;
            margin-bottom: 16px;
        }

        .summary-cell {
            display: table-cell;
            width: 25%;
            padding: 10px 12px;
            border: 1px solid #f0f0f0;
            border-radius: 6px;
        }

        .summary-cell + .summary-cell {
            margin-left: 8px;
        }

        .summary-num {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1;
        }

        .summary-lbl {
            font-size: 10px;
            color: #888;
            margin-top: 3px;
        }

        .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 4px;
            vertical-align: middle;
        }

        /* ── TABLE ── */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: #ff6600;
            color: #ffffff;
            padding: 9px 10px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        thead th:first-child { border-radius: 0; }

        tbody tr:nth-child(even) td {
            background-color: #fafafa;
        }

        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 11px;
            color: #1a1a1a;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .td-no {
            color: #888;
            text-align: center;
            width: 28px;
        }

        .td-nama {
            font-weight: 600;
        }

        .td-email {
            color: #555;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
        }

        .badge-superadmin { background: #fff3eb; color: #cc5200; }
        .badge-admin      { background: #e8f4ff; color: #1a5cb0; }
        .badge-masyarakat { background: #f0f0f0; color: #555555; }

        .badge-aktif    { background: #eafaf4; color: #1a7a4a; }
        .badge-nonaktif { background: #f0f0f0; color: #888888; }
        .badge-diblokir { background: #fff0ec; color: #cc3300; }

        /* ── FOOTER ── */
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #f0f0f0;
            display: table;
            width: 100%;
        }

        .footer-left {
            display: table-cell;
            font-size: 10px;
            color: #aaa;
        }

        .footer-right {
            display: table-cell;
            text-align: right;
            font-size: 10px;
            color: #aaa;
        }

        .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <div class="brand">FloodCare</div>
            <div class="brand-sub">Sistem Informasi Banjir</div>
        </div>
        <div class="header-right">
            <div class="doc-title">Data User</div>
            <div class="doc-meta">
                Diekspor: {{ now()->locale('id')->isoFormat('dddd, D MMMM Y · HH:mm') }} WIB
            </div>
            <div class="doc-meta">Total: {{ $users->count() }} user</div>
        </div>
    </div>

    <!-- {{-- SUMMARY --}}
    @php
        $superadminCount = $users->where('role', 'superadmin')->count();
        $adminCount      = $users->where('role', 'admin')->count();
        $masyarakatCount = $users->where('role', 'masyarakat')->count();
        $diblokirCount   = $users->where('status', 'diblokir')->count();
    @endphp -->

    <!-- <table style="margin-bottom:16px; border:none;">
        <tr>
            <td style="width:25%; padding:10px 12px; border:1px solid #f0f0f0; border-radius:6px;">
                <span class="dot" style="background:#ff6600;"></span>
                <span style="font-size:16px; font-weight:700;">{{ $superadminCount }}</span><br>
                <span style="font-size:10px; color:#888;">Superadmin</span>
            </td>
            <td style="width:4px;"></td>
            <td style="width:25%; padding:10px 12px; border:1px solid #f0f0f0; border-radius:6px;">
                <span class="dot" style="background:#2a7de8;"></span>
                <span style="font-size:16px; font-weight:700;">{{ $adminCount }}</span><br>
                <span style="font-size:10px; color:#888;">Admin</span>
            </td>
            <td style="width:4px;"></td>
            <td style="width:25%; padding:10px 12px; border:1px solid #f0f0f0; border-radius:6px;">
                <span class="dot" style="background:#2abe8a;"></span>
                <span style="font-size:16px; font-weight:700;">{{ $masyarakatCount }}</span><br>
                <span style="font-size:10px; color:#888;">Masyarakat</span>
            </td>
            <td style="width:4px;"></td>
            <td style="width:25%; padding:10px 12px; border:1px solid #f0f0f0; border-radius:6px;">
                <span class="dot" style="background:#cc3300;"></span>
                <span style="font-size:16px; font-weight:700;">{{ $diblokirCount }}</span><br>
                <span style="font-size:10px; color:#888;">Diblokir</span>
            </td>
        </tr>
    </table> -->

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th style="width:28px; text-align:center;">#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Role</th>
                <th>Provider</th>
                <th>Status</th>
                <th>Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $user)
            <tr>
                <td class="td-no">{{ $i + 1 }}</td>
                <td class="td-nama">{{ $user->nama_lengkap }}</td>
                <td class="td-email">{{ $user->email }}</td>
                <td>{{ $user->no_telepon ?? '—' }}</td>
                <td>
                    <span class="badge badge-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>{{ ucfirst($user->provider ?? 'email') }}</td>
                <td>
                    <span class="badge badge-{{ $user->status ?? 'aktif' }}">
                        {{ ucfirst($user->status ?? 'Aktif') }}
                    </span>
                </td>
                <td style="color:#888;">
                    {{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="footer-left">
            FloodCare Admin · Dokumen ini digenerate otomatis oleh sistem
        </div>
        <div class="footer-right">
            <span class="page-number"></span>
        </div>
    </div>

</body>
</html>