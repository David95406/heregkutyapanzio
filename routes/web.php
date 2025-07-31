<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\BlockedDateController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::resource('/', IndexController::class)->only(['index']);

Route::resource('rolunk', AboutController::class)->only(['index']);

Route::resource('foglalas', BookingController::class)->only(['index', 'store']);
Route::get('foglalas/verify/{token}', [BookingController::class, 'verify'])->name('booking.verify');

Route::get('aszf', [PolicyController::class, 'aszf']);

Route::get('adatkezeles', [PolicyController::class, 'privacy']);

// admin
Route::middleware('guest:admin')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.store');
});

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    // admin
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    // settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings/graph-api', [SettingsController::class, 'updateGraphApiKey'])->name('settings.update-graph-api');
    Route::put('settings/change-password', [AdminController::class, 'changePassword'])->name('settings.change-password');
    // booking
    Route::put('booking/{booking}', [AdminBookingController::class, 'update'])->name('admin.booking.update');
    Route::delete('booking/{booking}', [AdminBookingController::class, 'destroy'])->name('admin.booking.destroy');
    Route::patch('booking/{booking}/accept', [AdminBookingController::class, 'accept'])->name('admin.booking.accept');
    Route::patch('booking/{booking}/deny', [AdminBookingController::class, 'deny'])->name('admin.booking.deny');
    // blocked date
    Route::resource('blocked-dates', BlockedDateController::class)->only(['store', 'destroy', 'index']);
    // posts
    Route::resource('posts', AdminPostController::class)->only(['index', 'store', 'update', 'destroy']);
});
