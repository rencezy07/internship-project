<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        return inertia('User/Auth/Login');
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
