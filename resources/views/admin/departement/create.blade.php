@extends('layouts.admin')

@section('title', 'Tambah Departement')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.departement.index') }}"
                class="p-2 hover:bg-slate-100 rounded-lg transition-colors duration-150">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Tambah Departement Baru</h1>
                <p class="text-slate-600 mt-1">Buat departement baru untuk pilihan registrasi customer</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-50 to-orange-100 px-6 py-4 border-b border-amber-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-amber-600 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 10-8 0v4M5 21h14a2 2 0 002-2V9H3v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-800">Informasi Departement</h2>
                        <p class="text-sm text-slate-600">Masukkan nama departement yang akan dipakai saat customer register
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.departement.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Departement <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 10-8 0v4M5 21h14a2 2 0 002-2V9H3v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Contoh: Produksi, Quality Control, Administrasi"
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all duration-200 @error('name') border-red-300 focus:border-red-500 focus:ring-red-500/10 @enderror"
                            required>
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-amber-900">Tips Pengisian</p>
                            <ul class="text-sm text-amber-800 mt-1 space-y-1 list-disc list-inside">
                                <li>Gunakan nama departement yang singkat dan jelas</li>
                                <li>Nama ini akan tampil di dropdown saat customer register</li>
                                <li>Contoh: Produksi, Engineering, Administrasi, Warehouse</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-amber-700 hover:to-orange-700 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Departement
                    </button>
                    <a href="{{ route('admin.departement.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection