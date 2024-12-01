<?php

use App\Http\Controllers\Auth\Userfile\UserRegisterController;
use App\Http\Controllers\Auth\Userfile\UserAuthenticateController;
use App\Http\Controllers\Auth\Userfile\UserResetPasswordController;

Route::middleware('guest')->group(function() {

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

Route::middleware('auth')->group(function() {
    // Logout
    Route::post('/logout', [UserAuthenticateController::class, 'destroy'])->name('logout');
});
