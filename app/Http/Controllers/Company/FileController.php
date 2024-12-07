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
    
        if ($application->company_id !== auth()->user()->company_id) {
            abort(403, "Unauthorized access to internship ID {$internshipId}");
        }
                
            // Determine the file path
            $filePath = $type === 'resume' ? $application->resume : ($type === 'cover_letter' ? $application->cover_letter : null);    
        // Debugging file path
        
        if (!Storage::disk('private')->exists($filePath)) {
            abort(404, "File not found: {$filePath}");
        }



        $applicantFullName = str_replace(' ', '_', $application->applicant_name); // Replace spaces with underscores

        $customFileName = $type === 'resume' 
        ? "{$applicantFullName}_resume.pdf" 
        : "{$applicantFullName}_coverletter.pdf";
    
        return Storage::disk('private')->download($filePath, $customFileName);
    }
    
}
