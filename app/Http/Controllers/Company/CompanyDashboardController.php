<?php

namespace App\Http\Controllers\Company;
use Inertia\Inertia;

use App\Models\Internship;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\InternshipApplication;
use App\Notifications\ApplicationStatusNotification;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $companyId = Auth::guard('company')->id();
    
        if (!$companyId) {
            abort(403, 'Unauthorized');
        }
    
        $totalApplications = Application::whereHas('internship', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->count();
    
        $underReviewApplications = Application::whereHas('internship', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->where('status', 'under review')->count();
    
        $acceptedApplications = Application::whereHas('internship', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->where('status', 'accepted')->count();
    
        $rejectedApplicationsCount = Application::whereHas('internship', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->where('status', 'rejected')->count();
    
        // Load the 'internship' and 'user' relationships for recent applications
        $recentApplications = Application::whereHas('internship', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
            ->with(['internship', 'user']) // Eager load the relationships
            ->latest()
            ->take(5)
            ->get();
    
        return Inertia::render('Company/Dashboard', [
            'totalApplications' => $totalApplications,
            'underReviewApplications' => $underReviewApplications,
            'acceptedApplications' => $acceptedApplications,
            'rejectedApplicationsCount' => $rejectedApplicationsCount,
            'recentApplications' => $recentApplications,
            'auth' => ['user' => auth()->user()],
        ]);
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

    public function manageInternshipsApplication()
{
    // Get all the internships for the logged-in company
    $companyId = Auth::guard('company')->id();

    $internships = InternshipApplication::where('company_id', $companyId)
    ->get();
    // Pass internships and applications to the view via Inertia
    return inertia('Company/ManageInternshipsApplication', [
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


public function profile()
{
    $company = Auth::guard('company')->user();

    return inertia('Company/Profile', [
        'company' => $company->only('company_id', 'company_name', 'email', 'location', 'company_logo', 'business_permit'),
    ]);
}

public function updateProfile(Request $request)
{
    // Check if the company is authenticated
    if (!Auth::guard('company')->check()) {
        return redirect()->route('company.login')->with('error', 'You need to log in to update your profile.');
    }

    $company = Auth::guard('company')->user();

    // Validate the request
    $validated = $request->validate([
        'company_name' => 'required|string|max:255',
        'email' => 'required|email|unique:company,email,' . $company->company_id . ',company_id',
        'location' => 'required|string|max:255',
        'company_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'business_permit' => 'nullable|mimes:pdf|max:4096',
        'password' => 'required|string',
        'new_password' => 'nullable|string|min:8|same:confirm_password',
    ]);

    // Verify the current password
    if (!Hash::check($validated['password'], $company->password)) {
        return back()->withErrors(['password' => 'The provided password is incorrect.']);
    }

    try {
        // Handle file uploads
        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $request->file('company_logo')->store('company_logos', 'public');
        }

        if ($request->hasFile('business_permit')) {
            $validated['business_permit'] = $request->file('business_permit')->store('business_permits', 'public');
        }

        // Update the password if a new password is provided
        if (!empty($validated['new_password'])) {
            $company->password = bcrypt($validated['new_password']);
        }

        // Update the company's details
        $company->update([
            'company_name' => $validated['company_name'],
            'email' => $validated['email'],
            'location' => $validated['location'],
            'company_logo' => $validated['company_logo'] ?? $company->company_logo,
            'business_permit' => $validated['business_permit'] ?? $company->business_permit,
        ]);

        return redirect()->route('company.profile')
                         ->with('success', 'Profile updated successfully.');
    } catch (\Exception $e) {
        // Handle any unexpected errors
        return back()->with('error', 'Something went wrong. Please try again later.');
    }
}



public function manageAllInternships()
{
    // Fetch internships for the logged-in company
    $companyId = Auth::guard('company')->id();
    $internships = Internship::where('company_id', $companyId)->get();

    return inertia('Company/ManageInternships', [
        'internships' => $internships,
    ]);
}

public function manageInternships()
{
    $companyId = Auth::guard('company')->id();
    $internships = Internship::where('company_id', $companyId)->get();

    // Ensure the component you're trying to load exists and is correctly named
    return inertia('Company/ManageInternships', [
        'internships' => $internships,
    ]);
}

public function updateInternship(Request $request, $internshipId)
{
    $validated = $request->validate([
        'internship_name' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'salary' => 'required|numeric',
        'is_open' => 'required|boolean',
        // Add other validation rules as needed
    ]);

    $internship = Internship::findOrFail($internshipId);
    $internship->update($validated);

    return back()->with('success', 'Internship updated successfully.');

}

public function deleteInternship($internshipId)
{
    // Find and delete the internship
    $internship = Internship::findOrFail($internshipId);
    $internship->delete();

    return back()->with('success', 'Internship Deleted Successfully.');

}


}
