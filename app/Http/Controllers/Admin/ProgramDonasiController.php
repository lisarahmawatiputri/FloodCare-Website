<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgramDonasiController extends Controller
{
    public function create()
    {
        return view('admin.donasi.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'target_dana' => 'required|numeric|min:10000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('program', 'public');
        }

        $data['status'] = 'aktif';
        $data['terkumpul'] = 0;
        $data['dibuat_oleh'] = Auth::id();

        ProgramDonasi::create($data);

        return redirect()->route('admin.donasi.index')
            ->with('success', 'Program donasi berhasil ditambahkan.');
    }

    public function index()
    {
        $program = ProgramDonasi::where('status', 'aktif')
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_program' => $item->nama_program,
                    'deskripsi' => $item->deskripsi,
                    'target_dana' => $item->target_dana,
                    'terkumpul' => $item->terkumpul,
                    'status' => $item->status,
                    'foto' => $item->foto
                        ? asset('storage/' . $item->foto)
                        : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $program,
        ]);
    }

    public function edit($id)
    {
        $program = ProgramDonasi::findOrFail($id);

        return view('admin.donasi.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $program = ProgramDonasi::findOrFail($id);

        $data = $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'target_dana' => 'required|numeric|min:10000',
            'status' => 'nullable|in:aktif,selesai,nonaktif',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('foto')) {

            if ($program->foto && Storage::disk('public')->exists($program->foto)) {
                Storage::disk('public')->delete($program->foto);
            }

            $data['foto'] = $request->file('foto')->store('program', 'public');
        }

        $program->update($data);

        return redirect()->route('admin.donasi.program')
            ->with('success', 'Program donasi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $program = ProgramDonasi::findOrFail($id);

        if ($program->foto && Storage::disk('public')->exists($program->foto)) {
            Storage::disk('public')->delete($program->foto);
        }

        $program->delete();

        return back()->with('success', 'Program donasi berhasil dihapus.');
    }
}