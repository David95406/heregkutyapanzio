<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::resource('/', IndexController::class)->only(['index']);

Route::resource('rolunk', AboutController::class)->only(['index']);

Route::resource('foglalas', BookingController::class)->only(['index']);

// admin
Route::middleware('guest:admin')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.store');
});

// Itt a sima 'auth' middleware-t használjuk, de megadjuk neki az 'admin' guard-ot.
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // ide jön a többi admin route
});