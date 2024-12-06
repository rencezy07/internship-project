<?php

namespace App\Http\Controllers\User;

use App\Models\Internship;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
{
    // Get the authenticated user using the default guard (assuming 'web' guard)
    $user = auth()->user();

    // Retrieve all internships
    $internships = Internship::all();

    // Pass the user data and internships to the view via Inertia
    return inertia('User/Dashboard', [
        'internships' => $internships,
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
        ]
    ]);
}


        public function apply(Request $request, $internshipId)
        {
            // Validate the uploaded files
            $request->validate([
                'documents.resume' => 'required|file|mimes:pdf,doc,docx|max:10240', // Resume file validation
                'documents.cover_letter' => 'required|file|mimes:pdf,doc,docx|max:10240', // Cover letter file validation
            ]);
        
            // Store the files and create the application record
            Application::create([
                'user_id' => auth()->id(),
                'internship_id' => $internshipId,
                'resume' => $request->file('documents.resume')->store('applications', 'public'),
                'cover_letter' => $request->file('documents.cover_letter')->store('applications', 'public'),
                'status' => 'under review',
            ]);
        
            return back()->with('success', 'Your application is under review.');
        }

        public function showApplications()
        {
            $applications = Application::where('user_id', Auth::id())
            ->with('internship')  // Eager load the 'internship' relation
            ->get();
    
        return inertia('User/Application', [
            'applications' => $applications,
        ]);
        }
}    
