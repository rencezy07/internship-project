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
        // $internships = InternshipWithCompany::select('internship_name', 'company_name', 'city', 'employment_type', 'is_open')->get();// Adjust this to your model and data as needed
        // return inertia('User/Auth/Login', [
        //     'internships' => $internships, // Send internships to the frontend

        // ]);

            return inertia('User/Auth/Login');

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');



        if (Auth::guard('user')->attempt($credentials)) {
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
        Auth::guard('user')->logout();

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
        ],
    ]);
}
public function updateProfile(Request $request)
{
    $user = auth()->user();

    // Validate inputs
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'current_password' => 'required|string', // Current password is required
        'new_password' => 'nullable|string|confirmed|min:8', // Optional new password
        'dob' => 'required|date',
        'phone_number' => 'required|string|max:15',
        'gender' => 'required|in:male,female,other',
        'university' => 'required|string|max:255',
        'college_level' => 'required|in:freshman,sophomore,junior,senior',
        'profile_picture' => 'nullable|file|image|max:2048',
    ]);

    // Verify the current password
    if (!Hash::check($request->current_password, $user->password)) {
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


}
