<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'foto_laporan' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'alamat_lokasi' => 'nullable|string|max:255',
            'tinggi_banjir_cm' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('foto_laporan')) {
            $validated['foto_laporan'] = $request->file('foto_laporan')
                ->store('foto_laporan', 'public');
        }

        $validated['user_id'] = $request->user()->id;
        $validated['status_laporan'] = 'menunggu';
        $validated['jumlah_konfirmasi'] = 0;

        $laporan = Laporan::create($validated);

        return response()->json([
            'message' => 'Laporan banjir berhasil dikirim',
            'data' => $laporan,
        ], 201);
    }

    public function index()
{
    $laporans = Laporan::with('pelapor')
        ->where('status_laporan', 'valid')
        ->latest()
        ->limit(10)
        ->get()
        ->map(function ($laporan) {
            return [
                'id' => $laporan->id,
                'judul' => $laporan->judul,
                'deskripsi' => $laporan->deskripsi,
                'foto_url' => $laporan->foto_laporan
                    ? asset('storage/' . $laporan->foto_laporan)
                    : null,
                'latitude' => $laporan->latitude,
                'longitude' => $laporan->longitude,
                'alamat_lokasi' => $laporan->alamat_lokasi,
                'tinggi_banjir_cm' => $laporan->tinggi_banjir_cm,
                'tingkat_risiko' => $laporan->tingkat_risiko,
                'status_laporan' => $laporan->status_laporan,
                'created_at' => $laporan->created_at->format('d M Y H:i'),
            ];
        });

    return response()->json([
        'message' => 'Data laporan banjir valid berhasil diambil',
        'data' => $laporans,
    ]);
    
    }
    public function riwayat(Request $request)
{
    $laporans = Laporan::where('user_id', $request->user()->id)
        ->latest()
        ->get()
        ->map(function ($laporan) {
            return [
                'id' => $laporan->id,
                'judul' => $laporan->judul,
                'deskripsi' => $laporan->deskripsi,
                'foto_url' => $laporan->foto_laporan
                    ? asset('storage/' . $laporan->foto_laporan)
                    : null,
                'latitude' => $laporan->latitude,
                'longitude' => $laporan->longitude,
                'alamat_lokasi' => $laporan->alamat_lokasi,
                'tinggi_banjir_cm' => $laporan->tinggi_banjir_cm,
                'tingkat_risiko' => $laporan->tingkat_risiko,
                'status_laporan' => $laporan->status_laporan,
                'created_at' => $laporan->created_at->format('d M Y'),
            ];
        });

    return response()->json([
        'success' => true,
        'data' => $laporans,
    ]);
}
    public function show(Request $request, $id)
{
    $laporan = Laporan::with('pelapor')->find($id);

    if (!$laporan) {
        return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'id' => $laporan->id,
            'judul' => $laporan->judul,
            'deskripsi' => $laporan->deskripsi,
            'foto_url' => $laporan->foto_laporan
                ? asset('storage/' . $laporan->foto_laporan)
                : null,
            'latitude' => $laporan->latitude,
            'longitude' => $laporan->longitude,
            'alamat_lokasi' => $laporan->alamat_lokasi,
            'tinggi_banjir_cm' => $laporan->tinggi_banjir_cm,
            'tingkat_risiko' => $laporan->tingkat_risiko,
            'status_laporan' => $laporan->status_laporan,
            'jumlah_konfirmasi' => $laporan->jumlah_konfirmasi,
            'created_at' => $laporan->created_at->format('d M Y • H:i'),
            'pelapor' => $laporan->pelapor ? [
                'nama' => $laporan->pelapor->nama_lengkap,
                'foto' => $laporan->pelapor->foto_profil
                    ? asset('storage/' . $laporan->pelapor->foto_profil)
                    : null,
            ] : null,
        ],
    ]);
}
}
