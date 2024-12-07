<?php

namespace App\Http\Controllers\Company;

use App\Models\Internship;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipApplication;

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
            'status' => 'required|in:full-time,part-time',
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
    

        $company_id = auth()->user()->company_id; // Adjust to match your relationship and field name

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('internship_images', 'private'); // Save image in storage/app/public/internship_images
        }
    // Create the internship with the authenticated company's ID
    Internship::create([
        'internship_name' => $validated['internship_name'],
        'city' => $validated['city'],
        'status' => $validated['status'],
        'salary' => $validated['salary'],
        'about' => $validated['about'],
        'requirements' => $validated['requirements'],
        'company_id' => $company_id,
        'image' => $imagePath, // Store the image path in the database
        'duration' => $request->duration,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'benefits' => $request->benefits,
        'application_deadline' => $request->application_deadline,
        'tags' => $request->tags,
    ]);

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
    $user = $application->user; // Get the user who applied for the internship

    // Get the internship and company name
    $internship = $application->internship; // Assuming 'internship' is a relationship on the Application model
    $companyName = $internship->company->company_name; // Get the company name via the internship model

    // Update the application status
    $application->update(['status' => $request->status]);

    // Send a notification to the user based on the status update
    $this->sendNotificationToUser($user->id, $request->status, $internship->internship_name, $companyName);

    return back()->with([
        'success' => true,
        'message' => 'Application status updated successfully.',
    ]);
}

private function sendNotificationToUser($userId, $status, $internshipName, $companyName)
{
    // Debugging: Check the variables

    // Prepare the message based on the application status
    $message = $status == 'accepted'
        ? "Your application for the internship '$internshipName' at '$companyName' has been accepted."
        : ($status == 'rejected'
            ? "Your application for the internship '$internshipName' at '$companyName' has been rejected."
            : "Your application for the internship '$internshipName' at '$companyName' is under review.");

    // Create the notification and save it to the database
    Notification::create([
        'user_id' => $userId,
        'user_type' => 'user', // Targeting the regular user
        'type' => 'application_status', // Type of notification
        'message' => $message,
    ]);
}



    

    



}
