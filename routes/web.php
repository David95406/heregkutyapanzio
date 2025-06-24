<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::resource('/', IndexController::class)->only(['index']);

Route::resource('admin', AdminController::class)->only(['index']);

Route::resource('rolunk', AboutController::class)->only(['index']);

Route::resource('foglalas', BookingController::class)->only(['index']);
