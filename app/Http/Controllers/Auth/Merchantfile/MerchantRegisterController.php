<?php

namespace App\Http\Controllers\Auth\Merchantfile;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class MerchantRegisterController extends Controller
{

    /**
     * Display the registration view.
     */
    public function create() {
        return Inertia::render('Auth/Merchant/Register');
    }

    public function store(Request $request) {
     $credentials = $request->validate([
        'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:merchants,email',
            'phone_number' => 'required|string',
            'business_registration' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'owner_id' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'business_type' => 'required|string|in:Hotel,Resort,Tourist Spot',
            'province' => 'required|string',
            'city' => 'required|string',
            'description' => 'nullable|string|max:300',
            'password' => 'required|string|min:8|confirmed',
     ]);

     if ($request->hasFile('business_registration')) {
        $validated['business_registration'] = $request->file('business_registration')->store('business_documents');
    }

    if ($request->hasFile('owner_id')) {
        $validated['owner_id'] = $request->file('owner_id')->store('owner_documents');
    }

     $merchant = Merchant::create($credentials);
     
     Auth::login($merchant);

     return redirect()->route('merchant');
    }
}