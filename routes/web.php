<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\{
    ContactController,
    StationController,
    SensorController
};
use App\Http\Controllers\DataApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

// Route::view('/', 'index')->name('home');
// Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::resource('stations', StationController::class)->only(['index','create','store']);
Route::resource('sensors',  SensorController::class)->only(['index','create','store']);
Route::get('/telemetry', [DataApiController::class,'series'])->name('api.telemetry'); 