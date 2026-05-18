<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'password' => ['required','string','min:8','regex:/[a-z]/','regex:/[A-Z]/','regex:/[@$!%*#?&]/','confirmed',],
        ]);

        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'],
            'password' => $validated['password'],
            'role' => 'masyarakat',
            'provider' => 'email',
            'status' => 'aktif',
            'foto_profil' => null,
            // 'alasan_blokir' => null,
        ]);

        $token = $user->createToken('flutter-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register berhasil',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function verifyPassword(Request $request)
    {
        $user = $request->user();

        if (
            in_array(strtolower($user->provider ?? ''), ['google', 'gmail', 'google.com']) ||
            !empty($user->google_id)
        ) {
            return response()->json([
                'message' => 'Akun Google tidak dapat mengganti password dari aplikasi.',
            ], 403);
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password lama tidak sesuai.'],
            ]);
        }

        return response()->json([
            'message' => 'Password lama valid.',
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();

        if (
            in_array(strtolower($user->provider ?? ''), ['google', 'gmail', 'google.com']) ||
            !empty($user->google_id)
        ) {
            return response()->json([
                'message' => 'Akun Google tidak dapat mengganti password dari aplikasi.',
            ], 403);
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required','string','min:8','regex:/[a-z]/','regex:/[A-Z]/','regex:/[@$!%*#?&]/','confirmed',],
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password lama tidak sesuai.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Password berhasil diperbarui.',
        ]);
    }

    public function updateProfilePhoto(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'foto_profil' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        if (
            $user->foto_profil &&
            !Str::startsWith($user->foto_profil, ['http://', 'https://']) &&
            Storage::disk('public')->exists($user->foto_profil)
        ) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $path = $request->file('foto_profil')->store('foto_profil', 'public');

        $user->update([
            'foto_profil' => $path,
        ]);

        return response()->json([
            'message' => 'Foto profil berhasil diperbarui.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name ?? $user->nama_lengkap,
                'nama_lengkap' => $user->nama_lengkap ?? $user->name,
                'email' => $user->email,
                'foto_profil' => $path,
                'foto_profil_url' => asset('storage/' . $path),
                'provider' => $user->provider,
                'google_id' => $user->google_id ?? null,
            ],
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        if ($user->status !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak aktif',
            ], 403);
        }

        $token = $user->createToken('flutter-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user,
        ]);
    }
  public function updateFcmToken(Request $request)
{
    $request->validate([
        'fcm_token' => 'required|string',
    ]);

    $request->user()->update([
        'fcm_token' => $request->fcm_token,
    ]);

    return response()->json([
        'message' => 'FCM token berhasil disimpan',
    ]);
}

    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }}
