@extends('layouts.admin')

@section('title', 'Detail Material')

@section('content')
    <div class="bg-white rounded-lg shadow-sm border border-red-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-red-700">Detail Material: {{ $material->nama }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.materials.index') }}"
                   class="px-4 py-2 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 transition">
                    Kembali
                </a>
                <a href="{{ route('admin.materials.edit', $material) }}"
                   class="px-4 py-2 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-md hover:from-red-700 hover:to-rose-700 transition">
                    Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Detail Material -->
            <div>
                <h3 class="text-lg font-semibold text-red-700 mb-4">Informasi Material</h3>
                <div class="space-y-3">
                    <div class="flex">
                        <span class="w-32 text-sm font-medium text-slate-600">Tanggal:</span>
                        <span class="text-sm text-slate-800">{{ optional($material->tanggal)->format('d/m/Y') ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm font-medium text-slate-600">Material:</span>
                        <span class="text-sm text-slate-800">{{ $material->nama }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm font-medium text-slate-600">Spesifikasi:</span>
                        <span class="text-sm text-slate-800">{{ $material->spesifikasi ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm font-medium text-slate-600">Kategori:</span>
                        <span class="text-sm text-slate-800">{{ $material->kategori->name ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm font-medium text-slate-600">Satuan:</span>
                        <span class="text-sm text-slate-800">{{ $material->satuan->name ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm font-medium text-slate-600">Stok:</span>
                        @php($currentStock = $material->getCurrentStok())
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $currentStock > 0 ? 'bg-rose-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ number_format($currentStock, 0) }}
                        </span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm font-medium text-slate-600">Safety Stock:</span>
                        <span class="text-sm text-slate-800">{{ number_format($material->safety_stock, 0) }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm font-medium text-slate-600">Status:</span>
                        @if($material->isStokKurang())
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Stok Kurang</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-rose-100 text-green-800">Stok Aman</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ringkasan Stok -->
            <div>
                <h3 class="text-lg font-semibold text-red-700 mb-4">Ringkasan Stok</h3>
                <div class="space-y-4">
                    <div class="bg-rose-50 border border-rose-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-red-800">Total Masuk</p>
                                <p class="text-lg font-semibold text-red-900">
                                    {{ number_format($material->movements()->where('type', 'in')->sum('jumlah'), 0) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-rose-50 border border-rose-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-red-800">Total Keluar</p>
                                <p class="text-lg font-semibold text-red-900">
                                    {{ number_format($material->movements()->where('type', 'out')->sum('jumlah'), 0) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Perpindahan -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Riwayat Perpindahan Stok</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 border border-slate-200 rounded-lg">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Seksi</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Movement Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($material->movements()->orderBy('tanggal', 'desc')->get() as $movement)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm text-slate-900">{{ optional($movement->tanggal)->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($movement->type == 'in')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Masuk</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Keluar</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-900">{{ number_format($movement->jumlah, 0) }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500">{{ $movement->seksi ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500">{{ ucfirst($movement->movement_type) }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500">{{ $movement->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada perpindahan stok</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
