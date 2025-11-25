@extends('layouts.admin')

@section('title', 'Notification Details')

@section('content')
    <div class="space-y-6">
        <!-- Back Button -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.notifications.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Notifications
            </a>
        </div>

        <!-- Notification Header -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-rose-100 px-6 py-5 border-b border-red-100">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <!-- Icon based on type -->
                        <div class="flex-shrink-0">
                            @if($notification->type === 'job_order_created')
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-green-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.53 10.7a.75.75 0 00-1.06 1.061l1.5 1.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @elseif($notification->type === 'job_order_updated')
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-yellow-600">
                                        <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                                    </svg>
                                </div>
                            @elseif($notification->type === 'job_order_deleted')
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6 text-red-600">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-slate-800 mb-2">{{ $notification->title }}</h1>
                            <p class="text-slate-600 mb-4">{{ $notification->message }}</p>

                            <!-- Metadata -->
                            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $notification->created_at->format('d M Y, H:i') }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                </div>
                                @if($notification->actionBy)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        By {{ $notification->actionBy->name }} ({{ $notification->actionBy->npk ?? 'N/A' }})
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex-shrink-0">
                        @if($notification->isRead())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.53 10.7a.75.75 0 00-1.06 1.061l1.5 1.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                Read
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                New
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Order Details -->
        @if($notification->jobOrder)
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Job Order Details
                    </h2>
                </div>

                <div class="p-6">
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-red-50 to-rose-50 rounded-lg p-4">
                                <h3 class="text-sm font-semibold text-slate-700 mb-3">Basic Information</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">Project:</span>
                                        <span class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->project }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">Seksi:</span>
                                        <span class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->seksi ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">Area:</span>
                                        <span class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->area ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">Status:</span>
                                        @php
                                            $statusColors = [
                                                'Low' => 'bg-green-100 text-green-700 border-green-300',
                                                'Medium' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                                'High' => 'bg-orange-100 text-orange-700 border-orange-300',
                                                'Urgent' => 'bg-red-100 text-red-700 border-red-300',
                                            ];
                                            $colorClass = $statusColors[$notification->jobOrder->status] ?? 'bg-slate-100 text-slate-700 border-slate-300';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold border {{ $colorClass }}">
                                            {{ $notification->jobOrder->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4">
                                <h3 class="text-sm font-semibold text-slate-700 mb-3">Timeline</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">Start Date:</span>
                                        <span class="text-sm font-medium text-slate-800">
                                            {{ $notification->jobOrder->start ? \Carbon\Carbon::parse($notification->jobOrder->start)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">End Date:</span>
                                        <span class="text-sm font-medium text-slate-800">
                                            {{ $notification->jobOrder->end ? \Carbon\Carbon::parse($notification->jobOrder->end)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">Actual Date:</span>
                                        <span class="text-sm font-medium text-slate-800">
                                            {{ $notification->jobOrder->actual ? \Carbon\Carbon::parse($notification->jobOrder->actual)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-slate-600">Progress:</span>
                                        <div class="flex items-center gap-2">
                                            <div class="w-16 bg-slate-200 rounded-full h-2">
                                                <div class="bg-red-600 h-2 rounded-full" style="width: {{ $notification->jobOrder->progress ?? 0 }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->progress ?? 0 }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Fields -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <div class="bg-slate-50 rounded-lg p-4">
                            <h3 class="text-sm font-semibold text-slate-700 mb-2">Latar Belakang</h3>
                            <p class="text-sm text-slate-600">{{ $notification->jobOrder->latar_belakang ?? 'Not specified' }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4">
                            <h3 class="text-sm font-semibold text-slate-700 mb-2">Tujuan</h3>
                            <p class="text-sm text-slate-600">{{ $notification->jobOrder->tujuan ?? 'Not specified' }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-4">
                            <h3 class="text-sm font-semibold text-slate-700 mb-2">Target</h3>
                            <p class="text-sm text-slate-600">{{ $notification->jobOrder->target ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <!-- Materials/Items -->
                    @if($notification->jobOrder->items && $notification->jobOrder->items->count() > 0)
                        <div class="bg-amber-50 rounded-lg p-4">
                            <h3 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                Materials Required
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-amber-200">
                                            <th class="text-left py-2 px-3 font-semibold text-slate-700">Material</th>
                                            <th class="text-center py-2 px-3 font-semibold text-slate-700">Jumlah</th>
                                            <th class="text-left py-2 px-3 font-semibold text-slate-700">Satuan</th>
                                            <th class="text-left py-2 px-3 font-semibold text-slate-700">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-amber-200">
                                        @foreach($notification->jobOrder->items as $item)
                                            <tr>
                                                <td class="py-2 px-3">
                                                    <div class="font-medium text-slate-800">{{ $item->material->nama ?? 'N/A' }}</div>
                                                    @if($item->material && $item->material->spesifikasi)
                                                        <div class="text-xs text-slate-500">{{ $item->material->spesifikasi }}</div>
                                                    @endif
                                                </td>
                                                <td class="py-2 px-3 text-center font-medium text-slate-800">{{ $item->jumlah ?? 0 }}</td>
                                                <td class="py-2 px-3 text-slate-600">{{ $item->material->satuan->nama ?? 'N/A' }}</td>
                                                <td class="py-2 px-3 text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Actions</h3>
                <div class="flex flex-wrap gap-3">
                    @if($notification->jobOrder && $notification->type !== 'job_order_deleted')
                        <a href="{{ route('admin.joborder.show', $notification->jobOrder->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Full Job Order
                        </a>
                    @endif

                    @if(!$notification->isRead())
                        <button onclick="markAsRead()" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mark as Read
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function markAsRead() {
            fetch(`/admin/notifications/{{ $notification->id }}/mark-as-read`, {
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
    </script>
@endsection