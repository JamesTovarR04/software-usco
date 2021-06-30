<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public pages SPA - React
Route::get('/{any}', function () {
    return view('public');
})->where('any','^$|[a-z0-9]+\b(?<!auth|logout|student)');

// Routes for google login
Route::group(['prefix' => 'auth'], function () {
    Route::get('/google', [LoginController::class,'redirectToProvider'])->name('login-google');
    Route::get('/google/callback', [LoginController::class,'handleProviderCallback']);
});

// Private Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/auth/addprogram', [LoginController::class,'addProgram']);
    Route::get('/auth/logout', [LoginController::class,'logout']);
    Route::middleware('hasAProgram')->group(function () {
        Route::get('/student', function(){ return view('student'); });
    });
});