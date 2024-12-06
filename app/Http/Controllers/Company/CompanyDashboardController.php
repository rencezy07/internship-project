<?php

namespace App\Http\Controllers\Company;

use App\Models\Internship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        return inertia('Company/Dashboard');
    }
    public function showInternship()
    {
        return inertia('Company/Internships');
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
        ]);
    

        $company_id = auth()->user()->company_id; // Adjust to match your relationship and field name
    // Create the internship with the authenticated company's ID
    Internship::create([
        'internship_name' => $validated['internship_name'],
        'city' => $validated['city'],
        'status' => $validated['status'],
        'salary' => $validated['salary'],
        'about' => $validated['about'],
        'requirements' => $validated['requirements'],
        'company_id' => $company_id,
    ]);

    return redirect()->route('company.internships')->with('success', 'Internship created successfully');

    }
    
    

    



}
