<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CompanyAuthController extends Controller
{
    public function showLogin()
    {
        return inertia('Company/Auth/Login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Get company by email
        $company = Company::where('email', $request->email)->first();

        // Check if company exists
        if (!$company) {
            return back()->withErrors(['email' => 'Account not found.']);
        }

        // Check if the company is verified
        if (!$company->isVerified) {
            return back()->withErrors(['email' => 'Your account has been processed by the admin, please wait for a while.']);
        }

        // Attempt to log in if account exists and is verified
        if (Auth::guard('company')->attempt($request->only('email', 'password'))) {
            return redirect()->route('company.dashboard');
        }

        // If login fails
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showRegister()
    {
        return inertia('Company/Register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $company = Company::create([
            'company_name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_verified' => false,
        ]);

        Auth::guard('company')->login($company);

        return redirect()->route('company.dashboard');
    }

    public function dashboard()
    {
        return inertia('Company/Dashboard');
    }

    public function logout()
    {
        Auth::guard('company')->logout();

        return redirect()->route('company.login');
    }
}
