<?php

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