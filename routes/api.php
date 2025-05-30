<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\ProjectController;
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

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/users', [UserController::class, 'index']);
    // Route::apiResource('/vaccine-centers', VaccineCenterController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('projects', ProjectController::class);
});





Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');


// Route::prefix('v1')->group(function (Request $request) {
    // Route::post('/registration', [VaccineRegistrationController::class, 'store'])->name('registration.store');
    // Route::get('/vaccine-centers', [VaccineCenterController::class, 'index'])->name('vaccine-center-list');
    // Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // Route::post('/search', [SearchController::class, 'searchProcess'])->name('searchProcess');
// });

