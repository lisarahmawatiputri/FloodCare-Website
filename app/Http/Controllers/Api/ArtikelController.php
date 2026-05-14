<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::where('status', 'dipublikasi')->latest()->get();

        $formattedData = $artikels->map(function ($artikel) {
            return [
                'id'          => $artikel->id,
                'category'    => 'ARTIKEL',
                'title'       => $artikel->judul,
                'description' => Str::limit(strip_tags($artikel->konten), 100),
                'date'        => $artikel->created_at->translatedFormat('d M Y'),
                'image'       => $artikel->thumbnail
                                    ? asset('storage/' . $artikel->thumbnail)
                                    : '',
                'url'         => $artikel->slug ?? '',
            ];
        });

        return response()->json($formattedData, 200);
    }
}
        // Ambil semua artikel yang statusnya 'dipublikasi', urutkan dari yang terbaru
        $artikels = Artikel::where('status', 'dipublikasi')->latest()->get();

        // Format datanya agar langsung cocok dengan UI Flutter kamu
        $formattedData = $artikels->map(function ($artikel) {
            return [
                'id'          => $artikel->id,
                'category'    => 'ARTIKEL', // Bisa diganti kalau ada field kategori di database
                'title'       => $artikel->judul,
                // Mengambil sedikit konten untuk deskripsi dan membuang tag HTML (seperti <p>, <b>)
                'description' => Str::limit(strip_tags($artikel->konten), 100),
                'readTime'    => '5 mnt baca', // Hardcode sementara, atau bisa dihitung dari panjang string
                'date'        => $artikel->created_at->translatedFormat('d M Y'),
                // Generate URL lengkap untuk gambar agar bisa dibaca Flutter
                'image'       => $artikel->thumbnail ? asset('storage/foto_thumbnail' . $artikel->thumbnail) : '',
            ];
        });

        // Kembalikan dalam format JSON dengan status code 200 (OK)
        return response()->json($formattedData, 200);