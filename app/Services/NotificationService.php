<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\JobOrder;

class NotificationService
{
    protected function managementCustomerRecipients(User $customer)
    {
        return User::where('department_id', $customer->department_id)
            ->where(function ($query) {
                $query->where('role', 'management-customer')
                    ->orWhereHas('jabatan', function ($q) {
                        $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) = ?", ['managementcustomer']);
                    });
            })
            ->get();
    }

    protected function managementEppRecipients()
    {
        return User::where(function ($query) {
            $query->where('role', 'management-epp')
                ->orWhereHas('jabatan', function ($q) {
                    $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) IN (?, ?, ?)", [
                        'managementepp',
                        'manajemenepp',
                        'manajementepp'
                    ]);
                });
        })->get();
    }

    /**
     * Send notification to all admin users
     */
    public function notifyAdmins(string $title, string $message, string $type, JobOrder $jobOrder = null, User $actionBy = null): void
    {
        $admins = User::where('role', 'admin')->get();

        // Log for debugging
        \Log::info("Sending notification to {$admins->count()} admin users", [
            'title' => $title,
            'type' => $type,
            'admins' => $admins->pluck('name', 'id')->toArray()
        ]);

        foreach ($admins as $admin) {
            $notification = Notification::create([
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'user_id' => $admin->id,
                'job_order_id' => $jobOrder ? $jobOrder->id : null,
                'action_by' => $actionBy ? $actionBy->id : null,
                'data' => [
                    'job_order_project' => $jobOrder ? $jobOrder->project : null,
                    'job_order_seksi' => $jobOrder ? $jobOrder->seksi : null,
                    'job_order_area' => $jobOrder ? $jobOrder->area : null,
                    'action_by_name' => $actionBy ? $actionBy->name : null,
                    'action_by_npk' => $actionBy ? $actionBy->npk : null,
                ]
            ]);

            \Log::info("Notification created", [
                'notification_id' => $notification->id,
                'admin_id' => $admin->id,
                'admin_name' => $admin->name
            ]);
        }
    }

    /**
     * Notify when job order is created
     */
    public function notifyJobOrderCreated(JobOrder $jobOrder, User $customer): void
    {
        $this->notifyJobOrderApprovalRequested($jobOrder, $customer);
    }

    public function notifyJobOrderApprovalRequested(JobOrder $jobOrder, User $customer): void
    {
        foreach ($this->managementCustomerRecipients($customer) as $recipient) {
            Notification::create([
                'title' => 'Approval Request JO Baru',
                'message' => "Permintaan approval JO '{$jobOrder->project}' dari {$customer->name} menunggu persetujuan Anda.",
                'type' => 'job_order_approval_requested',
                'user_id' => $recipient->id,
                'job_order_id' => $jobOrder->id,
                'action_by' => $customer->id,
                'data' => [
                    'job_order_project' => $jobOrder->project,
                    'job_order_seksi' => $jobOrder->seksi,
                    'job_order_area' => $jobOrder->area,
                    'request_by_name' => $customer->name,
                    'requested_at' => $jobOrder->approval_requested_at?->toDateTimeString() ?? now()->toDateTimeString(),
                    'status' => 'pending',
                ]
            ]);
        }
    }

    /**
     * Notify management customer when a previously rejected job order is resubmitted after edit
     */
    public function notifyJobOrderResubmitted(JobOrder $jobOrder, User $customer): void
    {
        foreach ($this->managementCustomerRecipients($customer) as $recipient) {
            Notification::create([
                // Make title/message more prominent to indicate resubmission
                'title' => 'RESUBMISI: Permintaan Approval JO',
                'message' => "PERHATIAN — JO ini adalah resubmisi setelah ditolak. Permintaan approval ulang JO '{$jobOrder->project}' dari {$customer->name} menunggu persetujuan Anda.",
                'type' => 'job_order_resubmitted',
                'user_id' => $recipient->id,
                'job_order_id' => $jobOrder->id,
                'action_by' => $customer->id,
                'data' => [
                    'job_order_project' => $jobOrder->project,
                    'job_order_seksi' => $jobOrder->seksi,
                    'job_order_area' => $jobOrder->area,
                    'request_by_name' => $customer->name,
                    'requested_at' => $jobOrder->approval_requested_at?->toDateTimeString() ?? now()->toDateTimeString(),
                    'status' => 'resubmitted',
                ]
            ]);
        }
    }

    public function notifyJobOrderApproved(JobOrder $jobOrder, User $approvedBy): void
    {
        // Notif to EPP
        foreach ($this->managementEppRecipients() as $recipient) {
            Notification::create([
                'title' => 'Approval Request JO (EPP)',
                'message' => "Job Order '{$jobOrder->project}' telah disetujui Management Customer dan menunggu persetujuan EPP Anda.",
                'type' => 'job_order_epp_approval_requested',
                'user_id' => $recipient->id,
                'job_order_id' => $jobOrder->id,
                'action_by' => $approvedBy->id,
                'data' => [
                    'job_order_project' => $jobOrder->project,
                    'job_order_seksi' => $jobOrder->seksi,
                    'approved_by_name' => $approvedBy->name,
                    'approved_at' => now()->toDateTimeString(),
                    'status' => 'pending_epp',
                ]
            ]);
        }

        // Notif to Customer
        $customer = $jobOrder->creator;
        if ($customer) {
            Notification::create([
                'title' => 'Job Order Disetujui Management Customer',
                'message' => "Job Order '{$jobOrder->project}' telah disetujui Management Customer dan sedang diteruskan ke Management EPP.",
                'type' => 'job_order_approved_stage_1',
                'user_id' => $customer->id,
                'job_order_id' => $jobOrder->id,
                'action_by' => $approvedBy->id,
                'data' => [
                    'job_order_project' => $jobOrder->project,
                    'job_order_seksi' => $jobOrder->seksi,
                    'approved_by_name' => $approvedBy->name,
                    'approved_at' => now()->toDateTimeString(),
                    'status' => 'pending_epp',
                ]
            ]);
        }
    }

    public function notifyEppJobOrderApproved(JobOrder $jobOrder, User $approvedBy): void
    {
        $customer = $jobOrder->creator;

        // Notify Admins
        $this->notifyAdmins(
            'Job Order Baru Disetujui',
            "Job Order '{$jobOrder->project}' telah disetujui penuh (termasuk EPP) dan siap dikerjakan.",
            'job_order_fully_approved',
            $jobOrder,
            $approvedBy
        );

        // Notify Customer
        if ($customer) {
            Notification::create([
                'title' => 'Job Order Disetujui Sepenuhnya',
                'message' => "Job Order '{$jobOrder->project}' telah disetujui oleh Management EPP dan diteruskan ke Admin Workshop.",
                'type' => 'job_order_approved',
                'user_id' => $customer->id,
                'job_order_id' => $jobOrder->id,
                'action_by' => $approvedBy->id,
                'data' => [
                    'job_order_project' => $jobOrder->project,
                    'job_order_seksi' => $jobOrder->seksi,
                    'request_by_name' => $customer->name,
                    'approved_by_name' => $approvedBy->name,
                    'approved_at' => now()->toDateTimeString(),
                    'status' => 'yes',
                ]
            ]);

            // Notify Management Customer
            foreach ($this->managementCustomerRecipients($customer) as $recipient) {
                Notification::create([
                    'title' => 'Job Order Disetujui Management EPP',
                    'message' => "Job Order '{$jobOrder->project}' dari departemen Anda telah disetujui oleh Management EPP dan diteruskan ke Admin Workshop.",
                    'type' => 'job_order_fully_approved',
                    'user_id' => $recipient->id,
                    'job_order_id' => $jobOrder->id,
                    'action_by' => $approvedBy->id,
                    'data' => [
                        'job_order_project' => $jobOrder->project,
                        'job_order_seksi' => $jobOrder->seksi,
                        'request_by_name' => $customer->name,
                        'approved_by_name' => $approvedBy->name,
                        'approved_at' => now()->toDateTimeString(),
                        'status' => 'yes',
                    ]
                ]);
            }
        }
    }

    public function notifyJobOrderRejected(JobOrder $jobOrder, User $rejectedBy, ?string $reason = null): void
    {
        $customer = $jobOrder->creator;
        if (!$customer) {
            return;
        }

        Notification::create([
            'title' => 'Job Order Ditolak',
            'message' => "Job Order '{$jobOrder->project}' ditolak oleh management customer." . ($reason ? ' Alasan: ' . $reason : ''),
            'type' => 'job_order_rejected',
            'user_id' => $customer->id,
            'job_order_id' => $jobOrder->id,
            'action_by' => $rejectedBy->id,
            'data' => [
                'job_order_project' => $jobOrder->project,
                'job_order_seksi' => $jobOrder->seksi,
                'request_by_name' => $customer->name,
                'rejected_by_name' => $rejectedBy->name,
                'rejected_at' => now()->toDateTimeString(),
                'rejection_reason' => $reason,
                'status' => 'no',
            ]
        ]);
    }

    /**
     * Notify when job order is updated
     */
    public function notifyJobOrderUpdated(JobOrder $jobOrder, User $customer): void
    {
        foreach ($this->managementCustomerRecipients($customer) as $recipient) {
            Notification::create([
                'title' => 'Job Order Diperbarui',
                'message' => "Job Order '{$jobOrder->project}' telah diperbarui oleh {$customer->name}.",
                'type' => 'job_order_updated',
                'user_id' => $recipient->id,
                'job_order_id' => $jobOrder->id,
                'action_by' => $customer->id,
                'data' => [
                    'job_order_project' => $jobOrder->project,
                    'job_order_seksi' => $jobOrder->seksi,
                    'action_by_name' => $customer->name,
                ]
            ]);
        }
    }

    /**
     * Notify when job order is deleted
     */
    public function notifyJobOrderDeleted(JobOrder $jobOrder, User $customer): void
    {
        foreach ($this->managementCustomerRecipients($customer) as $recipient) {
            Notification::create([
                'title' => 'Job Order Dihapus',
                'message' => "Job Order '{$jobOrder->project}' telah dihapus oleh {$customer->name}.",
                'type' => 'job_order_deleted',
                'user_id' => $recipient->id,
                'job_order_id' => null, // Set to null to prevent cascade deletion when JobOrder is deleted
                'action_by' => $customer->id,
                'data' => [
                    'job_order_project' => $jobOrder->project,
                    'job_order_seksi' => $jobOrder->seksi,
                    'action_by_name' => $customer->name,
                ]
            ]);
        }
    }

    /**
     * Get unread notification count for a user
     */
    public function getUnreadCount(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->unread()
            ->count();
    }

    /**
     * Get notifications for a user with pagination
     */
    public function getNotifications(User $user, int $limit = 10, ?string $filter = null)
    {
        $query = Notification::where('user_id', $user->id)
            ->with(['jobOrder', 'actionBy']);

        // Support filter = 'resubmisi' to show only resubmitted JO notifications
        if ($filter && in_array(strtolower($filter), ['resubmisi', 'resubmitted', 'resubmission'])) {
            $query->where('type', 'job_order_resubmitted');
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId, User $user): bool
    {
        $notification = Notification::where('id', $notificationId)
            ->where('user_id', $user->id)
            ->first();

        if ($notification) {
            return $notification->markAsRead();
        }

        return false;
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->unread()
            ->update(['read_at' => now()]);
    }
}
