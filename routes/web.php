<?php

use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\ProgramDonasiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;


/*
|--------------------------------------------------------------------------
| Landing Page Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('LandingPage.index');
})->name('home');

Route::get('/blog', function () {
    return view('LandingPage.blog');
})->name('blog');

Route::get('/blog-details', function () {
    return view('LandingPage.blog-details');
})->name('blog.details');

Route::get('/portfolio-details', function () {
    return view('LandingPage.portofolio-details');
})->name('portfolio');

Route::get('/service-details', function () {
    return view('LandingPage.service-details');
})->name('service');

Route::get('/starter-page', function () {
    return view('LandingPage.starter-page');
})->name('starter-page');

/*
|--------------------------------------------------------------------------
| Auth & Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');


    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');

    /*
    |--------------------------------------------------------------------------
    | DONASI
    |--------------------------------------------------------------------------
    */
    Route::get('/donasi', [DonasiController::class, 'index'])->name('donasi.index');
    Route::get('/donasi/create', [ProgramDonasiController::class, 'create'])->name('donasi.create');
    Route::get('/donasi-program', [DonasiController::class, 'program'])->name('donasi.program');
    Route::get('/donasi-transaksi', [DonasiController::class, 'transaksi'])->name('donasi.transaksi');
    Route::get('/donasi/{id}', [DonasiController::class, 'show'])->whereNumber('id')->name('donasi.show');
    Route::patch('/donasi/{id}/status/{status}', [DonasiController::class, 'updateStatus'])->whereNumber('id')->name('donasi.updateStatus');

    Route::post('/donasi/program', [ProgramDonasiController::class, 'store'])->name('donasi.store');
    Route::put('/donasi/program/{id}', [ProgramDonasiController::class, 'update'])->whereNumber('id')->name('donasi.update');
    Route::delete('/donasi/program/{id}', [ProgramDonasiController::class, 'destroy'])->whereNumber('id')->name('donasi.destroy');


// ARTIKEL 
Route::prefix('artikel')->name('artikel.')->group(function () {
    Route::get('/', [ArtikelController::class, 'index'])->name('index');
    Route::get('/create', [ArtikelController::class, 'create'])->name('create');
    Route::post('/', [ArtikelController::class, 'store'])->name('store');
    Route::get('/{artikel}/edit', [ArtikelController::class, 'edit'])->name('edit');
    Route::patch('/{artikel}', [ArtikelController::class, 'update'])->name('update');
    Route::delete('/{artikel}', [ArtikelController::class, 'destroy'])->name('destroy');
});
    
    /*
    |--------------------------------------------------------------------------
    | VIDEO
    |--------------------------------------------------------------------------
    */
    
    Route::prefix('video')->name('video.')->group(function () {
    Route::get('/', [VideoController::class, 'index'])->name('index');
    Route::get('/create', [VideoController::class, 'create'])->name('create');
    Route::post('/', [VideoController::class, 'store'])->name('store');
    Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('edit');
    Route::patch('/{video}', [VideoController::class, 'update'])->name('update');
    Route::delete('/{video}', [VideoController::class, 'destroy'])->name('destroy');
    Route::post('/video/{video}/view', [VideoController::class, 'addView']);

    });
    
// USERS
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::patch('/users/{id}/status', [UserController::class, 'updateStatus'])->name('users.status');
Route::patch('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.role');
Route::patch('/users/{id}/blokir', [UserController::class, 'blokir'])->name('users.blokir');

});

require __DIR__.'/auth.php';