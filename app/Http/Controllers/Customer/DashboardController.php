<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function index()
    {
        // Data proyek urgent (per proyek, bukan agregat) - filtered by current customer
        $urgent_projects = \App\Models\JobOrder::where('status', 'Urgent')
            ->where('created_by', auth()->id())
            ->orderBy('actual')
            ->get(['project', 'seksi', 'actual', 'end']);

        // Data job order urgent per seksi - filtered by current customer
        $urgent_jobs = \App\Models\JobOrder::where('status', 'Urgent')
            ->where('created_by', auth()->id())
            ->selectRaw('seksi, count(*) as total')
            ->groupBy('seksi')
            ->get();

        // Data material kritis (stock < reorder)
        $critical_materials = \App\Models\Material::with(['satuan'])
            ->get()
            ->map(function($m) {
                $stock = $m->getCurrentStok();
                $reorder = $m->safety_stock;
                return [
                    'nama' => $m->nama . ($m->spesifikasi ? ' | ' . $m->spesifikasi : ''),
                    'stock' => (float) $stock,
                    'reorder' => (float) $reorder,
                ];
            })
            ->filter(function($m) { return $m['stock'] < $m['reorder']; })
            ->values();

        // Ambil data job order: nama proyek dan progress - filtered by current customer
        $query = \App\Models\JobOrder::with(['items.material'])
            ->where('created_by', auth()->id());

        // Apply same filters as admin (search, status, seksi, evaluasi, progress)
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('project', 'like', "%{$search}%")
                  ->orWhere('seksi', 'like', "%{$search}%");
            });
        }
        if (request()->filled('status')) { $query->where('status', request('status')); }
        if (request()->filled('seksi')) { $query->where('seksi', request('seksi')); }
        if (request()->filled('evaluasi')) { $query->where('evaluasi', request('evaluasi')); }
        if (request()->filled('progress')) {
            switch (request('progress')) {
                case '0-25': $query->whereBetween('progress', [0,25]); break;
                case '26-50': $query->whereBetween('progress', [26,50]); break;
                case '51-75': $query->whereBetween('progress', [51,75]); break;
                case '76-100': $query->whereBetween('progress', [76,100]); break;
            }
        }
        $joborders = $query->orderByDesc('progress')->get();

        // Job orders filtered by selected month and year - filtered by current customer
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);
        $all_joborders = \App\Models\JobOrder::where('created_by', auth()->id())
            ->orderBy('start', 'desc')
            ->get(['project','start','evaluasi']);
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

        // Materials: build both flat $materials (admin-like) and grouped $materials_by_category
        $materialModels = \App\Models\Material::with(['satuan','kategori'])->get();

        // flat materials list with kategori_nama (admin expects this variable too)
        $materials = $materialModels->map(function($m) {
            $catName = 'Uncategorized';
            if (isset($m->kategori)) {
                if (is_object($m->kategori)) $catName = $m->kategori->nama ?? ($m->kategori->name ?? $catName);
                else $catName = $m->kategori ?? $catName;
            }
            $sum_stock = $m->getCurrentStok();
            $sum_min = $m->safety_stock;
            $sum_reorder = $m->safety_stock;
            $sum_max = $m->jumlah + $m->movements()->where('type','in')->sum('jumlah');
            return [
                'nama' => $m->nama,
                'sum_stock' => (float)$sum_stock,
                'sum_min' => (float)$sum_min,
                'sum_reorder' => (float)$sum_reorder,
                'sum_max' => (float)$sum_max,
                'kategori_nama' => $catName
            ];
        })->values();

        // Group materials by kategori on server-side for the dashboard view
        $materials_by_category = [];
        foreach ($materialModels as $m) {
            $catName = 'Uncategorized';
            if (isset($m->kategori)) {
                if (is_object($m->kategori)) $catName = $m->kategori->nama ?? ($m->kategori->name ?? $catName);
                else $catName = $m->kategori ?? $catName;
            }
            $sum_stock = $m->getCurrentStok();
            $sum_min = $m->safety_stock;
            $sum_reorder = $m->safety_stock;
            $sum_max = $m->jumlah + $m->movements()->where('type','in')->sum('jumlah');
            $materials_by_category[$catName][] = [
                'nama' => $m->nama,
                'sum_stock' => (float)$sum_stock,
                'sum_min' => (float)$sum_min,
                'sum_reorder' => (float)$sum_reorder,
                'sum_max' => (float)$sum_max,
            ];
        }

        $averagePerformances = \App\Models\Performance::selectRaw('manpower_id, AVG(score) as average_score')
            ->groupBy('manpower_id')
            ->with('manpower')
            ->get();

        return view('customer.dashboard', compact(
            'joborders',
            'joborders_monthly',
            'materials_by_category',
            'critical_materials',
            'urgent_jobs',
            'urgent_projects',
            'averagePerformances'
        ));
    }
}
