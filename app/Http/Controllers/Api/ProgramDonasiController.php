<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProgramDonasiController extends Controller
{
    public function index()
    {
        $programs = DB::table('program_donasi')
            ->where('status', 'aktif')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->nama_program,
                    'description' => $item->deskripsi,
                    'image' => $item->foto,
                    'is_emergency' => true, // sementara semua darurat dulu
                    'collected_amount' => (int) $item->terkumpul,
                    'target_amount' => (int) $item->target_dana,
                    'location' => 'Jember, Jawa Timur',
                    'category' => 'Logistik',
                ];
            });

        return response()->json([
            'data' => $programs,
        ]);
    }
}
