<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    private function applyFilters($query, Request $request)
    {
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%'.$request->search.'%')
                  ->orWhere('alamat_lokasi', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->status)      $query->where('status_laporan', $request->status);
        if ($request->risiko)      $query->where('tingkat_risiko', $request->risiko);
        if ($request->tanggal_dari) $query->whereDate('created_at', '>=', $request->tanggal_dari);
        if ($request->tanggal_sampai) $query->whereDate('created_at', '<=', $request->tanggal_sampai);

        return $query;
    }

    public function index(Request $request)
    {
        $query = Laporan::with('pelapor');
        $this->applyFilters($query, $request);

        $laporans        = $query->latest()->paginate(10)->withQueryString();
        $countMenunggu   = Laporan::where('status_laporan', 'menunggu')->count();
        $countValid      = Laporan::where('status_laporan', 'valid')->count();
        $countTidakValid = Laporan::where('status_laporan', 'tidak_valid')->count();
        $totalLaporan    = $query->toBase()->getCountForPagination();

        return view('admin.laporan.index', compact(
            'laporans', 'countMenunggu', 'countValid', 'countTidakValid', 'totalLaporan'
        ));
    }

    public function exportPdf(Request $request)
    {
        $query = Laporan::with('pelapor');
        $this->applyFilters($query, $request);

        $laporans        = $query->latest()->get();
        $countMenunggu   = Laporan::where('status_laporan', 'menunggu')->count();
        $countValid      = Laporan::where('status_laporan', 'valid')->count();
        $countTidakValid = Laporan::where('status_laporan', 'tidak_valid')->count();
        $exportedAt      = now()->format('d M Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.export-pdf', compact(
            'laporans', 'countMenunggu', 'countValid', 'countTidakValid', 'exportedAt'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-banjir-' . now()->format('Ymd-His') . '.pdf');
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
            'catatan_admin'  => 'nullable|string',
        ]);

        // tingkat_risiko tidak perlu diisi manual, otomatis dari model
        $laporan->update([
            'status_laporan'  => $request->status_laporan,
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