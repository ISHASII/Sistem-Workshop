@extends('layouts.admin')

@section('title', 'Checklist Kualitas')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-rose-100 px-6 py-5 border-b border-red-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-red-600 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-7 4h8a2 2 0 002-2V6a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-800">Checklist Kualitas</h1>
                            <p class="text-sm text-slate-600 mt-0.5">Kelola opsi checklist kualitas untuk job order</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.checklist-quality.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-red-700 hover:to-rose-700 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Checklist
                    </a>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="px-6 py-4 bg-gradient-to-r from-red-50/50 to-rose-50/50 border-b border-red-100">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-white rounded-lg shadow-sm border border-red-200">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-7 4h8a2 2 0 002-2V6a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Total Checklist</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $items->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Search & Filter Section -->
            <div class="px-6 py-4 bg-rose-50 border-y border-rose-100">
                <form method="GET" action="{{ route('admin.checklist-quality.index') }}" class="flex gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari checklist kualitas..."
                               class="w-full pl-10 pr-4 py-2.5 bg-white border border-rose-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.checklist-quality.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Section -->
            <div class="p-6">
                @if($items->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-slate-200">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama Checklist</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Urutan</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($items as $item)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center shadow-sm">
                                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($item->name, 0, 2)) }}</span>
                                                </div>
                                                <span class="font-medium text-slate-800">{{ $item->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="text-slate-700 font-semibold">{{ $item->sort_order }}</span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700' }}">
                                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @include('admin.partials.action-buttons', [
                                                'editRoute' => route('admin.checklist-quality.edit', $item),
                                                'destroyRoute' => route('admin.checklist-quality.destroy', $item),
                                                'labelAlign' => 'center',
                                                'deleteTitle' => 'Hapus checklist?',
                                                'deleteText' => 'Checklist kualitas ini akan dihapus dari daftar.',
                                                'deleteConfirm' => 'Hapus'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-7 4h8a2 2 0 002-2V6a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-slate-500 font-medium">Belum ada checklist kualitas</p>
                        <p class="text-sm text-slate-400 mt-1">Klik tombol "Tambah Checklist" untuk menambah data</p>
                    </div>
                @endif

            <!-- Pagination -->
            @if($items->hasPages())
                <div class="px-4 md:px-6 py-3 md:py-4 border-t border-slate-200 bg-slate-50 rounded-b-xl">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-xs md:text-sm text-slate-600 text-center sm:text-left">
                            Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data
                        </div>
                        <div class="flex items-center gap-1 md:gap-2">
                            @php
                                $current = $items->currentPage();
                                $last = $items->lastPage();
                                $start = max(1, $current - 1);
                                $end = min($last, $current + 1);
                                $qs = http_build_query(request()->except('page'));
                                $qsPrefix = $qs ? '&' . $qs : '';
                            @endphp

                            {{-- Previous --}}
                            @if($items->onFirstPage())
                                <span class="px-2 py-1.5 md:px-3 md:py-2 text-sm rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </span>
                            @else
                                <a href="?page={{ max(1, $current - 1) }}{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </a>
                            @endif

                            {{-- First page + ellipsis if needed --}}
                            @if($start > 1)
                                <a href="?page=1{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-xs md:text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">1</a>
                                @if($start > 2)
                                    <span class="px-1 md:px-2 text-slate-400 text-xs md:text-sm">...</span>
                                @endif
                            @endif

                            {{-- Page window --}}
                            @for($i = $start; $i <= $end; $i++)
                                @if($i == $current)
                                    <span class="px-2 py-1.5 md:px-3 md:py-2 text-xs md:text-sm rounded-lg bg-red-600 text-white font-medium">{{ $i }}</span>
                                @else
                                    <a href="?page={{ $i }}{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-xs md:text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">{{ $i }}</a>
                                @endif
                            @endfor

                            {{-- Last page + ellipsis if needed --}}
                            @if($end < $last)
                                @if($end < $last - 1)
                                    <span class="px-1 md:px-2 text-slate-400 text-xs md:text-sm">...</span>
                                @endif
                                <a href="?page={{ $last }}{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-xs md:text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">{{ $last }}</a>
                            @endif

                            {{-- Next --}}
                            @if($current >= $last)
                                <span class="px-2 py-1.5 md:px-3 md:py-2 text-sm rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            @else
                                <a href="?page={{ min($last, $current + 1) }}{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </div>
@endsection
