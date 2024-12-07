<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'internship_id', 'resume','cover_letter', 'status'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Internship
    public function internship()
    {
        return $this->belongsTo(Internship::class, 'internship_id', 'internship_id'); // foreignKey, ownerKey
    }

    public function applications()
{
    return $this->hasMany(Application::class, 'internship_id');
}

}
