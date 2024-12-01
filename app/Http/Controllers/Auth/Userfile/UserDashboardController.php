<?php

namespace App\Http\Controllers\Auth\Userfile;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard');
    }
}
