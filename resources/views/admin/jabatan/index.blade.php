@extends('layouts.admin')

@section('title', 'Jabatan')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-orange-100 px-6 py-5 border-b border-red-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-orange-600 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 10-8 0v4M5 21h14a2 2 0 002-2V9H3v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-800">Data Jabatan</h1>
                            <p class="text-sm text-slate-600 mt-0.5">Kelola jabatan untuk pilihan register customer</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.jabatan.create') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-orange-600 to-amber-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:from-orange-700 hover:to-amber-700 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Jabatan
                    </a>
                </div>
            </div>

            <div class="px-6 py-4 bg-gradient-to-r from-orange-50/50 to-amber-50/50 border-b border-orange-100">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-white rounded-lg shadow-sm border border-orange-200">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 10-8 0v4M5 21h14a2 2 0 002-2V9H3v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-medium">Total Jabatan</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $jabatans->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-orange-50 border-y border-orange-100">
                <form method="GET" action="{{ route('admin.jabatan.index') }}" class="flex gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama jabatan..."
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-orange-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.jabatan.index') }}"
                            class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </form>
            </div>

            <div class="p-6">
                @if($jabatans->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-slate-200">
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                        Nama Jabatan</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($jabatans as $jabatan)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-4 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-400 to-amber-500 flex items-center justify-center shadow-sm">
                                                    <span
                                                        class="text-white font-bold text-sm">{{ strtoupper(substr($jabatan->name, 0, 2)) }}</span>
                                                </div>
                                                <span class="font-medium text-slate-800">{{ $jabatan->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @include('admin.partials.action-buttons', [
                                                'editRoute' => route('admin.jabatan.edit', $jabatan),
                                                'destroyRoute' => route('admin.jabatan.destroy', $jabatan),
                                                'labelAlign' => 'center',
                                                'deleteTitle' => 'Hapus jabatan?',
                                                'deleteText' => 'Jabatan dan referensinya pada data user akan dilepas.',
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 10-8 0v4M5 21h14a2 2 0 002-2V9H3v10a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-slate-500 font-medium">Belum ada data jabatan</p>
                    <p class="text-sm text-slate-400 mt-1">Klik tombol "Tambah Jabatan" untuk menambah data</p>
                </div>
            @endif

            </div>

            <!-- Pagination -->
            @if($jabatans->hasPages())
                <div class="px-4 md:px-6 py-3 md:py-4 border-t border-slate-200 bg-slate-50 rounded-b-xl">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-xs md:text-sm text-slate-600 text-center sm:text-left">
                            Menampilkan {{ $jabatans->firstItem() ?? 0 }} - {{ $jabatans->lastItem() ?? 0 }} dari {{ $jabatans->total() }} data
                        </div>
                        <div class="flex items-center gap-1 md:gap-2">
                            @php
                                $current = $jabatans->currentPage();
                                $last = $jabatans->lastPage();
                                $start = max(1, $current - 1);
                                $end = min($last, $current + 1);
                                $qs = http_build_query(request()->except('page'));
                                $qsPrefix = $qs ? '&' . $qs : '';
                            @endphp

                            {{-- Previous --}}
                            @if($jabatans->onFirstPage())
                                <span class="px-2 py-1.5 md:px-3 md:py-2 text-sm rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </span>
                            @else
                                <a href="?page={{ max(1, $current - 1) }}{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </a>
                            @endif

                            {{-- First page + ellipsis if needed --}}
                            @if($start > 1)
                                <a href="?page=1{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-xs md:text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">1</a>
                                @if($start > 2)
                                    <span class="px-1 md:px-2 text-slate-400 text-xs md:text-sm">...</span>
                                @endif
                            @endif

                            {{-- Page window --}}
                            @for($i = $start; $i <= $end; $i++)
                                @if($i == $current)
                                    <span class="px-2 py-1.5 md:px-3 md:py-2 text-xs md:text-sm rounded-lg bg-red-600 text-white font-medium">{{ $i }}</span>
                                @else
                                    <a href="?page={{ $i }}{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-xs md:text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">{{ $i }}</a>
                                @endif
                            @endfor

                            {{-- Last page + ellipsis if needed --}}
                            @if($end < $last)
                                @if($end < $last - 1)
                                    <span class="px-1 md:px-2 text-slate-400 text-xs md:text-sm">...</span>
                                @endif
                                <a href="?page={{ $last }}{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-xs md:text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">{{ $last }}</a>
                            @endif

                            {{-- Next --}}
                            @if($current >= $last)
                                <span class="px-2 py-1.5 md:px-3 md:py-2 text-sm rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            @else
                                <a href="?page={{ min($last, $current + 1) }}{{ $qsPrefix }}" class="px-2 py-1.5 md:px-3 md:py-2 text-sm rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
