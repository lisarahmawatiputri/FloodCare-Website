<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::where('status', 'dipublikasi')
            ->latest()
            ->get();

        $formattedData = $artikels->map(function ($artikel) {
            return $this->formatArtikel($artikel);
        });

        return response()->json($formattedData, 200);
    }

    public function latest()
    {
        $artikels = Artikel::where('status', 'dipublikasi')
            ->latest()
            ->limit(2)
            ->get();

        $formattedData = $artikels->map(function ($artikel) {
            return $this->formatArtikel($artikel);
        });

        return response()->json($formattedData, 200);
    }

    private function formatArtikel($artikel)
    {
        return [
            'id'          => $artikel->id,
            'category'    => 'ARTIKEL',
            'title'       => $artikel->judul,
            'description' => Str::limit(strip_tags($artikel->konten), 100),
            'readTime'    => '5 mnt baca',
            'date'        => $artikel->created_at->translatedFormat('d M Y'),
            'image'       => $this->getThumbnailUrl($artikel->thumbnail),
            'url'         => $artikel->slug ?? '',
        ];
    }

    private function getThumbnailUrl($thumbnail)
    {
        if (!$thumbnail) {
            return '';
        }

        if (Str::startsWith($thumbnail, ['http://', 'https://'])) {
            return $thumbnail;
        }

        $cleanPath = ltrim($thumbnail, '/');

        if (Str::startsWith($cleanPath, 'storage/')) {
            return asset($cleanPath);
        }

        return asset('storage/' . $cleanPath);
    }
}
