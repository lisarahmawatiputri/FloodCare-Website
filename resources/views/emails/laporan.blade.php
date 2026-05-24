<x-mail::message>

# Laporan Banjir Baru Masuk

Ada laporan banjir baru yang perlu ditinjau.

@php
  $tinggi = $laporan->tinggi_banjir_cm;
  $rangeValues = [20, 55, 115, 160];

  if (in_array($tinggi, $rangeValues)) {
    $label = match((int) $tinggi) {
      20  => '< 30 cm',
      55  => '30 – 80 cm',
      115 => '80 – 150 cm',
      160 => '> 150 cm',
      default => $tinggi . ' cm',
    };
  } else {
    $label = $tinggi . ' cm';
  }
@endphp

| | |
|---|---|
| **Judul** | {{ $laporan->judul }} |
| **Pelapor** | {{ $laporan->pelapor->nama_lengkap ?? '-' }} |
| **Alamat** | {{ $laporan->alamat_lokasi }} |
| **Tinggi Air** | {{ $label }} |
| **Risiko** | {{ ucfirst(str_replace('_', ' ', $laporan->tingkat_risiko)) }} |

@if($laporan->foto_laporan)
<img src="{{ $message->embed(Storage::disk('public')->path($laporan->foto_laporan)) }}"
     alt="Foto Laporan"
     style="width:100%; max-width:400px; border-radius:8px; margin:12px 0;">
@endif

<x-mail::button :url="route('admin.laporan.show', $laporan->id)" color="primary">
Lihat Laporan
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}

</x-mail::message>