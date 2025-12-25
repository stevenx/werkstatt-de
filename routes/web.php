<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Locations
Route::get('/werkstatten', [LocationController::class, 'index'])->name('locations.index');
Route::get('/werkstatten/{slug}', [LocationController::class, 'show'])->name('locations.show');

// Blog
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('posts.show');
