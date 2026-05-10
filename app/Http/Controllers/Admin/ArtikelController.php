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

        // Logic Slug
        $slug = $request->slug ?: Str::slug($request->judul);
        $originalSlug = $slug;
        $count = 1;
        while (Artikel::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // --- PERBAIKAN LOGIC UPLOAD ---
        $thumbnailName = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            // Buat nama file unik (misal: 1715123456.jpg)
            $thumbnailName = time() . '.' . $file->getClientOriginalExtension();
            // Simpan file ke folder fisik: storage/app/public/foto_thumbnail
            $file->storeAs('foto_thumbnail', $thumbnailName, 'public');
        }

        Artikel::create([
            'judul'       => $request->judul,
            'slug'        => $slug,
            'konten'      => $request->konten,
            'thumbnail'   => $thumbnailName, // Hanya simpan nama file
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

        // Logic Slug Update
        $slug = $artikel->slug;
        if ($request->slug && $request->slug !== $artikel->slug) {
            $newSlug = $request->slug;
            $count = 1;
            while (Artikel::where('slug', $newSlug)->where('id', '!=', $artikel->id)->exists()) {
                $newSlug = $request->slug . '-' . $count++;
            }
            $slug = $newSlug;
        }

        // --- PERBAIKAN LOGIC UPLOAD UPDATE ---
        $thumbnailName = $artikel->thumbnail;
        if ($request->hasFile('thumbnail')) {
            // Hapus foto lama jika ada
            if ($artikel->thumbnail) {
                Storage::disk('public')->delete('foto_thumbnail/' . $artikel->thumbnail);
            }

            $file = $request->file('thumbnail');
            $thumbnailName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto_thumbnail', $thumbnailName, 'public');
        }

        $artikel->update([
            'judul'     => $request->judul,
            'slug'      => $slug,
            'konten'    => $request->konten,
            'thumbnail' => $thumbnailName,
            'penulis'   => $request->penulis,
            'status'    => $request->status,
        ]);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Artikel $artikel)
    {
        if ($artikel->thumbnail) {
            // Hapus file fisik dari folder foto_thumbnail
            Storage::disk('public')->delete('foto_thumbnail/' . $artikel->thumbnail);
        }
        $artikel->delete();

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
