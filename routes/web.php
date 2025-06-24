<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::resource('/', IndexController::class)->only(['index']);

Route::resource('admin', AdminController::class)->only(['index']);
/*
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    // admin protected sites
});
*/

Route::resource('rolunk', AboutController::class)->only(['index']);

Route::resource('foglalas', BookingController::class)->only(['index']);
