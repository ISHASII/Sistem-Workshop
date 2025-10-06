<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Redirect to role-specific dashboard routes
        $role = auth()->user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'customer') {
            return redirect()->route('customer.dashboard');
        }

        abort(403, 'Role tidak dikenali');
    }
}
