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

    // route periodes
    Route::group(['prefix' => 'periodes', 'as' => 'periodes.'], function () {
        // Cabinets
        Route::get('/cabinets', [\App\Http\Controllers\CabinetController::class, 'index'])->name('cabinets.index');
        Route::post('/cabinets/store', [\App\Http\Controllers\CabinetController::class, 'store'])->name('cabinets.store');
        Route::get('/cabinets/{cabinet}/edit', [\App\Http\Controllers\CabinetController::class, 'edit'])->name('cabinets.edit');
        Route::put('/cabinets/{cabinet}/update', [\App\Http\Controllers\CabinetController::class, 'update'])->name('cabinets.update');
        Route::delete('/cabinets/{cabinet}/destroy', [\App\Http\Controllers\CabinetController::class, 'destroy'])->name('cabinets.destroy');

        // Filosofies
        Route::get('/filosofies', [\App\Http\Controllers\FilosofieController::class, 'index'])->name('filosofies.index');
        Route::post('/filosofies/store', [\App\Http\Controllers\FilosofieController::class, 'store'])->name('filosofies.store');
        Route::get('/filosofies/{filosofie}/edit', [\App\Http\Controllers\FilosofieController::class, 'edit'])->name('filosofies.edit');
        Route::put('/filosofies/{filosofie}/update', [\App\Http\Controllers\FilosofieController::class, 'update'])->name('filosofies.update');
        Route::delete('/filosofies/{filosofie}/destroy', [\App\Http\Controllers\FilosofieController::class, 'destroy'])->name('filosofies.destroy');        

        // Departments
        Route::get('/departments', [\App\Http\Controllers\DepartmentController::class, 'index'])->name('departments.index');
        Route::post('/departments/store', [\App\Http\Controllers\DepartmentController::class, 'store'])->name('departments.store');
        Route::get('/departments/{department}/edit', [\App\Http\Controllers\DepartmentController::class, 'edit'])->name('departments.edit');
        Route::put('/departments/{department}/update', [\App\Http\Controllers\DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{department}/destroy', [\App\Http\Controllers\DepartmentController::class, 'destroy'])->name('departments.destroy');        

        // Programs
        Route::get('/programs', [\App\Http\Controllers\ProgramController::class, 'index'])->name('programs.index');
        Route::post('/programs/store', [\App\Http\Controllers\ProgramController::class, 'store'])->name('programs.store');
        Route::get('/programs/{program}/edit', [\App\Http\Controllers\ProgramController::class, 'edit'])->name('programs.edit');
        Route::put('/programs/{program}/update', [\App\Http\Controllers\ProgramController::class, 'update'])->name('programs.update');
        Route::delete('/programs/{program}/destroy', [\App\Http\Controllers\ProgramController::class, 'destroy'])->name('programs.destroy');
    });

    // route logs
    Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
        // Activity Logs
        Route::get('/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');
        // Telescope
        Route::get('/telescope', [\App\Http\Controllers\TelescopeController::class, 'index'])->name('telescope.index');
    });
    
    // tom-select
    Route::get('/tom-select/permissions', [\App\Http\Controllers\TomSelectController::class, 'permissions'])->name('tom-select.permissions');
    Route::get('/tom-select/cabinets', [\App\Http\Controllers\TomSelectController::class, 'cabinets'])->name('tom-select.cabinets');
    Route::get('/tom-select/departments', [\App\Http\Controllers\TomSelectController::class, 'departments'])->name('tom-select.departments');
    Route::get('/tom-select/users', [\App\Http\Controllers\TomSelectController::class, 'users'])->name('tom-select.users');
});