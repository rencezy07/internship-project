<?php

namespace App\Http\Controllers\Auth\Merchantfile;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MerchantAuthenticateController extends Controller
{
    /**
     * Show the login page for merchants.
     */
    public function create()
    {
        return Inertia::render('Auth/Merchant/Login', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle merchant login.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::guard('merchant')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
    
            return redirect()->intended(route('merchant.dashboard'));
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    

    /**
     * Handle merchant logout.
     */
    public function destroy(Request $request)
    {
        Auth::guard('merchant')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('merchant.login');
    }
}
