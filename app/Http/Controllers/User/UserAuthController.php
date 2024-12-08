<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\InternshipWithCompany;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        $internships = InternshipWithCompany::select('internship_name', 'company_name', 'city', 'employment_type', 'is_open')->get();// Adjust this to your model and data as needed
        return inertia('User/Auth/Login', [
            'internships' => $internships, // Send internships to the frontend

        ]);

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');



        if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->route('user.home');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

   
    public function showRegister() {
        return inertia('User/Auth/Register');
    }
    public function Register(Request $request) {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone_number' => 'required|string|max:15',
            'gender' => 'required|in:male,female,other',
            'university' => 'required|string|max:255',
            'college_level' => 'required|in:freshman,sophomore,junior,senior',
            'profile_picture' => 'nullable|file|image|max:2048',
            'dob' => 'required|date',
        ]);

        $profile_picture_path = $request->file('profile_picture')->store('profile_pictures', 'public');

        $validated['profile_picture'] = $profile_picture_path;

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        auth()->login($user);

        // Redirect to the home page after registration
        return redirect()->route('user.home');

    }
    
    public function logout()
    {
        Auth::guard('user')->logout();

        return redirect()->route('user.login');
    }
}
