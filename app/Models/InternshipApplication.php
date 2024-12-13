<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    // Define the name of the view
    protected $table = 'internships_with_applications';
    protected $primaryKey = 'internship_id'; // Replace with the actual primary key

    
    public $timestamps = false;
    protected $fillable = [
        'internship_id', 'internship_name', 'city', 'status', 'salary', 'about', 'requirements',
        'company_id', 'company_name', 'applicant_name', 'application_status', 'resume', 'cover_letter',
    ];

    
    
}
