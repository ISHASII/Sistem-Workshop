@extends('layouts.admin')

@section('title', 'Perpindahan Stok Material')

@section('content')
    <div class="space-y-4 md:space-y-6 p-4">
        <!-- Header Section -->
    <div class="bg-gradient-to-r from-red-50 to-rose-100 rounded-lg p-4 md:p-6 border border-red-100">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="p-2 md:p-3 bg-red-600 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-slate-800">Perpindahan Stok Material</h1>
                        <p class="text-xs md:text-sm text-slate-600 mt-1">Kelola dan monitor perpindahan stok masuk dan keluar material</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 md:gap-3">
                          <a href="{{ route('admin.material-movements.exportPdfAll', request()->all()) }}" target="_blank"
                              class="px-4 py-2.5 md:py-3 bg-slate-800 text-white rounded-lg text-sm font-semibold hover:bg-slate-900 transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8"/>
                        </svg>
                        <span class="whitespace-nowrap">Export All PDF</span>
                    </a>
                          <a href="{{ route('admin.material-movements.stock-in') }}"
                              class="px-4 md:px-6 py-2.5 md:py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg text-sm font-semibold shadow-lg hover:from-red-700 hover:to-rose-700 transition-all duration-200 flex items-center justify-center gap-2 md:gap-3">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="whitespace-nowrap">Stok Masuk</span>
                    </a>
                          <a href="{{ route('admin.material-movements.stock-out') }}"
                              class="px-4 md:px-6 py-2.5 md:py-3 bg-gradient-to-r from-rose-600 to-red-600 text-white rounded-lg text-sm font-semibold shadow-lg hover:from-rose-700 hover:to-red-700 transition-all duration-200 flex items-center justify-center gap-2 md:gap-3">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                        <span class="whitespace-nowrap">Stok Keluar</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            <!-- Total Movements -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200 p-4 md:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 md:gap-3 mb-2 md:mb-3">
                            <div class="p-1.5 md:p-2 bg-red-100 rounded-lg flex-shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs md:text-sm font-medium text-slate-600">Total Perpindahan</p>
                                <p class="text-xs text-slate-500 hidden md:block">Semua data movement</p>
                            </div>
                        </div>
                        <div class="flex items-end gap-1 md:gap-2">
                            <p class="text-2xl md:text-3xl font-bold text-red-700">{{ $movements->total() ?? 0 }}</p>
                            <span class="text-xs md:text-sm text-slate-500 mb-0.5 md:mb-1">data</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock In Today -->
            <div class="bg-white rounded-xl shadow-sm border border-rose-200 p-4 md:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 md:gap-3 mb-2 md:mb-3">
                            <div class="p-1.5 md:p-2 bg-rose-100 rounded-lg flex-shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs md:text-sm font-medium text-slate-600">Stok Masuk Hari Ini</p>
                                <p class="text-xs text-slate-500">{{ now()->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-end gap-1 md:gap-2">
                            <p class="text-2xl md:text-3xl font-bold text-rose-700">{{ $movements->where('type', 'in')->where('tanggal', today())->count() }}</p>
                            <span class="text-xs md:text-sm text-slate-500 mb-0.5 md:mb-1">transaksi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Out Today -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200 p-4 md:p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 md:gap-3 mb-2 md:mb-3">
                            <div class="p-1.5 md:p-2 bg-red-100 rounded-lg flex-shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs md:text-sm font-medium text-slate-600">Stok Keluar Hari Ini</p>
                                <p class="text-xs text-slate-500">{{ now()->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-end gap-1 md:gap-2">
                            <p class="text-2xl md:text-3xl font-bold text-red-700">{{ $movements->where('type', 'out')->where('tanggal', today())->count() }}</p>
                            <span class="text-xs md:text-sm text-slate-500 mb-0.5 md:mb-1">transaksi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- session success flash removed per user request --}}

        <!-- Filter & Search Section -->
    <div class="bg-white rounded-lg shadow-sm border border-red-100 p-4 md:p-6">
            <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"/>
                </svg>
                <h3 class="text-base md:text-lg font-semibold text-slate-800">Filter & Pencarian</h3>
            </div>
            <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3 md:gap-4">
                <div>
                    <label class="block text-xs md:text-sm font-medium text-slate-700 mb-2">Cari Material</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Masukkan nama material..."
                               class="w-full pl-10 pr-4 py-2 md:py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2 md:top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-slate-700 mb-2">Tipe Perpindahan</label>
                    <select name="type" class="w-full px-3 md:px-4 py-2 md:py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                        <option value="">Semua Tipe</option>
                        <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>📈 Stok Masuk</option>
                        <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>📉 Stok Keluar</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-slate-700 mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                           class="w-full px-3 md:px-4 py-2 md:py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-medium text-slate-700 mb-2">Movement Type</label>
                    <select name="movement_type" class="w-full px-3 md:px-4 py-2 md:py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                        <option value="">Semua Movement</option>
                        <option value="jo" {{ request('movement_type') == 'jo' ? 'selected' : '' }}>📋 Job Order</option>
                        <option value="memo" {{ request('movement_type') == 'memo' ? 'selected' : '' }}>📝 Memo</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 md:py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 text-sm font-medium flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'type', 'date', 'movement_type']))
                                <a href="{{ route('admin.material-movements.index') }}"
                                    class="px-4 py-2 md:py-2.5 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>
        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-4 md:px-6 py-3 md:py-4 border-b border-slate-200 bg-slate-50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 md:gap-0">
                    <div class="flex items-center gap-2 md:gap-3">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2.586a1 1 0 00.707-.293l2.414-2.414A1 1 0 0011 16.586V7a2 2 0 00-2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5h2a2 2 0 012 2v11a2 2 0 01-2 2h-2.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0110 16.586V7a2 2 0 012-2z"/>
                        </svg>
                        <h3 class="text-base md:text-lg font-semibold text-slate-800">Data Perpindahan Stok</h3>
                    </div>
                    @if($movements->total() > 0)
                        <span class="px-2 md:px-3 py-1 bg-red-100 text-red-800 text-xs md:text-sm font-medium rounded-full">
                            {{ $movements->total() }} data ditemukan
                        </span>
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-max" style="min-width: 800px;">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-100 to-slate-50 border-b border-slate-200">
                            <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span>#</span>
                                </div>
                            </th>
                            <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Tanggal</span>
                                </div>
                            </th>
                            <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <span>Material</span>
                                </div>
                            </th>
                            <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                    <span>Tipe</span>
                                </div>
                            </th>
                            <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <span>Jumlah</span>
                                </div>
                            </th>

                            <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span>Movement</span>
                                </div>
                            </th>

                            <th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                    <span>Aksi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($movements as $index => $movement)
                            <tr class="hover:bg-slate-50 transition-colors duration-200 group">
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="w-6 h-6 md:w-8 md:h-8 bg-rose-100 text-red-600 rounded-full flex items-center justify-center text-xs md:text-sm font-medium group-hover:bg-red-200 group-hover:text-red-800 transition-colors duration-200">
                                            {{ $movements->firstItem() + $index }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2 md:gap-3">
                                        <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-red-500 rounded-full flex-shrink-0"></div>
                                        <div>
                                            <div class="text-xs md:text-sm font-medium text-slate-900">{{ optional($movement->tanggal)->format('d-m-Y') ?? '-' }}</div>
                                            <div class="text-xs text-slate-500 hidden md:block">{{ optional($movement->tanggal)->format('l') ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4">
                                    <div class="max-w-xs">
                                        <div class="text-xs md:text-sm font-medium text-slate-900 truncate">{{ $movement->material->nama ?? 'N/A' }}</div>
                                        @if($movement->material && $movement->material->spesifikasi)
                                            <div class="text-xs text-slate-500 truncate hidden md:block">{{ $movement->material->spesifikasi }}</div>
                                        @endif
                                        @if($movement->material && $movement->material->kategori)
                                            <span class="inline-flex items-center px-1.5 md:px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 mt-1">
                                                {{ $movement->material->kategori->name }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                    @if($movement->type == 'in')
                                        <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-xs md:text-sm font-medium bg-rose-100 text-rose-800 border border-rose-200">
                                            <svg class="w-2.5 h-2.5 md:w-3 md:h-3 mr-1 md:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            <span class="hidden sm:inline">Masuk</span>
                                            <span class="sm:hidden">In</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-xs md:text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                                            <svg class="w-2.5 h-2.5 md:w-3 md:h-3 mr-1 md:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                            </svg>
                                            <span class="hidden sm:inline">Keluar</span>
                                            <span class="sm:hidden">Out</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1 md:gap-2">
                                        <span class="inline-flex items-center px-2 md:px-3 py-0.5 md:py-1 rounded-full text-xs md:text-sm font-bold bg-red-100 text-red-800 border border-red-200">
                                            {{ number_format($movement->jumlah, 0, ',', '.') }}
                                        </span>
                                        @if($movement->material && $movement->material->satuan)
                                            <span class="text-xs text-slate-500 hidden md:inline">{{ $movement->material->satuan->name }}</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                                    @if($movement->movement_type)
                                        @php
                                            $badgeClass = 'inline-flex items-center px-1.5 md:px-2 py-0.5 md:py-1 rounded text-xs font-medium ';
                                            if ($movement->movement_type == 'jo') {
                                                $badgeClass .= 'bg-rose-100 text-rose-800';
                                            } elseif ($movement->movement_type == 'memo') {
                                                $badgeClass .= 'bg-yellow-100 text-yellow-800';
                                            } else {
                                                $badgeClass .= 'bg-gray-100 text-gray-800';
                                            }
                                        @endphp
                                        <span class="{{ $badgeClass }}">{{ strtoupper($movement->movement_type) }}</span>
                                    @else
                                        <span class="text-xs md:text-sm text-slate-500">-</span>
                                    @endif
                                </td>

                                <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap text-center">
                                    @include('admin.partials.action-buttons', [
                                        'showRoute' => route('admin.material-movements.show', $movement),
                                        'editRoute' => route('admin.material-movements.edit', $movement),
                                        'destroyRoute' => route('admin.material-movements.destroy', $movement),
                                        'labelAlign' => 'center',
                                        'deleteTitle' => 'Hapus perpindahan stok?',
                                        'deleteText' => 'Yakin ingin menghapus perpindahan stok untuk ' . ($movement->material?->nama ?? 'item ini') . '?',
                                        'deleteConfirm' => 'Hapus',
                                        'pdfRoute' => route('admin.material-movements.exportPdf', $movement)
                                    ])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 mb-2">Tidak ada data perpindahan stok</h3>
                                        <p class="text-slate-500 mb-6 max-w-md text-center">
                                            Belum ada perpindahan stok yang tercatat. Mulai dengan menambahkan stok masuk atau keluar.
                                        </p>
                                        <div class="flex gap-3">
                                            <a href="{{ route('admin.material-movements.stock-in') }}"
                                               class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-all duration-200 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Tambah Stok Masuk
                                            </a>
                                            <a href="{{ route('admin.material-movements.stock-out') }}"
                                               class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-all duration-200 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                                Tambah Stok Keluar
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($movements->hasPages())
                <div class="px-4 md:px-6 py-3 md:py-4 border-t border-slate-200 bg-slate-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-xs md:text-sm text-slate-600 text-center sm:text-left">
                            Menampilkan {{ $movements->firstItem() ?? 0 }} - {{ $movements->lastItem() ?? 0 }} dari {{ $movements->total() }} data
                        </div>
                        <div class="flex items-center gap-1 md:gap-2">
                            @php
                                $current = $movements->currentPage();
                                $last = $movements->lastPage();
                                $start = max(1, $current - 1);
                                $end = min($last, $current + 1);
                                $qs = http_build_query(request()->except('page'));
                                $qsPrefix = $qs ? '&' . $qs : '';
                            @endphp

                            {{-- Previous --}}
                            @if($movements->onFirstPage())
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
@endsection

        @push('scripts')
        <script>
            (function() {
                const form = document.getElementById('filterForm');
                if (!form) return;

                // Auto-submit on change for select/input elements except when user is typing in the search field
                const inputs = form.querySelectorAll('select, input[type="date"]');
                inputs.forEach(i => i.addEventListener('change', () => form.submit()));

                // For the search input, submit on Enter only
                const search = form.querySelector('input[name="search"]');
                if (search) {
                    search.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            form.submit();
                        }
                    });
                }
            })();
        </script>
        @endpush
