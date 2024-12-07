<?php

namespace App\Http\Controllers\User;

use App\Models\Internship;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    // Display internships in the dashboard
    public function index()
    {
        // Get the authenticated user using the default guard
        $user = auth()->user();

        // Retrieve all internships and add application status
        $internships = Internship::with([
            "applications" => function ($query) use ($user) {
                $query->where("user_id", $user->id); // Filter by current user's application
            },
        ])->get();

        // Pass the internships with the application status to the view via Inertia
        return inertia("User/Dashboard", [
            "internships" => $internships,
            "user" => [
                "name" => $user->name,
                "email" => $user->email,
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
            ->store("applications", "public");
        $coverLetterPath = $request
            ->file("documents.cover_letter")
            ->store("applications", "public");

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
        $applications = Application::where("user_id", Auth::id())
            ->with("internship") // Eager load the internship details
            ->get();

        return inertia("User/Application", [
            "applications" => $applications,
        ]);
    }

    public function rejectApplication($internshipId)
    {
        $application = Application::where("user_id", auth()->id())
            ->where("internship_id", $internshipId)
            ->first();

        if ($application) {
            $application->update(["status" => "rejected"]); // or set 'is_rejected' to true
        }

        return redirect()
            ->back()
            ->with("success", "Application has been rejected.");
    }
}
