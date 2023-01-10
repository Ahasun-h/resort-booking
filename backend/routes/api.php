<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ResortController;

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

Route::group(['middleware' => 'auth:sanctum'], function () {

    //  User Route
    Route::get('/users', [UserController::class,'index']);
    Route::post('/user/create',[UserController::class,'store']);
    Route::get('/user/{id}',[UserController::class,'show']);
    Route::post('/user/update/{id}',[UserController::class,'update']);
    Route::delete('/user/delete/{id}',[UserController::class,'delete']);

    // Resort Route
    Route::post('resort/create',[ResortController::class,'store']);

});

Route::post('login',[AuthenticationController::class,'login']);