<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get();
        return view('admin.video.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.video.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_video' => 'required|file|mimes:mp4,mov,avi,mkv|max:512000', // 500MB
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'durasi_detik' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,published',
        ]);

        // Handle video file
        if ($request->hasFile('file_video')) {
            $validated['file_video'] = $request->file('file_video')->store('videos', 'public');
        }

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Video::create($validated);

        return redirect()->route('admin.video.index')->with('success', 'Video berhasil ditambahkan');
    }

    public function edit(Video $video)
    {
        return view('admin.video.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_video' => 'nullable|file|mimes:mp4,mov,avi,mkv|max:512000',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'durasi_detik' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,published',
        ]);

        // Handle video file
        if ($request->hasFile('file_video')) {
            // Delete old video if exists
            if ($video->file_video) {
                Storage::disk('public')->delete($video->file_video);
            }
            $validated['file_video'] = $request->file('file_video')->store('videos', 'public');
        }

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $video->update($validated);

        return redirect()->route('admin.video.index')->with('success', 'Video berhasil diperbarui');
    }

    public function destroy(Video $video)
    {
        // Delete video file
        if ($video->file_video) {
            Storage::disk('public')->delete($video->file_video);
        }

        // Delete thumbnail
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        return redirect()->route('admin.video.index')->with('success', 'Video berhasil dihapus');
    }
}
