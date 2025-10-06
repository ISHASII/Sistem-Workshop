@extends('layouts.admin')

@section('title', 'Detail Perpindahan Stok')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 w-full mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    @if($materialMovement->type == 'in')
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-slate-800">Detail Perpindahan Stok</h2>
                    <p class="text-sm text-slate-600">Informasi lengkap perpindahan stok material</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.material-movements.edit', $materialMovement) }}"
                   class="px-4 py-2 bg-yellow-600 text-white rounded-lg text-sm font-medium shadow hover:bg-yellow-700 transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.material-movements.index') }}"
                   class="px-4 py-2 bg-slate-600 text-white rounded-lg text-sm font-medium shadow hover:bg-slate-700 transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Movement Details -->
            <div class="bg-slate-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Detail Perpindahan
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-start">
                        <span class="text-sm font-medium text-slate-600">Material</span>
                        <span class="text-sm text-slate-800 font-semibold text-right">{{ $materialMovement->material->nama }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-sm font-medium text-slate-600">Spesifikasi</span>
                        <span class="text-sm text-slate-800 text-right">{{ $materialMovement->material->spesifikasi ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-sm font-medium text-slate-600">Kategori</span>
                        <span class="text-sm text-slate-800 text-right">{{ $materialMovement->material->kategori->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-start">
                        <span class="text-sm font-medium text-slate-600">Satuan</span>
                        <span class="text-sm text-slate-800 text-right">{{ $materialMovement->material->satuan->name ?? '-' }}</span>
                    </div>
                    <div class="border-t border-slate-200 pt-4">
                        <div class="flex justify-between items-start">
                            <span class="text-sm font-medium text-slate-600">Tanggal</span>
                            <span class="text-sm text-slate-800 text-right">{{ $materialMovement->tanggal->format('d-m-Y') }}</span>
                        </div>
                        <div class="flex justify-between items-start mt-3">
                            <span class="text-sm font-medium text-slate-600">Tipe</span>
                            <div class="text-right">
                                @if($materialMovement->type == 'in')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Stok Masuk
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                        Stok Keluar
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-between items-start mt-3">
                            <span class="text-sm font-medium text-slate-600">Jumlah</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ number_format($materialMovement->jumlah, 0) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-start mt-3">
                            <span class="text-sm font-medium text-slate-600">Seksi</span>
                            <span class="text-sm text-slate-800 text-right">{{ $materialMovement->seksi ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-start mt-3">
                            <span class="text-sm font-medium text-slate-600">Movement Type</span>
                            <span class="text-sm text-slate-800 text-right">{{ ucfirst($materialMovement->movement_type) }}</span>
                        </div>
                        <div class="flex justify-between items-start mt-3">
                            <span class="text-sm font-medium text-slate-600">Dibuat</span>
                            <span class="text-sm text-slate-800 text-right">{{ $materialMovement->created_at->format('d-m-Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Material Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    Informasi Material
                </h3>

                <!-- Stok (Current) -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-800">Stok</p>
                                <p class="text-xs text-blue-600">Stok berjalan (in - out)</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @php($currentStock = $materialMovement->material->getCurrentStok())
                            <span class="text-2xl font-bold text-blue-800">{{ number_format($currentStock, 0, ',', '.') }}</span>
                            <p class="text-xs text-blue-600">{{ $materialMovement->material->satuan->name ?? 'unit' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Safety Stock -->
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-orange-100 rounded-lg">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-orange-800">Safety Stock</p>
                                <p class="text-xs text-orange-600">Batas minimum stok</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-orange-800">{{ number_format($materialMovement->material->safety_stock, 0, ',', '.') }}</span>
                            <p class="text-xs text-orange-600">{{ $materialMovement->material->satuan->name ?? 'unit' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stock Warning -->
                @if($materialMovement->material->isStokKurang())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <div class="p-1">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-red-800">Peringatan Stok!</p>
                                <p class="text-xs text-red-600 mt-1">Stok material saat ini berada di bawah batas minimum. Pertimbangkan untuk melakukan pengadaan ulang.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <div class="p-1">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-green-800">Stok Aman</p>
                                <p class="text-xs text-green-600 mt-1">Stok material saat ini masih berada di atas batas minimum.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
