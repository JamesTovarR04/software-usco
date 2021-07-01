<?php

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

// Protected routes - Sanctum
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/myprogram', [UserController::class,'addProgram']);
    Route::middleware('hasAProgram')->group(function () {
        Route::get('/user', [UserController::class,'getMyData']);
    });
});