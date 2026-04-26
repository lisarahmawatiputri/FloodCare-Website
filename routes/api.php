<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\ForgotPasswordOtpController;
use App\Http\Controllers\Api\DonationPaymentController;
use App\Http\Controllers\Api\ProgramDonasiController;

// PUBLIC (tidak perlu login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// PROTECTED (harus pakai token)
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/auth/google', [GoogleAuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordOtpController::class, 'sendOtp']);
Route::post('/reset-password', [ForgotPasswordOtpController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->post('/donations/pay', [DonationPaymentController::class, 'createPayment']);
Route::post('/midtrans/notification', [DonationPaymentController::class, 'notification']);
Route::get('/program-donasi', [ProgramDonasiController::class, 'index']);
