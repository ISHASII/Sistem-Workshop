@extends('layouts.admin')

@section('title', 'Edit Man Power')

@section('content')
    <div class="max-w-4xl mx-auto space-y-4 md:space-y-6 p-4">
        <!-- Header -->
        <div class="flex items-center gap-3 md:gap-4">
            <a href="{{ route('admin.manpower.index') }}" class="p-2 hover:bg-slate-100 rounded-lg transition-colors duration-150 flex-shrink-0">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div class="min-w-0">
                <h1 class="text-xl md:text-3xl font-bold text-slate-800">Edit Data Man Power</h1>
                <p class="text-xs md:text-sm text-slate-600 mt-1 truncate">Perbarui informasi: <span class="font-semibold text-rose-600">{{ $manpower->nama }}</span></p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-rose-50 to-red-50 px-4 md:px-6 py-3 md:py-4 border-b border-rose-100">
                <div class="flex items-center gap-2 md:gap-3">
                    <div class="p-1.5 md:p-2 bg-rose-600 rounded-lg flex-shrink-0">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-base md:text-lg font-semibold text-slate-800">Informasi Man Power</h2>
                        <p class="text-xs md:text-sm text-slate-600 hidden sm:block">Perbarui data identitas dan status karyawan</p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form action="{{ route('admin.manpower.update', $manpower) }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-6 space-y-4 md:space-y-6">
                @csrf
                @method('PUT')

                <!-- NRP Field -->
                <div>
                    <label for="nrp" class="block text-xs md:text-sm font-semibold text-slate-700 mb-2">
                        NRP (Nomor Registrasi Pegawai) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 md:pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                        </div>
                        <input type="text" id="nrp" name="nrp" value="{{ old('nrp', $manpower->nrp) }}"
                               placeholder="Contoh: NRP001"
                               class="w-full pl-10 md:pl-12 pr-3 md:pr-4 py-2.5 md:py-3 text-sm md:text-base bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200 @error('nrp') border-red-300 @enderror"
                               required>
                    </div>
                    @error('nrp')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nama Field -->
                <div>
                    <label for="nama" class="block text-xs md:text-sm font-semibold text-slate-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 md:pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $manpower->nama) }}"
                               placeholder="Masukkan nama lengkap"
                               class="w-full pl-10 md:pl-12 pr-3 md:pr-4 py-2.5 md:py-3 text-sm md:text-base bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200 @error('nama') border-red-300 @enderror"
                               required>
                    </div>
                    @error('nama')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Grid 2 Columns -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-xs md:text-sm font-semibold text-slate-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 md:pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="w-full pl-10 md:pl-12 pr-3 md:pr-4 py-2.5 md:py-3 text-sm md:text-base bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200 @error('jenis_kelamin') border-red-300 @enderror"
                                    required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="laki-laki" {{ old('jenis_kelamin', $manpower->jenis_kelamin ?? '')=='laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin', $manpower->jenis_kelamin ?? '')=='perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        @error('jenis_kelamin')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Status Pegawai -->
                    <div>
                        <label for="status_pegawai" class="block text-xs md:text-sm font-semibold text-slate-700 mb-2">
                            Status Pegawai <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 md:pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <select id="status_pegawai" name="status_pegawai"
                                    class="w-full pl-10 md:pl-12 pr-3 md:pr-4 py-2.5 md:py-3 text-sm md:text-base bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200 @error('status_pegawai') border-red-300 @enderror"
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="kontrak" {{ old('status_pegawai', $manpower->status_pegawai ?? '')=='kontrak' ? 'selected' : '' }}>Kontrak</option>
                                <option value="tetap" {{ old('status_pegawai', $manpower->status_pegawai ?? '')=='tetap' ? 'selected' : '' }}>Tetap</option>
                            </select>
                        </div>
                        @error('status_pegawai')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Warning Box -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 md:p-4">
                    <div class="flex items-start gap-2 md:gap-3">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs md:text-sm font-medium text-amber-800">Perhatian</p>
                            <p class="text-xs md:text-sm text-amber-700 mt-1">Pastikan perubahan data sudah sesuai sebelum menyimpan. Data yang sudah diupdate tidak dapat dikembalikan secara otomatis.</p>
                        </div>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div>
                    <label for="photo" class="block text-xs md:text-sm font-semibold text-slate-700 mb-2">Foto (opsional)</label>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 md:gap-4">
                        <input type="file" id="photo" name="photo" accept="image/*"
                               class="text-xs md:text-sm text-slate-700 file:rounded-md file:border-0 file:px-2 file:py-1.5 md:file:px-3 md:file:py-2 file:bg-rose-50 file:text-rose-700 file:text-xs md:file:text-sm" />

                        <!-- Preview container: shows existing photo or newly chosen file -->
                        <div id="photo-preview-wrap" class="w-16 h-16 md:w-20 md:h-20 rounded-md overflow-hidden border hidden flex-shrink-0">
                            <img id="photo-preview-img" src="@if($manpower->photo){{ asset('storage/'.$manpower->photo) }}@endif" alt="Foto {{ $manpower->nama }}" class="w-full h-full object-cover" data-original="@if($manpower->photo){{ asset('storage/'.$manpower->photo) }}@endif" />
                        </div>
                        <div id="photo-preview-controls">
                            <button id="photo-clear-btn" class="inline-flex items-center gap-1 md:gap-2 px-2 md:px-3 py-1.5 text-xs md:text-sm bg-white border border-slate-200 text-red-600 rounded-lg shadow-sm hover:bg-slate-50">Hapus preview</button>
                        </div>
                    </div>
                    @error('photo')
                        <p class="mt-2 text-xs md:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 md:gap-3 pt-3 md:pt-4 border-t border-slate-200">
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 md:px-6 py-2.5 md:py-3 text-sm md:text-base bg-gradient-to-r from-rose-600 to-red-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-rose-700 hover:to-red-700 transition-all duration-200">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Data
                    </button>
                    <a href="{{ route('admin.manpower.index') }}" class="inline-flex items-center justify-center gap-2 px-4 md:px-6 py-2.5 md:py-3 text-sm md:text-base bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold transition-colors duration-200">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const input = document.getElementById('photo');
            const previewWrap = document.getElementById('photo-preview-wrap');
            const previewImg = document.getElementById('photo-preview-img');
            const originalSrc = previewImg && previewImg.dataset ? previewImg.dataset.original : '';

            if(!input) return;

            // show existing photo initially if present
            if (originalSrc) {
                previewImg.src = originalSrc;
                previewWrap.classList.remove('hidden');
            }

            const clearBtn = document.getElementById('photo-clear-btn');
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e){
                    e.preventDefault();
                    // clear file input
                    input.value = '';
                    // revert to original if existed, otherwise hide
                    if (originalSrc) {
                        previewImg.src = originalSrc;
                        previewWrap.classList.remove('hidden');
                    } else {
                        previewImg.src = '';
                        previewWrap.classList.add('hidden');
                    }
                });
            }

            input.addEventListener('change', function(){
                const file = input.files && input.files[0];
                if (file) {
                    const url = URL.createObjectURL(file);
                    previewImg.src = url;
                    previewWrap.classList.remove('hidden');
                } else {
                    // revert to original if existed
                    if (originalSrc) {
                        previewImg.src = originalSrc;
                        previewWrap.classList.remove('hidden');
                    } else {
                        previewImg.src = '';
                        previewWrap.classList.add('hidden');
                    }
                }
            });
        });
    </script>
@endpush
