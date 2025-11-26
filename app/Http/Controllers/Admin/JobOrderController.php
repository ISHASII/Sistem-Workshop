<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Material;
use App\Models\JobOrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    $joborders = $query->latest()->paginate(10)->withQueryString();
        return view('admin.joborders.index', compact('joborders'));
    }

    /**
     * Show the specified job order.
     */
    public function show(JobOrder $joborder)
    {
        $joborder->load(['items.material.satuan', 'creator']);
        return view('admin.joborders.show', compact('joborder'));
    }

    public function create()
    {
        $materials = Material::with(['satuan', 'kategori'])->orderBy('nama')->get()->unique('nama');
        // Fetch booked ranges to disable on the datepicker
        $bookedRanges = JobOrder::select('start', 'end')->get()->map(function($r){
            // Convert to Y-m-d format for flatpickr
            try {
                $start = \Carbon\Carbon::createFromFormat('d-m-Y', $r->start);
                $end = \Carbon\Carbon::createFromFormat('d-m-Y', $r->end);
            } catch (\Throwable $e) {
                try {
                    $start = \Carbon\Carbon::createFromFormat('Y-m-d', $r->start);
                    $end = \Carbon\Carbon::createFromFormat('Y-m-d', $r->end);
                } catch (\Throwable $e2) {
                    return null;
                }
            }
            return ['from' => $start->format('Y-m-d'), 'to' => $end->format('Y-m-d')];
        })->filter()->values()->toArray();

        // Compute earliest allowed start: day after the latest existing end (in d-m-Y format)
        $allJobOrders = JobOrder::all();
        $latestEnd = null;
        foreach ($allJobOrders as $jo) {
            try {
                // Try d-m-Y format first
                $joEnd = \Carbon\Carbon::createFromFormat('d-m-Y', $jo->end);
            } catch (\Throwable $e) {
                try {
                    // Fallback to Y-m-d format
                    $joEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $jo->end);
                } catch (\Throwable $e2) {
                    continue;
                }
            }

            if ($latestEnd === null || $joEnd->greaterThan($latestEnd)) {
                $latestEnd = $joEnd;
            }
        }
        $earliestAllowedStart = $latestEnd ? $latestEnd->addDay()->format('d-m-Y') : null;

        return view('admin.joborders.create', compact('materials', 'bookedRanges', 'earliestAllowedStart'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'seksi' => 'required|string|max:255',
            'status' => 'required|in:Low,Medium,High,Urgent',
            'project' => 'required|string|max:255',
            'start' => 'required|string|max:255',
            'end' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.material_id' => 'required|exists:materials,id',
            'items.*.spesifikasi' => 'nullable|string',
            'items.*.jumlah' => 'nullable|integer',
            'items.*.satuan' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:255',
            'latar_belakang' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'target' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:5120', // max 5MB per image
        ]);

        // Validate date parsing and prevent overlapping job orders
        $start = null;
        $end = null;

        try {
            // Try d-m-Y format first (from form input)
            $start = \Carbon\Carbon::createFromFormat('d-m-Y', $data['start'])->startOfDay();
        } catch (\Throwable $e) {
            try {
                // Fallback to auto-parsing (Y-m-d, etc)
                $start = \Carbon\Carbon::parse($data['start'])->startOfDay();
            } catch (\Throwable $e2) {
                return back()->withInput()->withErrors(['start' => 'Format tanggal mulai tidak valid. Gunakan format d-m-Y (contoh: 01-11-2025).']);
            }
        }

        try {
            // Try d-m-Y format first (from form input)
            $end = \Carbon\Carbon::createFromFormat('d-m-Y', $data['end'])->endOfDay();
        } catch (\Throwable $e) {
            try {
                // Fallback to auto-parsing (Y-m-d, etc)
                $end = \Carbon\Carbon::parse($data['end'])->endOfDay();
            } catch (\Throwable $e2) {
                return back()->withInput()->withErrors(['end' => 'Format tanggal selesai tidak valid. Gunakan format d-m-Y (contoh: 30-11-2025).']);
            }
        }

        // Check for ANY overlap with existing job orders
        $allJobOrders = JobOrder::all();
        $hasOverlap = false;
        $latestEnd = null;

        foreach ($allJobOrders as $jo) {
            try {
                // Try d-m-Y format first
                $joStart = \Carbon\Carbon::createFromFormat('d-m-Y', $jo->start)->startOfDay();
            } catch (\Throwable $e) {
                try {
                    // Fallback to Y-m-d format
                    $joStart = \Carbon\Carbon::createFromFormat('Y-m-d', $jo->start)->startOfDay();
                } catch (\Throwable $e2) {
                    continue;
                }
            }

            try {
                // Try d-m-Y format first
                $joEnd = \Carbon\Carbon::createFromFormat('d-m-Y', $jo->end)->endOfDay();
            } catch (\Throwable $e) {
                try {
                    // Fallback to Y-m-d format
                    $joEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $jo->end)->endOfDay();
                } catch (\Throwable $e2) {
                    continue;
                }
            }

            // Track latest end date
            if ($latestEnd === null || $joEnd->greaterThan($latestEnd)) {
                $latestEnd = $joEnd;
            }

            // Check if new job order overlaps with this existing one
            // Overlap if: new_start <= existing_end AND new_end >= existing_start
            if ($start->lessThanOrEqualTo($joEnd) && $end->greaterThanOrEqualTo($joStart)) {
                $hasOverlap = true;
            }
        }

        // If there's ANY overlap, reject and suggest date after latest end
        if ($hasOverlap) {
            $suggest = $latestEnd ? $latestEnd->copy()->addDay()->format('d-m-Y') : $start->format('d-m-Y');
            $msg = "Rentang tanggal bentrok dengan job order yang sudah ada. Job order baru harus dimulai setelah: " . ($latestEnd ? $latestEnd->format('d-m-Y') : 'tanggal terakhir') . ". Tanggal mulai tersedia: $suggest";
            return back()->withInput()->withErrors(['start' => $msg]);
        }

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

        DB::transaction(function () use ($data, $request) {
            $jo = JobOrder::create(collect($data)->only(['seksi','status','project','start','end','area','latar_belakang','tujuan','target'])->toArray());

            // Handle uploaded images
            $savedImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $f) {
                    if ($f && $f->isValid()) {
                        $filename = 'joborders/' . date('Y/m') . '/' . Str::random(8) . '_' . $f->getClientOriginalName();
                        Storage::disk('public')->putFileAs(dirname($filename), $f, basename($filename));
                        $savedImages[] = 'storage/' . $filename; // accessible path via asset()
                    }
                }
            }
            if (!empty($savedImages)) {
                $jo->images = $savedImages;
                $jo->save();
            }
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
        $bookedRanges = JobOrder::where('id', '!=', $joborder->id)->select('start', 'end')->get()->map(function($r){
            // Convert to Y-m-d format for flatpickr
            try {
                $start = \Carbon\Carbon::createFromFormat('d-m-Y', $r->start);
                $end = \Carbon\Carbon::createFromFormat('d-m-Y', $r->end);
            } catch (\Throwable $e) {
                try {
                    $start = \Carbon\Carbon::createFromFormat('Y-m-d', $r->start);
                    $end = \Carbon\Carbon::createFromFormat('Y-m-d', $r->end);
                } catch (\Throwable $e2) {
                    return null;
                }
            }
            return ['from' => $start->format('Y-m-d'), 'to' => $end->format('Y-m-d')];
        })->filter()->values()->toArray();
        return view('admin.joborders.edit', compact('joborder','materials', 'bookedRanges'));
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
            'area' => 'nullable|string|max:255',
            'latar_belakang' => 'nullable|string',
            'tujuan' => 'nullable|string',
            'target' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:5120',
            'removed_images' => 'nullable|array',
            'removed_images.*' => 'nullable|string',
        ]);

        // Validate date parsing and prevent overlapping job orders (exclude current)
        $start = null;
        $end = null;

        if (isset($data['start'])) {
            try {
                // Try d-m-Y format first (from form input)
                $start = \Carbon\Carbon::createFromFormat('d-m-Y', $data['start'])->startOfDay();
            } catch (\Throwable $e) {
                try {
                    // Fallback to auto-parsing (Y-m-d, etc)
                    $start = \Carbon\Carbon::parse($data['start'])->startOfDay();
                } catch (\Throwable $e2) {
                    return back()->withInput()->withErrors(['start' => 'Format tanggal mulai tidak valid. Gunakan format d-m-Y (contoh: 01-11-2025).']);
                }
            }
        }

        if (isset($data['end'])) {
            try {
                // Try d-m-Y format first (from form input)
                $end = \Carbon\Carbon::createFromFormat('d-m-Y', $data['end'])->endOfDay();
            } catch (\Throwable $e) {
                try {
                    // Fallback to auto-parsing (Y-m-d, etc)
                    $end = \Carbon\Carbon::parse($data['end'])->endOfDay();
                } catch (\Throwable $e2) {
                    return back()->withInput()->withErrors(['end' => 'Format tanggal selesai tidak valid. Gunakan format d-m-Y (contoh: 30-11-2025).']);
                }
            }
        }

        if ($start && $end) {
            // Check overlap: no date ranges should overlap
            $allJobOrders = JobOrder::where('id', '!=', $joborder->id)->get();
            $hasOverlap = false;
            $latestEnd = null;

            foreach ($allJobOrders as $jo) {
                try {
                    // Try d-m-Y format first
                    $joStart = \Carbon\Carbon::createFromFormat('d-m-Y', $jo->start)->startOfDay();
                } catch (\Throwable $e) {
                    try {
                        // Fallback to Y-m-d format
                        $joStart = \Carbon\Carbon::createFromFormat('Y-m-d', $jo->start)->startOfDay();
                    } catch (\Throwable $e2) {
                        continue;
                    }
                }

                try {
                    // Try d-m-Y format first
                    $joEnd = \Carbon\Carbon::createFromFormat('d-m-Y', $jo->end)->endOfDay();
                } catch (\Throwable $e) {
                    try {
                        // Fallback to Y-m-d format
                        $joEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $jo->end)->endOfDay();
                    } catch (\Throwable $e2) {
                        continue;
                    }
                }

                // Track latest end date
                if ($latestEnd === null || $joEnd->greaterThan($latestEnd)) {
                    $latestEnd = $joEnd;
                }

                // Check if new job order overlaps with this existing one
                // Overlap if: new_start <= existing_end AND new_end >= existing_start
                if ($start->lessThanOrEqualTo($joEnd) && $end->greaterThanOrEqualTo($joStart)) {
                    $hasOverlap = true;
                }
            }

            if ($hasOverlap) {
                $suggest = $latestEnd ? $latestEnd->copy()->addDay()->format('d-m-Y') : $start->format('d-m-Y');
                $msg = "Rentang tanggal bentrok dengan job order yang sudah ada. Job order baru harus dimulai setelah: " . ($latestEnd ? $latestEnd->format('d-m-Y') : 'tanggal terakhir') . ". Tanggal mulai tersedia: $suggest";
                return back()->withInput()->withErrors(['start' => $msg]);
            }
        }

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
            $joborder->update(collect($data)->only(['seksi','status','project','start','end','area','latar_belakang','tujuan','target'])->toArray());

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
            // Handle removal of existing images (if user removed some in edit form)
            if (!empty($data['removed_images']) && is_array($data['removed_images'])) {
                $existing = is_array($joborder->images) ? $joborder->images : [];
                foreach ($data['removed_images'] as $rem) {
                    // normalize stored path (we saved as 'storage/...')
                    $normalized = ltrim(str_replace('\\', '/', $rem), '/');
                    // if path starts with 'storage/', compute storage disk path
                    if (strpos($normalized, 'storage/') === 0) {
                        $diskPath = substr($normalized, strlen('storage/'));
                        if (Storage::disk('public')->exists($diskPath)) {
                            Storage::disk('public')->delete($diskPath);
                        }
                    }
                    // remove from existing array
                    $existing = array_values(array_filter($existing, function($v) use ($rem) {
                        return $v !== $rem;
                    }));
                }
                $joborder->images = $existing;
                $joborder->save();
            }

            // Handle uploaded images (append)
            if (request()->hasFile('images')) {
                $existing = is_array($joborder->images) ? $joborder->images : [];
                foreach (request()->file('images') as $f) {
                    if ($f && $f->isValid()) {
                        $filename = 'joborders/' . date('Y/m') . '/' . Str::random(8) . '_' . $f->getClientOriginalName();
                        Storage::disk('public')->putFileAs(dirname($filename), $f, basename($filename));
                        $existing[] = 'storage/' . $filename;
                    }
                }
                $joborder->images = $existing;
                $joborder->save();
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
