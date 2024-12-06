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

    // Specify the fillable fields to allow mass assignment
    protected $fillable = [
        'internship_name',
        'city',
        'status',
        'salary',
        'about',
        'requirements',
        'company_id',  // FK linking to company table
    ];

    // Define relationships if necessary
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id'); // Link 'company_id' to 'id' of company
    }
}
