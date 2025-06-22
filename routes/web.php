<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::resource('/', IndexController::class)->only(['index']);

Route::resource('admin', AdminController::class)->only(['index']);
