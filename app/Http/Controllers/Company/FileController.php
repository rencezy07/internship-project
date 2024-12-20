<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download($type, $internshipId)
    {
        $application = InternshipApplication::findOrFail($internshipId);
    
        // Check if the authenticated company owns the application
        if ($application->company_id !== auth()->user()->company_id) {

            abort(403, "Unauthorized access to internship ID {$internshipId}");
        }
    
        // Determine the correct file path based on type
        $filePath = $type === 'resume' 
            ? $application->resume  // Ensure $application->resume contains just the filename
            : ($type === 'cover_letter' ? $application->cover_letter : null);
    
        // If no valid file type is provided
        if (!$filePath) {
            abort(400, "Invalid file type or file path not set.");
        }
    
        // Build the full file path in the `private/applications` directory
        $fullPath = "applications/{$filePath}";
    
        // Check if the file exists
        if (!Storage::disk('private')->exists($fullPath)) {
            abort(404, "File not found: {$fullPath}");
        }
    
        // Build custom filename for download
        $applicantFullName = str_replace(' ', '_', $application->applicant_name);
        $customFileName = $type === 'resume' 
            ? "{$applicantFullName}_resume.pdf" 
            : "{$applicantFullName}_coverletter.pdf";
    
        // Return the file for download
return response()->file(Storage::disk('private')->path($filePath), [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'inline; filename="' . $customFileName . '"',
]);
    }
    
    
}
