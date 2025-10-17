@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-rose-100 px-6 py-5 border-b border-red-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-red-600 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-800">Data Kategori</h1>
                            <p class="text-sm text-slate-600 mt-0.5">Kelola kategori material workshop</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-red-700 hover:to-rose-700 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kategori
                    </a>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="px-6 py-4 bg-gradient-to-r from-red-50/50 to-rose-50/50 border-b border-red-100">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-white rounded-lg shadow-sm border border-red-200">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Total Kategori</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $kategoris->total() }}</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mx-6 mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Search & Filter Section -->
            <div class="px-6 py-4 bg-rose-50 border-y border-rose-100">
                <form method="GET" action="{{ route('admin.kategori.index') }}" class="flex gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama kategori..."
                               class="w-full pl-10 pr-4 py-2.5 bg-white border border-rose-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Section -->
            <div class="p-6">
                @if($kategoris->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-slate-200">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            ID
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            Nama Kategori
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                        <div class="flex items-center justify-center gap-2">
                                            Aksi
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($kategoris as $kategori)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 text-red-700 font-semibold text-sm">
                                                {{ $kategori->id }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center shadow-sm">
                                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($kategori->name, 0, 2)) }}</span>
                                                </div>
                                                <span class="font-medium text-slate-800">{{ $kategori->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @include('admin.partials.action-buttons', [
                                                'editRoute' => route('admin.kategori.edit', $kategori),
                                                'destroyRoute' => route('admin.kategori.destroy', $kategori),
                                                'labelAlign' => 'center',
                                                'deleteTitle' => 'Hapus kategori?',
                                                'deleteText' => 'Kategori dan semua dependensi yang terkait akan dihapus.',
                                                'deleteConfirm' => 'Hapus'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <p class="text-slate-500 font-medium">Belum ada data kategori</p>
                        <p class="text-sm text-slate-400 mt-1">Klik tombol "Tambah Kategori" untuk menambah data</p>
                    </div>
                @endif

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $kategoris->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
