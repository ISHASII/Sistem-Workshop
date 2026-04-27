<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Performance;
use App\Models\Manpower;
use App\Models\JobOrder;
use App\Models\ChecklistQualityItem;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
        $checklistItems = ChecklistQualityItem::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.performance.create', compact('manpowers','joborders','checklistItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nrp' => 'required|exists:manpowers,nrp',
            'job_order_id' => 'nullable|exists:job_orders,id',
            'checklist_quality_item_ids' => 'sometimes|array',
            'checklist_quality_item_ids.*' => 'integer|exists:checklist_quality_items,id',
        ]);

        $manpower = Manpower::where('nrp', $data['nrp'])->first();
        $payload = [
            'manpower_id' => $manpower->id,
            'job_order_id' => $data['job_order_id'] ?? null,
        ];
        $selectedIds = $data['checklist_quality_item_ids'] ?? [];
        $totalItems = ChecklistQualityItem::where('is_active', true)->count();
        $selectedCount = count($selectedIds);
        $score = $totalItems > 0 ? (int) round(($selectedCount / $totalItems) * 100) : 0;
        $payload['score'] = $score;
        $payload['rating'] = $this->ratingFromScore($score);

        $performance = Performance::create($payload);
        $performance->checklistQualityItems()->sync($selectedIds);
        return redirect()->route('admin.performance.index')->with('success', 'Performance berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Performance $performance)
    {
        $performance->load(['manpower','jobOrder','checklistQualityItems']);
        $checklistItems = ChecklistQualityItem::orderBy('sort_order')
            ->orderBy('name')
            ->get();
        return view('admin.performance.show', compact('performance','checklistItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Performance $performance)
    {
        $manpowers = Manpower::orderBy('nrp')->get();
        $joborders = JobOrder::orderByDesc('id')->get();
        $checklistItems = ChecklistQualityItem::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $performance->load('checklistQualityItems');

        return view('admin.performance.edit', compact('performance','manpowers','joborders','checklistItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Performance $performance)
    {
        $data = $request->validate([
            'nrp' => 'required|exists:manpowers,nrp',
            'job_order_id' => 'nullable|exists:job_orders,id',
            'checklist_quality_item_ids' => 'sometimes|array',
            'checklist_quality_item_ids.*' => 'integer|exists:checklist_quality_items,id',
        ]);

        $manpower = Manpower::where('nrp', $data['nrp'])->first();
        $payload = [
            'manpower_id' => $manpower->id,
            'job_order_id' => $data['job_order_id'] ?? null,
        ];
        $selectedIds = $data['checklist_quality_item_ids'] ?? [];
        $totalItems = ChecklistQualityItem::where('is_active', true)->count();
        $selectedCount = count($selectedIds);
        $score = $totalItems > 0 ? (int) round(($selectedCount / $totalItems) * 100) : 0;
        $payload['score'] = $score;
        $payload['rating'] = $this->ratingFromScore($score);

        $performance->update($payload);
        $performance->checklistQualityItems()->sync($selectedIds);
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

    /**
     * Export all (filtered) performances to PDF
     */
    public function exportPdfAll(Request $request)
    {
        // Reuse index query so filters behave the same as the listing
        $query = Performance::with(['manpower','jobOrder']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('manpower', function($mq) use ($search) {
                $mq->where('nama', 'like', "%{$search}%")
                  ->orWhere('nrp', 'like', "%{$search}%");
            });
        }
        if ($request->filled('manpower')) {
            $query->where('manpower_id', $request->manpower);
        }
        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        $performances = $query->latest()->get();

        $pdf = PDF::loadView('admin.performance.pdf.all', compact('performances'))
                  ->setPaper('a4', 'landscape');

        $filename = 'performance_all_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Export a single performance to PDF
     */
    public function exportPdf(Performance $performance)
    {
        $performance->load(['manpower','jobOrder','checklistQualityItems']);
        $checklistItems = ChecklistQualityItem::orderBy('sort_order')
            ->orderBy('name')
            ->get();
        $pdf = PDF::loadView('admin.performance.pdf.item', compact('performance','checklistItems'));
        $filename = 'performance_' . ($performance->manpower?->nrp ?? $performance->id) . '_' . $performance->created_at->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }

    protected function ratingFromScore(int $score): string
    {
        if ($score >= 90) return 'Excellent';
        if ($score >= 80) return 'Good';
        if ($score >= 70) return 'Average';
        return 'Poor';
    }
}
