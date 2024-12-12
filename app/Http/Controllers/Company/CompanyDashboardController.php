<?php

namespace App\Http\Controllers\Company;

use App\Models\Internship;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipApplication;
use App\Notifications\ApplicationStatusNotification;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        return inertia('Company/Dashboard');
    }
   
    public function showInternship()
    {
        // Get the authenticated company ID
        $companyId = Auth::guard('company')->id();

        // Fetch internships related to the logged-in company
        $internships = Internship::where('company_id', $companyId)->get();

        // Return the data to the view via Inertia
        return inertia('Company/Internships', [
            'internships' => $internships,
        ]);
    }



    public function storeInternship(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'internship_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'employment_type' => 'required|string|in:full-time,part-time',
            'is_open' => 'required|boolean', // Validate the new is_open field
            'salary' => 'required|numeric',
            'about' => 'required|string',
            'requirements' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048', // Validate image
            'duration' => 'required|string|max:255', // Now required
            'start_date' => 'required|date', // Now required
            'end_date' => 'required|date', // Now required
            'benefits' => 'required|string', // Now required
            'application_deadline' => 'required|date', // Now required
            'tags' => 'required|string', // Now required

        ]);
        $validated['company_id'] = auth()->user()->company_id;



        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('internship_images', 'public');

        }
    // Create the internship with the authenticated company's ID
    Internship::create($validated);

    return redirect()->route('company.internships')->with('success', 'Internship created successfully');

    }
    


    // user under review ---------------------------

    public function manageInternships()
{
    // Get all the internships for the logged-in company
    $companyId = Auth::guard('company')->id();

    $internships = InternshipApplication::where('company_id', $companyId)
    ->get();
    // Pass internships and applications to the view via Inertia
    return inertia('Company/ManageInternships', [
        'internships' => $internships,
    ]);
}

// To update the application status
public function updateApplicationStatus(Request $request, $applicationId)
{
    // Validate the request data
    $request->validate([
        'status' => 'required|in:under review,accepted,rejected',
    ]);

    // Find the application and update the status
    $application = Application::findOrFail($applicationId);

    // Retrieve the user who applied for the internship (ensure 'user' is a relationship)
    $user = $application->user;

    // Get the internship and company name
    $internship = $application->internship; // Assuming 'internship' is a relationship on the Application model
    $companyName = $internship->company->company_name; // Get the company name via the internship model

    // Update the application status
    $application->update(['status' => $request->status]);

    // Send a notification to the user based on the status update
    $this->sendNotificationToUser($user, $request->status, $internship->internship_name, $companyName);

    return back()->with([
        'success' => true,
        'message' => 'Application status updated successfully.',
    ]);
}


private function sendNotificationToUser($user, $status, $internshipName, $companyName)
{
    // Send notification to the user
    $user->notify(new ApplicationStatusNotification($status, $internshipName, $companyName));
}



    

    



}
