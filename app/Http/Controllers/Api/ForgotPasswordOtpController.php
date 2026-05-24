<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordOtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = trim($request->email);
        $otp = random_int(1000, 9999);

        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $email],
            [
                'otp' => Hash::make((string) $otp),
                'expires_at' => now()->addMinutes(5),
                'used' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Cache::forget('password_reset_verified_' . $email);

        Mail::to($email)->send(new PasswordResetOtpMail($otp));

        return response()->json([
            'message' => 'Kode OTP berhasil dikirim ke email.',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:4',
        ]);

        $email = trim($request->email);

        $record = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('used', false)
            ->first();

        if (! $record) {
            return response()->json([
                'message' => 'OTP tidak valid.',
            ], 422);
        }

        if (now()->greaterThan(Carbon::parse($record->expires_at))) {
            return response()->json([
                'message' => 'OTP sudah expired.',
            ], 422);
        }

        if (! Hash::check((string) $request->otp, $record->otp)) {
            return response()->json([
                'message' => 'Kode OTP salah.',
            ], 422);
        }

        Cache::put(
            'password_reset_verified_' . $email,
            true,
            now()->addMinutes(10)
        );

        return response()->json([
            'message' => 'OTP berhasil diverifikasi.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[@$!%*#?&]/',
                'confirmed',
            ],
        ]);

        $email = trim($request->email);

        if (! Cache::get('password_reset_verified_' . $email)) {
            return response()->json([
                'message' => 'Sesi verifikasi OTP sudah habis. Silakan verifikasi ulang.',
            ], 422);
        }

        $record = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('used', false)
            ->first();

        if (! $record) {
            Cache::forget('password_reset_verified_' . $email);

            return response()->json([
                'message' => 'OTP tidak valid.',
            ], 422);
        }

        if (now()->greaterThan(Carbon::parse($record->expires_at))) {
            Cache::forget('password_reset_verified_' . $email);

            return response()->json([
                'message' => 'OTP sudah expired.',
            ], 422);
        }

        User::where('email', $email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_otps')
            ->where('email', $email)
            ->update([
                'used' => true,
                'updated_at' => now(),
            ]);

        Cache::forget('password_reset_verified_' . $email);

        return response()->json([
            'message' => 'Password berhasil diubah.',
        ]);
    }
}
