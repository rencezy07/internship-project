<?php

namespace App\Http\Controllers\Auth\Merchantfile;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MerchantPageController extends Controller
{
    public function index()
    {
        return Inertia::render('Merchant/Home'); // Adjust the path as per your Vue structure
    }
}
