<?php

namespace App\Http\Controllers\Auth\Userfile;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserRegisterController extends Controller
{
    public function create() {
        return Inertia::render('Auth/User/Register');
    }

    public function store(Request $request) {
     $credentials = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|lowercase|email|max:255',
        'password' => 'required|confirmed|min:3',
     ]);

     $user = User::create($credentials);
     
     Auth::login($user);

     return redirect()->route('home');
    }
}
