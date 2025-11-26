@extends('layouts.customer')

@section('title', 'Job Orders')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-rose-100 px-6 py-5 border-b border-red-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-red-600 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-800">Data Job Order</h1>
                            <p class="text-sm text-slate-600 mt-0.5">Kelola dan monitor project workshop</p>
                        </div>
                    </div>
                    <a href="{{ route('customer.joborder.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-red-700 hover:to-rose-700 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Job Order
                    </a>
                </div>
            </div>

            {{-- session flash notifications removed per user request --}}

            @if(session('error'))
                <div class="mx-6 mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V7a1 1 0 112 0v2a1 1 0 11-2 0zm0 4a1 1 0 112 0 1 1 0 11-2 0z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Search & Filter Section -->
            <div class="px-6 py-4 bg-rose-50 border-y border-rose-100">
                <form method="GET" action="{{ route('customer.joborder.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-2">Cari Project</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan project atau seksi..."
                        class="w-full pl-10 pr-4 py-2 bg-white border border-rose-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>

                        <!-- Filter Status -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 bg-white border border-rose-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">Semua Status</option>
                                <option value="Urgent" {{ request('status') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="High" {{ request('status') == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Medium" {{ request('status') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="Low" {{ request('status') == 'Low' ? 'selected' : '' }}>Low</option>
                            </select>
                        </div>

                        <!-- Filter Seksi -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2">Seksi</label>
                            <select name="seksi" class="w-full px-3 py-2 bg-white border border-rose-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">Semua Seksi</option>
                                <option value="Gensub" {{ request('seksi') == 'Gensub' ? 'selected' : '' }}>Gensub</option>
                                <option value="Assy Unit" {{ request('seksi') == 'Assy Unit' ? 'selected' : '' }}>Assy Unit</option>
                                <option value="Painting Steel" {{ request('seksi') == 'Painting Steel' ? 'selected' : '' }}>Painting Steel</option>
                                <option value="Welding" {{ request('seksi') == 'Welding' ? 'selected' : '' }}>Welding</option>
                                <option value="Assy Engine" {{ request('seksi') == 'Assy Engine' ? 'selected' : '' }}>Assy Engine</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Filter Evaluasi -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2">Evaluasi</label>
                            <select name="evaluasi" class="w-full px-3 py-2 bg-white border border-rose-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">Semua Evaluasi</option>
                                <option value="Tepat Waktu" {{ request('evaluasi') == 'Tepat Waktu' ? 'selected' : '' }}>Tepat Waktu</option>
                                <option value="Terlambat" {{ request('evaluasi') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                        </div>

                        <!-- Filter Progress -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2">Progress</label>
                            <select name="progress" class="w-full px-3 py-2 bg-white border border-rose-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">Semua Progress</option>
                                <option value="0-25" {{ request('progress') == '0-25' ? 'selected' : '' }}>0% - 25%</option>
                                <option value="26-50" {{ request('progress') == '26-50' ? 'selected' : '' }}>26% - 50%</option>
                                <option value="51-75" {{ request('progress') == '51-75' ? 'selected' : '' }}>51% - 75%</option>
                                <option value="76-100" {{ request('progress') == '76-100' ? 'selected' : '' }}>76% - 100%</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="md:col-span-2 flex items-end gap-2">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('customer.joborder.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-semibold transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="p-6">
                @if($joborders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b-2 border-slate-200">
                                    <th class="px-3 py-3 text-center text-xs font-bold text-slate-700 uppercase">No. Project</th>
                                    <th class="px-3 py-3 text-left text-xs font-bold text-slate-700 uppercase">Seksi</th>
                                    <th class="px-3 py-3 text-center text-xs font-bold text-slate-700 uppercase">Status</th>
                                    <th class="px-3 py-3 text-left text-xs font-bold text-slate-700 uppercase">Project</th>
                                    <th class="px-3 py-3 text-center text-xs font-bold text-slate-700 uppercase">Start</th>
                                    <th class="px-3 py-3 text-center text-xs font-bold text-slate-700 uppercase">End</th>
                                    <th class="px-3 py-3 text-center text-xs font-bold text-slate-700 uppercase">Progress</th>
                                    <th class="px-3 py-3 text-center text-xs font-bold text-slate-700 uppercase">Actual</th>
                                    <th class="px-3 py-3 text-center text-xs font-bold text-slate-700 uppercase">Evaluasi</th>
                                    <th class="px-3 py-3 text-center text-xs font-bold text-slate-700 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($joborders as $index => $jo)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <!-- No. Project -->
                                        <td class="px-3 py-3 text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-700 font-bold text-xs">
                                                {{ $index + 1 + ($joborders->currentPage() - 1) * $joborders->perPage() }}
                                            </span>
                                        </td>

                                        <!-- Seksi -->
                                        <td class="px-3 py-3">
                                            <span class="font-medium text-slate-800">{{ $jo->seksi ?? '-' }}</span>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-3 py-3 text-center">
                                            @php
                                                $statusColors = [
                                                    'Low' => 'bg-green-100 text-green-700 border-green-300',
                                                    'Medium' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                                    'High' => 'bg-orange-100 text-orange-700 border-orange-300',
                                                    'Urgent' => 'bg-red-100 text-red-700 border-red-300',
                                                ];
                                                $colorClass = $statusColors[$jo->status] ?? 'bg-slate-100 text-slate-700 border-slate-300';
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $colorClass }}">
                                                {{ $jo->status }}
                                            </span>
                                        </td>

                                        <!-- Project -->
                                        <td class="px-3 py-3">
                                            <span class="text-slate-800 font-medium">{{ $jo->project }}</span>
                                        </td>

                                        <!-- Start -->
                                        <td class="px-3 py-3 text-center">
                                            <span class="text-slate-600 text-xs">
                                                {{ $jo->start ? \Carbon\Carbon::parse($jo->start)->format('d-m-Y') : '-' }}
                                            </span>
                                        </td>

                                        <!-- End -->
                                        <td class="px-3 py-3 text-center">
                                            <span class="text-slate-600 text-xs">
                                                {{ $jo->end ? \Carbon\Carbon::parse($jo->end)->format('d-m-Y') : '-' }}
                                            </span>
                                        </td>

                                        <!-- Progress (display only for customers) -->
                                        <td class="px-3 py-3 text-center">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-700 rounded-lg transition-colors duration-150 text-xs font-semibold">
                                                {{ $jo->progress ?? 0 }}%
                                            </span>
                                        </td>

                                        <!-- Actual (display only for customers) -->
                                        <td class="px-3 py-3 text-center">
                                            @if($jo->actual)
                                                <span class="text-slate-700 text-xs font-medium">{{ \Carbon\Carbon::parse($jo->actual)->format('d-m-Y') }}</span>
                                            @else
                                                <span class="text-slate-400 text-xs">-</span>
                                            @endif
                                        </td>

                                        <!-- Evaluasi -->
                                        <td class="px-3 py-3 text-center">
                                            @if($jo->evaluasi)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $jo->evaluasi == 'Tepat Waktu' ? 'bg-green-100 text-green-700 border-green-300' : 'bg-red-100 text-red-700 border-red-300' }}">
                                                    {{ $jo->evaluasi }}
                                                </span>
                                            @else
                                                <span class="text-slate-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <!-- Aksi -->
                                        <td class="px-3 py-3 text-center">
                                            <div class="flex justify-center items-center gap-1">
                                                @include('admin.partials.action-buttons', [
                                                        'editRoute' => route('customer.joborder.edit', $jo->id),
                                                        'destroyRoute' => route('customer.joborder.destroy', $jo->id),
                                                        'pdfRoute' => route('customer.joborder.exportPdf', $jo->id) . '?stream=1',
                                                        'labelAlign' => 'center',
                                                        'deleteTitle' => 'Hapus job order?',
                                                        'deleteText' => 'Yakin ingin menghapus job order ini?',
                                                        'deleteConfirm' => 'Hapus'
                                                    ])
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-slate-500 font-medium">Belum ada data job order</p>
                    </div>
                @endif

                <!-- Pagination -->
                @if($joborders->hasPages())
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 px-6 py-4 mt-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-slate-600">
                                Menampilkan {{ $joborders->firstItem() }} - {{ $joborders->lastItem() }} dari {{ $joborders->total() }} project
                            </div>
                            <div class="flex items-center gap-2">
                                {{-- Previous Page Link --}}
                                @if ($joborders->onFirstPage())
                                    <span class="px-3 py-2 text-sm bg-slate-100 text-slate-400 rounded-lg cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $joborders->appends(request()->input())->previousPageUrl() }}" class="px-3 py-2 text-sm bg-white text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-800 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($joborders->getUrlRange(1, $joborders->lastPage()) as $page => $url)
                                    @if ($page == $joborders->currentPage())
                                        <span class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg font-medium">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}&{{ http_build_query(request()->except('page')) }}" class="px-3 py-2 text-sm bg-white text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-800 transition-colors duration-200">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($joborders->hasMorePages())
                                    <a href="{{ $joborders->appends(request()->input())->nextPageUrl() }}" class="px-3 py-2 text-sm bg-white text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-800 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="px-3 py-2 text-sm bg-slate-100 text-slate-400 rounded-lg cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Progress/Actual inputs removed for customer: admin manages these fields -->
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form.swal-delete').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus job order?',
                        text: 'Data job order akan dihapus dan tidak dapat dikembalikan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            confirmButton: 'swal2-confirm-red',
                            cancelButton: 'swal2-cancel-gray'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // submit the form programmatically
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        // Show toast notifications for flash messages (success / error)
        document.addEventListener('DOMContentLoaded', function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
            });

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: {!! json_encode(session('error')) !!}
                });
            @endif
        });
    </script>


    <style>
        /* Custom SweetAlert button styling */
        .swal2-confirm-red {
            background-color: #dc2626 !important;
            color: white !important;
            border: none !important;
            font-weight: 600 !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
        }
        .swal2-confirm-red:hover {
            background-color: #b91c1c !important;
        }
        .swal2-cancel-gray {
            background-color: #6b7280 !important;
            color: white !important;
            border: none !important;
            font-weight: 600 !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
        }
        .swal2-cancel-gray:hover {
            background-color: #4b5563 !important;
        }
    </style>
@endsection
