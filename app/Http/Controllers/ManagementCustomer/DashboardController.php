<?php

namespace App\Http\Controllers\ManagementCustomer;

use App\Http\Controllers\Controller;
use App\Models\JobOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->loadMissing(['departement', 'jabatan']);

        $baseQuery = JobOrder::whereHas('creator', function ($query) use ($user) {
            $query->where('department_id', $user->department_id);
        });

        $pendingCount = (clone $baseQuery)->pendingApproval()->count();
        $approvedCount = (clone $baseQuery)->approvedApproval()->count();
        $rejectedCount = (clone $baseQuery)->rejectedApproval()->count();
        $totalCount = (clone $baseQuery)->count();

        $recentRequests = (clone $baseQuery)
            ->with('creator')
            ->latest('approval_requested_at')
            ->take(5)
            ->get();

        return view('management-customer.dashboard', compact(
            'user',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'totalCount',
            'recentRequests'
        ));
    }
}
