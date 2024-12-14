<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListeingController;
use App\Http\Controllers\ListeingImageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RealtorListeingController;
use App\Http\Controllers\UserController;
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

Route::post('confirm/code', [PasswordController::class, 'confirmCodeSave'])->name('otp.save');
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'loginSave'])->name('login.save');
    Route::get('register', [UserController::class, 'register'])->name('register');
    Route::post('register', [UserController::class, 'registerSave'])->name('register.save');
    Route::get('forget/password', [PasswordController::class, 'forgetPassword'])->name('forget.password');
    Route::post('forget/password', [PasswordController::class, 'forgetPasswordSave'])->name('forget.password.save');
    Route::get('confirm/code', [PasswordController::class, 'confirmCode'])->name('otp');
    Route::prefix('{provider}')->group(function ($provider) {
        Route::get('social/login', [AuthController::class, 'socialLogin'])->name('social.login');
        Route::any('/callback', [AuthController::class, 'socialLoginCallback']);
    });
});


Route::middleware('auth:web', 'isActiveMiddleware')->group(function () {
    Route::post('reset/password', [PasswordController::class, 'resetPassword'])->name('reset.password');
    Route::delete('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('change/password', [PasswordController::class, 'changePassword'])->name('change.password');
    Route::post('change/password', [PasswordController::class, 'changePasswordSave'])->name('change.password.save');
    Route::post('profile', [AuthController::class, 'profileSave'])->name('profile.save');
    Route::resource('listeing', ListeingController::class)->except('destroy');
    Route::prefix('realtor')->name('realtor.')->group(function () {
        Route::get('listeing/restore/{id}', [RealtorListeingController::class, 'restore'])->name('listeing.restore');
        Route::resource('listeing', RealtorListeingController::class)->only(['index', 'destroy']);
    });
    Route::get('images/{listeing}', [ListeingImageController::class, 'create'])->name('images.create');
    Route::post('images/{listeing}', [ListeingImageController::class, 'store'])->name('images.store');
    Route::delete('images/{image}', [ListeingImageController::class, 'destroy'])->name('images.destroy');
    Route::post('offer/store/{id}', [OfferController::class, 'store'])->name('offer.store');
    Route::get('offer/{id}', [OfferController::class, 'index'])->name('offer.index');
    Route::post('offer/accept/{id}', [OfferController::class, 'accept'])->name('offer.accept');
    Route::resource('notifications', NotificationController::class)->only(['index', 'edit']);
});
