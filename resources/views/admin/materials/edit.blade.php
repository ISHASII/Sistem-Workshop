@extends('layouts.admin')

@section('title', 'Edit Material')

@section('content')
    <div class="bg-white rounded-lg shadow-sm border border-red-100 p-6">
    <h2 class="text-2xl font-bold text-red-700 mb-6">Edit Material</h2>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 rounded-md p-4 mb-6">
                <div class="flex">
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.materials.update', $material) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-slate-700 mb-1">
                        Tanggal Input
                    </label>
                    <input type="text" id="tanggal" name="tanggal" value="{{ optional($material->created_at)->format('d-m-Y') }}" readonly
                           class="w-full px-3 py-2 border border-slate-300 rounded-md bg-slate-100 text-slate-500 cursor-not-allowed">
                </div>

                <div>
                    <label for="material" class="block text-sm font-medium text-slate-700 mb-1">
                        Nama Material <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="material" name="material" value="{{ old('material', $material->nama) }}" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('material') border-red-500 @enderror">
                    @error('material')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="spesifikasi" class="block text-sm font-medium text-slate-700 mb-1">Spesifikasi</label>
                <input type="text" id="spesifikasi" name="spesifikasi" value="{{ old('spesifikasi', $material->spesifikasi) }}"
                       class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('spesifikasi') border-red-500 @enderror">
                @error('spesifikasi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="kategori_id" class="block text-sm font-medium text-slate-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori_id" name="kategori_id" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('kategori_id') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $material->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="satuan_id" class="block text-sm font-medium text-slate-700 mb-1">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <select id="satuan_id" name="satuan_id" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('satuan_id') border-red-500 @enderror">
                        <option value="">Pilih Satuan</option>
                        @foreach($satuans as $satuan)
                            <option value="{{ $satuan->id }}" {{ old('satuan_id', $material->satuan_id) == $satuan->id ? 'selected' : '' }}>
                                {{ $satuan->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('satuan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-slate-700 mb-1">
                        Jumlah Stok Awal <span class="text-red-500">*</span>
                    </label>
              <input type="number" step="1" min="0" id="jumlah" name="jumlah"
                  value="{{ old('jumlah', $material->getCurrentStok()) }}" readonly
                  class="w-full px-3 py-2 border border-slate-300 bg-slate-100 text-slate-500 rounded-md cursor-not-allowed">
                    @error('jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="safety_stock" class="block text-sm font-medium text-slate-700 mb-1">
                        Safety Stock <span class="text-red-500">*</span>
                    </label>
              <input type="number" step="1" min="0" id="safety_stock" name="safety_stock"
                  value="{{ old('safety_stock', number_format($material->safety_stock, 0)) }}" readonly
                  class="w-full px-3 py-2 border border-slate-300 bg-slate-100 text-slate-500 rounded-md cursor-not-allowed">
                    @error('safety_stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-2 pt-4">
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-md hover:from-red-700 hover:to-rose-700 transition">
                    Update
                </button>
                <a href="{{ route('admin.materials.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
