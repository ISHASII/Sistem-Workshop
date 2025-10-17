<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;
use Barryvdh\DomPDF\Facade\Pdf;
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
    $materials = Material::with(['satuan', 'kategori'])->orderBy('nama')->get()->unique('nama');
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

        // Backend stok validation
        foreach ($data['items'] as $idx => $item) {
            if (!empty($item['material_id']) && !empty($item['jumlah'])) {
                $mat = Material::find($item['material_id']);
                if ($mat && $item['jumlah'] > $mat->getCurrentStok()) {
                    return back()
                        ->withInput()
                        ->withErrors(["items.$idx.jumlah" => "Jumlah material pada baris ".($idx+1)." melebihi stok tersedia!"]);
                }
            }
        }

        DB::transaction(function () use ($data) {
            $jo = JobOrder::create(collect($data)->only(['seksi','status','project','start','end'])->toArray());
            foreach ($data['items'] as $item) {
                // Autofill unit/spec from material if not provided
                if (!empty($item['material_id'])) {
                    $mat = Material::with('satuan')->find($item['material_id']);
                    if ($mat) {
                        if (empty($item['satuan']) && $mat->satuan) $item['satuan'] = $mat->satuan->name;
                        if (empty($item['spesifikasi']) && !empty($mat->notes)) $item['spesifikasi'] = $mat->notes;
                    }
                }
                $createdItem = $jo->items()->create([
                    'material_id' => $item['material_id'] ?? null,
                    'spesifikasi' => $item['spesifikasi'] ?? null,
                    'jumlah' => $item['jumlah'] ?? null,
                    'satuan' => $item['satuan'] ?? null,
                ]);
                // Kurangi stok material dengan membuat MaterialMovement type 'out'
                if (!empty($item['material_id']) && !empty($item['jumlah'])) {
                    \App\Models\MaterialMovement::create([
                        'material_id' => $item['material_id'],
                        'type' => 'out',
                        'tanggal' => now(),
                        'jumlah' => $item['jumlah'],
                        'keterangan' => 'Job Order #' . $jo->id,
                    ]);
                }
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

        // Backend stok validation (edit) hanya jika jumlah berubah
        foreach ($data['items'] as $idx => $item) {
            if (!empty($item['material_id']) && !empty($item['jumlah'])) {
                $existing = null;
                if (!empty($item['id'])) {
                    $existing = $joborder->items()->where('id', $item['id'])->first();
                }
                $oldJumlah = $existing ? $existing->jumlah : null;
                // Validasi stok hanya jika item baru atau jumlah berubah
                if ($oldJumlah === null || (int)$item['jumlah'] !== (int)$oldJumlah) {
                    $mat = \App\Models\Material::find($item['material_id']);
                    if ($mat && $item['jumlah'] > $mat->getCurrentStok()) {
                        return back()
                            ->withInput()
                            ->withErrors(["items.$idx.jumlah" => "Jumlah material pada baris ".($idx+1)." melebihi stok tersedia!"]);
                    }
                }
            }
        }

        DB::transaction(function () use ($data, $joborder) {
            $joborder->update(collect($data)->only(['seksi','status','project','start','end'])->toArray());

            // Sync items: collect ids to retain
            $incomingIds = collect($data['items'])->pluck('id')->filter()->all();
            $joborder->items()->whereNotIn('id', $incomingIds)->delete();

            foreach ($data['items'] as $item) {
                // Autofill unit/spec from material if not provided
                if (!empty($item['material_id'])) {
                    $mat = \App\Models\Material::with('satuan')->find($item['material_id']);
                    if ($mat) {
                        if (empty($item['satuan']) && $mat->satuan) $item['satuan'] = $mat->satuan->name;
                        if (empty($item['spesifikasi']) && !empty($mat->notes)) $item['spesifikasi'] = $mat->notes;
                    }
                }

                if (!empty($item['id'])) {
                    // Cek apakah jumlah berubah
                    $existing = $joborder->items()->where('id', $item['id'])->first();
                    $oldJumlah = $existing ? $existing->jumlah : null;
                    $joborder->items()->where('id', $item['id'])->update([
                        'material_id' => $item['material_id'] ?? null,
                        'spesifikasi' => $item['spesifikasi'] ?? null,
                        'jumlah' => $item['jumlah'] ?? null,
                        'satuan' => $item['satuan'] ?? null,
                    ]);
                    // Hanya kurangi stok jika jumlah berubah
                    if (!empty($item['material_id']) && !empty($item['jumlah']) && $oldJumlah !== null && (int)$item['jumlah'] !== (int)$oldJumlah) {
                        $selisih = (int)$item['jumlah'] - (int)$oldJumlah;
                        if ($selisih > 0) {
                            // Jika jumlah bertambah, kurangi stok sesuai selisih
                            \App\Models\MaterialMovement::create([
                                'material_id' => $item['material_id'],
                                'type' => 'out',
                                'tanggal' => now(),
                                'jumlah' => $selisih,
                                'keterangan' => 'Job Order Edit #' . $joborder->id . ' (tambah material)',
                            ]);
                        } else if ($selisih < 0) {
                            // Jika jumlah berkurang, tambahkan stok kembali (type in)
                            \App\Models\MaterialMovement::create([
                                'material_id' => $item['material_id'],
                                'type' => 'in',
                                'tanggal' => now(),
                                'jumlah' => abs($selisih),
                                'keterangan' => 'Job Order Edit #' . $joborder->id . ' (kurangi material)',
                            ]);
                        }
                    }
                } else {
                    $createdItem = $joborder->items()->create([
                        'material_id' => $item['material_id'] ?? null,
                        'spesifikasi' => $item['spesifikasi'] ?? null,
                        'jumlah' => $item['jumlah'] ?? null,
                        'satuan' => $item['satuan'] ?? null,
                    ]);
                    // Item baru, kurangi stok
                    if (!empty($item['material_id']) && !empty($item['jumlah'])) {
                        \App\Models\MaterialMovement::create([
                            'material_id' => $item['material_id'],
                            'type' => 'out',
                            'tanggal' => now(),
                            'jumlah' => $item['jumlah'],
                            'keterangan' => 'Job Order Edit #' . $joborder->id . ' (item baru)',
                        ]);
                    }
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

    /**
     * Export a single joborder to PDF
     */
    public function exportPdf(JobOrder $joborder)
    {
        $joborder->load('items.material');
        $pdf = null;
        try {
            $pdf = Pdf::loadView('admin.joborders.pdf', compact('joborder'));
        } catch (\Throwable $e) {
            // Log error and return a readable message in UI
            \Log::error('Export PDF error for JobOrder '.$joborder->id.': '.$e->getMessage());
            return back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }

        // If ?stream=1 is provided, render inline in browser for quick testing
        if (request()->query('stream')) {
            return $pdf->stream('joborder-'.$joborder->id.'.pdf');
        }

        return $pdf->download('joborder-'.$joborder->id.'.pdf');
    }
}
