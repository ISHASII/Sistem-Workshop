<?php

namespace App\Http\Controllers\ManagementEpp;

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
        $departements = \App\Models\Departement::orderBy('name')->get();

        // EPP sees all job orders approved by Management Customer
        $baseQuery = JobOrder::where('approval_status', 'approved')->with(['creator.departement', 'creator.jabatan']);

        if ($request->filled('department_id')) {
            $baseQuery->whereHas('creator', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }

        if ($request->filled('status')) {
            $baseQuery->where('epp_approval_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function ($jobQuery) use ($search) {
                $jobQuery->where('project', 'like', '%' . $search . '%')
                    ->orWhere('seksi', 'like', '%' . $search . '%');
            });
        }

        $requests = (clone $baseQuery)->latest('approval_requested_at')->paginate(10)->withQueryString();
        $pendingCount = (clone $baseQuery)->where('epp_approval_status', 'pending')->count();
        $approvedCount = (clone $baseQuery)->where('epp_approval_status', 'approved')->count();

        return view('management-epp.requests.index', compact(
            'user',
            'requests',
            'pendingCount',
            'approvedCount',
            'departements'
        ));
    }

    public function approve(JobOrder $jobOrder)
    {
        $this->ensureEppAccess();

        if ($jobOrder->epp_approval_status !== 'pending' || $jobOrder->approval_status !== 'approved') {
            return back()->with('error', 'Request tidak valid atau sudah diproses.');
        }

        $jobOrder->update([
            'epp_approval_status' => 'approved',
            'epp_approved_by' => auth()->id(),
            'epp_approved_at' => now(),
        ]);

        $this->notificationService->notifyEppJobOrderApproved($jobOrder->fresh('creator'), auth()->user());

        return back()->with('success', 'Job order berhasil di-approve oleh Management EPP.');
    }

    public function show(JobOrder $jobOrder)
    {
        $this->ensureEppAccess();
        // EPP can see details of JO that have reached the EPP stage (approved by management customer)
        abort_unless($jobOrder->approval_status === 'approved', 403, 'Request belum disetujui oleh Management Customer.');
        
        $jobOrder->load(['items.material.satuan', 'creator']);
        return view('management-epp.requests.show', compact('jobOrder'));
    }

    public function exportPdf(JobOrder $jobOrder)
    {
        $this->ensureEppAccess();
        abort_unless($jobOrder->approval_status === 'approved', 403, 'Request belum disetujui oleh Management Customer.');
        
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

    protected function ensureEppAccess(): void
    {
        $user = auth()->user();
        abort_unless($user->isManagementEpp(), 403);
    }
}
