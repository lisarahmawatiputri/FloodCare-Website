<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->get();
        return view('admin.artikel.index', compact('artikels'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        return view('admin.artikel.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'url_link' => 'required|url|max:255',
            'konten' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'user_id' => 'nullable|exists:users,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('artikel', 'public');
        }

        $validated['user_id'] = $validated['user_id'] ?? Auth::id();
        $validated['views'] = 0;

        Artikel::create($validated);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        $users = \App\Models\User::all();
        return view('admin.artikel.edit', compact('artikel', 'users'));
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'url_link' => 'required|url|max:255',
            'konten' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'user_id' => 'nullable|exists:users,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($artikel->thumbnail) {
                Storage::disk('public')->delete($artikel->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('artikel', 'public');
        }

        $validated['user_id'] = $validated['user_id'] ?? $artikel->user_id ?? Auth::id();

        $artikel->update($validated);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        if ($artikel->thumbnail) {
            Storage::disk('public')->delete($artikel->thumbnail);
        }

        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
