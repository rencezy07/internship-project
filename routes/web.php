<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

// Import Controllers
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Company\CompanyAuthController;
use App\Http\Controllers\Company\CompanyDashboardController;


// ---------------------------------- Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
        Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AdminAuthController::class, 'register']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/company-applications', [AdminDashboardController::class, 'companyApp'])->name('companyapp');
        Route::put('/company-applications/{company}', [AdminDashboardController::class, 'updateCompanyVerification'])->name('companyapp.update');
        
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
    });
});


// // ---------------------------------- Company Routes
Route::prefix('company')->name('company.')->group(function () {
    Route::middleware('guest:company')->group(function () {
        Route::get('/login', [CompanyAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [CompanyAuthController::class, 'login']);
        Route::get('/register', [CompanyAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [CompanyAuthController::class, 'register']);
    });

    Route::middleware('auth:company')->group(function () {
        
        Route::get('/internships', [CompanyDashboardController::class, 'showInternship'])->name('internships');
        Route::post('/internships', [CompanyDashboardController::class, 'storeInternship'])->name('internship.store');


        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [CompanyAuthController::class, 'logout'])->name('logout');

         
        
    });
});





Route::get('/', function () {
    return redirect()->route('user.login');
})->name('home');


// Define a fallback /login route to avoid Route [login] not defined
Route::get('/login', function () {
    return redirect()->route('user.login');
})->name('login');




// ---------------------------------- User Routes
Route::prefix('user')->name('user.')->group(function () {

    Route::middleware('guest:user')->group(function () {
        Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [UserAuthController::class, 'login']);
        Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [UserAuthController::class, 'register']);
    });

    Route::middleware('auth:user')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    });
});

// // Default Laravel Profile and Dashboard (Optional)
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
