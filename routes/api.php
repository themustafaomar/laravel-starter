
<?php

use App\Http\Controllers\Api\AccessControl\PermissionController;
use App\Http\Controllers\Api\AccessControl\RoleController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

require_once __DIR__.'/auth.php';

// --------------------------------------
// Roles and permissions
// --------------------------------------
Route::middleware('role:super admin|admin')
    ->apiResource('/roles', RoleController::class)
    ->except('destroy', 'store');
Route::middleware('role:super admin|admin')
    ->get('/permissions', PermissionController::class);
Route::middleware('role:super admin')
    ->post('/roles/assign/{user}', RoleController::class.'@assignRoles');

// --------------------------------------
// Profile
// --------------------------------------
Route::post('/profile', ProfileController::class.'@index');
Route::get('/profile/user', ProfileController::class.'@user');
Route::post('/profile/avatar', ProfileController::class.'@changeAvatar');
Route::post('/profile/update-password', ProfileController::class.'@updatePassword');

// --------------------------------------
// Notifications
// --------------------------------------
Route::apiResource('/notifications', NotificationController::class)
    ->only('index', 'destroy');
Route::post('/notifications/{notification}/markas-read', NotificationController::class.'@markAsRead');
