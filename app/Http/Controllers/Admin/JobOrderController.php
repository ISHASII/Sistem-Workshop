<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;
use App\Models\Material;
use App\Models\JobOrderItem;
use Illuminate\Support\Facades\DB;

class JobOrderController extends Controller
{
    /**
     * Display a listing of job orders for admin.
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

        $joborders = $query->latest()->paginate(12)->withQueryString();
        return view('admin.joborders.index', compact('joborders'));
    }

    public function create()
    {
        $materials = Material::with(['satuan', 'kategori'])->orderBy('nama')->get();
        return view('admin.joborders.create', compact('materials'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'seksi' => 'nullable|string|max:255',
            'status' => 'required|in:Low,Medium,High,Urgent',
            'project' => 'nullable|string|max:255',
            'start' => 'nullable|string|max:255',
            'end' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.material_id' => 'nullable|exists:materials,id',
            'items.*.spesifikasi' => 'nullable|string',
            'items.*.jumlah' => 'nullable|integer',
            'items.*.satuan' => 'nullable|string|max:100',
        ]);
        DB::transaction(function () use ($data) {
            $jo = JobOrder::create(collect($data)->only(['seksi','status','project','start','end'])->toArray());
            foreach ($data['items'] as $item) {
                // Autofill unit/spec from material if not provided
                if (!empty($item['material_id'])) {
                    $mat = Material::find($item['material_id']);
                    if ($mat) {
                        if (empty($item['satuan'])) $item['satuan'] = $mat->unit;
                        if (empty($item['spesifikasi']) && !empty($mat->notes)) $item['spesifikasi'] = $mat->notes;
                    }
                }
                $jo->items()->create([
                    'material_id' => $item['material_id'] ?? null,
                    'spesifikasi' => $item['spesifikasi'] ?? null,
                    'jumlah' => $item['jumlah'] ?? null,
                    'satuan' => $item['satuan'] ?? null,
                ]);
            }
        });

        return redirect()->route('admin.joborder.index')->with('success', 'Job order created.');
    }

    public function edit(JobOrder $joborder)
    {
        $joborder->load('items');
        $materials = Material::with(['satuan', 'kategori'])->orderBy('nama')->get();
        return view('admin.joborders.edit', compact('joborder','materials'));
    }

    public function update(Request $request, JobOrder $joborder)
    {
        $data = $request->validate([
            'seksi' => 'nullable|string|max:255',
            'status' => 'required|in:Low,Medium,High,Urgent',
            'project' => 'nullable|string|max:255',
            'start' => 'nullable|string|max:255',
            'end' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|integer|exists:job_order_items,id',
            'items.*.material_id' => 'nullable|exists:materials,id',
            'items.*.spesifikasi' => 'nullable|string',
            'items.*.jumlah' => 'nullable|integer',
            'items.*.satuan' => 'nullable|string|max:100',
        ]);
        DB::transaction(function () use ($data, $joborder) {
            $joborder->update(collect($data)->only(['seksi','status','project','start','end'])->toArray());

            // Sync items: collect ids to retain
            $incomingIds = collect($data['items'])->pluck('id')->filter()->all();
            $joborder->items()->whereNotIn('id', $incomingIds)->delete();

            foreach ($data['items'] as $item) {
                // Autofill unit/spec from material if not provided
                if (!empty($item['material_id'])) {
                    $mat = Material::find($item['material_id']);
                    if ($mat) {
                        if (empty($item['satuan'])) $item['satuan'] = $mat->unit;
                        if (empty($item['spesifikasi']) && !empty($mat->notes)) $item['spesifikasi'] = $mat->notes;
                    }
                }

                if (!empty($item['id'])) {
                    $joborder->items()->where('id', $item['id'])->update([
                        'material_id' => $item['material_id'] ?? null,
                        'spesifikasi' => $item['spesifikasi'] ?? null,
                        'jumlah' => $item['jumlah'] ?? null,
                        'satuan' => $item['satuan'] ?? null,
                    ]);
                } else {
                    $joborder->items()->create([
                        'material_id' => $item['material_id'] ?? null,
                        'spesifikasi' => $item['spesifikasi'] ?? null,
                        'jumlah' => $item['jumlah'] ?? null,
                        'satuan' => $item['satuan'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('admin.joborder.index')->with('success', 'Job order updated.');
    }

    public function destroy(JobOrder $joborder)
    {
        $joborder->delete();
        return back()->with('success', 'Job order deleted.');
    }

    public function updateProgress(Request $request, JobOrder $joborder)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $joborder->update([
            'progress' => $request->progress,
        ]);

        return back()->with('success', 'Progress berhasil diupdate.');
    }

    public function updateActual(Request $request, JobOrder $joborder)
    {
        $request->validate([
            'actual' => 'required|date',
        ]);

        $actual = \Carbon\Carbon::parse($request->actual);
        $end = \Carbon\Carbon::parse($joborder->end);

        // Tentukan evaluasi
        $evaluasi = $actual->lte($end) ? 'Tepat Waktu' : 'Terlambat';

        $joborder->update([
            'actual' => $request->actual,
            'evaluasi' => $evaluasi,
        ]);

        return back()->with('success', 'Tanggal actual berhasil diupdate.');
    }
}
