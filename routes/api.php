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
use App\Http\Controllers\Api\LaporanController;


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
Route::middleware('auth:sanctum')->post('/profile/photo', [AuthController::class, 'updateProfilePhoto']);
Route::middleware('auth:sanctum')->put('/profile/update', [AuthController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->post('/fcm-token', [AuthController::class, 'updateFcmToken']);
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
Route::post('/verify-otp', [ForgotPasswordOtpController::class, 'verifyOtp']);
Route::post('/reset-password', [ForgotPasswordOtpController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->post('/verify-password', [AuthController::class, 'verifyPassword']);
Route::middleware('auth:sanctum')->post('/change-password', [AuthController::class, 'changePassword']);
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
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/donations/history', [DonationPaymentController::class, 'history']);
});
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
Route::get('/artikel-terbaru', [ArtikelController::class, 'latest']);

/*
|--------------------------------------------------------------------------
| VIDEO
|--------------------------------------------------------------------------
*/

Route::get('/video', [VideoController::class, 'index']);
Route::get('/video-terbaru', [VideoController::class, 'latest']);

/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/laporan-banjir', [LaporanController::class, 'index']);
Route::middleware('auth:sanctum')->post('/laporan-banjir', [LaporanController::class, 'store']);
Route::middleware('auth:sanctum')->get('/laporan-banjir/{id}', [LaporanController::class, 'show']);

/*
|--------------------------------------------------------------------------
| RIWAYAT LAPORAN
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/riwayat-laporan', [LaporanController::class, 'riwayat']);
