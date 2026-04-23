<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


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

// Auth & Dashboard Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Laporan
    Route::get('/laporan', function () {
        return view('admin.laporan.index');
    })->name('laporan.index');
    Route::get('/laporan/{id}', function ($id) {
        return view('admin.laporan.show');
    })->name('laporan.show');

    // Donasi
    Route::get('/donasi', function () {
        return view('admin.donasi.index');
    })->name('donasi.index');
    Route::get('/donasi/{id}', function ($id) {
        return view('admin.donasi.show');
    })->name('donasi.show');

    // Artikel
    Route::get('/artikel', function () {
        return view('admin.artikel.index');
    })->name('artikel.index');
    Route::get('/artikel/create', function () {
        return view('admin.artikel.create');
    })->name('artikel.create');
    Route::get('/artikel/{id}/edit', function ($id) {
        return view('admin.artikel.edit');
    })->name('artikel.edit');

    // Video
    Route::get('/video', function () {
        return view('admin.video.index');
    })->name('video.index');
    Route::get('/video/create', function () {
        return view('admin.video.create');
    })->name('video.create');

    // Users
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
    Route::get('/users/{id}', function ($id) {
        return view('admin.users.show');
    })->name('users.show');
});

require __DIR__.'/auth.php';