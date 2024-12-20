<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // Use your user model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

            // Split full name into first_name and last_name
            $fullName = $googleUser->getName();
            $nameParts = explode(' ', $fullName, 2);
            $firstName = $nameParts[0]; // First part is the first name
            $lastName = $nameParts[1] ?? 'Google User'; // Second part is last name, or default

            // Check if the user already exists or create a new one
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'google_id' => $googleUser->getId(),
                    'profile_picture' => $this->saveProfilePicture($googleUser->getAvatar()), // Save profile picture locally
                    'password' => bcrypt(Str::random(16)), // Default random password
                    'phone_number' => 'N/A', // Placeholder
                    'gender' => 'other', // Placeholder for gender
                    'university' => 'N/A', // Placeholder for university
                    'college_level' => 'freshman', // Placeholder for college level
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

    /**
     * Save profile picture locally.
     */
    protected function saveProfilePicture($url)
    {
        try {
            $contents = file_get_contents($url); // Download the image from the URL
            $fileName = 'profile_pictures/' . uniqid() . '.jpg'; // Generate a unique filename
            Storage::disk('public')->put($fileName, $contents); // Save to public storage
            return $fileName; // Return the relative path to save in the database
        } catch (\Exception $e) {
            \Log::error('Failed to save profile picture', ['error' => $e->getMessage()]);
            return null; // Return null if the image could not be saved
        }
    }
}
