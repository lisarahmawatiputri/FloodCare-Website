<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('status', 'dipublikasi')
            ->latest()
            ->get();

        $formattedData = $videos->map(function ($video) {
            return $this->formatVideo($video);
        });

        return response()->json($formattedData, 200);
    }

    public function latest()
    {
        $video = Video::where('status', 'dipublikasi')
            ->latest()
            ->first();

        if (!$video) {
            return response()->json(null, 200);
        }

        return response()->json($this->formatVideo($video), 200);
    }

    private function formatVideo($video)
    {
        $durasiDetik = (int) ($video->durasi_detik ?? 0);

        $menit = floor($durasiDetik / 60);
        $detik = $durasiDetik % 60;
        $durasi = sprintf('%02d:%02d', $menit, $detik);

        return [
            'id'          => $video->id,
            'category'    => 'VIDEO',
            'title'       => $video->judul,
            'description' => $video->deskripsi ?? '',
            'duration'    => $durasi,
            'thumbnail'   => $video->thumbnail
                ? asset('storage/' . ltrim($video->thumbnail, '/'))
                : '',
            'video_url'   => $video->file_video
                ? asset('storage/' . ltrim($video->file_video, '/'))
                : '',
            'date'        => $video->created_at->translatedFormat('d M Y'),
        ];
    }
}
