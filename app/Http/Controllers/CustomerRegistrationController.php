<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerRegistrationController extends Controller
{
    /**
     * Show the public customer registration form.
     */
    public function show()
    {
        return view('auth.register-customer');
    }

    /**
     * Handle new customer registration.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'username' => $data['username'],
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        return redirect()->route('login')->with('success', 'Akun customer berhasil dibuat. Silakan login.');
    }
}