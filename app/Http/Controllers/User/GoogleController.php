<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // Use your user model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email']) // Add required scopes
            ->redirect();
    }
    

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if the user already exists
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'first_name' => $googleUser->getName(), // Use Google's name as first_name
                    'last_name' => 'Google User', // Placeholder for last_name
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(16)), // Default random password
                    'phone_number' => 'N/A', // Placeholder
                    'gender' => 'other', // Placeholder for gender
                    'university' => 'N/A', // Placeholder for university
                    'college_level' => 'freshman', // Placeholder for college_level
                    'dob' => now()->subYears(18)->toDateString(), // Placeholder DOB
                ]
            );

            // Log the user in using the `user` guard
            Auth::guard('user')->login($user);

            // Redirect to the user homepage
            return redirect()->route('user.home');
        } catch (\Exception $e) {
            \Log::error('Google Login Error', ['error' => $e->getMessage()]);
            return redirect()->route('user.login')->with('error', 'Google login failed. Please try again.');
        }
    }
}