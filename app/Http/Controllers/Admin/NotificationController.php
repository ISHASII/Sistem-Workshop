<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Models\Notification;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display notifications for admin
     */
    public function index(Request $request)
    {
        $notifications = $this->notificationService->getNotifications(auth()->user(), 15);
        $unreadCount = $this->notificationService->getUnreadCount(auth()->user());

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id)
    {
        $this->notificationService->markAsRead($id, auth()->user());

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $count = $this->notificationService->markAllAsRead(auth()->user());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'count' => $count]);
        }

        return back()->with('success', "Marked {$count} notifications as read.");
    }

    /**
     * Show notification details
     */
    public function show($id)
    {
        $notification = Notification::with(['jobOrder.items.material', 'actionBy'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        // Mark as read when viewed
        if (!$notification->isRead()) {
            $notification->markAsRead();
        }

        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * Get unread notifications count (for AJAX)
     */
    public function getUnreadCount()
    {
        $count = $this->notificationService->getUnreadCount(auth()->user());
        return response()->json(['count' => $count]);
    }
}