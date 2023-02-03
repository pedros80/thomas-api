<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('boards')->group(function () {
    Route::get('/departures/{station?}', [BoardController::class, 'departures']);
    Route::get('/departures/{station}/platform/{platform}', [BoardController::class, 'departuresPlatform']);
    Route::get('/arrivals/{station?}', [BoardController::class, 'arrivals']);
});

Route::prefix('stations')->group(function () {
    Route::post('/search', [StationController::class, 'search']);
});

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'get']);
});