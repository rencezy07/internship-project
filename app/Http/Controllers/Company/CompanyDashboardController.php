<?php

namespace App\Http\Controllers\Company;

use App\Models\Internship;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        ]);
    

        $company_id = auth()->user()->company_id; // Adjust to match your relationship and field name

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('internship_images', 'public'); // Save image in storage/app/public/internship_images
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
    ]);

    return redirect()->route('company.internships')->with('success', 'Internship created successfully');

    }
    


    // user under review ---------------------------

    public function manageInternships()
{
    // Get all the internships for the logged-in company
    $internships = Internship::where('company_id', auth()->id()) // Assuming company_id is used to associate internships with companies
        ->with('applications.user')  // Eager load applications and user data for each internship
        ->get();

    // Pass internships and applications to the view via Inertia
    return inertia('Company/ManageInternships', [
        'internships' => $internships,
    ]);
}

// To update the application status
public function updateApplicationStatus(Request $request, $applicationId)
{
    $request->validate([
        'status' => 'required|in:under review,accepted,rejected',
    ]);

    // Find the application and update the status
    $application = Application::findOrFail($applicationId);
    $application->update(['status' => $request->status]);

    // Return a response indicating success
    return inertia('Company/ManageInternships');

}

    

    



}
