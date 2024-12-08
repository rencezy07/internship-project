<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipWithCompany;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        $internships = InternshipWithCompany::all(); // Adjust this to your model and data as needed
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

   

    public function logout()
    {
        Auth::guard('user')->logout();

        return redirect()->route('user.login');
    }
}
