<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $query = Artikel::latest();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $artikels = $query->paginate(10)->withQueryString();

        return view('admin.artikel.index', compact('artikels'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'slug'      => 'nullable|string|max:500',
            'konten'    => 'required|string',
            'penulis'   => 'nullable|string|max:100',
            'status'    => 'required|in:draft,dipublikasi,diarsip',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = $request->slug ?: Str::slug($request->judul);
        $originalSlug = $slug;
        $count = 1;
        while (Artikel::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('artikel', 'public');
        }

        Artikel::create([
            'judul'       => $request->judul,
            'slug'        => $slug,
            'konten'      => $request->konten,
            'thumbnail'   => $thumbnailPath,
            'penulis'     => $request->penulis,
            'uploaded_by' => Auth::id(),
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil disimpan.');
    }

    public function edit(Artikel $artikel)
    {
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'slug'      => 'nullable|string|max:500',
            'konten'    => 'required|string',
            'penulis'   => 'nullable|string|max:100',
            'status'    => 'required|in:draft,dipublikasi,diarsip',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = $artikel->slug;
        if ($request->slug && $request->slug !== $artikel->slug) {
            $newSlug = $request->slug;
            $count = 1;
            while (Artikel::where('slug', $newSlug)->where('id', '!=', $artikel->id)->exists()) {
                $newSlug = $request->slug . '-' . $count++;
            }
            $slug = $newSlug;
        }

        $thumbnailPath = $artikel->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($artikel->thumbnail) {
                Storage::disk('public')->delete($artikel->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('artikel', 'public');
        }

        $artikel->update([
            'judul'     => $request->judul,
            'slug'      => $slug,
            'konten'    => $request->konten,
            'thumbnail' => $thumbnailPath,
            'penulis'   => $request->penulis,
            'status'    => $request->status,
        ]);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel)
    {
        if ($artikel->thumbnail) {
            Storage::disk('public')->delete($artikel->thumbnail);
        }
        $artikel->delete();

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}