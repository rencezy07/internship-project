<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    public function updateCompanyVerification(Request $request, Company $company)
    {
        $request->validate([
            'isVerified' => 'required|boolean', // Validate the input as boolean
        ]);
    
        $company->isVerified = $request->isVerified; // Update the isVerified field
        $company->save(); // Save the changes to the database
    return back()->with([
    'success' => 'Company verification status updated successfully.',
    'isVerified' => $company->isVerified,
]);
    }
    public function viewUsers()
    {
        $users = User::select('id', 'first_name', 'last_name', 'email', 'profile_picture')->get();
    
        // Prepend the storage path to the profile_picture
        foreach ($users as $user) {
            $user->profile_picture = $user->profile_picture
                ? asset('storage/' . $user->profile_picture)
                : null;
        }
    
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


public function studentInternshipApplications()
{
    $applications = InternshipApplication::all();

    // Pass data to the frontend
    return inertia('Admin/StudentInternshipApplications', [
        'applications' => $applications,
    ]);
}






    

    
    
    
}
