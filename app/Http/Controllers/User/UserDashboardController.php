<?php

namespace App\Http\Controllers\User;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipWithCompany;
use App\Models\UserApplicationSummary;

class UserDashboardController extends Controller
{   


    public function home()
    {
        $user = auth()->user();
    
        return inertia("User/Home", [
            "notificationCount" => $user->unreadNotifications->count(),
            "notifications" => $user->notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->data['message'] ?? 'No message available', // Extract the message
                    'created_at' => $notification->created_at->toDateTimeString(),
                    'read_at' => $notification->read_at, // Optional: Track read status
                ];
            }),
            "internships" => InternshipWithCompany::all(),
            "user" => [
                "first_name" => $user->first_name,
                "profile_picture" => $user->profile_picture,
                "email" => $user->email, // Add the email field

            ],
        ]);
    }
    

    // Handle the internship application
    public function apply(Request $request, $internshipId)
    {
        // Validate the uploaded files
        $request->validate([
            "documents.resume" => "required|file|mimes:pdf,doc,docx|max:10240",
            "documents.cover_letter" =>
                "required|file|mimes:pdf,doc,docx|max:10240",
        ]);

        // Check if the user has already applied to this internship
        $existingApplication = Application::where("user_id", auth()->id())
            ->where("internship_id", $internshipId)
            ->first();

        if ($existingApplication) {
            return back()->with(
                "error",
                "You have already applied to this internship."
            );
        }

        // Store the uploaded files
        $resumePath = $request
            ->file("documents.resume")
            ->store("applications", "private");
        $coverLetterPath = $request
            ->file("documents.cover_letter")
            ->store("applications", "private");

        // Create the application record
        Application::create([
            "user_id" => auth()->id(),
            "internship_id" => $internshipId,
            "resume" => $resumePath,
            "cover_letter" => $coverLetterPath,
            "status" => "under review", // Set the initial status
        ]);

        return back()->with(
            "success",
            "Your application has been submitted and is under review."
        );
    }

    // Display the list of applications the user has made
    public function showApplications()
    {
        $user = auth()->user();
    
        // Retrieve detailed applications with internship details
        $applications = Application::where("user_id", $user->id)
            ->with("internship") // Eager load the internship details
            ->get();
    
        // Use the Eloquent model to query the summary view
        $applicationSummary = UserApplicationSummary::where('user_id', $user->id)->get();
    
        return inertia("User/Application", [
            "applications" => $applications,
            "notificationCount" => $user->unreadNotifications->count(),
            "notifications" => $user->notifications->toArray(),
            "applicationSummary" => $applicationSummary,
        ]);
    }
    
}
