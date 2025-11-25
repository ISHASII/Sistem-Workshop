@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-rose-100 px-6 py-5 border-b border-red-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-red-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-white">
                                <path d="M4.214 3.227a.75.75 0 0 0-1.156-.955 8.97 8.97 0 0 0-1.856 3.825.75.75 0 0 0 1.466.316 7.47 7.47 0 0 1 1.546-3.186ZM16.942 2.272a.75.75 0 0 0-1.157.955 7.47 7.47 0 0 1 1.547 3.186.75.75 0 0 0 1.466-.316 8.971 8.971 0 0 0-1.856-3.825Z" />
                                <path fill-rule="evenodd" d="M10 2a6 6 0 0 0-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 0 0 .515 1.076 32.91 32.91 0 0 0 3.256.508 3.5 3.5 0 0 0 6.972 0 32.903 32.903 0 0 0 3.256-.508.75.75 0 0 0 .515-1.076A11.448 11.448 0 0 1 16 8a6 6 0 0 0-6-6Zm0 14.5a2 2 0 0 1-1.95-1.557 33.54 33.54 0 0 0 3.9 0A2 2 0 0 1 10 16.5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-800">Notifications</h1>
                            <p class="text-sm text-slate-600 mt-0.5">Job Order notifications from customers</p>
                        </div>
                    </div>
                    @if($unreadCount > 0)
                        <button onclick="markAllAsRead()" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-red-700 hover:to-rose-700 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mark All Read ({{ $unreadCount }})
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            @if($notifications->count() > 0)
                <div class="divide-y divide-slate-100">
                    @foreach($notifications as $notification)
                        <div class="notification-item p-4 hover:bg-slate-50 transition-colors duration-200 {{ !$notification->isRead() ? 'bg-red-50 border-l-4 border-red-500' : '' }}" data-id="{{ $notification->id }}">
                            <div class="flex items-start gap-4">
                                <!-- Icon based on type -->
                                <div class="flex-shrink-0 mt-1">
                                    @if($notification->type === 'job_order_created')
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600">
                                                <path d="M4.214 3.227a.75.75 0 0 0-1.156-.955 8.97 8.97 0 0 0-1.856 3.825.75.75 0 0 0 1.466.316 7.47 7.47 0 0 1 1.546-3.186ZM16.942 2.272a.75.75 0 0 0-1.157.955 7.47 7.47 0 0 1 1.547 3.186.75.75 0 0 0 1.466-.316 8.971 8.971 0 0 0-1.856-3.825Z" />
                                                <path fill-rule="evenodd" d="M10 2a6 6 0 0 0-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 0 0 .515 1.076 32.91 32.91 0 0 0 3.256.508 3.5 3.5 0 0 0 6.972 0 32.903 32.903 0 0 0 3.256-.508.75.75 0 0 0 .515-1.076A11.448 11.448 0 0 1 16 8a6 6 0 0 0-6-6Zm0 14.5a2 2 0 0 1-1.95-1.557 33.54 33.54 0 0 0 3.9 0A2 2 0 0 1 10 16.5Z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @elseif($notification->type === 'job_order_updated')
                                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-yellow-600">
                                                <path d="M4.214 3.227a.75.75 0 0 0-1.156-.955 8.97 8.97 0 0 0-1.856 3.825.75.75 0 0 0 1.466.316 7.47 7.47 0 0 1 1.546-3.186ZM16.942 2.272a.75.75 0 0 0-1.157.955 7.47 7.47 0 0 1 1.547 3.186.75.75 0 0 0 1.466-.316 8.971 8.971 0 0 0-1.856-3.825Z" />
                                                <path fill-rule="evenodd" d="M10 2a6 6 0 0 0-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 0 0 .515 1.076 32.91 32.91 0 0 0 3.256.508 3.5 3.5 0 0 0 6.972 0 32.903 32.903 0 0 0 3.256-.508.75.75 0 0 0 .515-1.076A11.448 11.448 0 0 1 16 8a6 6 0 0 0-6-6Zm0 14.5a2 2 0 0 1-1.95-1.557 33.54 33.54 0 0 0 3.9 0A2 2 0 0 1 10 16.5Z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @elseif($notification->type === 'job_order_deleted')
                                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-600">
                                                <path d="M4.214 3.227a.75.75 0 0 0-1.156-.955 8.97 8.97 0 0 0-1.856 3.825.75.75 0 0 0 1.466.316 7.47 7.47 0 0 1 1.546-3.186ZM16.942 2.272a.75.75 0 0 0-1.157.955 7.47 7.47 0 0 1 1.547 3.186.75.75 0 0 0 1.466-.316 8.971 8.971 0 0 0-1.856-3.825Z" />
                                                <path fill-rule="evenodd" d="M10 2a6 6 0 0 0-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 0 0 .515 1.076 32.91 32.91 0 0 0 3.256.508 3.5 3.5 0 0 0 6.972 0 32.903 32.903 0 0 0 3.256-.508.75.75 0 0 0 .515-1.076A11.448 11.448 0 0 1 16 8a6 6 0 0 0-6-6Zm0 14.5a2 2 0 0 1-1.95-1.557 33.54 33.54 0 0 0 3.9 0A2 2 0 0 1 10 16.5Z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Notification Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-semibold text-slate-800 mb-1">
                                                {{ $notification->title }}
                                            </h3>
                                            <p class="text-sm text-slate-600 mb-2">{{ $notification->message }}</p>

                                            <!-- Job Order Details -->
                                            @if($notification->jobOrder)
                                                <div class="bg-slate-50 rounded-lg p-3 mb-2">
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-xs">
                                                        <div><strong>Project:</strong> {{ $notification->jobOrder->project }}</div>
                                                        <div><strong>Seksi:</strong> {{ $notification->jobOrder->seksi }}</div>
                                                        <div><strong>Area:</strong> {{ $notification->jobOrder->area }}</div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Action By -->
                                            @if($notification->actionBy)
                                                <p class="text-xs text-slate-500">
                                                    By: {{ $notification->actionBy->name }} ({{ $notification->actionBy->npk }})
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col items-end gap-2 ml-4">
                                            <div class="flex items-center gap-2">
                                                <!-- View Details Button -->
                                                @if($notification->jobOrder)
                                                    <a href="{{ route('admin.notifications.show', $notification->id) }}" class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg transition-colors duration-200 text-xs font-medium">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                        View Details
                                                    </a>
                                                @endif
                                                @if(!$notification->isRead())
                                                    <button onclick="markAsRead({{ $notification->id }})" class="text-red-600 hover:text-red-800 transition-colors duration-200" title="Mark as read">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                            <span class="text-xs text-slate-400">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    {{ $notifications->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-12 h-12 text-slate-400">
                            <path d="M4.214 3.227a.75.75 0 0 0-1.156-.955 8.97 8.97 0 0 0-1.856 3.825.75.75 0 0 0 1.466.316 7.47 7.47 0 0 1 1.546-3.186ZM16.942 2.272a.75.75 0 0 0-1.157.955 7.47 7.47 0 0 1 1.547 3.186.75.75 0 0 0 1.466-.316 8.971 8.971 0 0 0-1.856-3.825Z" />
                            <path fill-rule="evenodd" d="M10 2a6 6 0 0 0-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 0 0 .515 1.076 32.91 32.91 0 0 0 3.256.508 3.5 3.5 0 0 0 6.972 0 32.903 32.903 0 0 0 3.256-.508.75.75 0 0 0 .515-1.076A11.448 11.448 0 0 1 16 8a6 6 0 0 0-6-6Zm0 14.5a2 2 0 0 1-1.95-1.557 33.54 33.54 0 0 0 3.9 0A2 2 0 0 1 10 16.5Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">No Notifications</h3>
                    <p class="text-slate-600">You don't have any notifications yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function markAsRead(notificationId) {
            fetch(`/admin/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
                    notificationItem.classList.remove('bg-red-50', 'border-l-4', 'border-red-500');
                    const unreadDot = notificationItem.querySelector('.w-2.h-2.bg-red-500');
                    if (unreadDot) unreadDot.remove();
                    const readButton = notificationItem.querySelector('button[onclick*="markAsRead"]');
                    if (readButton) readButton.remove();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function markAllAsRead() {
            Swal.fire({
                title: 'Mark all as read?',
                text: 'This will mark all notifications as read.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, mark all!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/notifications/mark-all-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        }
    </script>
@endsection
