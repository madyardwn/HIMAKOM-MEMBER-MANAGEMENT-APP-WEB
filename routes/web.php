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

Route::group(['middleware' => ['auth']], function () {
    // dashboard
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');    
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/about', [\App\Http\Controllers\AboutController::class, 'index'])->name('about.index');

    // route users-management group
    Route::group(['prefix' => 'users-management', 'as' => 'users-management.'], function () {
        // Users
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index')->middleware('permission:read-users');
    });

    // route auth-web group
    Route::group(['prefix' => 'auth-web', 'as' => 'auth-web.'], function () {
        // Permissions
        Route::get('/permissions', [\App\Http\Controllers\AuthWebPermissionController::class, 'index'])->name('permissions.index');
        
        // Roles
        Route::get('/roles', [\App\Http\Controllers\AuthWebRoleController::class, 'index'])->name('roles.index');
        Route::post('/roles/store', [\App\Http\Controllers\AuthWebRoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}/edit', [\App\Http\Controllers\AuthWebRoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}/update', [\App\Http\Controllers\AuthWebRoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}/destroy', [\App\Http\Controllers\AuthWebRoleController::class, 'destroy'])->name('roles.destroy');
    });
    
    // tom-select
    Route::get('/tom-select/permissions', [\App\Http\Controllers\TomSelectController::class, 'permissions'])->name('tom-select.permissions');
});