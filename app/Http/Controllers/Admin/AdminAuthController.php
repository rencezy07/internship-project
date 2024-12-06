<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (!Auth::guard('admin')->check()) {
            // Redirect to login page if not logged in
            return Inertia::render('Admin/Auth/Login');
        }
        
        return inertia('Admin/Auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function dashboard()
    {
        $companies = Company::where('is_verified', false)->get(); // Fetch unverified companies
        return inertia('Admin/Dashboard', [
            'unverifiedCompanies' => $companies,
        ]);
    }


    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout(); // Log out the admin
    
        // Invalidate the session
        $request->session()->invalidate();
    
        // Regenerate the CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();
    
        // Redirect to the admin login page
        return redirect()->route('admin.login');
    }
    
}
