<?php

namespace App\Http\Controllers\User;

use App\Models\Application;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipWithCompany;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();
    
        // Fetch the latest notifications
        $notifications = Notification::where('user_id', $user->id)->get();
    
        // Fetch internships related to the user
        $internships = InternshipWithCompany::whereNotIn('id', function ($query) {
            $query->select('internship_id')
                ->from('applications')
                ->where('user_id', auth()->id());
        })->get();
    
        // Pass the data to Inertia
        return inertia("User/Dashboard", [
            "notifications" => $notifications,
            "internships" => $internships,
            "user" => [
                "name" => $user->name,
            ],
        ]);
    }

    // Handle the internship application
    public function apply(Request $request, $internshipId)
    {
        // Validate the uploaded files
        $request->validate([
            "documents.resume" => "required|file|mimes:pdf,doc,docx|max:10240",
            "documents.cover_letter" => "required|file|mimes:pdf,doc,docx|max:10240",
        ]);

        // Check if the user has already applied to this internship
        $existingApplication = Application::where("user_id", auth()->id())
            ->where("internship_id", $internshipId)
            ->first();

        if ($existingApplication) {
            return back()->with("error", "You have already applied to this internship.");
        }

        // Store the uploaded files
        try {
            $resumePath = $request
                ->file("documents.resume")
                ->storeAs("applications/" . auth()->id(), "resume_" . time() . "." . $request->file('documents.resume')->getClientOriginalExtension(), "private");

            $coverLetterPath = $request
                ->file("documents.cover_letter")
                ->storeAs("applications/" . auth()->id(), "cover_letter_" . time() . "." . $request->file('documents.cover_letter')->getClientOriginalExtension(), "private");
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error uploading your files. Please try again.');
        }

        // Create the application record
        Application::create([
            "user_id" => auth()->id(),
            "internship_id" => $internshipId,
            "resume" => $resumePath,
            "cover_letter" => $coverLetterPath,
            "status" => "under review", // Set the initial status
        ]);

        return back()->with("success", "Your application has been submitted and is under review.");
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

    // Reject the internship application
    public function rejectApplication($internshipId)
    {
        $application = Application::where("user_id", auth()->id())
            ->where("internship_id", $internshipId)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found or already processed.');
        }

        $application->update(["status" => "rejected"]); // or set 'is_rejected' to true

        return redirect()->back()->with("success", "Application has been rejected.");
    }
}
