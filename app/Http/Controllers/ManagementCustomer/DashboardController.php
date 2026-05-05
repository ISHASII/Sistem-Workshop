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
        $approvedCount = (clone $baseQuery)->where('approval_status', 'approved')->count();
        $rejectedCount = (clone $baseQuery)->rejectedApproval()->count();
        $totalCount = (clone $baseQuery)->count();

        $recentRequests = (clone $baseQuery)
            ->with('creator')
            ->latest('approval_requested_at')
            ->take(5)
            ->get();

        // Data proyek urgent (per proyek) - filtered by department and EPP approval
        $urgent_projects = (clone $baseQuery)->approvedApproval()->where('status', 'Urgent')
            ->orderBy('actual')
            ->get(['project', 'seksi', 'actual', 'end']);

        // Data job order urgent per seksi - filtered by department and EPP approval
        $urgent_jobs = (clone $baseQuery)->approvedApproval()->where('status', 'Urgent')
            ->selectRaw('seksi, count(*) as total')
            ->groupBy('seksi')
            ->get();

        // Data job order untuk Progress Chart - filtered by department and EPP approval
        $joborders = (clone $baseQuery)->approvedApproval()->orderByDesc('progress')->get(['project', 'progress']);

        // Job orders filtered by selected month and year for table
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);
        $all_joborders = (clone $baseQuery)->approvedApproval()->orderBy('start', 'desc')->get(['project','start','end','evaluasi']);
        
        $joborders_monthly = $all_joborders->filter(function($jo) use ($bulan, $tahun) {
            if (!$jo->start) return false;
            $date = null;
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $jo->start)) {
                $date = \DateTime::createFromFormat('d-m-Y', $jo->start);
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $jo->start)) {
                $date = \DateTime::createFromFormat('Y-m-d', $jo->start);
            }
            if (!$date) return false;
            return ((int)$date->format('Y') === (int)$tahun) && ((int)$date->format('m') === (int)$bulan);
        })->values();

        return view('management-customer.dashboard', compact(
            'user',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'totalCount',
            'recentRequests',
            'urgent_projects',
            'urgent_jobs',
            'joborders',
            'joborders_monthly'
        ));
    }
}
