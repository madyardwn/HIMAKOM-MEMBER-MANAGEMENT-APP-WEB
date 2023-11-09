<?php

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

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [App\Http\Controllers\Api\UserController::class, 'user']);
    Route::put('/user/device-token', [App\Http\Controllers\Api\UserController::class, 'updateDeviceToken']);

    Route::get('/cabinet', [App\Http\Controllers\Api\CabinetController::class, 'cabinet']);

    Route::get('/events', [App\Http\Controllers\Api\EventController::class, 'events']);
    Route::get('/notifications', [App\Http\Controllers\Api\NotificationController::class, 'notifications']);
    Route::get('/notifications/{notification}/read', [App\Http\Controllers\Api\NotificationController::class, 'read']);

    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
});
