<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::resource('/', IndexController::class)->only(['index']);

Route::resource('rolunk', AboutController::class)->only(['index']);

Route::resource('foglalas', BookingController::class)->only(['index', 'store']);

Route::get('aszf', [PolicyController::class, 'aszf']);

Route::get('adatkezeles', [PolicyController::class, 'privacy']);

// admin
Route::middleware('guest:admin')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.store');
});

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('services', ServiceController::class)->only(['index', 'update']);
    Route::get('settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});