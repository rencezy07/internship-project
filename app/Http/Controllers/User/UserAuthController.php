<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\InternshipWithCompany;
use Illuminate\Support\Facades\DB;


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
        // Update last_login_at for the authenticated user
        $user = Auth::guard('user')->user();
        $user->last_login_at = now();
        $user->save();

        // Redirect to user home
        return redirect()->route('user.home');
    }

    return back()->withErrors(['email' => 'Invalid Credentials']);
}

    public function showRegister() {
        return inertia('User/Auth/Register');
    }
    public function Register(Request $request) {

        $existingUser = User::where('email', $request->email)->exists();
       
        if ($existingUser) {
            return back()->withErrors([
                'email' => 'An account with this email already exists.',
            ]);
        }
        

        
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

        auth('user')->login($user);

        // Redirect to the home page after registration
        return redirect()->route('user.home');

    }
    
    public function logout()
    {
        // Get the authenticated user
        $user = Auth::guard('user')->user();
    
        if ($user) {
            // Update the last_logout_at field to trigger the log
            $user->last_logout_at = now();
            $user->save();
        }
    
        // Perform the logout
        Auth::guard('user')->logout();
    
        // Redirect to the login page
        return redirect()->route('user.login');
    }
    

    public function showProfile()
{
    $user = auth()->user();

    return inertia('User/Profile', [
        'user' => [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'dob' => $user->dob,
            'phone_number' => $user->phone_number,
            'gender' => $user->gender,
            'university' => $user->university,
            'college_level' => $user->college_level,
            'profile_picture' => $user->profile_picture,
            'avatar' => $user->avatar ?? null, // Ensure avatar is included even if null

        ],
    ]);
}public function updateProfile(Request $request)
{
    $user = auth()->user();

    // Validate inputs
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'current_password' => 'required_if:google_id,null|string', // Only required if not a Google user
        'new_password' => 'nullable|string|confirmed|min:8', // Optional new password
        'dob' => 'required|date',
        'phone_number' => 'required|string|max:15',
        'gender' => 'required|in:male,female,other',
        'university' => 'required|string|max:255',
        'college_level' => 'required|in:freshman,sophomore,junior,senior',
        'profile_picture' => 'nullable|file|image|max:2048',
    ]);

    // Bypass password check for Google users
    if ($user->google_id === null && !Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
    }

    // Handle profile picture upload if provided
    if ($request->hasFile('profile_picture')) {
        $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
    } else {
        // Keep the existing profile picture if no new file is uploaded
        $validated['profile_picture'] = $user->profile_picture;
    }

    // Update the password if a new password is provided
    if (!empty($validated['new_password'])) {
        $validated['password'] = Hash::make($validated['new_password']);
    } else {
        unset($validated['password']); // Do not update the password if new_password is not provided
    }

    $user->update($validated);

    return back()->with('success', 'Profile updated successfully!');
}


public function destroy(Request $request)
{
    $user = auth()->user();

    // Log the account deletion in the activity_logs table
    DB::table('activity_logs')->insert([
        'user_type' => 'user',
        'user_id' => $user->id,
        'action_performed' => 'User "' . $user->first_name . '" (ID: ' . $user->id . ') deleted their account',
        'table_name' => 'users',
        'created_at' => now(),
    ]);

    // Check if the user logged in via Google
    if ($user->google_id) {
        // Google users do not have a password, so skip password validation
        $user->delete();

        // Log the user out
        auth()->logout();

        // Redirect to the login page or home
        return redirect()->route('user.login')->with('success', 'Your account has been deleted successfully.');
    }

    // Validate the current password for non-Google users
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'The password is incorrect.']);
    }

    // Delete the user
    $user->delete();

    // Log the user out after deletion
    auth()->logout();

    // Redirect to the login page or home
    return redirect()->route('user.login')->with('success', 'Your account has been deleted successfully.');
}





}
