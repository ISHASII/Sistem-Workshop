@extends('layouts.admin')

@section('title', 'Tambah Material')

@section('content')
    <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 border border-red-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-red-700">Tambah Material</h2>
            </div>

            {{-- session success flash removed per user request --}}

            <form action="{{ route('admin.materials.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600">Tanggal</label>
                        <input type="text" name="tanggal" value="{{ old('tanggal', date('d-m-Y')) }}" class="mt-1 block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200" required readonly>
                        @error('tanggal')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600">Nama Material</label>
                        <input type="text" name="material" value="{{ old('material') }}" class="mt-1 block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200" required>
                        @error('material')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-600">Spesifikasi</label>
                        <input type="text" name="spesifikasi" value="{{ old('spesifikasi') }}" class="mt-1 block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200">
                        @error('spesifikasi')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600">Jumlah Stok Awal</label>
                        <input type="number" step="1" name="jumlah" value="{{ old('jumlah') }}" class="mt-1 block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200" required>
                        @error('jumlah')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600">Safety Stock</label>
                        <input type="number" step="1" name="safety_stock" value="{{ old('safety_stock') }}" class="mt-1 block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200" required>
                        @error('safety_stock')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600">Kategori</label>
                        <select name="kategori_id" class="mt-1 block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200 appearance-none" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->name }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600">Satuan</label>
                        <select name="satuan_id" class="mt-1 block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all duration-200 appearance-none" required>
                            <option value="">-- Pilih Satuan --</option>
                            @foreach($satuans as $satuan)
                                <option value="{{ $satuan->id }}" {{ old('satuan_id') == $satuan->id ? 'selected' : '' }}>{{ $satuan->name }}</option>
                            @endforeach
                        </select>
                        @error('satuan_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="pt-4 flex justify-between">
                    <a href="{{ route('admin.materials.index') }}" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-md shadow">Kembali</a>
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white rounded-md shadow">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
