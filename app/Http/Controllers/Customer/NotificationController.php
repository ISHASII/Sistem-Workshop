<?php

namespace App\Http\Controllers\Customer;

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
        $filter = $request->get('filter');
        $notifications = $this->notificationService->getNotifications(auth()->user(), 15, $filter);
        $unreadCount = $this->notificationService->getUnreadCount(auth()->user());

        return view('notifications.index', [
            'layoutView' => 'layouts.customer',
            'pageTitle' => 'Notifications',
            'pageSubtitle' => 'Job Order notifications and approval updates',
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'showRouteName' => 'customer.notifications.show',
            'markAsReadRouteName' => 'customer.notifications.markAsRead',
            'markAllReadRouteName' => 'customer.notifications.markAllAsRead',
        ]);
    }

    public function markAsRead(Request $request, Notification $notification)
    {
        $this->notificationService->markAsRead($notification->id, auth()->user());

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(Request $request)
    {
        $count = $this->notificationService->markAllAsRead(auth()->user());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'count' => $count]);
        }

        return back()->with('success', "Marked {$count} notifications as read.");
    }

    public function show(Notification $notification)
    {
        $notification = Notification::with(['jobOrder.items.material', 'actionBy'])
            ->where('user_id', auth()->id())
            ->findOrFail($notification->id);

        if (!$notification->isRead()) {
            $notification->markAsRead();
        }

        return view('notifications.show', [
            'layoutView' => 'layouts.customer',
            'pageTitle' => 'Notification Details',
            'backRouteName' => 'customer.notifications.index',
            'notification' => $notification,
        ]);
    }

    public function getUnreadCount()
    {
        return response()->json(['count' => $this->notificationService->getUnreadCount(auth()->user())]);
    }
}
