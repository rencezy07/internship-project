<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'user_type', 'type', 'message', 'read'];

    // Polymorphic relationship: The notification belongs to a user (admin, company, or user)
    public function user()
    {
        return $this->morphTo();
    }
}

