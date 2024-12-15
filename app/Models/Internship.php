<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Internship.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    // Define the table name if it differs from the default plural form
    protected $table = 'internships';

    protected $primaryKey = 'internship_id';  // Set primary key as 'internship_id'

    // Specify the fillable fields to allow mass assignment
    protected $fillable = [
        'internship_name',
        'city',
        'employment_type',
        'is_open',
        'salary',
        'about',
        'requirements',
        'company_id',  // FK linking to company table
        'image',
        'duration',
        'start_date',
        'end_date',
        'benefits',
        'application_deadline',
        'tags',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'internship_id');  // An internship has many applications
    }
    // Define relationships if necessary
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id'); // Link 'company_id' to 'id' of company
    }

    // Internship Model

}
