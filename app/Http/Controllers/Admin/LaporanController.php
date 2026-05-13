<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with('pelapor');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%'.$request->search.'%')
                  ->orWhere('alamat_lokasi', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->status)  $query->where('status_laporan', $request->status);
        if ($request->risiko)  $query->where('tingkat_risiko', $request->risiko);

        $laporans       = $query->latest()->paginate(10);
        $countMenunggu  = Laporan::where('status_laporan', 'menunggu')->count();
        $countValid     = Laporan::where('status_laporan', 'valid')->count();
        $countTidakValid = Laporan::where('status_laporan', 'tidak_valid')->count();
        $totalLaporan   = Laporan::count();

        return view('admin.laporan.index', compact(
            'laporans', 'countMenunggu', 'countValid', 'countTidakValid', 'totalLaporan'
        ));
    }

    public function show($id)
    {
        $laporan     = Laporan::with(['pelapor', 'validator', 'konfirmasi.user'])->findOrFail($id);
        $konfirmasis = $laporan->konfirmasi()->with('user')->latest('created_at')->get();

        return view('admin.laporan.show', compact('laporan', 'konfirmasis'));
    }

    public function validasi(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'status_laporan' => 'required|in:menunggu,valid,tidak_valid,diterima',
            'tingkat_risiko' => 'required|in:rendah,sedang,tinggi',
            'catatan_admin'  => 'nullable|string',
        ]);

        $laporan->update([
            'status_laporan'  => $request->status_laporan,
            'tingkat_risiko'  => $request->tingkat_risiko,
            'catatan_admin'   => $request->catatan_admin,
            'divalidasi_oleh' => Auth::id(),
        ]);

        return back()->with('success', 'Laporan berhasil divalidasi!');
    }

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}