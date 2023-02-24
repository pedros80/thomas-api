<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RealTimeIncidentsController;
use App\Http\Controllers\ServiceIndicatorController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->group(function () {
    Route::controller(BoardController::class)->prefix('boards')->group(function () {
        Route::get('/departures/{station?}', 'departures');
        Route::get('/departures/{station}/platform/{platform}', 'departuresPlatform');
        Route::get('/arrivals/{station?}', [BoardController::class, 'arrivals']);
    });

    Route::controller(StationController::class)->prefix('stations')->group(function () {
        Route::post('/search', 'search');
        Route::get('/messages/{station}', 'messages');
    });

    Route::controller(NewsController::class)->prefix('news')->group(function () {
        Route::get('/', 'get');
    });

    Route::controller(ServiceIndicatorController::class)->prefix('service-indicator')->group(function () {
        Route::get('/', 'get');
    });

    Route::controller(RealTimeIncidentsController::class)->prefix('rti')->group(function () {
        Route::get('/', 'get');
    });
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::post('/', 'add')->middleware('fatcontroller');
});
