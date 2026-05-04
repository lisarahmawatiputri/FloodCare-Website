<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->role)     $query->where('role', $request->role);
        if ($request->status)   $query->where('status', $request->status);
        if ($request->provider) $query->where('provider', $request->provider);

        $users           = $query->latest()->paginate(10);
        $countSuperadmin = User::where('role', 'superadmin')->count();
        $countAdmin      = User::where('role', 'admin')->count();
        $countMasyarakat = User::where('role', 'masyarakat')->count();
        $countDiblokir   = User::where('status', 'diblokir')->count();

        return view('admin.users.index', compact(
            'users', 'countSuperadmin', 'countAdmin', 'countMasyarakat', 'countDiblokir'
        ));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $laporanUser     = $user->laporan()->latest()->get();
        // $konfirmasiUser  = $user->konfirmasi()->latest()->get();
        $totalLaporan    = $laporanUser->count();
        // $totalKonfirmasi = $konfirmasiUser->count();

        return view('admin.users.show', compact(
            'user', 'laporanUser',  'totalLaporan', 
        ));
    }

    public function updateStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->save();
        return back()->with('success', 'Status user berhasil diubah!');
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
        return back()->with('success', 'Role user berhasil diubah!');
    }

    public function blokir($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'diblokir';
        $user->save();
        return back()->with('success', 'User berhasil diblokir!');
    }
}