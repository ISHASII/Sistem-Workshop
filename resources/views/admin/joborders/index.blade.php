@extends('layouts.admin')

@section('title', 'Job Orders')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5 border-b border-blue-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-600 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-800">Data Job Order</h1>
                            <p class="text-sm text-slate-600 mt-0.5">Kelola dan monitor project workshop</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.joborder.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Job Order
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mx-6 mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Search & Filter Section -->
            <div class="px-6 py-4 bg-slate-50 border-y border-slate-200">
                <form method="GET" action="{{ route('admin.joborder.index') }}" class="space-y-4">
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
                                       class="w-full pl-10 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Filter Status -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                            <select name="seksi" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                            <select name="evaluasi" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Evaluasi</option>
                                <option value="Tepat Waktu" {{ request('evaluasi') == 'Tepat Waktu' ? 'selected' : '' }}>Tepat Waktu</option>
                                <option value="Terlambat" {{ request('evaluasi') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                        </div>

                        <!-- Filter Progress -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-2">Progress</label>
                            <select name="progress" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Progress</option>
                                <option value="0-25" {{ request('progress') == '0-25' ? 'selected' : '' }}>0% - 25%</option>
                                <option value="26-50" {{ request('progress') == '26-50' ? 'selected' : '' }}>26% - 50%</option>
                                <option value="51-75" {{ request('progress') == '51-75' ? 'selected' : '' }}>51% - 75%</option>
                                <option value="76-100" {{ request('progress') == '76-100' ? 'selected' : '' }}>76% - 100%</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="md:col-span-2 flex items-end gap-2">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('admin.joborder.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-semibold transition-colors duration-200">
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
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold text-xs">
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
                                            <span class="text-slate-600 text-xs">{{ $jo->start }}</span>
                                        </td>
                                        
                                        <!-- End -->
                                        <td class="px-3 py-3 text-center">
                                            <span class="text-slate-600 text-xs">{{ $jo->end }}</span>
                                        </td>
                                        
                                        <!-- Progress -->
                                        <td class="px-3 py-3 text-center">
                                            <button onclick="openProgressModal({{ $jo->id }}, {{ $jo->progress ?? 0 }})" 
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition-colors duration-150 text-xs font-semibold">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                {{ $jo->progress ?? 0 }}%
                                            </button>
                                        </td>
                                        
                                        <!-- Actual -->
                                        <td class="px-3 py-3 text-center">
                                            @if($jo->actual)
                                                <span class="text-slate-700 text-xs font-medium">{{ \Carbon\Carbon::parse($jo->actual)->format('d-M-y') }}</span>
                                            @else
                                                <button onclick="openActualModal({{ $jo->id }})" 
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg transition-colors duration-150 text-xs font-semibold">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    Input
                                                </button>
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
                                                <a href="{{ route('admin.joborder.edit', $jo->id) }}" class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition-all duration-150 text-xs font-medium">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.joborder.destroy', $jo->id) }}" class="inline-block" onsubmit="return confirm('Hapus job order ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-all duration-150 text-xs font-medium">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
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
                        <p class="text-sm text-slate-400 mt-1">Klik tombol "Tambah Job Order" untuk menambah data</p>
                    </div>
                @endif

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $joborders->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Progress -->
    <div id="progressModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">Edit Progress</h3>
                    <button onclick="closeProgressModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="progressForm" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Progress (%)</label>
                        <input type="number" name="progress" id="progressInput" min="0" max="100" 
                               class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200" 
                               required>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan
                        </button>
                        <button type="button" onclick="closeProgressModal()" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Input Actual -->
    <div id="actualModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-amber-100 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">Input Tanggal Actual</h3>
                    <button onclick="closeActualModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="actualForm" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Actual Selesai</label>
                        <input type="date" name="actual" id="actualInput" 
                               class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all duration-200" 
                               required>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-3">
                        <p class="text-xs text-blue-700">
                            <strong>Info:</strong> Evaluasi akan otomatis dihitung berdasarkan tanggal End yang telah ditentukan.
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-amber-700 hover:to-orange-700 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan
                        </button>
                        <button type="button" onclick="closeActualModal()" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold transition-colors duration-200">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openProgressModal(jobOrderId, currentProgress) {
            document.getElementById('progressModal').classList.remove('hidden');
            document.getElementById('progressForm').action = `/admin/joborders/${jobOrderId}/update-progress`;
            document.getElementById('progressInput').value = currentProgress;
        }

        function closeProgressModal() {
            document.getElementById('progressModal').classList.add('hidden');
        }

        function openActualModal(jobOrderId) {
            document.getElementById('actualModal').classList.remove('hidden');
            document.getElementById('actualForm').action = `/admin/joborders/${jobOrderId}/update-actual`;
            document.getElementById('actualInput').value = '';
        }

        function closeActualModal() {
            document.getElementById('actualModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('progressModal').addEventListener('click', function(e) {
            if (e.target === this) closeProgressModal();
        });

        document.getElementById('actualModal').addEventListener('click', function(e) {
            if (e.target === this) closeActualModal();
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeProgressModal();
                closeActualModal();
            }
        });
    </script>
@endsection
