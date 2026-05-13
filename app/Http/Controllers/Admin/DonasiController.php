<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\ProgramDonasi;
use Illuminate\Support\Facades\DB;

class DonasiController extends Controller
{
    public function index()
    {
        $program = ProgramDonasi::latest()->get();

        $donasi = Donasi::with(['user', 'program'])
            ->latest()
            ->paginate(10);

        $totalDonasi = Donasi::whereIn('status_pembayaran', ['sukses', 'success'])
            ->sum('nominal');

        $programAktif = ProgramDonasi::where('status', 'aktif')->count();

        $totalDonatur = Donasi::whereIn('status_pembayaran', ['sukses', 'success'])
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        return view('admin.donasi.index', compact(
            'program',
            'donasi',
            'totalDonasi',
            'programAktif',
            'totalDonatur'
        ));
    }

    public function show($id)
    {
        $donasi = Donasi::with(['user', 'program'])->findOrFail($id);

        return view('admin.donasi.show', compact('donasi'));
    }

    public function program()
    {
        $program = ProgramDonasi::latest()->get();

        return view('admin.donasi.program', compact('program'));
    }

    public function transaksi()
    {
        $donasi = Donasi::with(['user', 'program'])->latest()->paginate(10);

        return view('admin.donasi.transaksi', compact('donasi'));
    }

    public function updateStatus($id, $status)
    {
        $statusBaru = $this->normalizeStatus($status);

        return DB::transaction(function () use ($id, $statusBaru) {
            $donasi = Donasi::lockForUpdate()->findOrFail($id);
            $statusLama = $this->normalizeStatus($donasi->status_pembayaran);

            if ($statusLama === $statusBaru) {
                return back()->with('success', 'Status donasi tidak berubah.');
            }

            $donasi->status_pembayaran = $statusBaru;
            $donasi->paid_at = $statusBaru === 'sukses' ? ($donasi->paid_at ?? now()) : null;
            $donasi->save();

            $program = ProgramDonasi::lockForUpdate()->find($donasi->program_donasi_id);

            if ($program) {
                if ($statusLama !== 'sukses' && $statusBaru === 'sukses') {
                    $program->terkumpul = (float) $program->terkumpul + (float) $donasi->nominal;
                }

                if ($statusLama === 'sukses' && $statusBaru !== 'sukses') {
                    $program->terkumpul = max(0, (float) $program->terkumpul - (float) $donasi->nominal);
                }

                $program->status = ((float) $program->terkumpul >= (float) $program->target_dana)
                    ? 'selesai'
                    : 'aktif';

                $program->save();
            }

            return back()->with('success', 'Status donasi berhasil diupdate.');
        });
    }

    private function normalizeStatus(?string $status): string
    {
        return match ($status) {
            'success', 'sukses', 'settlement' => 'sukses',
            'pending', 'menunggu', 'challenge' => 'menunggu',
            'failed', 'failure', 'deny', 'expire', 'cancel', 'gagal' => 'gagal',
            default => 'menunggu',
        };
    }
}
