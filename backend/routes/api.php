<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ResortController;
use App\Http\Controllers\Api\ResortImageController;
use App\Http\Controllers\Api\ResortBookingController;

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
    Route::get('/resorts',[ResortController::class,'index']);
    Route::post('/resort/create',[ResortController::class,'store']);
    Route::get('/resort/view/{id}',[ResortController::class,'show']);
    Route::delete('/resort/delete/{id}',[ResortController::class,'delete']);
    Route::post('/resort/update/{id}',[ResortController::class,'update']);

    // Resort Image Route
    Route::get('/resort/images/{id}',[ResortImageController::class,'index']);
    Route::delete('/resort/images/delete/{id}',[ResortImageController::class,'delete']);

    Route::get('/bookings',[ResortBookingController::class,'bookings']);

});



Route::get('all-resorts',[ResortBookingController::class,'index']);
Route::get('view-resort/{id}',[ResortBookingController::class,'show']);
Route::post('resort-booking/{id}',[ResortBookingController::class,'booking']);

Route::post('login',[AuthenticationController::class,'login']);