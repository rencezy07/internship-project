<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyApplicationSummary extends Model
{
    // Specify the table name for the materialized view
    protected $table = 'company_applications_summary';

    // Disable timestamps since materialized views don't have created_at or updated_at
    public $timestamps = false;

    // Optionally, protect against mass assignment
    protected $guarded = [];
}
