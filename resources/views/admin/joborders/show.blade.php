@extends('layouts.admin')

@section('title', 'Job Order Details')

@section('content')
    <div class="space-y-6">
        <!-- Back Button -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.joborder.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Job Orders
            </a>
        </div>

        <!-- Job Order Header -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-rose-100 px-6 py-5 border-b border-red-100">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800 mb-2">{{ $joborder->project }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-sm">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="text-slate-600">{{ $joborder->seksi ?? 'No Seksi' }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-slate-600">{{ $joborder->area ?? 'No Area' }}</span>
                            </div>
                            @if($joborder->creator)
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-slate-600">Created by {{ $joborder->creator->name }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Badge -->
                    @php
                        $statusColors = [
                            'Low' => 'bg-green-100 text-green-700 border-green-300',
                            'Medium' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                            'High' => 'bg-orange-100 text-orange-700 border-orange-300',
                            'Urgent' => 'bg-red-100 text-red-700 border-red-300',
                        ];
                        $colorClass = $statusColors[$joborder->status] ?? 'bg-slate-100 text-slate-700 border-slate-300';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold border {{ $colorClass }}">
                        {{ $joborder->status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Timeline Information -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Timeline & Progress
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Start Date</label>
                            <div class="text-sm text-slate-600">
                                {{ $joborder->start ? \Carbon\Carbon::parse($joborder->start)->format('d M Y') : 'Not set' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">End Date</label>
                            <div class="text-sm text-slate-600">
                                {{ $joborder->end ? \Carbon\Carbon::parse($joborder->end)->format('d M Y') : 'Not set' }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Actual Completion</label>
                            <div class="text-sm text-slate-600">
                                {{ $joborder->actual ? \Carbon\Carbon::parse($joborder->actual)->format('d M Y') : 'Not completed' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Evaluasi</label>
                            <div class="text-sm">
                                @if($joborder->evaluasi)
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold border {{ $joborder->evaluasi == 'Tepat Waktu' ? 'bg-green-100 text-green-700 border-green-300' : 'bg-red-100 text-red-700 border-red-300' }}">
                                        {{ $joborder->evaluasi }}
                                    </span>
                                @else
                                    <span class="text-slate-400">Not evaluated</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Progress</label>
                        <div class="flex items-center gap-3">
                            <div class="flex-1 bg-slate-200 rounded-full h-3">
                                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $joborder->progress ?? 0 }}%"></div>
                            </div>
                            <span class="text-sm font-semibold text-slate-700 min-w-[3rem]">{{ $joborder->progress ?? 0 }}%</span>
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div class="pt-4 border-t border-slate-100">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Created</label>
                        <div class="text-sm text-slate-600">
                            {{ $joborder->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Fields -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Description
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Latar Belakang</label>
                        <div class="bg-slate-50 rounded-lg p-3">
                            <p class="text-sm text-slate-600">{{ $joborder->latar_belakang ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tujuan</label>
                        <div class="bg-slate-50 rounded-lg p-3">
                            <p class="text-sm text-slate-600">{{ $joborder->tujuan ?? 'Not specified' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Target</label>
                        <div class="bg-slate-50 rounded-lg p-3">
                            <p class="text-sm text-slate-600">{{ $joborder->target ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materials/Items -->
        @if($joborder->items && $joborder->items->count() > 0)
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Materials Required
                    </h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200">
                                    <th class="text-left py-3 px-4 font-semibold text-slate-700">Material</th>
                                    <th class="text-center py-3 px-4 font-semibold text-slate-700">Jumlah</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-700">Satuan</th>
                                    <th class="text-left py-3 px-4 font-semibold text-slate-700">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($joborder->items as $item)
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 px-4">
                                            <div class="font-medium text-slate-800">{{ $item->material->nama ?? 'N/A' }}</div>
                                            @if($item->material && $item->material->spesifikasi)
                                                <div class="text-xs text-slate-500 mt-1">{{ $item->material->spesifikasi }}</div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="font-medium text-slate-800">{{ $item->jumlah ?? 0 }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-slate-600">
                                            {{ $item->material->satuan->nama ?? 'N/A' }}
                                        </td>
                                        <td class="py-3 px-4 text-slate-600">
                                            {{ $item->keterangan ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Actions</h2>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.joborder.edit', $joborder) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Job Order
                    </a>

                    <a href="{{ route('admin.joborder.exportPdf', $joborder) }}?stream=1" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200" target="_blank">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download PDF
                    </a>

                    <button onclick="confirmDelete()" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Job Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form (hidden) -->
    <form id="deleteForm" action="{{ route('admin.joborder.destroy', $joborder) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Delete Job Order?',
                text: 'This action cannot be undone. The job order will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
@endsection
