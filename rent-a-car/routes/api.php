<?php

use app\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CarController;
use app\Http\Controllers\api\RegistrationController;
use App\Http\Controllers\ReservationController;
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

Route::get('/test', function (){
    return \App\Models\User::all();
});

Route::post('/register', 'App\Http\Controllers\api\RegistrationController@register');
Route::post('/login', 'App\Http\Controllers\api\AuthController@login');

//Example
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});



Route::middleware('auth:sanctum')-> group(function (){
    Route::post('/logout', 'App\Http\Controllers\api\AuthController@logout');
    Route::apiResource('/cars', CarController::class);


    Route::get('/cars', [CarController::class, 'index']);
    Route::post('/car', [CarController::class, 'store']);
    Route::put('/cars/{car}', [CarController::class, 'update']);
    Route::delete('/cars/{car}', [CarController::class, 'destroy']);



    Route::apiResource('/reservations', ReservationController::class);
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
    Route::put('/reservations/{id}', [ReservationController::class, 'update']);

    Route::get('/reservations/excel', [ReservationController::class, 'exportExcel']);


});

