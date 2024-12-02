<?php

use Inertia\Inertia;
use App\Http\Controllers\Auth\Userfile\UserRegisterController;
use App\Http\Controllers\Auth\Merchantfile\MerchantPageController;
use App\Http\Controllers\Auth\Userfile\UserAuthenticateController;
use App\Http\Controllers\Auth\Userfile\UserResetPasswordController;
use App\Http\Controllers\Auth\Merchantfile\MerchantRegisterController;
use App\Http\Controllers\Auth\Merchantfile\MerchantAuthenticateController;

Route::middleware('guest:user')->group(function() {
    //  ------------------------------- USER -------------------------------- 
    // Register
    Route::get('/register', [UserRegisterController::class, 'create'])->name('register');
    Route::post('/register', [UserRegisterController::class, 'store']);
    // Login
    Route::get('/login', [UserAuthenticateController::class, 'create'])->name('login');
    Route::post('/login', [UserAuthenticateController::class, 'store']);

    // Reset Password
    Route::get('/forgot-password', [UserResetPasswordController::class, 'requestPass'])
    ->middleware('guest')->name('password.request');
    Route::post('/forgot-password', [UserResetPasswordController::class, 'sendEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [UserResetPasswordController::class, 'resetForm'])->name('password.reset');
    
    Route::post('/reset-password', [UserResetPasswordController::class, 'resetHandler'])->name('password.update');

    
});

// -------------------------------- MERCHANTS --------------------------------------

Route::middleware('guest:merchant')->group(function () {
    Route::get('/merchant', [MerchantPageController::class, 'index'])->name('merchant');
    Route::get('/merchant-register', [MerchantRegisterController::class, 'create'])->name('merchant.register');
    Route::post('/merchant-register', [MerchantRegisterController::class, 'store'])->name('merchant.register.store');
    Route::get('/merchant-login', [MerchantAuthenticateController::class, 'create'])->name('merchant.login');
    Route::post('/merchant-login', [MerchantAuthenticateController::class, 'store']);
    
});

Route::middleware('auth:merchant')->group(function () {
    Route::get('/merchant/dashboard', function () {
        return Inertia::render('Merchant/Dashboard');
    })->name('merchant.dashboard');
});





Route::middleware('auth')->group(function() {
    // Logout
    Route::post('/logout', [UserAuthenticateController::class, 'destroy'])->name('logout');
});
