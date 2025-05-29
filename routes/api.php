<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VaccineCenterController;
use App\Http\Controllers\API\VaccineRegistrationController;
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
    Route::get('/users', [UserController::class, 'index']);
    Route::apiResource('/vaccine-centers', VaccineCenterController::class);
});





Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');


// Route::prefix('v1')->group(function (Request $request) {
    Route::post('/registration', [VaccineRegistrationController::class, 'store'])->name('registration.store');
    // Route::get('/vaccine-centers', [VaccineCenterController::class, 'index'])->name('vaccine-center-list');
    // Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/search', [SearchController::class, 'searchProcess'])->name('searchProcess');
// });

