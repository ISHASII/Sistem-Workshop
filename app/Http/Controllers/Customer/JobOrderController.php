<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;

class JobOrderController extends Controller
{
    /**
     * Display a listing of job orders for customer.
     */
    public function index(Request $request)
    {
        $query = JobOrder::with(['items.material']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('project', 'like', "%{$search}%")
                  ->orWhere('seksi', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Seksi
        if ($request->filled('seksi')) {
            $query->where('seksi', $request->seksi);
        }

        // Filter Evaluasi
        if ($request->filled('evaluasi')) {
            $query->where('evaluasi', $request->evaluasi);
        }

        // Filter Progress
        if ($request->filled('progress')) {
            switch ($request->progress) {
                case '0-25':
                    $query->whereBetween('progress', [0, 25]);
                    break;
                case '26-50':
                    $query->whereBetween('progress', [26, 50]);
                    break;
                case '51-75':
                    $query->whereBetween('progress', [51, 75]);
                    break;
                case '76-100':
                    $query->whereBetween('progress', [76, 100]);
                    break;
            }
        }

    $joborders = $query->latest()->paginate(10)->withQueryString();
        return view('customer.joborders.index', compact('joborders'));
    }
}
