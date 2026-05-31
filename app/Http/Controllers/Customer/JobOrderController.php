<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Material;
use App\Models\JobOrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\NotificationService;

class JobOrderController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    protected function departmentSection(?\App\Models\User $user = null): ?string
    {
        $user = $user ?: auth()->user();

        return optional($user?->departement)->name;
    }
    /**
     * Display a listing of job orders for customer.
     */
    public function index(Request $request)
    {
        if (auth()->user()->isManagementCustomer()) {
            return redirect()->route('management-customer.requests.index');
        }

        $query = JobOrder::with(['items.material'])
            ->where('created_by', auth()->id()); // Only show job orders created by current user

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

    public function create()
    {
        if (auth()->user()->isManagementCustomer()) {
            return redirect()->route('management-customer.requests.index');
        }

        $materials = Material::with(['satuan', 'kategori', 'movements'])
            ->orderBy('nama')
            ->get()
            ->filter(fn($m) => $m->getCurrentStok() > 0)
            ->unique('nama')
            ->values();
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

        $defaultSeksi = $this->departmentSection();

        return view('customer.joborders.create', compact('materials', 'bookedRanges', 'earliestAllowedStart', 'defaultSeksi'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->isManagementCustomer()) {
            return redirect()->route('management-customer.requests.index');
        }

        $data = $request->validate([
            'seksi' => 'nullable|string|max:255',
            'status' => 'required|in:Low,Medium,High,Urgent',
            'project' => 'required|string|max:255',
            'start' => 'required|string|max:255',
            'end' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.material_id' => 'required|exists:materials,id',
            'items.*.spesifikasi' => 'nullable|string',
            'items.*.jumlah' => 'required|integer|min:1',
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

        $departmentSection = $this->departmentSection();
        if (empty($departmentSection)) {
            return back()->withInput()->withErrors(['seksi' => 'Departement akun Anda belum diisi. Hubungi admin untuk melengkapinya.']);
        }

        $data['seksi'] = $departmentSection;

        // Backend stok validation
        foreach ($data['items'] as $idx => $item) {
            $requestedQty = (int) ($item['jumlah'] ?? 0);
            if (!empty($item['material_id'])) {
                $mat = Material::find($item['material_id']);
                if ($mat) {
                    $currentStock = (int) $mat->getCurrentStok();

                    if ($currentStock <= 0) {
                        return back()
                            ->withInput()
                            ->withErrors(["items.$idx.material_id" => "Material pada baris " . ($idx + 1) . " stoknya tidak tersedia. Pilih material lain."]);
                    }

                    if ($requestedQty <= 0) {
                        return back()
                            ->withInput()
                            ->withErrors(["items.$idx.jumlah" => "Jumlah material pada baris " . ($idx + 1) . " harus lebih dari 0."]);
                    }

                    if ($requestedQty > $currentStock) {
                        return back()
                            ->withInput()
                            ->withErrors(["items.$idx.jumlah" => "Jumlah material pada baris " . ($idx + 1) . " melebihi stok tersedia (stok: {$currentStock})."]);
                    }
                }
            }
        }

        $jo = null;
        DB::transaction(function () use ($data, $request, &$jo) {
            $jobOrderData = collect($data)->only(['seksi','status','project','start','end','area','latar_belakang','tujuan','target'])->toArray();
            $jobOrderData['created_by'] = auth()->id();
            $jobOrderData['approval_status'] = 'pending';
            $jobOrderData['approval_requested_at'] = now();
            $jo = JobOrder::create($jobOrderData);

            $savedImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $f) {
                    if ($f && $f->isValid()) {
                        $filename = 'joborders/' . date('Y/m') . '/' . Str::random(8) . '_' . $f->getClientOriginalName();
                        Storage::disk('public')->putFileAs(dirname($filename), $f, basename($filename));
                        $savedImages[] = 'storage/' . $filename;
                    }
                }
            }

            if (!empty($savedImages)) {
                $jo->images = $savedImages;
                $jo->save();
            }

            foreach ($data['items'] as $item) {
                if (!empty($item['material_id'])) {
                    $mat = Material::with('satuan')->find($item['material_id']);
                    if ($mat) {
                        if (empty($item['satuan']) && $mat->satuan) {
                            $item['satuan'] = $mat->satuan->name;
                        }
                        if (empty($item['spesifikasi']) && !empty($mat->notes)) {
                            $item['spesifikasi'] = $mat->notes;
                        }
                    }
                }

                $jo->items()->create([
                    'material_id' => $item['material_id'] ?? null,
                    'spesifikasi' => $item['spesifikasi'] ?? null,
                    'jumlah' => $item['jumlah'] ?? null,
                    'satuan' => $item['satuan'] ?? null,
                ]);

                // No stock movement on store under post-approval stock deduction model.
            }
        });

        $this->notificationService->notifyJobOrderApprovalRequested($jo, auth()->user());

        return redirect()->route('customer.joborder.index')->with('success', 'Job order berhasil dibuat dan menunggu approval management customer.');
    }

    public function edit(JobOrder $joborder)
    {
        if (auth()->user()->isManagementCustomer()) {
            return redirect()->route('management-customer.requests.index');
        }

        if (($joborder->approval_status ?? 'pending') !== 'rejected') {
            return back()->with('error', 'Job order hanya bisa diedit setelah ditolak oleh Management Customer.');
        }

        $joborder->load('items');
        $materials = Material::with(['satuan', 'kategori', 'movements'])
            ->orderBy('nama')
            ->get()
            ->filter(function($m) use ($joborder) {
                // Show if stock > 0 OR if it's already used in this job order
                return $m->getCurrentStok() > 0 || $joborder->items->contains('material_id', $m->id);
            })
            ->values();
        $bookedRanges = JobOrder::where('id', '!=', $joborder->id)->select('start', 'end')->get()->map(function($r){
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

        $defaultSeksi = $this->departmentSection();

        return view('customer.joborders.edit', compact('joborder', 'materials', 'bookedRanges', 'defaultSeksi'));
    }

    public function update(Request $request, JobOrder $joborder)
    {
        if (auth()->user()->isManagementCustomer()) {
            return redirect()->route('management-customer.requests.index');
        }

        if (($joborder->approval_status ?? 'pending') !== 'rejected') {
            return back()->with('error', 'Job order hanya bisa diperbarui setelah ditolak oleh Management Customer.');
        }

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

        $departmentSection = $this->departmentSection();
        if (empty($departmentSection)) {
            return back()->withInput()->withErrors(['seksi' => 'Departement akun Anda belum diisi. Hubungi admin untuk melengkapinya.']);
        }

        $data['seksi'] = $departmentSection;

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

        $oldStatus = $joborder->approval_status;

        DB::transaction(function () use ($data, $joborder, $oldStatus) {
            $joborder->update(collect($data)->only(['seksi','status','project','start','end','area','latar_belakang','tujuan','target'])->toArray() + [
                'approval_status' => 'pending',
                'approval_requested_at' => now(),
                'approved_by' => null,
                'approved_at' => null,
                'rejected_by' => null,
                'rejected_at' => null,
                'rejection_reason' => null,
            ]);

            // Sync items: collect ids to retain
            $incomingIds = collect($data['items'])->pluck('id')->filter()->all();
            // No stock refund on item removal under post-approval stock deduction model.
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

                    // No stock movements under post-approval stock deduction model on update.
                } else {
                    $createdItem = $joborder->items()->create([
                        'material_id' => $item['material_id'] ?? null,
                        'spesifikasi' => $item['spesifikasi'] ?? null,
                        'jumlah' => $item['jumlah'] ?? null,
                        'satuan' => $item['satuan'] ?? null,
                    ]);
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

        // Re-send approval request to management customer after updates
        // Use a distinct notification for resubmissions so management can distinguish from new JOs
        $this->notificationService->notifyJobOrderResubmitted($joborder, auth()->user());

        return redirect()->route('customer.joborder.index')->with('success', 'Job order updated.');
    }

    public function destroy(JobOrder $joborder)
    {
        if (auth()->user()->isManagementCustomer()) {
            return redirect()->route('management-customer.requests.index');
        }

        // Allow deletion if pending or rejected. If approved, usually it shouldn't be deleted by customer.
        if (!in_array($joborder->approval_status, ['pending', 'rejected'])) {
            return back()->with('error', 'Job order yang sudah disetujui tidak bisa dihapus oleh customer.');
        }

        $this->notificationService->notifyJobOrderDeleted($joborder, auth()->user());
        
        DB::transaction(function () use ($joborder) {
            // Return stock if and only if EPP has approved the Job Order, as that is when the stock was deducted.
            if ($joborder->epp_approval_status === 'approved') {
                foreach ($joborder->items as $item) {
                    if (!empty($item->material_id) && !empty($item->jumlah)) {
                        \App\Models\MaterialMovement::create([
                            'material_id' => $item->material_id,
                            'type' => 'in',
                            'tanggal' => now(),
                            'jumlah' => $item->jumlah,
                            'movement_type' => 'jo',
                            'keterangan' => 'Job Order Deleted (Customer) #' . $joborder->id,
                        ]);
                    }
                }
            }
            $joborder->delete();
        });

        return back()->with('success', 'Job order berhasil dihapus dan stok material telah dikembalikan.');
    }

    public function updateProgress(Request $request, JobOrder $joborder)
    {
        // Customers are not allowed to update progress. Only admins can update this field.
        abort(403, 'Forbidden: only admins can update progress.');
    }

    public function updateActual(Request $request, JobOrder $joborder)
    {
        // Customers are not allowed to set actual completion date. Only admins can update this field.
        abort(403, 'Forbidden: only admins can update actual completion date.');
    }

    /**
     * Export a single joborder to PDF
     */
    public function exportPdf(JobOrder $joborder)
    {
        $joborder->load(['items.material', 'creator', 'approvedBy', 'rejectedBy', 'eppApprovedBy']);
        $pdf = null;
        try {
            $pdf = Pdf::loadView('customer.joborders.pdf', compact('joborder'));
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
