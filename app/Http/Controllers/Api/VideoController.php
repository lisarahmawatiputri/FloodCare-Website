<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('status', 'dipublikasi')->latest()->get();

        $formattedData = $videos->map(function ($video) {
            // Konversi durasi_detik ke format MM:SS
            $menit  = floor($video->durasi_detik / 60);
            $detik  = $video->durasi_detik % 60;
            $durasi = sprintf('%02d:%02d', $menit, $detik);

            return [
                'id'          => $video->id,
                'title'       => $video->judul,
                'description' => $video->deskripsi ?? '',
                'duration'    => $durasi,
                'thumbnail'   => $video->thumbnail
                                    ? asset('storage/' . $video->thumbnail)
                                    : '',
                'video_url'   => $video->file_video
                                    ? asset('storage/' . $video->file_video)
                                    : '',
                'date'        => $video->created_at->translatedFormat('d M Y'),
            ];
        });

        return response()->json($formattedData, 200);
    }
}