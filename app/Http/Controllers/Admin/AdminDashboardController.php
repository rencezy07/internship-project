<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    

    // Manually validate the request
    $validated = $request->validate([
        'isVerified' => 'required|boolean', // Ensure it's a boolean value
    ]);

  
    // Now update the company record if validation passes
    $company->isVerified = $validated['isVerified'];
    $company->save();

    // Return a success message with a redirect
    return redirect()->route('admin.companyapp')->with('success', 'Company verification status updated.');
}


    
}
