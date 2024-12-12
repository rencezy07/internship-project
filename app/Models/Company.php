<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'company'; // Explicitly define the table name
    protected $primaryKey = 'company_id';

    // Add the new fields to the $fillable array
    protected $fillable = [
        'company_name',
        'email',
        'password',
        'location',          // Added location
        'company_logo',      // Added company_logo
        'business_permit',   // Added business_permit
        'isVerified',       // Make sure 'is_verified' is also fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the internships for the company.
     */
    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
