<?php

namespace App\Http\Controllers\ManagementEpp;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService)
    {
    }

    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $notifications = $this->notificationService->getNotifications(auth()->user(), 15, $filter);
        $unreadCount = $this->notificationService->getUnreadCount(auth()->user());

        return view('notifications.index', [
            'layoutView' => 'layouts.management-epp',
            'pageTitle' => 'Notifications',
            'pageSubtitle' => 'Job Order approval updates',
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'showRouteName' => 'management-epp.notifications.show',
            'markAsReadRouteName' => 'management-epp.notifications.markAsRead',
            'markAllReadRouteName' => 'management-epp.notifications.markAllAsRead',
        ]);
    }

    public function show(Notification $notification)
    {
        // Ensure user owns this notification
        abort_if($notification->user_id !== auth()->id(), 403);

        $notification->markAsRead();

        return view('notifications.show', [
            'layoutView' => 'layouts.management-epp',
            'pageTitle' => 'Notification Details',
            'backRouteName' => 'management-epp.notifications.index',
            'notification' => $notification,
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        // Ensure user owns this notification
        abort_if($notification->user_id !== auth()->id(), 403);

        $this->notificationService->markAsRead($notification->id, auth()->user());

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        $count = $this->notificationService->markAllAsRead(auth()->user());

        return back()->with('success', "{$count} notifikasi ditandai sudah dibaca.");
    }

    public function getUnreadCount()
    {
        return response()->json([
            'count' => $this->notificationService->getUnreadCount(auth()->user())
        ]);
    }
}
