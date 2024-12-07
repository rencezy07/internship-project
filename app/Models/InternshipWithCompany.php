<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipWithCompany extends Model
{
    protected $table = 'internships_with_company'; // Name of the view
    public $timestamps = false; // Views don’t have timestamps
}
