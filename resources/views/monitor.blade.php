<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor - Sistem Workshop</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-start justify-center font-sans">
    <main class="w-full min-h-screen py-3 px-2 sm:py-4 sm:px-3 md:py-6 md:px-4 lg:px-6 xl:px-8">
        <div class="max-w-[1920px] mx-auto space-y-3 sm:space-y-4 md:space-y-5 lg:space-y-6">
            <!-- Live Clock (center top) -->
            <div class="flex justify-center">
                <div id="live-clock-card"
                    class="bg-red-600 rounded-xl sm:rounded-2xl shadow-lg border border-red-200/50 px-2 py-1.5 sm:px-3 sm:py-2 md:px-4 md:py-3 mb-1 sm:mb-2 w-full max-w-[280px] sm:max-w-sm md:max-w-md backdrop-blur-sm">
                    <div class="flex items-center w-full text-white">
                        <div class="w-1/4 text-[10px] sm:text-xs font-semibold opacity-90 hidden md:block">Waktu Server
                        </div>
                        <div class="flex-1 md:w-1/2 text-center">
                            <div id="live-time" class="text-sm sm:text-base md:text-lg font-bold tracking-wide"></div>
                        </div>
                        <div class="flex-1 md:w-1/4 text-right">
                            <div id="live-date" class="text-[10px] sm:text-xs md:text-sm opacity-90"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts grid (Performance, Job Order Progress) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 sm:gap-4 md:gap-5 lg:gap-6">
                <div
                    class="md:col-span-5 lg:col-span-4 bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl border border-indigo-200/50 p-3 sm:p-4 md:p-5 lg:p-6">
                    <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-indigo-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                            </svg>
                        </div>
                        <h3 class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-900 leading-tight">
                            Rata-rata Performance Karyawan</h3>
                    </div>
                    <div class="flex-1 flex justify-center items-center h-40 sm:h-48 md:h-56 lg:h-64">
                        <canvas id="performancePieChartDashboard"
                            class="w-full h-full max-w-[200px] sm:max-w-[240px] md:max-w-xs lg:max-w-sm mx-auto"></canvas>
                    </div>
                    <div
                        class="mt-3 sm:mt-4 md:mt-5 lg:mt-6 space-y-1.5 sm:space-y-2 md:space-y-3 max-h-28 sm:max-h-32 md:max-h-36 lg:max-h-40 overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-indigo-300/50 scrollbar-track-transparent">
                        @php $legendColors = ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16']; @endphp
                        @if(isset($averagePerformances) && $averagePerformances->isNotEmpty())
                            @foreach($averagePerformances as $i => $performance)
                                <div
                                    class="flex items-center gap-1.5 sm:gap-2 md:gap-3 p-1.5 sm:p-2 md:p-3 bg-gradient-to-r from-gray-50 to-indigo-50 rounded-lg sm:rounded-xl">
                                    <span
                                        class="inline-block w-2.5 h-2 sm:w-3 sm:h-2.5 md:w-4 md:h-3 rounded-full shadow-sm flex-shrink-0"
                                        style="background-color: {{ $legendColors[$i % count($legendColors)] }}"></span>
                                    <span
                                        class="text-gray-700 font-semibold text-[10px] sm:text-xs md:text-sm flex-1 truncate">{{ $performance->manpower->nama }}</span>
                                    <span
                                        class="text-indigo-600 font-bold text-[10px] sm:text-xs md:text-sm flex-shrink-0">{{ number_format($performance->average_score, 1) }}%</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-3 sm:py-4 md:py-6 text-gray-400 text-xs sm:text-sm">Data performance
                                tidak tersedia
                            </div>
                        @endif
                    </div>
                </div>

                <div
                    class="md:col-span-7 lg:col-span-8 bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl border border-blue-200/50 p-3 sm:p-4 md:p-5 lg:p-6">
                    <div class="flex items-center justify-between mb-3 sm:mb-4 md:mb-5">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-blue-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <h3 class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-900">Progress Job
                                Order</h3>
                        </div>
                        <span
                            class="text-[10px] sm:text-xs md:text-sm text-gray-500 font-medium">{{ now()->format('d M Y') }}</span>
                    </div>
                    <div
                        class="h-52 sm:h-64 md:h-72 lg:h-80 xl:h-96 overflow-hidden rounded-lg sm:rounded-xl border border-gray-200/50">
                        <div id="progress-joborder-scroll-wrapper"
                            class="w-full h-full overflow-y-auto overflow-x-auto scrollbar-thin scrollbar-thumb-blue-300/50 scrollbar-track-transparent">
                            <div id="progress-joborder-chart-wrapper" class="w-full min-h-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Order Monthly + Urgent Projects -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 md:gap-5 lg:gap-6">
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl border border-green-200/50 p-2.5 sm:p-3 md:p-4">
                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-3 mb-2 sm:mb-3">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xs sm:text-sm md:text-base font-bold text-gray-900">Job Order Perbulan</h3>
                        </div>
                        <form id="filterJobOrderMonth" class="flex items-center gap-1 sm:gap-2" method="GET"
                            action="{{ route('monitor') }}">
                            <select name="bulan"
                                class="w-20 sm:w-24 md:w-28 border border-gray-300/50 bg-white/80 rounded-lg sm:rounded-xl px-1.5 sm:px-2 py-1 text-[10px] sm:text-xs">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" @if($m == request('bulan', now()->month)) selected @endif>
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="tahun"
                                class="w-14 sm:w-16 md:w-20 border border-gray-300/50 bg-white/80 rounded-lg sm:rounded-xl px-1.5 sm:px-2 py-1 text-[10px] sm:text-xs">
                                @foreach(range(now()->year - 5, now()->year + 1) as $y)
                                    <option value="{{ $y }}" @if($y == request('tahun', now()->year)) selected @endif>{{ $y }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-2 sm:px-3 py-1 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-semibold whitespace-nowrap">Filter</button>
                        </form>
                    </div>

                    @php $jobMonthlyScrollable = isset($joborders_monthly) && count($joborders_monthly) > 6; @endphp
                    <div
                        class="overflow-x-auto rounded-lg sm:rounded-xl border border-gray-200/50 {{ $jobMonthlyScrollable ? 'max-h-44 sm:max-h-52 md:max-h-56 overflow-y-auto' : '' }}">
                        <table class="w-full text-[10px] sm:text-xs">
                            <thead class="bg-gradient-to-r from-gray-50 to-green-50 sticky top-0">
                                <tr>
                                    <th class="px-2 sm:px-3 py-1.5 sm:py-2 text-left font-semibold text-gray-700">
                                        Tanggal</th>
                                    <th class="px-2 sm:px-3 py-1.5 sm:py-2 text-left font-semibold text-gray-700">Proyek
                                    </th>
                                    <th class="px-2 sm:px-3 py-1.5 sm:py-2 text-left font-semibold text-gray-700">
                                        Evaluasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200/50">
                                @forelse($joborders_monthly as $jo)
                                    @php
                                        $startFormatted = $jo->start ? \Carbon\Carbon::parse($jo->start)->format('d M') : '-';
                                        $endFormatted = $jo->end ? \Carbon\Carbon::parse($jo->end)->format('d M Y') : '-';
                                        $dateRange = ($startFormatted !== '-' && $endFormatted !== '-') ? $startFormatted . ' - ' . $endFormatted : ($startFormatted !== '-' ? $startFormatted : $endFormatted);
                                    @endphp
                                    <tr class="hover:bg-green-50/50 transition-all duration-200">
                                        <td
                                            class="px-2 sm:px-3 py-1.5 sm:py-2 font-semibold text-blue-700 whitespace-nowrap">
                                            {{ $dateRange }}
                                        </td>
                                        <td
                                            class="px-2 sm:px-3 py-1.5 sm:py-2 text-gray-700 max-w-[100px] sm:max-w-[150px] md:max-w-xs truncate">
                                            {{ $jo->project }}
                                        </td>
                                        <td class="px-2 sm:px-3 py-1.5 sm:py-2 text-gray-700">{{ $jo->evaluasi ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 sm:py-6 text-gray-500 text-xs">Tidak ada job
                                            order bulan ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div
                    class="bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl border border-red-200/50 p-2.5 sm:p-3 md:p-4">
                    <div class="flex items-center gap-2 mb-2 sm:mb-3">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 bg-gradient-to-br from-red-100 to-rose-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xs sm:text-sm md:text-base font-bold text-gray-900">Proyek Urgent</h3>
                    </div>
                    <div
                        class="h-36 sm:h-44 md:h-52 lg:h-56 overflow-hidden rounded-lg sm:rounded-xl border border-gray-200/50">
                        <div id="urgent-project-scroll-wrapper"
                            class="w-full h-full overflow-y-auto overflow-x-hidden scrollbar-thin scrollbar-thumb-red-300/50 scrollbar-track-transparent">
                            <div id="urgent-project-chart-wrapper" class="w-full min-h-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Material Cards -->
            <div
                class="bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl border border-orange-200/50 p-3 sm:p-4 md:p-5 lg:p-6">
                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4 md:mb-5">
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-100 to-amber-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-orange-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-900">Material Kritis
                        (Stock &lt; Reorder)</h3>
                </div>
                <div
                    class="h-48 sm:h-56 md:h-64 lg:h-72 xl:h-80 overflow-hidden rounded-lg sm:rounded-xl border border-gray-200/50">
                    <div id="critical-material-scroll-wrapper"
                        class="w-full h-full overflow-y-auto overflow-x-auto scrollbar-thin scrollbar-thumb-orange-300/50 scrollbar-track-transparent">
                        <div class="w-full p-1.5 sm:p-2">
                            <table class="w-full text-[10px] sm:text-xs">
                                <thead class="bg-gradient-to-r from-gray-50 to-orange-50 sticky top-0">
                                    <tr>
                                        <th class="px-2 sm:px-3 py-1.5 sm:py-2 text-left font-semibold text-gray-700">
                                            Nama Material</th>
                                        <th class="px-2 sm:px-3 py-1.5 sm:py-2 text-right font-semibold text-gray-700">
                                            Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200/50">
                                    @forelse($critical_materials as $m)
                                        @php
                                            $name = is_array($m) ? ($m['nama'] ?? '') : ($m['nama'] ?? '');
                                            $stock = is_array($m) ? ($m['stock'] ?? 0) : ($m['stock'] ?? 0);
                                        @endphp
                                        <tr class="hover:bg-orange-50/50 transition-all duration-200">
                                            <td
                                                class="px-2 sm:px-3 py-1.5 sm:py-2 text-gray-700 truncate max-w-[150px] sm:max-w-xs">
                                                {{ $name }}
                                            </td>
                                            <td class="px-2 sm:px-3 py-1.5 sm:py-2 text-right font-semibold text-gray-700">
                                                {{ number_format($stock) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-4 sm:py-6 text-gray-500 text-xs">Tidak ada
                                                material kritis.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Material Stock Summary -->
            <div
                class="bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl border border-purple-200/50 p-3 sm:p-4 md:p-5 lg:p-6">
                <div class="flex items-center justify-between gap-2 sm:gap-3 md:gap-4 mb-2 sm:mb-3">
                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-br from-purple-100 to-violet-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-purple-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3
                            class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-900 leading-tight text-left">
                            Material Stock Summary</h3>
                    </div>
                    <div class="flex items-center gap-1 sm:gap-2">
                        <button id="mat-prev-btn" type="button"
                            class="text-[10px] sm:text-xs px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-lg sm:rounded-xl bg-gray-100 hover:bg-gray-200 border border-gray-200 flex-shrink-0 transition-colors">
                            <span class="hidden md:inline">Prev</span>
                            <svg class="md:hidden w-3 h-3 sm:w-4 sm:h-4 inline" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>

                        <button id="mat-play-btn" type="button"
                            class="text-[10px] sm:text-xs px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-lg sm:rounded-xl bg-gray-100 hover:bg-gray-200 border border-gray-200 flex-shrink-0 transition-colors"
                            aria-pressed="true">
                            <span class="hidden md:inline mat-play-text">Pause</span>
                            <svg class="md:hidden w-3 h-3 sm:w-4 sm:h-4 inline" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <g class="icon-pause">
                                    <rect x="6" y="5" width="4" height="14" rx="1"></rect>
                                    <rect x="14" y="5" width="4" height="14" rx="1"></rect>
                                </g>
                                <g class="icon-play" style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v18l15-9L5 3z">
                                    </path>
                                </g>
                            </svg>
                        </button>

                        <button id="mat-next-btn" type="button"
                            class="text-[10px] sm:text-xs px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-lg sm:rounded-xl bg-gray-100 hover:bg-gray-200 border border-gray-200 flex-shrink-0 transition-colors">
                            <span class="hidden md:inline">Next</span>
                            <svg class="md:hidden w-3 h-3 sm:w-4 sm:h-4 inline" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto rounded-lg sm:rounded-xl border border-gray-200/50">
                    <div id="material-chart-container-inner" class="w-full"></div>
                </div>
            </div>
        </div>
    </main>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <script>
        // Live clock (similar to admin dashboard)
        (function () {
            var initialServer = '{{ now()->setTimezone("Asia/Jakarta")->toDateTimeString() }}';
            var liveDateEl = document.getElementById('live-date');
            var liveTimeEl = document.getElementById('live-time');
            function pad(n) { return n < 10 ? '0' + n : n; }
            function renderTimeUTC(dt) {
                var d = dt.getUTCDate();
                var m = dt.getUTCMonth() + 1;
                var y = dt.getUTCFullYear();
                var hh = pad(dt.getUTCHours());
                var mm = pad(dt.getUTCMinutes());
                var ss = pad(dt.getUTCSeconds());
                if (liveDateEl) liveDateEl.textContent = pad(d) + '-' + pad(m) + '-' + y;
                if (liveTimeEl) liveTimeEl.textContent = hh + ':' + mm + ':' + ss;
            }
            var nowUtcDate = new Date();
            try {
                if (initialServer) {
                    var parts = initialServer.split(' ');
                    if (parts.length === 2) {
                        var datePart = parts[0];
                        var timePart = parts[1];
                        var dateParts = datePart.split('-');
                        var timeParts = timePart.split(':');
                        var y = parseInt(dateParts[0]);
                        var mo = parseInt(dateParts[1]);
                        var d = parseInt(dateParts[2]);
                        var hh = parseInt(timeParts[0]);
                        var mm = parseInt(timeParts[1]);
                        var ss = parseInt(timeParts[2]);
                        nowUtcDate = new Date(Date.UTC(y, mo - 1, d, hh, mm, ss));
                    }
                }
            } catch (e) { }
            renderTimeUTC(nowUtcDate);
            setInterval(function () { nowUtcDate = new Date(nowUtcDate.getTime() + 1000); renderTimeUTC(nowUtcDate); }, 1000);
        })();

        // Register ChartDataLabels plugin globally
        if (window.ChartDataLabels) {
            Chart.register(ChartDataLabels);
        }

        // === PERFORMANCE PIE CHART ===
        const perfData = @json(isset($averagePerformances) && $averagePerformances->isNotEmpty() ? $averagePerformances->map(function ($p) {
            return ['name' => $p->manpower->nama ?? '-', 'score' => (float) $p->average_score];
        })->values()->toArray() : []);

        // Helper function for responsive font sizes
        function getResponsiveFontSize(base, min, max) {
            var width = window.innerWidth;
            if (width < 480) return min;
            if (width < 768) return Math.round((min + base) / 2);
            if (width < 1024) return base;
            return max || base;
        }

        if (perfData.length > 0) {
            const ctxPerfDash = document.getElementById('performancePieChartDashboard').getContext('2d');
            new Chart(ctxPerfDash, {
                type: 'doughnut',
                data: {
                    labels: perfData.map(function (p) { return p.name; }),
                    datasets: [{
                        data: perfData.map(function (p) { return p.score; }),
                        backgroundColor: ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'],
                        borderWidth: window.innerWidth < 640 ? 2 : 3,
                        borderColor: '#FFFFFF'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: window.innerWidth < 640 ? '55%' : '60%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) { return ctx.label + ': ' + parseFloat(ctx.raw).toFixed(1) + '%'; }
                            },
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(255,255,255,0.2)',
                            cornerRadius: 8,
                            titleFont: { size: getResponsiveFontSize(12, 10, 14) },
                            bodyFont: { size: getResponsiveFontSize(11, 9, 13) }
                        },
                        datalabels: {
                            color: '#FFFFFF',
                            font: { weight: 'bold', size: getResponsiveFontSize(11, 8, 12) },
                            formatter: function (v) { return parseFloat(v).toFixed(1) + '%'; },
                            anchor: 'end',
                            align: 'start',
                            offset: window.innerWidth < 640 ? 5 : 10,
                            display: function (ctx) { return ctx.dataset.data[ctx.dataIndex] > 5; }
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
        }

        // === JOB ORDER BAR CHART ===
        const progressJobOrders = @json($joborders ?? []);
        const progressScrollWrapper = document.getElementById('progress-joborder-scroll-wrapper');
        const progressChartWrapper = document.getElementById('progress-joborder-chart-wrapper');
        (function renderProgressChart() {
            const itemCount = Array.isArray(progressJobOrders) ? progressJobOrders.length : (progressJobOrders ? Object.keys(progressJobOrders).length : 0);
            var rowHeight = window.innerWidth < 640 ? 36 : (window.innerWidth < 768 ? 40 : 48);
            const minHeight = window.innerWidth < 640 ? 180 : 240;
            const maxHeight = Math.max(minHeight, Math.min(2000, itemCount * rowHeight));
            var maxVisibleItems = window.innerWidth < 640 ? 6 : (window.innerWidth < 768 ? 8 : 10);
            if (itemCount > maxVisibleItems) {
                if (progressScrollWrapper) {
                    progressScrollWrapper.style.overflowY = 'auto';
                    progressScrollWrapper.style.maxHeight = (rowHeight * maxVisibleItems) + 'px';
                }
            } else {
                if (progressScrollWrapper) {
                    progressScrollWrapper.style.overflowY = 'hidden';
                    progressScrollWrapper.style.maxHeight = '';
                }
            }
            progressChartWrapper.innerHTML = '<div style="width:100%;"><canvas id="progressJobOrderBarChart" style="width:100%;height:' + maxHeight + 'px"></canvas></div>';
            const canvas = document.getElementById('progressJobOrderBarChart');
            if (!canvas) return;
            const ctxProgress = canvas.getContext('2d');
            try { if (window._progressJobOrderChart && window._progressJobOrderChart.destroy) { window._progressJobOrderChart.destroy(); } } catch (e) { }
            var labelFontSize = getResponsiveFontSize(11, 9, 12);
            var dataLabelSize = getResponsiveFontSize(11, 9, 12);
            window._progressJobOrderChart = new Chart(ctxProgress, {
                type: 'bar',
                data: {
                    labels: progressJobOrders.map(function (j) { return j.project || '-'; }),
                    datasets: [{
                        label: 'Progress (%)',
                        data: progressJobOrders.map(function (j) { return (typeof j.progress === 'number' ? j.progress : (parseInt(j.progress) || 0)); }),
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: '#3b82f6',
                        borderRadius: window.innerWidth < 640 ? 4 : 8,
                        borderWidth: 1,
                        maxBarThickness: window.innerWidth < 640 ? 14 : 20
                    }]
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
                            font: { weight: 'bold', size: dataLabelSize },
                            offset: 4,
                            formatter: function (v) { return v + '%'; }
                        }
                    },
                    scales: {
                        x: { min: 0, max: 120, display: false, grid: { display: false } },
                        y: {
                            grid: { display: false },
                            ticks: {
                                font: { size: labelFontSize },
                                align: 'start',
                                padding: window.innerWidth < 640 ? 4 : 8,
                                callback: function (value, index) {
                                    var label = this.getLabelForValue(value);
                                    var maxLen = window.innerWidth < 640 ? 15 : (window.innerWidth < 768 ? 20 : 30);
                                    if (label && label.length > maxLen) {
                                        return label.substring(0, maxLen) + '...';
                                    }
                                    return label;
                                }
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
        const urgentProjects = @json($urgent_projects ?? []);
        const urgentChartWrapper = document.getElementById('urgent-project-chart-wrapper');
        if (urgentChartWrapper) {
            var urgentHeight = window.innerWidth < 640 ? 'h-36' : (window.innerWidth < 768 ? 'h-44' : 'h-52');
            urgentChartWrapper.innerHTML = '<canvas id="urgentProjectBarChart" class="w-full ' + urgentHeight + '"></canvas>';
            const ctxUrgent = document.getElementById('urgentProjectBarChart').getContext('2d');
            var urgentLabelSize = getResponsiveFontSize(11, 9, 12);
            var urgentDataLabelSize = getResponsiveFontSize(10, 8, 11);
            new Chart(ctxUrgent, {
                type: 'bar',
                data: {
                    labels: urgentProjects.map(function (p) { return p.project || '-'; }),
                    datasets: [{
                        label: 'Jumlah',
                        data: urgentProjects.map(function (p) { return (typeof p.total === 'number' ? p.total : (parseInt(p.total) || 1)); }),
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderColor: '#ef4444',
                        borderRadius: window.innerWidth < 640 ? 4 : 8,
                        borderWidth: 1,
                        maxBarThickness: window.innerWidth < 640 ? 20 : 32
                    }]
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
                            font: { weight: 'bold', size: urgentDataLabelSize },
                            formatter: function (v, ctx) {
                                var p = urgentProjects[ctx.dataIndex];
                                var seksi = p.seksi || '-';
                                var tgl = '-';
                                if (p.end) {
                                    if (/^\d{2}-\d{2}-\d{4}$/.test(p.end)) {
                                        tgl = p.end;
                                    } else if (/^\d{4}-\d{2}-\d{2}$/.test(p.end)) {
                                        var parts = p.end.split('-');
                                        tgl = parts[2] + '-' + parts[1] + '-' + parts[0];
                                    } else {
                                        tgl = p.end;
                                    }
                                } else {
                                    tgl = 'N/A';
                                }
                                if (window.innerWidth < 640) {
                                    return tgl;
                                }
                                return seksi + ' | ' + tgl;
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: { display: false },
                            min: 0,
                            max: (function () {
                                var vals = urgentProjects.map(function (p) { return (typeof p.total === 'number' ? p.total : (parseInt(p.total) || 1)); });
                                var maxVal = Math.max.apply(null, vals.length ? vals : [0]);
                                return Math.ceil(maxVal * 1.2) || 5;
                            })(),
                            ticks: { stepSize: 1, font: { size: urgentLabelSize } }
                        },
                        y: {
                            grid: { display: false },
                            ticks: {
                                font: { size: urgentLabelSize },
                                callback: function (value, index) {
                                    var label = this.getLabelForValue(value);
                                    var maxLen = window.innerWidth < 640 ? 12 : (window.innerWidth < 768 ? 18 : 25);
                                    if (label && label.length > maxLen) {
                                        return label.substring(0, maxLen) + '...';
                                    }
                                    return label;
                                }
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
        }

        // === MATERIAL STOCK SUMMARY (rotate categories) ===
        const materialsByCategory = @json($materials_by_category ?? []);
        const categoryKeys = Object.keys(materialsByCategory || {});
        if (categoryKeys.length > 0) {
            const container = document.getElementById('material-chart-container-inner');
            container.style.position = 'relative';
            var currentChart = null;
            var currentCategoryIndex = 0;
            const rotateInterval = 10000;
            var rotateTimer = null;
            var isPaused = false;

            function buildChartInContainer(parent, key, data) {
                parent.innerHTML = '';
                const labels = data.map(function (m) { return m.nama || '-'; });
                if (labels.length === 0) {
                    parent.innerHTML = '<div class="p-3 sm:p-4 text-xs sm:text-sm text-gray-500">Tidak ada data untuk kategori ini.</div>';
                    return null;
                }
                const sumStock = data.map(function (m) { return m.sum_stock || 0; });
                const sumMin = data.map(function (m) { return m.sum_min || 0; });
                const sumReorder = data.map(function (m) { return m.sum_reorder || 0; });
                const sumMax = data.map(function (m) { return m.sum_max || 0; });
                var minCanvasWidth = window.innerWidth < 480 ? 320 : (window.innerWidth < 640 ? 400 : (window.innerWidth < 768 ? 600 : 800));
                var perItemWidth = window.innerWidth < 640 ? 80 : 120;
                const canvasWidth = Math.max(labels.length * perItemWidth, minCanvasWidth);
                const wrapper = document.createElement('div');
                wrapper.className = 'mat-slide w-full';
                wrapper.style.minWidth = canvasWidth + 'px';
                wrapper.style.transition = 'opacity 450ms ease, transform 450ms ease';
                wrapper.style.position = 'relative';
                wrapper.style.width = '100%';
                wrapper.style.opacity = '0';
                var chartHeight = window.innerWidth < 480 ? 'h-48' : (window.innerWidth < 640 ? 'h-56' : (window.innerWidth < 768 ? 'h-64' : (window.innerWidth < 1024 ? 'h-72' : 'h-80')));
                wrapper.innerHTML = '<div class="w-full"><canvas class="w-full ' + chartHeight + ' materialBarChartCanvas"></canvas></div>';
                parent.appendChild(wrapper);
                void wrapper.offsetWidth;
                const canvas = wrapper.querySelector('.materialBarChartCanvas');
                const ctx = canvas.getContext('2d');
                var titleSize = getResponsiveFontSize(14, 11, 16);
                var legendSize = getResponsiveFontSize(11, 9, 12);
                var tickSize = getResponsiveFontSize(10, 8, 11);
                var legendPadding = window.innerWidth < 640 ? 15 : (window.innerWidth < 768 ? 25 : 40);
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            { label: 'Stock', data: sumStock, backgroundColor: 'rgba(76,175,80,0.8)', borderColor: '#4caf50', borderRadius: window.innerWidth < 640 ? 4 : 8, borderWidth: 1 },
                            { label: 'Min', data: sumMin, backgroundColor: 'rgba(255,152,0,0.8)', borderColor: '#ff9800', borderRadius: window.innerWidth < 640 ? 4 : 8, borderWidth: 1 },
                            { label: 'Reorder', data: sumReorder, backgroundColor: 'rgba(103,58,183,0.8)', borderColor: '#673ab7', borderRadius: window.innerWidth < 640 ? 4 : 8, borderWidth: 1 },
                            { label: 'Max', data: sumMax, backgroundColor: 'rgba(33,150,243,0.8)', borderColor: '#2196f3', borderRadius: window.innerWidth < 640 ? 4 : 8, borderWidth: 1 }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: { display: true, text: key, font: { size: titleSize, weight: '600' }, padding: { bottom: window.innerWidth < 640 ? 8 : 12 } },
                            legend: {
                                position: 'bottom',
                                align: window.innerWidth < 640 ? 'center' : 'start',
                                labels: {
                                    font: { size: legendSize },
                                    padding: legendPadding,
                                    usePointStyle: true,
                                    boxWidth: window.innerWidth < 640 ? 10 : 16
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: false,
                                grid: { color: 'rgba(0,0,0,0.05)' },
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: window.innerWidth < 640 ? 60 : 45,
                                    minRotation: 0,
                                    font: { size: tickSize },
                                    callback: function (value, index) {
                                        var label = this.getLabelForValue(value);
                                        var maxLen = window.innerWidth < 480 ? 8 : (window.innerWidth < 640 ? 10 : (window.innerWidth < 768 ? 12 : 15));
                                        if (label && label.length > maxLen) {
                                            return label.substring(0, maxLen) + '...';
                                        }
                                        return label;
                                    }
                                }
                            },
                            y: { beginAtZero: true, stacked: false, grid: { color: 'rgba(0,0,0,0.1)' }, ticks: { font: { size: tickSize } } }
                        },
                        barPercentage: window.innerWidth < 640 ? 0.9 : 0.8,
                        categoryPercentage: window.innerWidth < 640 ? 0.7 : 0.6,
                        animation: { duration: 600, easing: 'easeOutQuart' }
                    }
                });
                requestAnimationFrame(function () { wrapper.style.opacity = '1'; });
                return { wrapper: wrapper, chart: chart };
            }

            function showCategory(idx) {
                const key = categoryKeys[idx];
                const data = materialsByCategory[key] || [];
                const result = buildChartInContainer(container, key, data);
                if (!result) return;
                const previous = container.querySelectorAll('.mat-slide');
                if (previous.length > 1) {
                    const old = previous[0];
                    old.style.opacity = '0';
                    setTimeout(function () { try { old.remove(); } catch (e) { } }, 500);
                }
                if (currentChart && currentChart.destroy) { try { currentChart.destroy(); } catch (e) { } }
                currentChart = result.chart;
            }

            function startRotation() {
                if (rotateTimer) clearInterval(rotateTimer);
                rotateTimer = setInterval(function () {
                    currentCategoryIndex = (currentCategoryIndex + 1) % categoryKeys.length;
                    showCategory(currentCategoryIndex);
                }, rotateInterval);
            }

            function stopRotation() {
                if (rotateTimer) { clearInterval(rotateTimer); rotateTimer = null; }
            }

            showCategory(currentCategoryIndex);
            startRotation();

            const prevBtn = document.getElementById('mat-prev-btn');
            const nextBtn = document.getElementById('mat-next-btn');
            const playBtn = document.getElementById('mat-play-btn');

            function updatePlayButtonState() {
                if (!playBtn) return;
                var textEl = playBtn.querySelector('.mat-play-text');
                var iconPause = playBtn.querySelector('.icon-pause');
                var iconPlay = playBtn.querySelector('.icon-play');

                if (isPaused) {
                    if (textEl) textEl.textContent = 'Play';
                    if (iconPause) iconPause.style.display = 'none';
                    if (iconPlay) iconPlay.style.display = 'block';
                } else {
                    if (textEl) textEl.textContent = 'Pause';
                    if (iconPause) iconPause.style.display = 'block';
                    if (iconPlay) iconPlay.style.display = 'none';
                }
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function () {
                    currentCategoryIndex = (currentCategoryIndex - 1 + categoryKeys.length) % categoryKeys.length;
                    showCategory(currentCategoryIndex);
                    if (!isPaused) { stopRotation(); startRotation(); }
                });
            }
            if (nextBtn) {
                nextBtn.addEventListener('click', function () {
                    currentCategoryIndex = (currentCategoryIndex + 1) % categoryKeys.length;
                    showCategory(currentCategoryIndex);
                    if (!isPaused) { stopRotation(); startRotation(); }
                });
            }
            if (playBtn) {
                playBtn.addEventListener('click', function () {
                    if (isPaused) {
                        isPaused = false;
                        startRotation();
                    } else {
                        isPaused = true;
                        stopRotation();
                    }
                    updatePlayButtonState();
                });
            }
        } else {
            const container = document.getElementById('material-chart-container-inner');
            if (container) container.innerHTML = '<div class="p-3 sm:p-4 text-xs sm:text-sm text-gray-500">Tidak ada data material.</div>';
        }

        // === RESPONSIVE RESIZE HANDLER ===
        var resizeTimeout;
        var lastWidth = window.innerWidth;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function () {
                var newWidth = window.innerWidth;
                // Only re-render if significant width change (crossing breakpoints)
                var crossedBreakpoint = (
                    (lastWidth < 480 && newWidth >= 480) || (lastWidth >= 480 && newWidth < 480) ||
                    (lastWidth < 640 && newWidth >= 640) || (lastWidth >= 640 && newWidth < 640) ||
                    (lastWidth < 768 && newWidth >= 768) || (lastWidth >= 768 && newWidth < 768) ||
                    (lastWidth < 1024 && newWidth >= 1024) || (lastWidth >= 1024 && newWidth < 1024)
                );

                if (crossedBreakpoint) {
                    lastWidth = newWidth;
                    // Refresh Progress Job Order chart
                    if (typeof renderProgressChart === 'function') {
                        renderProgressChart();
                    }
                    // Refresh Material Stock Summary chart
                    if (typeof showCategory === 'function' && typeof currentCategoryIndex !== 'undefined') {
                        showCategory(currentCategoryIndex);
                    }
                }
            }, 250);
        });
    </script>

    <style>
        /* Custom responsive styles for charts */
        @media (max-width: 480px) {
            .scrollbar-thin::-webkit-scrollbar {
                width: 4px;
                height: 4px;
            }
        }

        @media (min-width: 481px) and (max-width: 767px) {
            .scrollbar-thin::-webkit-scrollbar {
                width: 5px;
                height: 5px;
            }
        }

        @media (min-width: 768px) {
            .scrollbar-thin::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            border-radius: 10px;
        }

        /* Smooth transitions for responsive changes */
        .bg-white\/80 {
            transition: padding 0.2s ease;
        }

        /* Better touch targets on mobile */
        @media (max-width: 640px) {
            button {
                min-height: 32px;
                min-width: 32px;
            }
        }

        /* Prevent horizontal overflow */
        main {
            overflow-x: hidden;
        }

        /* Chart container responsive overflow */
        #progress-joborder-scroll-wrapper,
        #urgent-project-scroll-wrapper,
        #critical-material-scroll-wrapper,
        #material-chart-container-inner {
            -webkit-overflow-scrolling: touch;
        }
    </style>
</body>

</html>