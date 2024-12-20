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

use App\Models\CompanyApplicationSummary;


class AdminDashboardController extends Controller
{
    public function index()
    {

            // Get the application status distribution
    $statusSummary = DB::table('applications')
    ->select('status', DB::raw('COUNT(*) as total'))
    ->groupBy('status')
    ->get();

    // Data for line chart: user signups per month
    $userTrends = DB::table('users')
    ->select(DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as total"))
    ->groupBy('month')
    ->orderBy('month')
    ->get();

        $totalUsers = User::count(); // Total users
        $totalCompanies = Company::count(); // Total companies
        $totalApplications = InternshipApplication::count(); // Total applications
        $verifiedCompanies = Company::where('isVerified', true)->count(); // Verified companies
        $underReviewApplications = InternshipApplication::where('application_status', 'under review')->count(); // Applications under review
    
        // Fetch the most recent users and companies
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $recentCompanies = Company::orderBy('created_at', 'desc')->take(5)->get();
    
        return inertia('Admin/Dashboard', [
            'statusSummary' => $statusSummary,

            'userTrends' => $userTrends,
            'totalUsers' => $totalUsers,
            'totalCompanies' => $totalCompanies,
            'totalApplications' => $totalApplications,
            'verifiedCompanies' => $verifiedCompanies,
            'underReviewApplications' => $underReviewApplications,
            'recentUsers' => $recentUsers,
            'recentCompanies' => $recentCompanies,
        ]);
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
    $users->transform(function ($user) {
        // Prepend the storage path to the profile_picture
        $user->profile_picture = $user->profile_picture
            ? asset('storage/' . $user->profile_picture)
            : null;

        // Fetch total applications for this user
        $result = DB::select('SELECT total_applications(?) AS total_applications', [$user->id]);

        // Assign the total applications count (ensure result exists)
        $user->total_applications = !empty($result) && isset($result[0]->total_applications)
            ? (int) $result[0]->total_applications
            : 0;

        return $user;
    });

    // Pass the data to the Inertia component
    return inertia('Admin/DisplayUsers', ['users' => $users]);
}

public function viewCompanies()
{
    $companies = Company::select('company_id', 'company_logo', 'company_name', 'email')->get();

    // Iterate through each company to add total internships and company logo paths
    foreach ($companies as $company) {
        // Prepend the storage path to the company_logo field
        $company->company_logo = $company->company_logo
            ? asset('storage/' . $company->company_logo)
            : null;

        // Fetch total internships for the current company
        $totalInternships = DB::select('SELECT total_internships_by_company(?) AS total', [$company->company_id]);
        $company->total_internships = $totalInternships[0]->total ?? 0; // Default to 0 if null
    }


// Fetch the materialized view data
$summaries = CompanyApplicationSummary::all();



    // Return the companies data to the view
    return inertia('Admin/ViewCompanies', [
        'companies' => $companies,
        'summaries' => $summaries, // Pass the materialized view data
]);
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


// activity logsssss

public function activityLogs(Request $request)
    {
        // Start the query for activity_logs
        $query = DB::table('activity_logs')->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('action_performed')) {
            $query->where('action_performed', $request->action_performed);
        }

        if ($request->filled('table_name')) {
            $query->where('table_name', $request->table_name);
        }

        if ($request->filled('column_name')) {
            $query->where('column_name', $request->column_name);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Paginate the results
        $activityLogs = $query->paginate(10)->appends($request->all());

        return Inertia::render('Admin/ActivityLogs', [
            'activityLogs' => $activityLogs,
            'filters' => $request->all(),
        ]);
    }

}
