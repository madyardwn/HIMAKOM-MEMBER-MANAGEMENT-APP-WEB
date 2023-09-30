<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect(route('login'));
});

Auth::routes([
    'register' => false,
    'verify' => false,
]);

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    // Route::get('/users-management/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    
    // route group name
    Route::group(['prefix' => 'users-management', 'as' => 'users-management.'], function () {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        // Route::group(['prefix' => 'auth-web', 'as' => 'auth-web.'], function () {
        //     Route::get('/permissions', [\App\Http\Controllers\PermissionController::class, 'index'])->name('permissions.index');
        //     Route::get('/roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
        // });
    });
});