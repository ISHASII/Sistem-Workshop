@extends('layouts.admin')

@section('title', 'Stok Masuk Material')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Stok Masuk Material</h2>
                        <p class="text-green-50 text-sm mt-1">Input material yang masuk ke gudang</p>
                    </div>
                </div>
                <a href="{{ route('admin.material-movements.index') }}"
                   class="px-5 py-2.5 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white rounded-lg font-medium transition-all duration-200 flex items-center gap-2 border border-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-green-800">
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-red-800">
                        <p class="font-medium mb-2">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.material-movements.process-stock-in') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Material Selection -->
                <div class="md:col-span-2">
                    <label for="material_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Material <span class="text-red-500">*</span>
                    </label>
                    <select id="material_id" name="material_id" required onchange="updateStock()"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-slate-700 @error('material_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        <option value="" data-stock="" data-unit="">Pilih Material</option>
                        @foreach($materials as $material)
                            @php
                                $currentStock = $material->getCurrentStok();
                            @endphp
                            <option value="{{ $material->id }}"
                                    {{ old('material_id') == $material->id ? 'selected' : '' }}
                                    data-stock="{{ (int)$currentStock }}"
                                    data-unit="{{ $material->satuan->name ?? '' }}"
                                    class="text-slate-700">
                                {{ $material->nama }}
                                @if($material->spesifikasi)
                                    ({{ $material->spesifikasi }})
                                @endif
                                - {{ $material->kategori->name ?? '' }}
                                [Stok: {{ (int)$currentStock }} {{ $material->satuan->name ?? '' }}]
                            </option>
                        @endforeach
                    </select>
                    @error('material_id')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Stock Info Display Card - Always Visible -->
            <div id="stock-info-in" class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-600 rounded-xl shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-green-700 mb-1">Stok Tersedia Saat Ini</p>
                        <p id="stock-value-in" class="text-3xl font-bold text-green-900">-</p>
                    </div>
                    <div class="hidden lg:block">
                        <div class="px-4 py-2 bg-white/70 rounded-lg">
                            <p class="text-xs font-medium text-green-600 uppercase">Ready</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date -->
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal" name="tanggal" required
                           value="{{ old('tanggal') }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('tanggal') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('tanggal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-slate-700 mb-2">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="1" min="1" id="jumlah" name="jumlah" required inputmode="numeric" pattern="\d+"
                           value="{{ old('jumlah') }}"
                           placeholder="Masukkan jumlah"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('jumlah') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="md:col-span-2 flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit"
                        class="flex-1 px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-3 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                    Simpan Stok Masuk
                </button>
                <a href="{{ route('admin.material-movements.index') }}"
                   class="sm:w-auto px-8 py-4 bg-slate-600 hover:bg-slate-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-3 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
        </div>
    </div>

    <!-- Stock Info Script - Simple & Direct -->
    <script>
        function updateStock() {
            const select = document.getElementById('material_id');
            const stockDisplay = document.getElementById('stock-value-in');

            if (!select || !stockDisplay) {
                alert('ERROR: Element tidak ditemukan!');
                return;
            }

            const selectedOption = select.options[select.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            const unit = selectedOption.getAttribute('data-unit');

            console.log('Selected:', select.value);
            console.log('Stock:', stock);
            console.log('Unit:', unit);

            if (stock && unit && select.value) {
                stockDisplay.textContent = stock + ' ' + unit;
                stockDisplay.className = 'text-3xl font-bold text-green-900';
            } else {
                stockDisplay.textContent = '-';
                stockDisplay.className = 'text-3xl font-bold text-gray-500';
            }
        }

        // Test saat page load
        window.onload = function() {
            console.log('Page loaded - ready!');
            const select = document.getElementById('material_id');
            if (select && select.value) {
                updateStock();
            }
        };
    </script>
@endsection
