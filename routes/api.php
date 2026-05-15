<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\ForgotPasswordOtpController;
use App\Http\Controllers\Api\DonationPaymentController;
use App\Http\Controllers\Api\ProgramDonasiController;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\VideoController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {

        return response()->json([
            'success' => true,
            'user' => $request->user(),
        ]);

    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| GOOGLE LOGIN
|--------------------------------------------------------------------------
*/

Route::post('/auth/google', [GoogleAuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/

Route::post('/forgot-password', [ForgotPasswordOtpController::class, 'sendOtp']);

Route::post('/reset-password', [ForgotPasswordOtpController::class, 'resetPassword']);

/*
|--------------------------------------------------------------------------
| DONASI
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->post(
    '/donations/pay',
    [DonationPaymentController::class, 'createPayment']
);

Route::post(
    '/midtrans/notification',
    [DonationPaymentController::class, 'notification']
);

Route::post(
    '/donasi/{id}/simulate-success',
    [DonationPaymentController::class, 'simulateSuccess']
);

/*
|--------------------------------------------------------------------------
| PROGRAM DONASI
|--------------------------------------------------------------------------
*/

Route::get('/program-donasi', [ProgramDonasiController::class, 'index']);

/*
|--------------------------------------------------------------------------
| ARTIKEL
|--------------------------------------------------------------------------
*/

Route::get('/artikel', [ArtikelController::class, 'index']);

/*
|--------------------------------------------------------------------------
| VIDEO
|--------------------------------------------------------------------------
*/

Route::get('/video', [VideoController::class, 'index']);