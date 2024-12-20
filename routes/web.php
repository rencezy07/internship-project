<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

// Import Controllers
use App\Http\Controllers\Company\FileController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Company\CompanyAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Company\CompanyDashboardController;

//-----------------------------------Google Routes
use App\Http\Controllers\User\GoogleController;

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

        Route::put('/company-applications/{company_id}', [AdminDashboardController::class, 'updateCompanyVerification'])->name('companyapp.update');


        Route::get('/student-internship-applications/{id?}', [AdminDashboardController::class, 'studentInternshipApplications'])->name('student-internship-applications');


        Route::get('/view-users', [AdminDashboardController::class, 'viewUsers'])->name('view-users');

        Route::get('/view-companies', [AdminDashboardController::class, 'viewCompanies'])->name('view-companies');

            // Activity Logs Route
    Route::get('/activity-logs', [AdminDashboardController::class, 'activityLogs'])->name('activity-logs');


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


        Route::get('/manage-internships-application', [CompanyDashboardController::class, 'manageInternshipsApplication'])->name('manage-internships-application');


        Route::put('/application/{applicationId}/status', [CompanyDashboardController::class, 'updateApplicationStatus'])
        ->name('company.updateApplicationStatus');
        Route::get('/download/{type}/{internshipId}', [FileController::class, 'download'])
        ->name('download');
    

        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [CompanyAuthController::class, 'logout'])->name('logout');
        

        Route::get('/profile', [CompanyDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [CompanyDashboardController::class, 'updateProfile'])->name('profile.update');


        Route::get('/manage-internships', [CompanyDashboardController::class, 'manageInternships'])->name('manageInternships');

        Route::put('/update/{internshipId}', [CompanyDashboardController::class, 'updateInternship'])->name('update');
        Route::delete('/delete/{internshipId}', [CompanyDashboardController::class, 'deleteInternship'])->name('delete');


    });
});



Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');


// Define a fallback /login route to avoid Route [login] not defined
Route::get('/login', function () {
    return redirect()->route('user.login');
})->name('login');


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');


// ---------------------------------- User Routes
Route::prefix('user')->name('user.')->group(function () {

    Route::middleware('guest:user')->group(function () {
        Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [UserAuthController::class, 'login']);
        Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [UserAuthController::class, 'register']);
    });

    Route::middleware('auth:user')->group(function () {
        Route::post('/apply/{internshipId}', [UserDashboardController::class, 'apply'])->name('apply');
        Route::get('/home', [UserDashboardController::class, 'home'])->name('home');

        Route::get('/application', [UserDashboardController::class, 'showApplications'])->name('application');
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

        Route::get('/profile', [UserAuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [UserAuthController::class, 'updateProfile'])->name('profile.update');

    Route::delete('/delete', [UserAuthController::class, 'destroy'])->name('delete');

    });
});

//activity logsssss route


// // Default Laravel Profile and Dashboard (Optional)
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
