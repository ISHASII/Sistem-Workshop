@extends('layouts.admin')

@section('title', 'Stok Keluar Material')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
    <div class="bg-gradient-to-r from-red-700 to-rose-600 rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Stok Keluar Material</h2>
                        <p class="text-rose-50 text-sm mt-1">Input material yang keluar dari gudang</p>
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

        {{-- session success flash removed per user request --}}

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
        <form action="{{ route('admin.material-movements.process-stock-out') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Material Selection -->
                <div class="md:col-span-2">
                    <label for="material_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Material <span class="text-red-500">*</span>
                    </label>
                    <select id="material_id" name="material_id" required onchange="updateStockOut()"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 text-slate-700 @error('material_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        <option value="" data-stock="" data-unit="">Pilih Material</option>
                        @foreach($materials as $material)
                            @php
                                $currentStock = $material->getCurrentStok();
                            @endphp
                            <option value="{{ $material->id }}"
                                    {{ old('material_id') == $material->id ? 'selected' : '' }}
                                    data-stock="{{ (int)$currentStock }}"
                                    data-unit="{{ $material->satuan->name ?? '' }}"
                                    data-spesifikasi="{{ $material->spesifikasi ?? '' }}"
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

            <!-- Material Info Display - Spesifikasi & Satuan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Spesifikasi (Read-only) -->
                <div>
                    <label for="spesifikasi_display" class="block text-sm font-medium text-slate-700 mb-2">
                        Spesifikasi Material
                    </label>
                    <input type="text" id="spesifikasi_display" readonly
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-600 cursor-not-allowed"
                           placeholder="-"
                           value="-">
                    <p class="mt-1 text-xs text-slate-500">Otomatis terisi dari material yang dipilih</p>
                </div>

                <!-- Satuan (Read-only) -->
                <div>
                    <label for="satuan_display" class="block text-sm font-medium text-slate-700 mb-2">
                        Satuan
                    </label>
                    <input type="text" id="satuan_display" readonly
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-600 cursor-not-allowed"
                           placeholder="-"
                           value="-">
                    <p class="mt-1 text-xs text-slate-500">Satuan dari material yang dipilih</p>
                </div>
            </div>

            <!-- Stock Info Display Card - Always Visible -->
            <div id="stock-info" class="transition-all duration-300">
                <div id="stock-card" class="bg-gradient-to-br from-rose-50 to-red-50 border-2 border-rose-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 flex-1">
                            <div class="p-3 bg-red-600 rounded-xl shadow-md">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-rose-700 mb-1">Stok Tersedia Saat Ini</p>
                                <p id="stock-value" class="text-3xl font-bold text-rose-900">-</p>
                            </div>
                        </div>
                        <div id="stock-warning" class="hidden">
                            <div class="p-3 bg-red-500 rounded-xl shadow-lg animate-pulse">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
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
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 @error('tanggal') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
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
                           oninput="validateStockOut()"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 @error('jumlah') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section -->
                <div>
                    <label for="seksi" class="block text-sm font-medium text-slate-700 mb-2">
                        Seksi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="seksi" name="seksi" required
                           value="{{ old('seksi') }}"
                           placeholder="Masukkan nama seksi"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 @error('seksi') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('seksi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Movement Type -->
                <div>
                    <label for="movement_type" class="block text-sm font-medium text-slate-700 mb-2">
                        Movement Type <span class="text-red-500">*</span>
                    </label>
                    <select id="movement_type" name="movement_type" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 text-slate-700 @error('movement_type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        <option value="" class="text-slate-500">Pilih Movement Type</option>
                        <option value="jo" {{ old('movement_type') == 'jo' ? 'selected' : '' }} class="text-slate-700">
                            Job Order (JO)
                        </option>
                        <option value="memo" {{ old('movement_type') == 'memo' ? 'selected' : '' }} class="text-slate-700">
                            Memo
                        </option>
                        <option value="other" {{ old('movement_type') == 'other' ? 'selected' : '' }} class="text-slate-700">
                            Lainnya
                        </option>
                    </select>
                    @error('movement_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="md:col-span-2 flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit"
                        class="flex-1 px-8 py-4 bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-3 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3"/>
                    </svg>
                    Simpan Stok Keluar
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

    <!-- Stock Validation Script - Simple & Direct -->
    <script>
        let currentStockGlobal = 0;
        let currentUnitGlobal = '';

        function updateStockOut() {
            const select = document.getElementById('material_id');
            const stockDisplay = document.getElementById('stock-value');
            const stockCard = document.getElementById('stock-card');
            const stockWarning = document.getElementById('stock-warning');
            const spesifikasiDisplay = document.getElementById('spesifikasi_display');
            const satuanDisplay = document.getElementById('satuan_display');

            if (!select || !stockDisplay || !stockCard || !stockWarning) {
                alert('ERROR: Element tidak ditemukan!');
                return;
            }

            const selectedOption = select.options[select.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');
            const unit = selectedOption.getAttribute('data-unit');
            const spesifikasi = selectedOption.getAttribute('data-spesifikasi');

            console.log('Selected:', select.value);
            console.log('Stock:', stock);
            console.log('Unit:', unit);
            console.log('Spesifikasi:', spesifikasi);

            currentStockGlobal = parseInt(stock) || 0;
            currentUnitGlobal = unit || '';

            if (stock && unit && select.value) {
                // Update stock display
                stockDisplay.textContent = stock + ' ' + unit;

                // Update spesifikasi dan satuan display
                if (spesifikasiDisplay) {
                    spesifikasiDisplay.value = spesifikasi || '-';
                }
                if (satuanDisplay) {
                    satuanDisplay.value = unit || '-';
                }

                // Reset to blue theme
                stockCard.className = 'bg-gradient-to-br from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl p-5 shadow-sm';
                stockDisplay.className = 'text-3xl font-bold text-blue-900';
                stockWarning.classList.add('hidden');

                validateStockOut();
            } else {
                // Reset displays
                stockDisplay.textContent = '-';
                stockDisplay.className = 'text-3xl font-bold text-gray-500';
                stockWarning.classList.add('hidden');

                if (spesifikasiDisplay) spesifikasiDisplay.value = '-';
                if (satuanDisplay) satuanDisplay.value = '-';
            }
        }

        function validateStockOut() {
            const jumlahInput = document.getElementById('jumlah');
            const stockDisplay = document.getElementById('stock-value');
            const stockCard = document.getElementById('stock-card');
            const stockWarning = document.getElementById('stock-warning');
            const select = document.getElementById('material_id');

            if (!jumlahInput || !select.value) return;

            const jumlah = parseInt(jumlahInput.value) || 0;

            console.log('Validating - Jumlah:', jumlah, 'Stock:', currentStockGlobal);

            if (jumlah > currentStockGlobal && jumlah > 0) {
                // Red warning - not enough
                stockCard.className = 'bg-gradient-to-br from-red-50 to-rose-50 border-2 border-red-300 rounded-xl p-5 shadow-sm';
                stockDisplay.className = 'text-3xl font-bold text-red-900';
                stockDisplay.textContent = currentStockGlobal + ' ' + currentUnitGlobal + ' (Tidak Cukup!)';
                stockWarning.classList.remove('hidden');
            } else if (jumlah > 0) {
                // Blue with info
                stockCard.className = 'bg-gradient-to-br from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl p-5 shadow-sm';
                stockDisplay.className = 'text-3xl font-bold text-blue-900';
                stockDisplay.textContent = currentStockGlobal + ' ' + currentUnitGlobal + ' (Akan diambil: ' + jumlah + ')';
                stockWarning.classList.add('hidden');
            } else {
                // Reset
                stockCard.className = 'bg-gradient-to-br from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl p-5 shadow-sm';
                stockDisplay.className = 'text-3xl font-bold text-blue-900';
                stockDisplay.textContent = currentStockGlobal + ' ' + currentUnitGlobal;
                stockWarning.classList.add('hidden');
            }
        }

        // Test saat page load
        window.onload = function() {
            console.log('Page loaded - Stock Out ready!');
            const select = document.getElementById('material_id');
            if (select && select.value) {
                updateStockOut();
            }
        };
    </script>
@endsection
