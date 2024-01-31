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


Auth::routes([
    'register' => false,
    'verify' => false,
]);

Route::get('/', fn () => redirect(route('login')));

Route::group(['middleware' => ['auth']], function () {
    // dashboard
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/about', [\App\Http\Controllers\AboutController::class, 'index'])->name('about.index');

    // Complaints
    Route::get('/complaints', [\App\Http\Controllers\ComplaintController::class, 'index'])->name('complaints.index')->middleware('permission:read-complaints');
    Route::post('/complaints/store', [\App\Http\Controllers\ComplaintController::class, 'store'])->name('complaints.store')->middleware('permission:create-complaints');
    Route::get('/complaints/{complaint}/edit', [\App\Http\Controllers\ComplaintController::class, 'edit'])->name('complaints.edit')->middleware('permission:update-complaints');
    Route::put('/complaints/{complaint}/update', [\App\Http\Controllers\ComplaintController::class, 'update'])->name('complaints.update')->middleware('permission:update-complaints');
    Route::delete('/complaints/{complaint}/destroy', [\App\Http\Controllers\ComplaintController::class, 'destroy'])->name('complaints.destroy')->middleware('permission:delete-complaints');
    Route::put('/complaints/{complaint}/resolve', [\App\Http\Controllers\ComplaintController::class, 'resolve'])->name('complaints.resolve')->middleware('permission:update-complaints');

    // route users-management group
    Route::group(['prefix' => 'users-management', 'as' => 'users-management.'], function () {
        // Users
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index')->middleware('permission:read-users');
        Route::post('/users/store', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store')->middleware('permission:create-users');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit')->middleware('permission:update-users');
        Route::put('/users/{user}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update')->middleware('permission:update-users');
        Route::delete('/users/{user}/destroy', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete-users');

        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index')->middleware('permission:read-notifications');
        Route::post('/notifications/store', [\App\Http\Controllers\NotificationController::class, 'store'])->name('notifications.store')->middleware('permission:create-notifications');
        Route::delete('/notifications/{notification}/destroy', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy')->middleware('permission:delete-notifications');

        // WorkHistories
        Route::get('/work-histories', [\App\Http\Controllers\WorkHistoryController::class, 'index'])->name('work-histories.index')->middleware('permission:read-work-histories');
        Route::get('/work-histories/{user}', [\App\Http\Controllers\WorkHistoryController::class, 'show'])->name('work-histories.show')->middleware('permission:read-work-histories');
        Route::get('/work-histories/{user}/position', [\App\Http\Controllers\WorkHistoryController::class, 'positions'])->name('work-histories.positions')->middleware('permission:read-work-histories');
        Route::get('/work-histories/{user}/programs', [\App\Http\Controllers\WorkHistoryController::class, 'programs'])->name('work-histories.programs')->middleware('permission:read-work-histories');
    });

    // route auth-web group
    Route::group(['prefix' => 'auth-web', 'as' => 'auth-web.'], function () {
        // Permissions
        Route::get('/permissions', [\App\Http\Controllers\AuthWebPermissionController::class, 'index'])->name('permissions.index')->middleware('permission:read-auth-web-permissions');

        // Roles
        Route::get('/roles', [\App\Http\Controllers\AuthWebRoleController::class, 'index'])->name('roles.index')->middleware('permission:read-auth-web-roles');
        Route::post('/roles/store', [\App\Http\Controllers\AuthWebRoleController::class, 'store'])->name('roles.store')->middleware('permission:create-auth-web-roles');
        Route::get('/roles/{role}/edit', [\App\Http\Controllers\AuthWebRoleController::class, 'edit'])->name('roles.edit')->middleware('permission:update-auth-web-roles');
        Route::put('/roles/{role}/update', [\App\Http\Controllers\AuthWebRoleController::class, 'update'])->name('roles.update')->middleware('permission:update-auth-web-roles');
        Route::delete('/roles/{role}/destroy', [\App\Http\Controllers\AuthWebRoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:delete-auth-web-roles');
    });

    // route periodes
    Route::group(['prefix' => 'periodes', 'as' => 'periodes.'], function () {
        // Cabinets
        Route::get('/cabinets', [\App\Http\Controllers\CabinetController::class, 'index'])->name('cabinets.index')->middleware('permission:read-cabinets');
        Route::post('/cabinets/store', [\App\Http\Controllers\CabinetController::class, 'store'])->name('cabinets.store')->middleware('permission:create-cabinets');
        Route::get('/cabinets/{cabinet}/edit', [\App\Http\Controllers\CabinetController::class, 'edit'])->name('cabinets.edit')->middleware('permission:update-cabinets');
        Route::put('/cabinets/{cabinet}/update', [\App\Http\Controllers\CabinetController::class, 'update'])->name('cabinets.update')->middleware('permission:update-cabinets');
        Route::delete('/cabinets/{cabinet}/destroy', [\App\Http\Controllers\CabinetController::class, 'destroy'])->name('cabinets.destroy')->middleware('permission:delete-cabinets');

        // Filosofies
        Route::get('/filosofies', [\App\Http\Controllers\FilosofieController::class, 'index'])->name('filosofies.index')->middleware('permission:read-filosofies');
        Route::post('/filosofies/store', [\App\Http\Controllers\FilosofieController::class, 'store'])->name('filosofies.store')->middleware('permission:create-filosofies');
        Route::get('/filosofies/{filosofie}/edit', [\App\Http\Controllers\FilosofieController::class, 'edit'])->name('filosofies.edit')->middleware('permission:update-filosofies');
        Route::put('/filosofies/{filosofie}/update', [\App\Http\Controllers\FilosofieController::class, 'update'])->name('filosofies.update')->middleware('permission:update-filosofies');
        Route::delete('/filosofies/{filosofie}/destroy', [\App\Http\Controllers\FilosofieController::class, 'destroy'])->name('filosofies.destroy')->middleware('permission:delete-filosofies');

        // DBUs
        Route::get('/dbus', [\App\Http\Controllers\DBUController::class, 'index'])->name('dbus.index')->middleware('permission:read-dbus');
        Route::post('/dbus/store', [\App\Http\Controllers\DBUController::class, 'store'])->name('dbus.store')->middleware('permission:create-dbus');
        Route::get('/dbus/{dbu}/edit', [\App\Http\Controllers\DBUController::class, 'edit'])->name('dbus.edit')->middleware('permission:update-dbus');
        Route::put('/dbus/{dbu}/update', [\App\Http\Controllers\DBUController::class, 'update'])->name('dbus.update')->middleware('permission:update-dbus');
        Route::delete('/dbus/{dbu}/destroy', [\App\Http\Controllers\DBUController::class, 'destroy'])->name('dbus.destroy')->middleware('permission:delete-dbus');

        // Programs
        Route::get('/programs', [\App\Http\Controllers\ProgramController::class, 'index'])->name('programs.index')->middleware('permission:read-programs');
        Route::post('/programs/store', [\App\Http\Controllers\ProgramController::class, 'store'])->name('programs.store')->middleware('permission:create-programs');
        Route::get('/programs/{program}/edit', [\App\Http\Controllers\ProgramController::class, 'edit'])->name('programs.edit')->middleware('permission:update-programs');
        Route::put('/programs/{program}/update', [\App\Http\Controllers\ProgramController::class, 'update'])->name('programs.update')->middleware('permission:update-programs');
        Route::delete('/programs/{program}/destroy', [\App\Http\Controllers\ProgramController::class, 'destroy'])->name('programs.destroy')->middleware('permission:delete-programs');

        // Events
        Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index')->middleware('permission:read-events');
        Route::post('/events/store', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store')->middleware('permission:create-events');
        Route::get('/events/{event}/edit', [\App\Http\Controllers\EventController::class, 'edit'])->name('events.edit')->middleware('permission:update-events');
        Route::put('/events/{event}/update', [\App\Http\Controllers\EventController::class, 'update'])->name('events.update')->middleware('permission:update-events');
        Route::delete('/events/{event}/destroy', [\App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy')->middleware('permission:delete-events');
        Route::post('/events/notification/{event}', [\App\Http\Controllers\EventController::class, 'notification'])->name('events.notification')->middleware('permission:create-notifications');
    });

    // route logs
    Route::group(['prefix' => 'logs', 'as' => 'logs.'], function () {
        // Activity Logs
        Route::get('/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index')->middleware('permission:read-activity-logs');
        // Telescope
        Route::get('/telescope', [\App\Http\Controllers\TelescopeController::class, 'index'])->name('telescope.index')->middleware('permission:read-telescope');
    });

    // tom-select
    Route::get('/tom-select/users', [\App\Http\Controllers\TomSelectController::class, 'users'])->name('tom-select.users')->middleware('permission:read-users');

    // Excel Import
    Route::post('/import/users', [\App\Http\Controllers\ImportController::class, 'users'])->name('import.users')->middleware('permission:create-users');
});
