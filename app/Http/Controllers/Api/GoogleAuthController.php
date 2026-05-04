<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        $client = new GoogleClient([
            'client_id' => env('GOOGLE_CLIENT_ID'),
        ]);

        $payload = $client->verifyIdToken($request->id_token);

        if (! $payload) {
            return response()->json([
                'message' => 'Token Google tidak valid',
            ], 401);
        }

        $email = $payload['email'] ?? null;

        if (! $email) {
            return response()->json([
                'message' => 'Email Google tidak ditemukan',
            ], 422);
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'nama_lengkap' => $payload['name'] ?? 'User Google',
                'foto_profil' => $payload['picture'] ?? null,
                'provider' => 'google',
                'status' => 'aktif',
                'role' => 'masyarakat',
                'password' => null,
            ]
        );

        $token = $user->createToken('google-mobile-token')->plainTextToken;

        return response()->json([
            'message' => 'Login Google berhasil',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
