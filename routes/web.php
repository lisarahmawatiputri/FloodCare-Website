<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page Routes
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

require __DIR__.'/auth.php';