<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
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

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/', [AuthController::class, 'loginSave'])->name('admin.login.save');
});

Route::middleware('auth:admin')->group(function () {
    Route::delete('logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::middleware('isSuperAdmin')->group(function () {
        Route::resource('roles', RoleController::class)->except('show');
        Route::resource('admins', AdminController::class)->except('show');
    });
    Route::resource('users', UserController::class)->only('index');
});
