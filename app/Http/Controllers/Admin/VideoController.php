<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::with('uploader');

        if ($request->search) {
            $query->where('judul', 'like', '%'.$request->search.'%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $videos     = $query->latest()->get();
        $totalVideo = $videos->count();

        return view('admin.video.index', compact('videos', 'totalVideo'));
    }

    public function create()
    {
        return view('admin.video.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:50',
            'deskripsi'    => 'nullable|string',
            'file_video'   => 'required|file|mimes:mp4,mov,avi|max:512000',
            'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'durasi_detik' => 'nullable|integer|min:0',
            'status'       => 'required|in:draft,dipublikasi,diarsip',
        ]);

        $videoPath = $request->file('file_video')->store('video_edukasi', 'public');

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('video_thumbnail', 'public');
        }

        Video::create([
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'file_video'   => $videoPath,
            'thumbnail'    => $thumbnailPath,
            'uploaded_by'  => Auth::id(),
            'durasi_detik' => $request->durasi_detik ?? 0,
            'status'       => $request->status,
            'dilihat'      => 0,
        ]);

        return redirect()->route('admin.video.index')
            ->with('success', 'Video berhasil ditambahkan!');
    }

    public function edit(Video $video)
    {
        return view('admin.video.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'judul'        => 'required|string|max:50',
            'deskripsi'    => 'nullable|string',
            'file_video'   => 'nullable|file|mimes:mp4,mov,avi|max:512000',
            'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'durasi_detik' => 'nullable|integer|min:0',
            'status'       => 'required|in:draft,dipublikasi,diarsip',
        ]);

        $videoPath = $video->file_video;
        if ($request->hasFile('file_video')) {
            if ($video->file_video) Storage::disk('public')->delete($video->file_video);
            $videoPath = $request->file('file_video')->store('video_edukasi', 'public');
        }

        $thumbnailPath = $video->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) Storage::disk('public')->delete($video->thumbnail);
            $thumbnailPath = $request->file('thumbnail')->store('video_thumbnail', 'public');
        }

        $video->update([
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'file_video'   => $videoPath,
            'thumbnail'    => $thumbnailPath,
            'durasi_detik' => $request->durasi_detik ?? $video->durasi_detik,
            'status'       => $request->status,
        ]);

        return redirect()->route('admin.video.index')
            ->with('success', 'Video berhasil diperbarui!');
    }

    public function destroy(Video $video)
    {
        if ($video->file_video) Storage::disk('public')->delete($video->file_video);
        if ($video->thumbnail) Storage::disk('public')->delete($video->thumbnail);
        $video->delete();

        return redirect()->route('admin.video.index')
            ->with('success', 'Video berhasil dihapus!');
    }

    public function addView(Video $video)
{
    $video->increment('dilihat');

    return response()->json([
        'total_views' => $video->dilihat
    ]);
}
}