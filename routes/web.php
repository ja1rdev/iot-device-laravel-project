<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController, StationController, SensorController};

Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::resource('stations', StationController::class)->only(['index','create','store']);
Route::resource('sensors',  SensorController::class)->only(['index','create','store']);