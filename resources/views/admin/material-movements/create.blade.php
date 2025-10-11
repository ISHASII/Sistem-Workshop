@extends('layouts.admin')

@section('title', 'Tambah Perpindahan Stok')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 w-full mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-red-700">Tambah Perpindahan Stok</h2>
                    <p class="text-sm text-slate-600">Menambahkan data perpindahan stok material</p>
                </div>
            </div>
                <a href="{{ route('admin.material-movements.index') }}"
                    class="px-4 py-2 bg-rose-600 text-white rounded-lg text-sm font-medium shadow hover:bg-rose-700 transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-lg">
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
    <form action="{{ route('admin.material-movements.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Material Selection -->
                <div>
                    <label for="material_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Material <span class="text-red-500">*</span>
                    </label>
            <select id="material_id" name="material_id" required
                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 text-slate-700 @error('material_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        <option value="" class="text-slate-500">Pilih Material</option>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}"
                                    {{ old('material_id') == $material->id ? 'selected' : '' }}
                                    data-current-stock="{{ $material->stok_current }}"
                                    data-satuan="{{ $material->satuan->name ?? '' }}"
                                    class="text-slate-700">
                                {{ $material->nama }}
                                @if($material->spesifikasi)
                                    ({{ $material->spesifikasi }})
                                @endif
                                - {{ $material->kategori->name ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('material_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-slate-700 mb-2">
                        Tipe <span class="text-red-500">*</span>
                    </label>
                    <select id="type" name="type" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-700 @error('type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        <option value="" class="text-slate-500">Pilih Tipe</option>
                        <option value="in" {{ old('type') == 'in' ? 'selected' : '' }} class="text-slate-700">
                            Masuk
                        </option>
                        <option value="out" {{ old('type') == 'out' ? 'selected' : '' }} class="text-slate-700">
                            Keluar
                        </option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('tanggal') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
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
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('jumlah') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Section -->
                <div>
                    <label for="seksi" class="block text-sm font-medium text-slate-700 mb-2">
                        Seksi
                    </label>
                    <input type="text" id="seksi" name="seksi"
                           value="{{ old('seksi') }}"
                           placeholder="Masukkan nama seksi"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('seksi') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('seksi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">Wajib diisi untuk stok keluar</p>
                </div>

                <!-- Safety Stock -->
                <div>
                    <label for="safety_stock" class="block text-sm font-medium text-slate-700 mb-2">
                        Safety Stock
                    </label>
                    <input type="number" step="1" min="0" id="safety_stock" name="safety_stock" inputmode="numeric" pattern="\d+"
                           value="{{ old('safety_stock') }}"
                           placeholder="Masukkan safety stock"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('safety_stock') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('safety_stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">Untuk stok masuk</p>
                </div>
            </div>

            <!-- Movement Type -->
            <div>
                <label for="movement_type" class="block text-sm font-medium text-slate-700 mb-2">
                    Movement Type <span class="text-red-500">*</span>
                </label>
                <select id="movement_type" name="movement_type" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-700 @error('movement_type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
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

            <!-- Description -->
            <div>
                <label for="keterangan" class="block text-sm font-medium text-slate-700 mb-2">
                    Keterangan
                </label>
                <textarea id="keterangan" name="keterangan" rows="3"
                          placeholder="Masukkan keterangan atau deskripsi..."
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('keterangan') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-200">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium shadow hover:bg-blue-700 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('admin.material-movements.index') }}"
                   class="px-6 py-2 bg-slate-600 text-white rounded-lg font-medium shadow hover:bg-slate-700 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
