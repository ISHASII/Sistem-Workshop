@extends($layoutView)

@section('title', $pageTitle)

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route($backRouteName) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Notifications
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-rose-100 px-6 py-5 border-b border-red-100">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            @php $type = $notification->type ?? ''; @endphp
                            @if($type === 'job_order_resubmitted')
                                <div class="w-12 h-12 bg-violet-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3M20 12a8 8 0 11-16 0 8 8 0 0116 0z" />
                                    </svg>
                                </div>
                            @elseif(in_array($type, ['job_order_approval_requested', 'job_order_created']))
                                <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @elseif($type === 'job_order_approved')
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            @elseif(in_array($type, ['job_order_rejected', 'job_order_deleted']))
                                <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                <h1 class="text-2xl font-bold text-slate-800 mb-2">{{ $notification->title }}</h1>
                                @if($type === 'job_order_resubmitted')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-violet-100 text-violet-800">Resubmisi</span>
                                @endif
                            </div>
                            <p class="text-slate-600 mb-4">{{ $notification->message }}</p>

                            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $notification->created_at->format('d M Y, H:i') }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    @if($type === 'job_order_resubmitted')
                                        Resubmisi
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                    @endif
                                </div>
                                @if($notification->actionBy)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        By
                                        {{ $notification->actionBy->name }}{{ $notification->actionBy->npk ? ' (' . $notification->actionBy->npk . ')' : '' }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex-shrink-0">
                        @if($notification->isRead())
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Read</span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">New</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($notification->jobOrder)
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Job Order Details
                    </h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-red-50 to-rose-50 rounded-lg p-4">
                                <h3 class="text-sm font-semibold text-slate-700 mb-3">Basic Information</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between"><span class="text-sm text-slate-600">Project:</span><span
                                            class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->project }}</span>
                                    </div>
                                    <div class="flex justify-between"><span class="text-sm text-slate-600">Seksi:</span><span
                                            class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->seksi ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between"><span class="text-sm text-slate-600">Area:</span><span
                                            class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->area ?? '-' }}</span>
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
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold border {{ $colorClass }}">{{ $notification->jobOrder->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4">
                                <h3 class="text-sm font-semibold text-slate-700 mb-3">Timeline</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between"><span class="text-sm text-slate-600">Start
                                            Date:</span><span
                                            class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->start ? \Carbon\Carbon::parse($notification->jobOrder->start)->format('d M Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between"><span class="text-sm text-slate-600">End Date:</span><span
                                            class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->end ? \Carbon\Carbon::parse($notification->jobOrder->end)->format('d M Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between"><span class="text-sm text-slate-600">Actual
                                            Date:</span><span
                                            class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->actual ? \Carbon\Carbon::parse($notification->jobOrder->actual)->format('d M Y') : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between"><span class="text-sm text-slate-600">Progress:</span>
                                        <div class="flex items-center gap-2">
                                            <div class="w-16 bg-slate-200 rounded-full h-2">
                                                <div class="bg-red-600 h-2 rounded-full"
                                                    style="width: {{ $notification->jobOrder->progress ?? 0 }}%"></div>
                                            </div><span
                                                class="text-sm font-medium text-slate-800">{{ $notification->jobOrder->progress ?? 0 }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <div class="bg-slate-50 rounded-lg p-4">
                            <h3 class="text-sm font-semibold text-slate-700 mb-2">Latar Belakang</h3>
                            <p class="text-sm text-slate-600">{{ $notification->jobOrder->latar_belakang ?? 'Not specified' }}
                            </p>
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
                </div>
            </div>
        @endif
    </div>
@endsection
