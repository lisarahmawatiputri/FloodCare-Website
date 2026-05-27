<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Laporan;
use App\Models\KonfirmasiLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();
        $query = User::query();

        if ($authUser->role === 'admin') {
            $query->where('role', 'masyarakat');
        }

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

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\']+$/'],
            'email'        => ['required', 'min:6', 'unique:users,email', 'regex:/^[^@]+@[^@]+\.com$/'],
            'no_telepon'   => ['required', 'digits_between:12,13'],
            'password'     => ['required', 'confirmed', Password::min(8)],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.regex'    => "Nama hanya boleh huruf, spasi, titik (.), dan tanda petik (').",
            'email.required'            => 'Email wajib diisi.',
            'email.min'                 => 'Email minimal 6 karakter.',
            'email.unique'              => 'Email sudah terdaftar.',
            'email.regex'               => 'Email harus menggunakan domain .com.',
            'no_telepon.required'       => 'Nomor telepon wajib diisi.',
            'no_telepon.digits_between' => 'Nomor telepon harus 12-13 angka.',
            'password.required'         => 'Password wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'no_telepon'   => $request->no_telepon,
            'password'     => Hash::make($request->password),
            'role'         => 'admin',
            'provider'     => 'email',
            'status'       => 'aktif',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun admin berhasil dibuat!');
    }

    public function show($id)
    {
        $authUser = auth()->user();
        $user = User::findOrFail($id);

        if ($authUser->role === 'admin' && in_array($user->role, ['superadmin', 'admin'])) {
            abort(403, 'Tidak diizinkan.');
        }

        if ($user->role === 'masyarakat') {
            $laporanUser     = $user->laporan()->latest()->get();
            $konfirmasiUser  = collect([]);
            $totalLaporan    = $laporanUser->count();
            $totalKonfirmasi = 0;

        } elseif ($user->role === 'admin') {
            $laporanUser     = Laporan::where('divalidasi_oleh', $user->id)->latest()->get();
            $konfirmasiUser  = $user->konfirmasi()->with('laporan')->latest()->get();
            $totalLaporan    = $laporanUser->count();
            $totalKonfirmasi = $konfirmasiUser->count();

        } else {
            $laporanUser     = Laporan::where('divalidasi_oleh', $user->id)->latest()->get();
            $konfirmasiUser  = $user->konfirmasi()->with('laporan')->latest()->get();
            $totalLaporan    = $laporanUser->count();
            $totalKonfirmasi = $konfirmasiUser->count();
        }

        return view('admin.users.show', compact(
            'user', 'laporanUser', 'konfirmasiUser', 'totalLaporan', 'totalKonfirmasi'
        ));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.\']+$/'],
            'email'        => ['required', 'min:6', 'unique:users,email,'.$user->id, 'regex:/^[^@]+@[^@]+\.com$/'],
            'no_telepon'   => ['required', 'digits_between:12,13'],
            'password'     => ['nullable', 'string', Password::min(8)],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.regex'    => "Nama hanya boleh huruf, spasi, titik (.), dan tanda petik (').",
            'email.required'            => 'Email wajib diisi.',
            'email.min'                 => 'Email minimal 6 karakter.',
            'email.unique'              => 'Email sudah digunakan akun lain.',
            'email.regex'               => 'Email harus menggunakan domain .com.',
            'no_telepon.required'       => 'Nomor telepon wajib diisi.',
            'no_telepon.digits_between' => 'Nomor telepon harus 12-13 angka.',
            'password.min'              => 'Password minimal 8 karakter.',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email        = $request->email;
        $user->no_telepon   = $request->no_telepon;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'Profil user berhasil diperbarui!');
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

    public function export(Request $request)
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

        $users = $query->orderBy('nama_lengkap')->get();

        $pdf = Pdf::loadView('admin.users.pdf', compact('users'))
                   ->setPaper('a4', 'landscape');

        return $pdf->download('data-user-floodcare.pdf');
    }
}