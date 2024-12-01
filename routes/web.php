<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Userfile\UserProfileController;
use App\Http\Controllers\Auth\Userfile\UserDashboardController;


Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'updateInfo'])->name('profile.info');

});

Route::inertia('/', 'Home')->name('home');
require __DIR__ . '/auth.php';