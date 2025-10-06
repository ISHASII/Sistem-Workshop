<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Performance;
use App\Models\Manpower;
use App\Models\JobOrder;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Performance::with(['manpower','jobOrder']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('manpower', function($mq) use ($search) {
                $mq->where('nama', 'like', "%{$search}%")
                  ->orWhere('nrp', 'like', "%{$search}%");
            });
        }

        // Filter by Manpower
        if ($request->filled('manpower')) {
            $query->where('manpower_id', $request->manpower);
        }

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        $performances = $query->latest()->paginate(10)->withQueryString();

        // Calculate average performance for each manpower
        $averagePerformances = Performance::selectRaw('manpower_id, AVG(score) as average_score')
            ->groupBy('manpower_id')
            ->with('manpower')
            ->get();

        // Get all manpowers for filter dropdown
        $manpowers = Manpower::orderBy('nama')->get();

        return view('admin.performance.index', compact('performances', 'averagePerformances', 'manpowers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $manpowers = Manpower::orderBy('nrp')->get();
        $joborders = JobOrder::orderByDesc('id')->get();
        return view('admin.performance.create', compact('manpowers','joborders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nrp' => 'required|exists:manpowers,nrp',
            'job_order_id' => 'nullable|exists:job_orders,id',
            // checkboxes optional boolean
            'material_sesuai_jo' => 'sometimes|boolean',
            'dimensi_sesuai_jo' => 'sometimes|boolean',
            'item_sesuai_design' => 'sometimes|boolean',
            'pengelasan_tidak_retak' => 'sometimes|boolean',
            'item_bebas_spatter' => 'sometimes|boolean',
            'baut_terpasang_baik_lengkap' => 'sometimes|boolean',
            'tidak_ada_bagian_tajam' => 'sometimes|boolean',
            'finishing_standar' => 'sometimes|boolean',
            'tidak_ada_kotoran' => 'sometimes|boolean',
            'berfungsi_dengan_baik' => 'sometimes|boolean',
        ]);

        $manpower = Manpower::where('nrp', $data['nrp'])->first();
        $payload = [
            'manpower_id' => $manpower->id,
            'job_order_id' => $data['job_order_id'] ?? null,
        ];
        $flags = [
            'material_sesuai_jo','dimensi_sesuai_jo','item_sesuai_design','pengelasan_tidak_retak','item_bebas_spatter',
            'baut_terpasang_baik_lengkap','tidak_ada_bagian_tajam','finishing_standar','tidak_ada_kotoran','berfungsi_dengan_baik'
        ];
        $score = 0; $perFlag = 100 / count($flags);
        foreach ($flags as $f) {
            $val = (bool)($request->boolean($f));
            $payload[$f] = $val;
            if ($val) { $score += $perFlag; }
        }
        $score = (int) round($score);
        $payload['score'] = $score;
        $payload['rating'] = $this->ratingFromScore($score);

        Performance::create($payload);
        return redirect()->route('admin.performance.index')->with('success', 'Performance berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Performance $performance)
    {
        $performance->load(['manpower','jobOrder']);
        return view('admin.performance.show', compact('performance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Performance $performance)
    {
        $manpowers = Manpower::orderBy('nrp')->get();
        $joborders = JobOrder::orderByDesc('id')->get();
        return view('admin.performance.edit', compact('performance','manpowers','joborders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Performance $performance)
    {
        $data = $request->validate([
            'nrp' => 'required|exists:manpowers,nrp',
            'job_order_id' => 'nullable|exists:job_orders,id',
            'material_sesuai_jo' => 'sometimes|boolean',
            'dimensi_sesuai_jo' => 'sometimes|boolean',
            'item_sesuai_design' => 'sometimes|boolean',
            'pengelasan_tidak_retak' => 'sometimes|boolean',
            'item_bebas_spatter' => 'sometimes|boolean',
            'baut_terpasang_baik_lengkap' => 'sometimes|boolean',
            'tidak_ada_bagian_tajam' => 'sometimes|boolean',
            'finishing_standar' => 'sometimes|boolean',
            'tidak_ada_kotoran' => 'sometimes|boolean',
            'berfungsi_dengan_baik' => 'sometimes|boolean',
        ]);

        $manpower = Manpower::where('nrp', $data['nrp'])->first();
        $payload = [
            'manpower_id' => $manpower->id,
            'job_order_id' => $data['job_order_id'] ?? null,
        ];
        $flags = [
            'material_sesuai_jo','dimensi_sesuai_jo','item_sesuai_design','pengelasan_tidak_retak','item_bebas_spatter',
            'baut_terpasang_baik_lengkap','tidak_ada_bagian_tajam','finishing_standar','tidak_ada_kotoran','berfungsi_dengan_baik'
        ];
        $score = 0; $perFlag = 100 / count($flags);
        foreach ($flags as $f) {
            $val = (bool)($request->boolean($f));
            $payload[$f] = $val;
            if ($val) { $score += $perFlag; }
        }
        $score = (int) round($score);
        $payload['score'] = $score;
        $payload['rating'] = $this->ratingFromScore($score);

        $performance->update($payload);
        return redirect()->route('admin.performance.index')->with('success', 'Performance berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Performance $performance)
    {
        $performance->delete();
        return redirect()->route('admin.performance.index')->with('success', 'Performance berhasil dihapus');
    }

    protected function ratingFromScore(int $score): string
    {
        if ($score >= 90) return 'Excellent';
        if ($score >= 80) return 'Good';
        if ($score >= 70) return 'Average';
        return 'Poor';
    }
}