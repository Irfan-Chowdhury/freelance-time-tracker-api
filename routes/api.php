<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\TimeLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');

    Route::apiResource('clients', ClientController::class);
    Route::apiResource('projects', ProjectController::class);

    Route::prefix('time-logs')->group(function () {
        Route::controller(TimeLogController::class)->group(function() {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/pdf', 'pdfExport');
            Route::put('/{timeLog}', 'update');
            Route::delete('/{timeLog}', 'destroy');
            Route::post('/{timeLog}/stop', 'stopTimer'); // Timer-specific route
        });
    });

    Route::get('/report', [ReportController::class, 'index']);
});


