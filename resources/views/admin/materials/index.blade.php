@extends('layouts.admin')

@section('title', 'Data Material')

@section('content')
    <div class="min-h-screen bg-gray-50 p-4 flex flex-col">
        <!-- Header Section -->
    <div class="bg-gradient-to-r from-red-50 to-rose-100 rounded-lg p-6 border border-red-100 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-600 rounded-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-800">Data Material</h1>
                        <p class="text-slate-600 mt-1">Kelola dan monitor inventory material workshop</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.materials.create') }}"
                       class="px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-lg font-semibold shadow-lg hover:from-red-700 hover:to-rose-700 transition-all duration-200 flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Material
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Materials -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-red-100 rounded-lg">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Total Material</p>
                                <p class="text-xs text-slate-500">Semua jenis material</p>
                            </div>
                        </div>
                        <div class="flex items-end gap-2">
                            <p class="text-3xl font-bold text-red-700">{{ $totalMaterials }}</p>
                            <span class="text-sm text-slate-500 mb-1">jenis</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Materials -->
            <div class="bg-white rounded-xl shadow-sm border border-yellow-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Stok Kurang</p>
                                <p class="text-xs text-slate-500">Dibawah safety stock</p>
                            </div>
                        </div>
                        <div class="flex items-end gap-2">
                            <p class="text-3xl font-bold text-yellow-600">{{ $lowStockMaterials }}</p>
                            <span class="text-sm text-slate-500 mb-1">material</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Stock Materials -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-red-100 rounded-lg">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Stok Habis</p>
                                <p class="text-xs text-slate-500">Material kosong</p>
                            </div>
                        </div>
                        <div class="flex items-end gap-2">
                            <p class="text-3xl font-bold text-red-600">{{ $emptyStockMaterials }}</p>
                            <span class="text-sm text-slate-500 mb-1">material</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Safe Stock Materials -->
            <div class="bg-white rounded-xl shadow-sm border border-green-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Stok Aman</p>
                                <p class="text-xs text-slate-500">Diatas safety stock</p>
                            </div>
                        </div>
                        <div class="flex items-end gap-2">
                            <p class="text-3xl font-bold text-green-600">{{ $safeStockMaterials }}</p>
                            <span class="text-sm text-slate-500 mb-1">material</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Search & Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-red-100 p-6 mb-6">
            <form method="GET" action="{{ route('admin.materials.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Cari Material</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari berdasarkan nama atau spesifikasi..."
                                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-rose-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                    </div>

                    <!-- Filter Kategori -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Kategori</label>
                        <select name="kategori" class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Satuan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Satuan</label>
                        <select name="satuan" class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Satuan</option>
                            @foreach($satuans as $satuan)
                                <option value="{{ $satuan->id }}" {{ request('satuan') == $satuan->id ? 'selected' : '' }}>
                                    {{ $satuan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Filter Stock Status -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Status Stok</label>
                        <select name="stock_status" class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="empty" {{ request('stock_status') == 'empty' ? 'selected' : '' }}>Stok Habis (0)</option>
                            <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Stok Kurang (< Safety)</option>
                            <option value="safe" {{ request('stock_status') == 'safe' ? 'selected' : '' }}>Stok Aman (≥ Safety)</option>
                        </select>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Urutkan</label>
                        <select name="sort" class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                            <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                            <option value="jumlah_asc" {{ request('sort') == 'jumlah_asc' ? 'selected' : '' }}>Jumlah (Terendah)</option>
                            <option value="jumlah_desc" {{ request('sort') == 'jumlah_desc' ? 'selected' : '' }}>Jumlah (Tertinggi)</option>
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="md:col-span-2 flex items-end gap-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.materials.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden flex-1">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2.586a1 1 0 00.707-.293l2.414-2.414A1 1 0 0011 16.586V7a2 2 0 00-2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5h2a2 2 0 012 2v11a2 2 0 01-2 2h-2.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 0110 16.586V7a2 2 0 012-2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-slate-800">Daftar Material</h3>
                    </div>
                    @if($totalMaterials > 0)
                        <span class="px-3 py-1 bg-blue-100 text-red-800 text-sm font-medium rounded-full">
                            {{ $totalMaterials }} material terdaftar
                        </span>
                    @endif
                </div>
            </div>

            <div class="overflow-auto" style="height: calc(100vh - 400px);">
                <table class="w-full min-w-max table-fixed" style="min-width: 1120px;">
                    <colgroup>
                        <col style="width: 50px;">
                        <col style="width: 90px;">
                        <col style="width: 200px;">
                        <col style="width: 150px;">
                        <col style="width: 90px;">
                        <col style="width: 80px;">
                        <col style="width: 80px;">
                        <col style="width: 80px;">
                        <col style="width: 90px;">
                        <col style="width: 120px;">
                    </colgroup>
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-100 to-slate-50 border-b border-slate-200">
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <span>No</span>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <div class="flex items-center gap-1">
                                    <span>Tanggal</span>
                                </div>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <div class="flex items-center gap-1">
                                    <span>Material</span>
                                </div>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <div class="flex items-center gap-1">
                                    <span>Spesifikasi</span>
                                </div>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <div class="flex items-center gap-1">
                                    <span>Kategori</span>
                                </div>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <div class="flex items-center gap-1">
                                    <span>Satuan</span>
                                </div>
                            </th>
                            <th class="px-2 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-1">
                                    <span class="hidden sm:inline">Stok</span>
                                </div>
                            </th>
                            <th class="px-2 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-1">
                                    <span class="hidden sm:inline">Safety</span>
                                </div>
                            </th>
                            <th class="px-2 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-1">
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="px-2 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-1">
                                    <span>Aksi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($materials as $index => $material)
                            <tr class="hover:bg-slate-50 transition-colors duration-200 group">
                                <!-- NO -->
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="w-6 h-6 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center text-xs font-medium group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors duration-200">
                                        {{ $materials->firstItem() + $index }}
                                    </span>
                                </td>
                                <!-- TANGGAL -->
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <div class="text-xs font-medium text-slate-900">
                                        {{ $material->tanggal ? ($material->tanggal instanceof \Illuminate\Support\Carbon ? $material->tanggal->format('d-m-Y') : (is_string($material->tanggal) ? \Carbon\Carbon::parse($material->tanggal)->format('d-m-Y') : '-') ) : '-' }}
                                    </div>
                                </td>
                                <!-- MATERIAL -->
                                <td class="px-3 py-3">
                                    <div class="text-sm font-medium text-slate-900 truncate">{{ $material->nama }}</div>
                                </td>
                                <!-- SPESIFIKASI -->
                                <td class="px-3 py-3">
                                    <div class="text-sm text-slate-900 truncate">{{ $material->spesifikasi ? $material->spesifikasi : '-' }}</div>
                                </td>
                                <!-- KATEGORI -->
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="text-sm text-slate-900">{{ $material->kategori ? ($material->kategori->nama ?? $material->kategori->name ?? '-') : '-' }}</span>
                                </td>
                                <!-- SATUAN -->
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="text-sm text-slate-900">{{ $material->satuan ? ($material->satuan->nama ?? $material->satuan->name ?? '-') : '-' }}</span>
                                </td>
                                <!-- STOK -->
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    @php $currentStock = $material->getCurrentStok(); @endphp
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold border-2 {{ $currentStock > 0 ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-100 text-red-800 border-red-200' }}">
                                        {{ number_format($currentStock, 0, ',', '.') }}
                                    </span>
                                </td>
                                <!-- SAFETY -->
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200">
                                        {{ number_format($material->safety_stock ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                                                        @if($material->getCurrentStok() <= 0)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            Habis
                                        </span>
                                    @elseif($material->isStokKurang())
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            Kurang
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Aman
                                        </span>
                                    @endif
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    @include('admin.partials.action-buttons', [
                                        'showRoute' => route('admin.materials.show', $material),
                                        'editRoute' => route('admin.materials.edit', $material),
                                        'destroyRoute' => route('admin.materials.destroy', $material),
                                        'labelAlign' => 'center',
                                        'deleteTitle' => 'Hapus material?',
                                        'deleteText' => 'Yakin ingin menghapus material ' . ($material->nama ?? '') . '?',
                                        'deleteConfirm' => 'Hapus'
                                    ])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900 mb-2">Tidak ada data material</h3>
                                        <p class="text-slate-500 mb-6 max-w-md text-center">
                                            Belum ada material yang terdaftar. Mulai dengan menambahkan material baru.
                                        </p>
                                        <a href="{{ route('admin.materials.create') }}"
                                           class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-all duration-200 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Tambah Material Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($materials->hasPages())
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 px-6 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-slate-600">
                        Menampilkan {{ $materials->firstItem() }} - {{ $materials->lastItem() }} dari {{ $materials->total() }} material
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- Previous Page Link --}}
                        @if ($materials->onFirstPage())
                            <span class="px-3 py-2 text-sm bg-slate-100 text-slate-400 rounded-lg cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $materials->previousPageUrl() }}" class="px-3 py-2 text-sm bg-white text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-800 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($materials->getUrlRange(1, $materials->lastPage()) as $page => $url)
                            @if ($page == $materials->currentPage())
                                <span class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg font-medium">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-2 text-sm bg-white text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-800 transition-colors duration-200">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($materials->hasMorePages())
                            <a href="{{ $materials->nextPageUrl() }}" class="px-3 py-2 text-sm bg-white text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-800 transition-colors duration-200">
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
@endsection
