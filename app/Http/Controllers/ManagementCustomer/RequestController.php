<?php

namespace App\Http\Controllers\ManagementCustomer;

use App\Http\Controllers\Controller;
use App\Models\JobOrder;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct(protected NotificationService $notificationService)
    {
    }

    public function index(Request $request)
    {
        $user = auth()->user()->loadMissing(['departement', 'jabatan']);

        $baseQuery = JobOrder::with(['creator.departement', 'creator.jabatan'])
            ->whereHas('creator', function ($creatorQuery) use ($user) {
                $creatorQuery->where('department_id', $user->department_id);
            });

        if ($request->filled('status')) {
            $baseQuery->where('approval_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function ($jobQuery) use ($search) {
                $jobQuery->where('project', 'like', '%' . $search . '%')
                    ->orWhere('seksi', 'like', '%' . $search . '%');
            });
        }

        $requests = (clone $baseQuery)->latest('approval_requested_at')->paginate(10)->withQueryString();
        $pendingCount = (clone $baseQuery)->where('approval_status', 'pending')->count();
        $approvedCount = (clone $baseQuery)->where('approval_status', 'approved')->count();
        $rejectedCount = (clone $baseQuery)->where('approval_status', 'rejected')->count();

        return view('management-customer.requests.index', compact(
            'user',
            'requests',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    public function approve(JobOrder $jobOrder)
    {
        $this->ensureSameDepartment($jobOrder);

        if ($jobOrder->approval_status !== 'pending') {
            return back()->with('error', 'Request sudah diproses.');
        }

        $jobOrder->update([
            'approval_status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejected_by' => null,
            'rejected_at' => null,
            'rejection_reason' => null,
        ]);

        $this->notificationService->notifyJobOrderApproved($jobOrder->fresh('creator'), auth()->user());

        return back()->with('success', 'Job order berhasil di-approve.');
    }

    public function reject(Request $request, JobOrder $jobOrder)
    {
        $this->ensureSameDepartment($jobOrder);

        $data = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        if ($jobOrder->approval_status !== 'pending') {
            return back()->with('error', 'Request sudah diproses.');
        }

        $jobOrder->update([
            'approval_status' => 'rejected',
            'rejected_by' => auth()->id(),
            'rejected_at' => now(),
            'approved_by' => null,
            'approved_at' => null,
            'rejection_reason' => $data['rejection_reason'] ?? null,
        ]);

        $this->notificationService->notifyJobOrderRejected($jobOrder->fresh('creator'), auth()->user(), $data['rejection_reason'] ?? null);

        return back()->with('success', 'Job order berhasil di-reject.');
    }

    public function show(JobOrder $jobOrder)
    {
        $this->ensureSameDepartment($jobOrder);
        $jobOrder->load(['items.material.satuan', 'creator']);
        return view('management-customer.requests.show', compact('jobOrder'));
    }

    public function exportPdf(JobOrder $jobOrder)
    {
        $this->ensureSameDepartment($jobOrder);
        $joborder = $jobOrder; // Variable name compatibility with the PDF view
        $joborder->load(['items.material', 'creator', 'approvedBy', 'rejectedBy', 'eppApprovedBy']);
        
        try {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.joborders.pdf', compact('joborder'));
        } catch (\Throwable $e) {
            \Log::error('Export PDF error for JobOrder '.$joborder->id.': '.$e->getMessage());
            return back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }

        if (request()->query('stream')) {
            return $pdf->stream('joborder-'.$joborder->id.'.pdf');
        }

        return $pdf->download('joborder-'.$joborder->id.'.pdf');
    }

    protected function ensureSameDepartment(JobOrder $jobOrder): void
    {
        $user = auth()->user();
        $creatorDepartmentId = $jobOrder->creator?->department_id;

        abort_unless($user->isManagementCustomer() && $user->department_id === $creatorDepartmentId, 403);
    }
}
