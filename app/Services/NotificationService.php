<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\JobOrder;

class NotificationService
{
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
        $this->notifyAdmins(
            'Job Order Baru',
            "Job Order baru dengan project '{$jobOrder->project}' telah dibuat oleh {$customer->name} ({$customer->npk})",
            'job_order_created',
            $jobOrder,
            $customer
        );
    }

    /**
     * Notify when job order is updated
     */
    public function notifyJobOrderUpdated(JobOrder $jobOrder, User $customer): void
    {
        $this->notifyAdmins(
            'Job Order Diperbarui',
            "Job Order dengan project '{$jobOrder->project}' telah diperbarui oleh {$customer->name} ({$customer->npk})",
            'job_order_updated',
            $jobOrder,
            $customer
        );
    }

    /**
     * Notify when job order is deleted
     */
    public function notifyJobOrderDeleted(JobOrder $jobOrder, User $customer): void
    {
        $this->notifyAdmins(
            'Job Order Dihapus',
            "Job Order dengan project '{$jobOrder->project}' telah dihapus oleh {$customer->name} ({$customer->npk})",
            'job_order_deleted',
            $jobOrder,
            $customer
        );
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
    public function getNotifications(User $user, int $limit = 10)
    {
        return Notification::where('user_id', $user->id)
            ->with(['jobOrder', 'actionBy'])
            ->orderBy('created_at', 'desc')
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