@extends('layouts.admin')

@section('title', 'Edit Perpindahan Stok')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 w-full mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-rose-100 rounded-lg">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-red-700">Edit Perpindahan Stok</h2>
                    <p class="text-sm text-slate-600">Mengubah data perpindahan stok material</p>
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
        <form action="{{ route('admin.material-movements.update', $materialMovement) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

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
                                    {{ old('material_id', $materialMovement->material_id) == $material->id ? 'selected' : '' }}
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
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 text-slate-700 @error('type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                        <option value="" class="text-slate-500">Pilih Tipe</option>
                        <option value="in" {{ old('type', $materialMovement->type) == 'in' ? 'selected' : '' }} class="text-slate-700">
                            Masuk
                        </option>
                        <option value="out" {{ old('type', $materialMovement->type) == 'out' ? 'selected' : '' }} class="text-slate-700">
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
                           value="{{ old('tanggal', $materialMovement->tanggal->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 @error('tanggal') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
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
                  value="{{ old('jumlah', (int) $materialMovement->jumlah) }}"
                           placeholder="Masukkan jumlah"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 @error('jumlah') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
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
                           value="{{ old('seksi', $materialMovement->seksi) }}"
                           placeholder="Masukkan nama seksi"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 @error('seksi') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('seksi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Safety Stock -->
                <div>
                    <label for="safety_stock" class="block text-sm font-medium text-slate-700 mb-2">
                        Safety Stock
                    </label>
              <input type="number" step="1" min="0" id="safety_stock" name="safety_stock" inputmode="numeric" pattern="\d+"
                  value="{{ old('safety_stock', $materialMovement->safety_stock !== null ? (int) $materialMovement->safety_stock : null) }}"
                           placeholder="Masukkan safety stock"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 @error('safety_stock') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    @error('safety_stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Movement Type -->
            <div>
                <label for="movement_type" class="block text-sm font-medium text-slate-700 mb-2">
                    Movement Type <span class="text-red-500">*</span>
                </label>
                <select id="movement_type" name="movement_type" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 text-slate-700 @error('movement_type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">
                    <option value="" class="text-slate-500">Pilih Movement Type</option>
                    <option value="jo" {{ old('movement_type', $materialMovement->movement_type) == 'jo' ? 'selected' : '' }} class="text-slate-700">
                        Job Order (JO)
                    </option>
                    <option value="memo" {{ old('movement_type', $materialMovement->movement_type) == 'memo' ? 'selected' : '' }} class="text-slate-700">
                        Memo
                    </option>
                    <option value="other" {{ old('movement_type', $materialMovement->movement_type) == 'other' ? 'selected' : '' }} class="text-slate-700">
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
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 @error('keterangan') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror">{{ old('keterangan', $materialMovement->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-200">
                <button type="submit"
                        class="px-6 py-2 bg-yellow-600 text-white rounded-lg font-medium shadow hover:bg-yellow-700 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Update
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tgl = document.getElementById('tanggal');
            if (!tgl) return;

            // Make sure it's a text input (avoid native datepicker forcing yyyy-mm-dd)
            try { tgl.setAttribute('type', 'text'); } catch (e) {}
            tgl.setAttribute('placeholder', 'dd-mm-yyyy');
            tgl.setAttribute('pattern', '\\d{2}-\\d{2}-\\d{4}');

            const toDmy = (val) => {
                const iso = /^(\\d{4})-(\\d{2})-(\\d{2})$/;
                const dmy = /^(\\d{2})-(\\d{2})-(\\d{4})$/;
                if (iso.test(val)) {
                    const [, y, m, d] = val.match(iso);
                    return `${d}-${m}-${y}`;
                }
                if (dmy.test(val)) return val;
                // Try to normalize values like 1/2/2025 or 1-2-25
                const cleaned = val.replace(/\//g, '-').trim();
                const parts = cleaned.split('-');
                if (parts.length === 3 && parts[0] && parts[1] && parts[2]) {
                    let [d, m, y] = parts;
                    if (y.length === 2) y = (parseInt(y, 10) < 50 ? '20' : '19') + y;
                    d = d.padStart(2, '0');
                    m = m.padStart(2, '0');
                    y = y.padStart(4, '0');
                    if (/^\\d{2}$/.test(d) && /^\\d{2}$/.test(m) && /^\\d{4}$/.test(y)) {
                        return `${d}-${m}-${y}`;
                    }
                }
                return val;
            };

            // Normalize on load (in case browser fills yyyy-mm-dd)
            if (tgl.value) {
                const nv = toDmy(tgl.value);
                if (nv !== tgl.value) tgl.value = nv;
            }

            // Normalize whenever the value changes
            ['change', 'blur'].forEach(ev => {
                tgl.addEventListener(ev, () => {
                    const nv = toDmy(tgl.value);
                    if (nv !== tgl.value) tgl.value = nv;
                });
            });
        });
    </script>
@endsection
