<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserApplicationSummary extends Model
{
    // Define the table name for the SQL view
    protected $table = 'user_applications_summary';

    // Prevent Laravel from expecting a primary key
    public $incrementing = false;
    protected $primaryKey = null;

    // Prevent timestamps as views don't typically have them
    public $timestamps = false;

    // Define any fillable or guarded fields, if necessary
    protected $fillable = [
        'user_id',
        'user_name',
        'internship_id',
        'internship_name',
        'company_name',
        'total_applications',
        'under_review_count',
        'accepted_count',
        'rejected_count',
    ];
}
