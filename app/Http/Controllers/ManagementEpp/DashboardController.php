<?php

namespace App\Http\Controllers\ManagementEpp;

use App\Http\Controllers\Controller;
use App\Models\JobOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->loadMissing(['departement', 'jabatan']);

        // EPP sees all job orders (or optionally filtered by departement)
        $baseQuery = JobOrder::query();

        // If department filter is selected
        $departement_id = request('departement_id');
        if ($departement_id) {
            $baseQuery->whereHas('creator', function ($q) use ($departement_id) {
                $q->where('department_id', $departement_id);
            });
        }

        // Keep the counts and recent requests based on EPP approval logic
        $approvalQuery = (clone $baseQuery)->where('approval_status', 'approved');
        
        $pendingEppCount = (clone $approvalQuery)->where('epp_approval_status', 'pending')->count();
        $approvedEppCount = (clone $approvalQuery)->where('epp_approval_status', 'approved')->count();

        $recentRequests = (clone $approvalQuery)
            ->where('epp_approval_status', 'pending')
            ->with(['creator.departement', 'creator.jabatan'])
            ->latest('approval_requested_at')
            ->take(5)
            ->get();

        // Data proyek urgent (per proyek)
        $urgent_projects = (clone $baseQuery)->where('status', 'Urgent')
            ->orderBy('actual')
            ->get(['project', 'seksi', 'actual', 'end']);

        // Data job order urgent per seksi
        $urgent_jobs = (clone $baseQuery)->where('status', 'Urgent')
            ->selectRaw('seksi, count(*) as total')
            ->groupBy('seksi')
            ->get();

        // Data job order untuk Progress Chart
        $joborders = (clone $baseQuery)->orderByDesc('progress')->get(['project', 'progress']);

        // Job orders filtered by selected month and year for table
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);
        $all_joborders = (clone $baseQuery)->orderBy('start', 'desc')->get(['project','start','end','evaluasi']);
        
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

        // Fetch all departments for the filter dropdown
        $departements = \App\Models\Departement::orderBy('name')->get();

        return view('management-epp.dashboard', compact(
            'user',
            'pendingEppCount',
            'approvedEppCount',
            'recentRequests',
            'urgent_projects',
            'urgent_jobs',
            'joborders',
            'joborders_monthly',
            'departements',
            'departement_id'
        ));
    }
}
