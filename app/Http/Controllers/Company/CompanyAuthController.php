<?php

namespace App\Http\Controllers\Company;

use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyAuthController extends Controller
{
    public function showLogin()
    {
        return inertia('Company/Auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('company')->attempt($credentials)) {
            $company = Auth::guard('company')->user();
    
            // Check if the company is verified
            if (!$company->isVerified) {
                Auth::guard('company')->logout(); // Logout unverified company
                return redirect()->route('company.login')->withErrors([
                    'email' => 'Your account is being processed, please wait.',
                ]);
            }
    
            // Redirect to the dashboard if verified
            return redirect()->route('company.dashboard');
        }
    
        return back()->withErrors([
            'email' => 'Invalid Credentials',
        ]);
    }
    
    

    public function showRegister()
    {
        return inertia('Company/Auth/Register');
    }

    public function register(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|unique:company,email',
            'password' => 'required|string|confirmed|min:6',
            'location' => 'required|string|max:255', // Required location
            'company_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Required logo
            'business_permit' => 'required|mimes:pdf,docx,doc,jpg,png,gif|max:4096', // Required business permit
        ]);
    
        // Handle file uploads
        $logoPath = $request->file('company_logo')->store('company_logos', 'public');
        $permitPath = $request->file('business_permit')->store('business_permits', 'public');
    
        // Add file paths to the validated data
        $validated['company_logo'] = $logoPath;
        $validated['business_permit'] = $permitPath;
        $validated['password'] = bcrypt($request->password); // Encrypt the password
        $validated['isVerified'] = false; // Set is_verified to false initially
    
        // Create the company using the validated data
        $company = Company::create($validated);
    
        // Log the company in after successful registration
    
        // Redirect to the company dashboard
        return redirect()->route('company.login')->with('message', 'Your account is being processed, please wait.');
    }
    

    public function dashboard()
    {
        $company = Auth::guard('company')->user();

        return inertia('Company/Dashboard', [
            'internships' => $company->internships, // Example: Pass related internships if needed
        ]);
    }

    public function logout()
    {
        Auth::guard('company')->logout();

        return redirect()->route('company.login');
    }
}
