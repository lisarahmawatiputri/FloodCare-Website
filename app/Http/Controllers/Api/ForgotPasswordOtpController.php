<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
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

        $otp = random_int(1000, 9999);

        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => Hash::make((string) $otp),
                'expires_at' => now()->addMinutes(5),
                'used' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new PasswordResetOtpMail($otp));

        return response()->json([
            'message' => 'Kode OTP berhasil dikirim ke email.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:4',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->where('used', false)
            ->first();

        if (! $record) {
            return response()->json([
                'message' => 'OTP tidak valid.',
            ], 422);
        }

        if (now()->greaterThan($record->expires_at)) {
            return response()->json([
                'message' => 'OTP sudah expired.',
            ], 422);
        }

        if (! Hash::check($request->otp, $record->otp)) {
            return response()->json([
                'message' => 'Kode OTP salah.',
            ], 422);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->update([
                'used' => true,
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Password berhasil diubah.',
        ]);
    }
}
