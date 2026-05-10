<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
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