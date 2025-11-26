@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: currentColor;
            border-radius: 3px;
        }
    </style>
    <div class="w-full min-h-screen py-4 px-2 sm:py-6 sm:px-4 md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-4 sm:space-y-6">
            <!-- Live Clock (center top, responsive) -->
            <div class="flex justify-center">
                <div id="live-clock-card"
                    class="bg-red-600 rounded-2xl shadow-lg border border-red-200/50 px-3 py-2 sm:px-4 sm:py-3 mb-2 w-full max-w-sm sm:max-w-md backdrop-blur-sm">
                    <div class="flex items-center w-full text-white">
                        <div class="w-1/4 text-xs font-semibold opacity-90 hidden sm:block">Waktu Server</div>
                        <div class="w-1/2 text-center">
                            <div id="live-time" class="text-base sm:text-lg font-bold tracking-wide"></div>
                        </div>
                        <div class="w-1/2 sm:w-1/4 text-right">
                            <div id="live-date" class="text-xs sm:text-sm opacity-90"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Man Power Chart Card -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">
                <div
                    class="lg:col-span-4 bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-indigo-200/50 p-4 sm:p-6 transform hover:scale-[1.005] transition-all duration-300 hover:shadow-2xl">
                    <div class="flex items-center justify-between mb-4 sm:mb-5">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Rata-rata Performance Karyawan</h3>
                        </div>
                    </div>
                    <div class="flex-1 flex justify-center items-center h-48 sm:h-64">
                        <canvas id="performancePieChartDashboard"
                            class="w-full h-full max-w-xs sm:max-w-md mx-auto"></canvas>
                    </div>
                    <!-- Custom Legend -->
                    <div
                        class="mt-4 sm:mt-6 space-y-2 sm:space-y-3 max-h-32 sm:max-h-40 overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-indigo-300/50 scrollbar-track-transparent">
                        @php
                            $legendColors = ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'];
                        @endphp
                        @if(isset($averagePerformances) && $averagePerformances->isNotEmpty())
                            @foreach($averagePerformances as $i => $performance)
                                <div
                                    class="flex items-center gap-2 sm:gap-3 p-2 sm:p-3 bg-gradient-to-r from-gray-50 to-indigo-50 rounded-xl hover:bg-indigo-100 transition-all duration-200 cursor-pointer">
                                    <span class="inline-block w-3 h-2.5 sm:w-4 sm:h-3 rounded-full shadow-sm"
                                        style="background-color: {{ $legendColors[$i % count($legendColors)] }}"></span>
                                    <span
                                        class="text-gray-700 font-semibold text-xs sm:text-sm flex-1 truncate">{{ $performance->manpower->nama }}</span>
                                    <span
                                        class="text-indigo-600 font-bold text-xs sm:text-sm">{{ number_format($performance->average_score, 1) }}%</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4 sm:py-6 text-gray-400 text-sm">Data performance tidak tersedia</div>
                        @endif
                    </div>
                </div>

                <!-- Job Order Progress Chart Card -->
                <div
                    class="lg:col-span-8 bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-blue-200/50 p-4 sm:p-6 transform hover:scale-[1.005] transition-all duration-300 hover:shadow-2xl">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-4 sm:mb-5">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Progress Job Order</h3>
                        </div>
                        <span class="text-xs sm:text-sm text-gray-500 font-medium">{{ now()->format('d M Y') }}</span>
                    </div>
                    <div class="h-72 sm:h-80 lg:h-96 overflow-hidden rounded-xl border border-gray-200/50">
                        <div id="progress-joborder-scroll-wrapper"
                            class="w-full h-full overflow-y-auto overflow-x-auto scrollbar-thin scrollbar-thumb-blue-300/50 scrollbar-track-transparent">
                            <div id="progress-joborder-chart-wrapper" class="w-full min-h-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two-column: Job Order Monthly List + Proyek Urgent -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-green-200/50 p-3 transform hover:scale-[1.005] transition-all duration-300 hover:shadow-2xl">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-9 h-9 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">Job Order Perbulan</h3>
                        </div>
                        <form id="filterJobOrderMonth" class="flex flex-wrap items-center gap-2 max-w-full sm:max-w-xs"
                            method="GET" action="">
                            <select name="bulan"
                                class="w-28 sm:w-auto border border-gray-300/50 bg-white/80 rounded-xl px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 transition-all truncate">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" @if($m == request('bulan', now()->month)) selected @endif>
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="tahun"
                                class="w-20 sm:w-auto border border-gray-300/50 bg-white/80 rounded-xl px-2 py-1 text-xs focus:ring-2 focus:ring-green-500 transition-all truncate">
                                @foreach(range(now()->year - 5, now()->year + 1) as $y)
                                    <option value="{{ $y }}" @if($y == request('tahun', now()->year)) selected @endif>{{ $y }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-3 py-1 rounded-xl text-xs font-semibold whitespace-nowrap flex-shrink-0">
                                <span class="hidden sm:inline">Tampilkan</span>
                                <svg class="sm:hidden w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10h18v8a1 1 0 01-1 1H4a1 1 0 01-1-1v-8z">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    @php $jobMonthlyScrollable = isset($joborders_monthly) && count($joborders_monthly) > 6; @endphp
                    <div
                        class="overflow-x-auto rounded-xl border border-gray-200/50 {{ $jobMonthlyScrollable ? 'max-h-56 overflow-y-auto' : '' }}">
                        <table class="w-full text-xs">
                            <thead class="bg-gradient-to-r from-gray-50 to-green-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-700">Tanggal</th>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-700">Proyek</th>
                                    <th class="px-3 py-2 text-left font-semibold text-gray-700">Evaluasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200/50">
                                @forelse($joborders_monthly as $jo)
                                    @php
                                        $startFormatted = $jo->start ? \Carbon\Carbon::parse($jo->start)->format('d M Y') : '-';
                                        $endFormatted = $jo->end ? \Carbon\Carbon::parse($jo->end)->format('d M Y') : '-';
                                        $dateRange = ($startFormatted !== '-' && $endFormatted !== '-')
                                            ? $startFormatted . ' - ' . $endFormatted
                                            : ($startFormatted !== '-' ? $startFormatted : $endFormatted);
                                    @endphp
                                    <tr class="hover:bg-green-50/50 transition-all duration-200">
                                        <td class="px-3 py-2 font-semibold text-blue-700">{{ $dateRange }}</td>
                                        <td class="px-3 py-2 text-gray-700 max-w-xs truncate">{{ $jo->project }}</td>
                                        <td class="px-3 py-2 text-gray-700">{{ $jo->evaluasi ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-6 text-gray-500">Tidak ada job order bulan ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-red-200/50 p-3 transform hover:scale-[1.005] transition-all duration-300 hover:shadow-2xl">
                    <div class="flex items-center gap-2 mb-3">
                        <div
                            class="w-9 h-9 bg-gradient-to-br from-red-100 to-rose-100 rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Proyek Urgent</h3>
                    </div>
                    <div class="h-44 sm:h-56 overflow-hidden rounded-xl border border-gray-200/50">
                        <div id="urgent-project-scroll-wrapper"
                            class="w-full h-full overflow-y-auto overflow-x-hidden scrollbar-thin scrollbar-thumb-red-300/50 scrollbar-track-transparent">
                            <div id="urgent-project-chart-wrapper" class="w-full min-h-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Material Kritis Card -->
            <div
                class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-orange-200/50 p-4 sm:p-6 transform hover:scale-[1.005] transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-5">
                    <div
                        class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-orange-100 to-amber-100 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-orange-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">Material Kritis (Stock < Reorder)</h3>
                </div>
                <div class="h-72 sm:h-80 lg:h-96 overflow-hidden rounded-xl border border-gray-200/50">
                    <div id="critical-material-scroll-wrapper"
                        class="w-full h-full overflow-y-auto overflow-x-auto scrollbar-thin scrollbar-thumb-orange-300/50 scrollbar-track-transparent">
                        <div class="w-full p-2">
                            <table class="w-full text-xs">
                                <thead class="bg-gradient-to-r from-gray-50 to-orange-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-semibold text-gray-700">Nama Material</th>
                                        <th class="px-3 py-2 text-right font-semibold text-gray-700">Stock</th>

                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200/50">
                                    @forelse($critical_materials as $m)
                                        @php
                                            // support both Eloquent models (objects) and arrays
                                            $name = is_array($m) ? ($m['nama'] ?? ($m['nama'] ?? '')) : ($m->nama ?? '');
                                            $stock = is_array($m) ? ($m['stock'] ?? 0) : ($m->stock ?? 0);


                                        @endphp
                                        <tr>
                                            <td class="px-3 py-2 text-gray-700 truncate">{{ $name }}</td>
                                            <td class="px-3 py-2 text-right font-semibold text-gray-700">
                                                {{ number_format($stock) }}</td>


                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-6 text-gray-500">Tidak ada material kritis.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Material Stock Summary Card -->
            <div
                class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-purple-200/50 p-4 sm:p-6 transform hover:scale-[1.005] transition-all duration-300 hover:shadow-2xl">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div
                        class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-100 to-violet-100 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 leading-tight text-left">
                        Material Stock Summary
                    </h3>
                </div>

                <button id="mat-prev-btn" type="button"
                    class="text-xs px-2 py-1 rounded-xl bg-gray-100 hover:bg-gray-200 border border-gray-200 flex-shrink-0">
                    <span class="hidden sm:inline">Prev</span>
                    <svg class="sm:hidden w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <button id="mat-play-btn" type="button"
                    class="text-xs px-2 py-1 rounded-xl bg-gray-100 hover:bg-gray-200 border border-gray-200 flex-shrink-0"
                    aria-pressed="true">
                    <span class="hidden sm:inline mat-play-text">Pause</span>
                    <svg class="sm:hidden w-4 h-4 inline ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <g class="icon-pause">
                            <rect x="6" y="5" width="4" height="14" rx="1"></rect>
                            <rect x="14" y="5" width="4" height="14" rx="1"></rect>
                        </g>
                        <g class="icon-play" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v18l15-9L5 3z">
                            </path>
                        </g>
                    </svg>
                </button>

                <button id="mat-next-btn" type="button"
                    class="text-xs px-2 py-1 rounded-xl bg-gray-100 hover:bg-gray-200 border border-gray-200 flex-shrink-0">
                    <span class="hidden sm:inline">Next</span>
                    <svg class="sm:hidden w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <div class="overflow-x-auto rounded-xl border border-gray-200/50">
                    <div id="material-chart-container-inner" class="w-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <script>
        // Live clock: tampilkan tanggal dan waktu (HH:MM:SS) berdasarkan zona Asia/Jakarta, update setiap detik
        (function () {
            // Ambil waktu server dalam timezone Asia/Jakarta
            const initialServer = '{{ now()->setTimezone("Asia/Jakarta")->toDateTimeString() }}'; // 'YYYY-MM-DD HH:MM:SS'
            const liveDateEl = document.getElementById('live-date');
            const liveTimeEl = document.getElementById('live-time');

            function pad(n) { return n < 10 ? '0' + n : n; }

            // render menggunakan komponen UTC agar tidak terpengaruh timezone client
            function renderTimeUTC(dt) {
                const d = dt.getUTCDate();
                const m = dt.getUTCMonth() + 1;
                const y = dt.getUTCFullYear();
                const hh = pad(dt.getUTCHours());
                const mm = pad(dt.getUTCMinutes());
                const ss = pad(dt.getUTCSeconds());
                liveDateEl.textContent = `${pad(d)}-${pad(m)}-${y}`;
                liveTimeEl.textContent = `${hh}:${mm}:${ss}`;
            }

            // Parse initial server time (YYYY-MM-DD HH:MM:SS) and build a UTC Date representing that local Jakarta time
            let nowUtcDate = new Date();
            try {
                if (initialServer) {
                    const parts = initialServer.split(' ');
                    if (parts.length === 2) {
                        const [datePart, timePart] = parts;
                        const [y, mo, d] = datePart.split('-').map(Number);
                        const [hh, mm, ss] = timePart.split(':').map(Number);
                        // Build a Date UTC with same Y/M/D H/M/S — treat these components as Jakarta local and store into UTC fields
                        nowUtcDate = new Date(Date.UTC(y, mo - 1, d, hh, mm, ss));
                    }
                }
            } catch (e) { /* ignore */ }

            renderTimeUTC(nowUtcDate);
            setInterval(function () {
                nowUtcDate = new Date(nowUtcDate.getTime() + 1000);
                renderTimeUTC(nowUtcDate);
            }, 1000);
        })();

        // === PERFORMANCE PIE CHART ===
        @if(isset($averagePerformances) && $averagePerformances->isNotEmpty())
            const ctxPerfDash = document.getElementById('performancePieChartDashboard').getContext('2d');
            if (window.ChartDataLabels) Chart.register(ChartDataLabels);
            new Chart(ctxPerfDash, {
                type: 'doughnut',
                data: {
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
                        backgroundColor: ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'],
                        borderWidth: 3,
                        borderColor: '#FFFFFF'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '60%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => `${ctx.label}: ${parseFloat(ctx.raw).toFixed(1)}%`
                            },
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(255,255,255,0.2)',
                            cornerRadius: 8
                        },
                        datalabels: {
                            color: '#FFFFFF',
                            font: { weight: 'bold', size: 12 },
                            formatter: v => `${parseFloat(v).toFixed(1)}%`,
                            anchor: 'end',
                            align: 'start',
                            offset: 10
                        }
                    },
                    animation: {
                        animateRotate: true,
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                },
                plugins: [ChartDataLabels]
            });
        @endif

        // === JOB ORDER BAR CHART ===
        const progressJobOrders = @json($joborders);
        const progressScrollWrapper = document.getElementById('progress-joborder-scroll-wrapper');
        const progressChartWrapper = document.getElementById('progress-joborder-chart-wrapper');
        // If there are many items, compute a taller canvas and allow vertical scrolling
        (function renderProgressChart() {
            const itemCount = Array.isArray(progressJobOrders) ? progressJobOrders.length : (progressJobOrders ? Object.keys(progressJobOrders).length : 0);
            // base row height for each bar (px)
            const rowHeight = 48; // enough for label and padding
            // compute canvas height: clamp min and max to keep reasonable sizes
            const minHeight = 240; // default small screen height
            const maxHeight = Math.max(minHeight, Math.min(2000, itemCount * rowHeight));

            // If more than 10 items, allow vertical scrolling in the wrapper
            if (itemCount > 10) {
                if (progressScrollWrapper) {
                    progressScrollWrapper.style.overflowY = 'auto';
                    progressScrollWrapper.style.maxHeight = (rowHeight * 10) + 'px'; // show 10 rows, scroll the rest
                }
            } else {
                if (progressScrollWrapper) {
                    progressScrollWrapper.style.overflowY = 'hidden';
                    progressScrollWrapper.style.maxHeight = '';
                }
            }

            // Render responsive canvas with computed height
            progressChartWrapper.innerHTML = `<div style="width:100%;"><canvas id="progressJobOrderBarChart" style="width:100%;height:${maxHeight}px"></canvas></div>`;
            const canvas = document.getElementById('progressJobOrderBarChart');
            if (!canvas) return;
            const ctxProgress = canvas.getContext('2d');

            // Destroy previous chart instance if it exists to avoid duplicates
            try { if (window._progressJobOrderChart && window._progressJobOrderChart.destroy) { window._progressJobOrderChart.destroy(); } } catch (e) { }

            window._progressJobOrderChart = new Chart(ctxProgress, {
                type: 'bar',
                data: {
                    labels: progressJobOrders.map(j => j.project ?? '-'),
                    datasets: [
                        {
                            label: 'Progress (%)',
                            data: progressJobOrders.map(j => (typeof j.progress === 'number' ? j.progress : (parseInt(j.progress) || 0))),
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderColor: '#3b82f6',
                            borderRadius: 8,
                            borderWidth: 1,
                            maxBarThickness: 20
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        datalabels: {
                            anchor: 'end',
                            align: 'right',
                            color: '#3b82f6',
                            font: { weight: 'bold', size: 12 },
                            offset: 4,
                            formatter: (v) => `${v}%`
                        }
                    },
                    scales: {
                        x: {
                            min: 0,
                            max: 120,
                            display: false,
                            grid: { display: false }
                        },
                        y: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 11 },
                                align: 'start',
                                padding: 8
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart'
                    }
                },
                plugins: [ChartDataLabels]
            });
        })();

        // === URGENT PROJECTS ===
        const urgentProjects = @json($urgent_projects);
        const urgentScrollWrapper = document.getElementById('urgent-project-scroll-wrapper');
        const urgentChartWrapper = document.getElementById('urgent-project-chart-wrapper');
        urgentChartWrapper.innerHTML = `<canvas id="urgentProjectBarChart" class="w-full h-44 sm:h-56"></canvas>`;
        const ctxUrgent = document.getElementById('urgentProjectBarChart').getContext('2d');
        new Chart(ctxUrgent, {
            type: 'bar',
            data: {
                labels: urgentProjects.map(p => p.project ?? '-'),
                datasets: [
                    {
                        label: 'Jumlah',
                        data: urgentProjects.map(p => (typeof p.total === 'number' ? p.total : (parseInt(p.total) || 1))),
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderColor: '#ef4444',
                        borderRadius: 8,
                        borderWidth: 1,
                        maxBarThickness: 32
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',
                        color: '#ef4444',
                        font: { weight: 'bold', size: 11 },
                        formatter: (v, ctx) => {
                            const p = urgentProjects[ctx.dataIndex];
                            const seksi = p.seksi ?? '-';
                            let tgl = '-';
                            if (p.end) {
                                if (/^\d{2}-\d{2}-\d{4}$/.test(p.end)) {
                                    tgl = p.end;
                                } else if (/^\d{4}-\d{2}-\d{2}$/.test(p.end)) {
                                    const [y, m, d] = p.end.split('-');
                                    tgl = `${d}-${m}-${y}`;
                                } else {
                                    tgl = p.end;
                                }
                            } else {
                                tgl = 'Tidak Ada Tanggal';
                            }
                            return `${seksi} | ${tgl}`;
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        grid: { display: false },
                        min: 0,
                        max: (() => {
                            const vals = urgentProjects.map(p => (typeof p.total === 'number' ? p.total : (parseInt(p.total) || 1)));
                            const maxVal = Math.max(...vals);
                            return Math.ceil(maxVal * 1.2) || 5;
                        })(),
                        ticks: { stepSize: 1, font: { size: 11 } }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            },
            plugins: [ChartDataLabels]
        });

        // Critical materials are rendered server-side as a compact table above.

        // === MATERIAL STOCK SUMMARY (rotate by category every 10s) ===
        const materialsByCategory = @json($materials_by_category ?? []);
        const categoryKeys = Object.keys(materialsByCategory || {});
        if (categoryKeys.length > 0) {
            const container = document.getElementById('material-chart-container-inner');
            container.style.position = 'relative';
            let currentChart = null;
            let currentCategoryIndex = 0;
            const rotateInterval = 10000; // 10s
            let rotateTimer = null;
            let isPaused = false;

            function buildChartInContainer(parent, key, data) {
                parent.innerHTML = '';
                const labels = data.map(m => m.nama || '-');
                if (labels.length === 0) {
                    parent.innerHTML = '<div class="p-4 text-sm text-gray-500">Tidak ada data untuk kategori ini.</div>';
                    return null;
                }
                const sumStock = data.map(m => m.sum_stock || 0);
                const sumMin = data.map(m => m.sum_min || 0);
                const sumReorder = data.map(m => m.sum_reorder || 0);
                const sumMax = data.map(m => m.sum_max || 0);
                const canvasWidth = Math.max(labels.length * 120, window.innerWidth < 640 ? 400 : 800);
                const wrapper = document.createElement('div');
                wrapper.className = 'mat-slide w-full';
                wrapper.style.minWidth = canvasWidth + 'px';
                wrapper.style.transition = 'opacity 450ms ease, transform 450ms ease';
                wrapper.style.position = 'relative';
                wrapper.style.width = '100%';
                wrapper.style.opacity = '0';
                wrapper.innerHTML = `
                    <div class="w-full">
                        <canvas class="w-full h-64 sm:h-80 lg:h-96 materialBarChartCanvas"></canvas>
                    </div>
                `;
                parent.appendChild(wrapper);
                // force reflow
                void wrapper.offsetWidth;
                // initialize chart
                const canvas = wrapper.querySelector('.materialBarChartCanvas');
                const ctx = canvas.getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            { label: 'Stock', data: sumStock, backgroundColor: 'rgba(76, 175, 80, 0.8)', borderColor: '#4caf50', borderRadius: 8, borderWidth: 1 },
                            { label: 'Min', data: sumMin, backgroundColor: 'rgba(255, 152, 0, 0.8)', borderColor: '#ff9800', borderRadius: 8, borderWidth: 1 },
                            { label: 'Reorder', data: sumReorder, backgroundColor: 'rgba(103, 58, 183, 0.8)', borderColor: '#673ab7', borderRadius: 8, borderWidth: 1 },
                            { label: 'Max', data: sumMax, backgroundColor: 'rgba(33, 150, 243, 0.8)', borderColor: '#2196f3', borderRadius: 8, borderWidth: 1 }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: { display: true, text: key, font: { size: 14, weight: '600' } },
                            legend: { position: 'bottom', align: 'start', labels: { font: { size: 12 }, padding: 40, usePointStyle: true, boxWidth: 16 } }
                        },
                        scales: {
                            x: { stacked: false, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { autoSkip: false, maxRotation: 45, minRotation: 0, font: { size: 10 } } },
                            y: { beginAtZero: true, stacked: false, grid: { color: 'rgba(0,0,0,0.1)' }, ticks: { font: { size: 11 } } }
                        },
                        barPercentage: 0.8,
                        categoryPercentage: 0.6,
                        animation: { duration: 600, easing: 'easeOutQuart' }
                    }
                });
                // fade in
                requestAnimationFrame(() => { wrapper.style.opacity = '1'; });
                return { wrapper, chart };
            }

            function showCategory(idx, direction) {
                const key = categoryKeys[idx];
                const data = materialsByCategory[key] || [];
                // prepare new slide
                const result = buildChartInContainer(container, key, data);
                if (!result) return;
                // animate out previous
                const previous = container.querySelectorAll('.mat-slide');
                if (previous.length > 1) {
                    // the first is the older one, the last is the new; fade out the first
                    const old = previous[0];
                    old.style.opacity = '0';
                    // destroy any chart instance attached (we don't keep refs for old ones)
                    setTimeout(() => { try { old.remove(); } catch (e) { } }, 500);
                }
                // set currentChart for destruction when next changes
                if (currentChart && currentChart.destroy) { try { currentChart.destroy(); } catch (e) { } }
                currentChart = result.chart;
            }

            function startRotation() { if (rotateTimer) clearInterval(rotateTimer); rotateTimer = setInterval(() => { currentCategoryIndex = (currentCategoryIndex + 1) % categoryKeys.length; showCategory(currentCategoryIndex, 1); }, rotateInterval); }
            function stopRotation() { if (rotateTimer) { clearInterval(rotateTimer); rotateTimer = null; } }

            // initial
            showCategory(currentCategoryIndex, 0);
            startRotation();

            // controls
            const prevBtn = document.getElementById('mat-prev-btn');
            const nextBtn = document.getElementById('mat-next-btn');
            const playBtn = document.getElementById('mat-play-btn');

            if (prevBtn) {
                prevBtn.addEventListener('click', function () {
                    currentCategoryIndex = (currentCategoryIndex - 1 + categoryKeys.length) % categoryKeys.length;
                    showCategory(currentCategoryIndex, -1);
                    // restart rotation timer so next auto-change comes after full interval
                    if (!isPaused) { stopRotation(); startRotation(); }
                });
            }
            if (nextBtn) {
                nextBtn.addEventListener('click', function () {
                    currentCategoryIndex = (currentCategoryIndex + 1) % categoryKeys.length;
                    showCategory(currentCategoryIndex, 1);
                    if (!isPaused) { stopRotation(); startRotation(); }
                });
            }
            if (playBtn) {
                playBtn.addEventListener('click', function () {
                    if (isPaused) {
                        isPaused = false; playBtn.textContent = 'Pause'; startRotation();
                    } else {
                        isPaused = true; playBtn.textContent = 'Play'; stopRotation();
                    }
                });
            }
        } else {
            const container = document.getElementById('material-chart-container-inner');
            if (container) container.innerHTML = '<div class="p-4 text-sm text-gray-500">Tidak ada data material.</div>';
        }
    </script>
@endsection