<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccineCenterController;
use App\Http\Controllers\VaccineRegistrationController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registration', [VaccineRegistrationController::class, 'create'])->name('registration');
Route::post('/registration', [VaccineRegistrationController::class, 'store'])->name('registration.store');


Route::get('/vaccine-center-list', [VaccineCenterController::class, 'index'])->name('vaccine-center-list');

Route::get('/search', [SearchController::class, 'searchPage'])->name('searchPage');
Route::post('/search', [SearchController::class, 'searchProcess'])->name('searchProcess');


Route::get('/all-users', [UserController::class, 'index'])->name('users.index');
