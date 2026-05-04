<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departement;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerRegistrationController extends Controller
{
    /**
     * Show the public customer registration form.
     */
    public function show()
    {
        $departements = Departement::orderBy('name')->get();
        
        // Filter out Management EPP from public registration
        $jabatans = Jabatan::whereRaw("LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) NOT IN (?, ?, ?)", [
            'managementepp',
            'manajemenepp',
            'manajementepp'
        ])->orderBy('name')->get();

        return view('auth.register-customer', compact('departements', 'jabatans'));
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
            'department_id' => ['required', 'integer', 'exists:departements,id'],
            'jabatan_id' => [
                'required', 
                'integer', 
                Rule::exists('jabatans', 'id')->where(function ($query) {
                    $query->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) NOT IN (?, ?, ?)", [
                        'managementepp',
                        'manajemenepp',
                        'manajementepp'
                    ]);
                })
            ],
        ]);

        $user = User::create([
            'username' => $data['username'],
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'department_id' => $data['department_id'],
            'jabatan_id' => $data['jabatan_id'],
        ]);

        return redirect()->route('login')->with('success', 'Akun customer berhasil dibuat. Silakan login.');
    }
}
