<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MotorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/motor', [MotorController::class, 'getData']);
Route::post('/addData', [MotorController::class, 'addData']);
Route::put('/motor/{id}', [MotorController::class, 'updateData']);
Route::delete('/motor/{id}', [MotorController::class, 'deleteData']);
