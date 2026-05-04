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
        } elseif ($role === 'management-epp' || auth()->user()->isManagementEpp()) {
            return redirect()->route('management-epp.dashboard');
        } elseif ($role === 'management-customer' || auth()->user()->isManagementCustomer()) {
            return redirect()->route('management-customer.dashboard');
        } elseif ($role === 'customer') {
            return redirect()->route('customer.dashboard');
        }

        abort(403, 'Role tidak dikenali');
    }
}
