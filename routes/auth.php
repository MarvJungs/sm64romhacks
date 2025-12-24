<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\ProfileSettingsController;
use App\Http\Controllers\Auth\SocialiteController;

use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(
    function () {
        Route::get('redirect/{driver}', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
        Route::get('callback/{driver}', [SocialiteController::class, 'callback'])->name('socialite.callback');
        Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');
        Route::delete('delete', [ProfileController::class, 'delete'])->middleware(['auth', 'verified'])->name('auth.delete');
    }
);

Route::prefix('email')->group(
    function () {
        Route::get('verify', [EmailVerificationController::class, 'index'])->name('verification.notice');
        Route::get('verify/{id}/{hash}', [EmailVerificationController::class, 'handle'])->middleware(['auth', 'signed'])->name('verification.verify');
        Route::post('verification-notification', [EmailVerificationController::class, 'sendNotification'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    }
);

Route::prefix('settings')->group(
    function () {
        Route::get('account', [ProfileSettingsController::class, 'index'])->middleware(['auth', 'verified'])->name('auth.profile.settings');
        Route::post('account', [ProfileSettingsController::class, 'handle']);
    }
);
