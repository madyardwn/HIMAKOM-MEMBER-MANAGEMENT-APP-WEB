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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [App\Http\Controllers\Api\UserController::class, 'user']);
    Route::put('/user/device-token', [App\Http\Controllers\Api\UserController::class, 'updateDeviceToken']);

    Route::get('/cabinet', [App\Http\Controllers\Api\CabinetController::class, 'cabinet']);

    Route::get('/departments', [App\Http\Controllers\Api\DepartmentController::class, 'index']);

    Route::get('/events', [App\Http\Controllers\Api\EventController::class, 'index']);
    Route::get('/events/notification', [App\Http\Controllers\Api\EventController::class, 'notification']);
    Route::get('/events/notification/{notification}/read', [App\Http\Controllers\Api\EventController::class, 'notificationRead']);

    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
});
