<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipApplication;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return inertia('Admin/Dashboard');
    }

    public function companyApp()
    {

        $companies = Company::all(); // Fetch all companies
        return inertia('Admin/CompanyApp', ['companies' => $companies]);
        
    }

    public function updateCompanyVerification(Request $request, $company_id)
{
    $company = Company::where('company_id', $company_id)->firstOrFail();

    $request->validate([
        'isVerified' => 'required|boolean',
    ]);

    $company->isVerified = $request->isVerified;
    $company->save();
 // Check if the status is "Rejected" (isVerified = false)
 if (!$request->isVerified && Auth::guard('company')->id() == $company->company_id) {
    Auth::guard('company')->logout(); // Log out the company user
    session()->invalidate(); // Invalidate the session
        session()->regenerateToken(); // Regenerate the session token
}

return back()->with('success', 'Company verification status updated successfully.');
}

public function viewUsers()
{
    // Fetch users and calculate total applications for each user using the scalar function
    $users = User::select('id', 'first_name', 'last_name', 'email', 'profile_picture')->get();

    // Add the total applications for each user
    foreach ($users as $user) {
        // Prepend the storage path to the profile_picture
        $user->profile_picture = $user->profile_picture
            ? asset('storage/' . $user->profile_picture)
            : null;

        // Call the scalar function total_applications with the user's id
        $totalApplications = DB::select('SELECT total_applications(?)', [$user->id]);

        // Add total applications to the user object
        $user->total_applications = $totalApplications[0]->total_applications ?? 0;  // Default to 0 if null
    }

    // Pass the data to the Inertia component
    return inertia('Admin/DisplayUsers', ['users' => $users]);
}

    

    public function viewCompanies()
{
    $companies = Company::select('company_id', 'company_logo', 'company_name', 'email')->get();

    // Prepend the storage path to the company_logo field
    foreach ($companies as $company) {
        $company->company_logo = $company->company_logo
            ? asset('storage/' . $company->company_logo)
            : null;
    }

    return inertia('Admin/ViewCompanies', ['companies' => $companies]);
}


public function studentInternshipApplications($id = null)
{
    if ($id) {
        // If an id is provided, fetch applications for a specific student
        $applications = DB::select('SELECT * FROM get_student_applications(?)', [$id]);
    } else {
        // If no id is provided, fetch all internship applications for all students
        $applications = DB::select('SELECT * FROM get_all_internship_applications()');
    }

    // Pass the applications data to the Inertia component
    return inertia('Admin/StudentInternshipApplications', [
        'applications' => $applications,
    ]);
}




    

    
    
    
}
