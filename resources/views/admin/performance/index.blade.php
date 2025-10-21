@extends('layouts.admin')

@section('title', 'Performance Man Power')

@section('content')
    <!-- Chart libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <div class="bg-gray-50 p-4">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-md p-4 md:p-5 mb-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Performance Man Power</h2>
                    <p class="text-gray-600 text-sm mt-1">Monitor dan analisis performa karyawan</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.performance.exportPdfAll', request()->all()) }}" target="_blank"
                       class="inline-flex items-center px-3 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-900 transition-all duration-200 shadow">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8"/>
                        </svg>
                        Export All PDF
                    </a>

                    <a href="{{ route('admin.performance.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-all duration-200 shadow">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Performance
                </a>
                </div>
            </div>

            <!-- Search & Filter Form -->
            <form method="GET" action="{{ route('admin.performance.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-1">
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Cari Performance</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari nama atau NRP..."
                                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                    </div>

                    <!-- Filter Man Power -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Man Power</label>
                        <select name="manpower" class="w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="">Semua Karyawan</option>
                            @foreach($manpowers as $manpower)
                                <option value="{{ $manpower->id }}" {{ request('manpower') == $manpower->id ? 'selected' : '' }}>
                                    {{ $manpower->nrp }} - {{ $manpower->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tanggal Mulai -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Filter Tanggal Akhir -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>

                    <!-- Action Buttons -->
                    <div class="md:col-span-1 flex items-end gap-2">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'manpower', 'start_date', 'end_date']))
                            <a href="{{ route('admin.performance.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Content Section -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            <!-- Chart Section -->
            <div class="xl:col-span-3 bg-white rounded-lg shadow-md p-6 flex flex-col justify-center mb-6 xl:mb-0">
                <div class="mb-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Rata-rata Performance per Karyawan</h3>
                    <p class="text-gray-600 text-sm">Visualisasi rata-rata performa keseluruhan setiap karyawan</p>
                </div>
                <div class="flex justify-center items-center flex-1">
                    <div class="w-full">
                        <canvas id="performancePieChart"></canvas>
                    </div>
                </div>
                <!-- Custom Legend -->
                <div class="mt-6 space-y-3 max-h-56 overflow-auto pr-1">
                    @php
                        $legendColors = ['#EF4444','#F59E0B','#10B981','#3B82F6','#8B5CF6','#EC4899','#06B6D4','#84CC16'];
                    @endphp
                    @foreach($averagePerformances as $i => $performance)
                        <div class="flex items-center gap-3">
                            <span class="inline-block w-6 h-3 rounded" style="background-color: {{ $legendColors[$i % count($legendColors)] }}"></span>
                            <span class="text-gray-800 text-sm">{{ $performance->manpower->nama }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Data Table Section -->
            <div class="xl:col-span-9 bg-white rounded-lg shadow-md flex flex-col p-6">
                <div class="px-4 py-4 border-b border-gray-200 mb-2">
                    <h3 class="text-lg font-semibold text-gray-900">Data Performance</h3>
                    <p class="text-gray-600 text-sm">Daftar semua data performance karyawan</p>
                </div>

                <div>
                    <table class="w-full min-w-max table-fixed text-sm" style="min-width: 900px;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NRP</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($performances as $performance)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">
                                        {{ $performance->created_at->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $performance->manpower?->nrp }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">
                                        {{ $performance->manpower?->nama }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-semibold">{{ $performance->score }}%</span>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-3">
                                            @include('admin.partials.action-buttons', [
                                                'showRoute' => route('admin.performance.show', $performance),
                                                'editRoute' => route('admin.performance.edit', $performance),
                                                'destroyRoute' => route('admin.performance.destroy', $performance),
                                                'pdfRoute' => route('admin.performance.exportPdf', $performance),
                                                'labelAlign' => 'center',
                                                'deleteTitle' => 'Hapus data performance?',
                                                'deleteText' => 'Yakin ingin menghapus performance ' . ($performance->manpower?->nama ?? '' ) . '?',
                                                'deleteConfirm' => 'Hapus'
                                            ])
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-6 flex justify-end">
                        {{ $performances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('performancePieChart').getContext('2d');
        if (window.ChartDataLabels) { Chart.register(ChartDataLabels); }

        const chartData = {
            labels: [
                @foreach($averagePerformances as $performance)
                    '{{ $performance->manpower->nama }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($averagePerformances as $performance)
                        {{ number_format($performance->average_score, 2) }},
                    @endforeach
                ],
                backgroundColor: ['#EF4444','#F59E0B','#10B981','#3B82F6','#8B5CF6','#EC4899','#06B6D4','#84CC16'],
                borderWidth: 2,
                borderColor: '#FFFFFF',
                hoverBorderWidth: 3,
                hoverBorderColor: '#374151'
            }]
        };

        const config = {
            type: 'doughnut',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '60%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleColor: '#FFFFFF',
                        bodyColor: '#FFFFFF',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                return `${label}: ${parseFloat(value).toFixed(1)}%`;
                            }
                        }
                    },
                    datalabels: {
                        color: '#111827',
                        font: { weight: 'bold', size: 14 },
                        // Show the employee's average score itself (not share of the whole)
                        formatter: function(value) {
                            return `${parseFloat(value).toFixed(1)}%`;
                        },
                        anchor: 'center',
                        align: 'center'
                    }
                },
                animation: { animateRotate: true, animateScale: true, duration: 1000 }
            }
        };

        new Chart(ctx, config);
    </script>
@endsection
