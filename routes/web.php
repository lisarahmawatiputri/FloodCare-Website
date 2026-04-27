<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LaporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;


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
    Route::get('/donasi', function () {
        return view('admin.donasi.index');
    })->name('donasi.index');

    Route::get('/donasi/{id}', function ($id) {
        return view('admin.donasi.show');
    })->name('donasi.show');

    /*
    |--------------------------------------------------------------------------
    | ARTIKEL
    |--------------------------------------------------------------------------
    */
    Route::get('/artikel', function () {
        return view('admin.artikel.index');
    })->name('artikel.index');

    Route::get('/artikel/create', function () {
        return view('admin.artikel.create');
    })->name('artikel.create');

    Route::get('/artikel/{id}/edit', function ($id) {
        return view('admin.artikel.edit');
    })->name('artikel.edit');

    /*
    |--------------------------------------------------------------------------
    | VIDEO
    |--------------------------------------------------------------------------
    */
    
    Route::get('/video', function () {
        return view('admin.video.index');
    })->name('video.index');

    Route::get('/video/create', function () {
        return view('admin.video.create');
    })->name('video.create');

    
// USERS
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::patch('/users/{id}/status', [UserController::class, 'updateStatus'])->name('users.status');
Route::patch('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.role');
Route::patch('/users/{id}/blokir', [UserController::class, 'blokir'])->name('users.blokir');

});

require __DIR__.'/auth.php';