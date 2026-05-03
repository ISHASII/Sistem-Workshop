@extends('layouts.management-epp')

@section('title', 'Dashboard Management EPP')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[2rem] overflow-hidden bg-white shadow-xl border border-orange-100">
            <div class="p-8 sm:p-10 bg-gradient-to-br from-orange-600 via-red-600 to-rose-600 text-white">
                <p class="text-sm uppercase tracking-[0.3em] text-orange-100">Management EPP</p>
                <h1 class="mt-3 text-3xl sm:text-4xl font-black">Welcome, {{ $user->name ?? $user->username }}</h1>
                <p class="mt-3 max-w-2xl text-orange-50">Ini adalah halaman khusus Management EPP. Gunakan navbar untuk membuka dashboard atau me-review approval dari seluruh departement.</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="rounded-[2rem] bg-white shadow-xl border border-slate-200 p-6 sm:p-8">
                <h2 class="text-xl font-bold text-slate-900">Ringkasan Request</h2>
                <div class="mt-5 grid grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-orange-50 border border-orange-100 p-4">
                        <div class="text-sm font-semibold text-orange-700">Total</div>
                        <div class="mt-2 text-3xl font-black text-slate-900">{{ $pendingEppCount + $approvedEppCount }}</div>
                    </div>
                    <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4">
                        <div class="text-sm font-semibold text-amber-700">Pending EPP</div>
                        <div class="mt-2 text-3xl font-black text-slate-900">{{ $pendingEppCount }}</div>
                    </div>
                    <div class="rounded-2xl bg-green-50 border border-green-100 p-4">
                        <div class="text-sm font-semibold text-green-700">Approved EPP</div>
                        <div class="mt-2 text-3xl font-black text-slate-900">{{ $approvedEppCount }}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] bg-slate-950 text-white shadow-xl p-6 sm:p-8">
                <p class="text-sm uppercase tracking-[0.25em] text-orange-100">Quick Access</p>
                <h3 class="mt-2 text-2xl font-black">Buka Request Approval</h3>
                <p class="mt-3 text-slate-300">Lihat request pending dari seluruh departement dan lakukan approve.</p>
                <a href="{{ route('management-epp.requests.index') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white text-slate-900 font-semibold hover:bg-orange-50 transition-colors">
                    Ke Halaman Request
                </a>
            </div>
        </div>

        <!-- NEW CHARTS SECTION WITH DEPARTMENT FILTER -->
        <div class="mt-8 flex items-center justify-between flex-wrap gap-4">
            <h2 class="text-xl font-bold text-slate-900">Analitik Job Order</h2>
            <form id="epp-filterDepartement" class="flex items-center gap-2" method="GET" action="">
                <!-- Preserve existing filters like bulan and tahun if needed -->
                @if(request()->filled('bulan')) <input type="hidden" name="bulan" value="{{ request('bulan') }}"> @endif
                @if(request()->filled('tahun')) <input type="hidden" name="tahun" value="{{ request('tahun') }}"> @endif
                
                <label for="departement_id" class="text-sm font-medium text-slate-700">Filter Departement:</label>
                <select name="departement_id" id="departement_id" class="border border-slate-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-orange-500 transition-all bg-white" onchange="this.form.submit()">
                    <option value="">Semua Departement</option>
                    @foreach($departements as $dept)
                        <option value="{{ $dept->id }}" {{ ($departement_id ?? '') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mt-4">
            <!-- Progress Job Order -->
            <div class="bg-white/80 rounded-lg shadow border border-slate-200 p-3">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-base">Progress Job Order</h3>
                    </div>
                    <span class="text-xs text-slate-500">{{ now()->format('d M Y') }}</span>
                </div>
                <div class="h-56 sm:h-64 md:h-72 overflow-hidden rounded-xl border border-slate-100">
                    <div id="customer-progress-joborder-scroll-wrapper" class="w-full h-full overflow-x-auto overflow-y-hidden scrollbar-thin scrollbar-thumb-blue-300/50 scrollbar-track-transparent">
                        <div id="customer-progress-joborder-chart-wrapper" class="w-full min-h-full" style="min-width: 100%; visibility: visible;"></div>
                    </div>
                </div>
            </div>

            <!-- Job Order Perbulan -->
            <div class="bg-white/80 rounded-lg shadow border border-slate-200 p-3">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-base">Job Order Perbulan</h3>
                    </div>
                    <form id="epp-filterJobOrderMonth" class="flex flex-wrap items-center gap-2 max-w-full sm:max-w-xs" method="GET" action="">
                        @if(request()->filled('departement_id')) <input type="hidden" name="departement_id" value="{{ request('departement_id') }}"> @endif
                        <select name="bulan" class="w-24 sm:w-auto border border-gray-300/50 bg-white/80 rounded-lg px-2 py-0.5 text-xs focus:ring-2 focus:ring-green-500 transition-all truncate">
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" @if($m == request('bulan', now()->month)) selected @endif>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                            @endforeach
                        </select>
                        <select name="tahun" class="w-16 sm:w-auto border border-gray-300/50 bg-white/80 rounded-lg px-2 py-0.5 text-xs focus:ring-2 focus:ring-green-500 transition-all truncate">
                            @foreach(range(now()->year-3, now()->year+1) as $y)
                                <option value="{{ $y }}" @if($y == request('tahun', now()->year)) selected @endif>{{ $y }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-2 py-0.5 rounded-lg text-xs font-semibold whitespace-nowrap flex-shrink-0">
                            <span class="hidden sm:inline">Tampilkan</span>
                            <svg class="sm:hidden w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10h18v8a1 1 0 01-1 1H4a1 1 0 01-1-1v-8z"></path></svg>
                        </button>
                    </form>
                </div>
                <div class="overflow-hidden rounded-xl border border-slate-100">
                    <div id="customer-joborder-monthly-scroll-wrapper" class="w-full h-52 md:h-64 overflow-auto scrollbar-thin scrollbar-thumb-green-300/50 scrollbar-track-transparent p-1">
                        <table class="w-full text-sm table-auto">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-2 py-1 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                                    <th class="px-2 py-1 text-left text-xs font-semibold text-slate-600">Proyek</th>
                                    <th class="px-2 py-1 text-left text-xs font-semibold text-slate-600">Evaluasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($joborders_monthly ?? [] as $jo)
                                    @php
                                        $joStart = data_get($jo, 'start');
                                        $joEnd = data_get($jo, 'end');
                                        $joProject = data_get($jo, 'project');
                                        $joEvaluasi = data_get($jo, 'evaluasi');

                                        $startFormatted = $joStart ? \Carbon\Carbon::parse($joStart)->format('d M Y') : '-';
                                        $endFormatted = $joEnd ? \Carbon\Carbon::parse($joEnd)->format('d M Y') : '-';
                                        $dateRange = ($startFormatted !== '-' && $endFormatted !== '-')
                                            ? $startFormatted . ' - ' . $endFormatted
                                            : ($startFormatted !== '-' ? $startFormatted : $endFormatted);
                                    @endphp
                                    <tr>
                                        <td class="px-2 py-1 align-top text-xs">{{ $dateRange }}</td>
                                        <td class="px-2 py-1 align-top text-xs break-words whitespace-normal max-w-[36ch]">{{ $joProject }}</td>
                                        <td class="px-2 py-1 align-top text-xs break-words whitespace-normal">{{ $joEvaluasi ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-3 py-4 text-center text-slate-400">Tidak ada job order bulan ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Proyek Urgent (Per Proyek) -->
            <div class="bg-white/80 rounded-2xl shadow border border-slate-200 p-4 lg:col-span-2">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg">Proyek Urgent (Per Proyek)</h3>
                    </div>
                    <span class="text-xs text-slate-500">Ringkasan per proyek</span>
                </div>
                <div class="h-44 sm:h-52 md:h-64 overflow-hidden rounded-xl border border-slate-100">
                    <div id="customer-urgent-project-scroll-wrapper" class="w-full h-full overflow-y-auto scrollbar-thin scrollbar-thumb-red-300/50 scrollbar-track-transparent">
                        <div id="customer-urgent-project-chart-wrapper" class="w-full min-h-full"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts: Chart.js + datalabels -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <script>
        // === DATA SOURCES ===
        const customerProgressJobOrders = @json($joborders ?? []);
        const customerUrgentProjects = @json($urgent_projects ?? []);

        // === JOB ORDER BAR CHART ===
        (function(){
            if (typeof Chart === 'undefined') { console.warn('Chart.js not loaded'); return; }
            if (window.ChartDataLabels) try { Chart.register(ChartDataLabels); } catch(e) {}

            const progressJobOrders = Array.isArray(customerProgressJobOrders) ? customerProgressJobOrders : [];
            const progressScrollWrapper = document.getElementById('customer-progress-joborder-scroll-wrapper');
            const progressChartWrapper = document.getElementById('customer-progress-joborder-chart-wrapper');

            function renderProgressChart(){
                const itemCount = progressJobOrders.length;
                const rowHeight = 40; 
                const minHeight = 200;
                const maxHeight = Math.max(minHeight, Math.min(1600, itemCount * rowHeight));

                const perItemWidth = 42; 
                const minCanvasWidth = progressChartWrapper ? progressChartWrapper.clientWidth : 520;
                const canvasWidth = Math.max(minCanvasWidth, itemCount * perItemWidth);

                if (itemCount > 10) {
                    if (progressScrollWrapper) {
                        progressScrollWrapper.style.overflowY = 'auto';
                        progressScrollWrapper.style.maxHeight = (rowHeight * 10) + 'px';
                    }
                } else {
                    if (progressScrollWrapper) {
                        progressScrollWrapper.style.overflowY = 'hidden';
                        progressScrollWrapper.style.maxHeight = '';
                    }
                }

                if (!progressChartWrapper) return;

                progressChartWrapper.style.visibility = 'visible';
                progressChartWrapper.innerHTML = `<div style="width:${canvasWidth}px; min-height:${maxHeight}px;"><canvas id="customerProgressJobOrderBarChart" width="${canvasWidth}" height="${maxHeight}" style="display:block; width:100%; height:100%;" ></canvas></div>`;

                setTimeout(() => {
                    const canvas = document.getElementById('customerProgressJobOrderBarChart');
                    if (!canvas) return;

                    if (progressScrollWrapper) { progressScrollWrapper.style.overflowX = 'auto'; }
                    const ctx = canvas.getContext('2d');

                    try { if (window._customerProgressChart && window._customerProgressChart.destroy) { window._customerProgressChart.destroy(); } } catch(e) {}

                    window._customerProgressChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: progressJobOrders.map(j => j.project ?? '-'),
                            datasets: [{
                                label: 'Progress (%)',
                                data: progressJobOrders.map(j => (typeof j.progress === 'number' ? j.progress : (parseInt(j.progress) || 0))),
                                backgroundColor: 'rgba(59,130,246,0.8)',
                                borderColor: '#3b82f6',
                                borderRadius: 8,
                                borderWidth: 1,
                                maxBarThickness: 20
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
                                    font: { weight: '600', size: 11 },
                                    offset: 3,
                                    formatter: v => `${v}%`
                                }
                            },
                            scales: {
                                x: { min: 0, max: 120, display: false, grid: { display: false } },
                                y: { grid: { display: false }, ticks: { font: { size: 11 }, align: 'start', padding: 8 } }
                            },
                            animation: {
                                duration: 800,
                                easing: 'easeOutQuart',
                                onComplete: function() {
                                    if (progressChartWrapper) {
                                        progressChartWrapper.style.visibility = 'visible';
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                }, 100);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', renderProgressChart);
            } else {
                setTimeout(renderProgressChart, 50);
            }
        })();

        // === Proyek Urgent (bar chart horizontal) ===
        (function(){
            if (typeof Chart === 'undefined') { console.warn('Chart.js not loaded'); return; }
            if (window.ChartDataLabels) try { Chart.register(ChartDataLabels); } catch(e) {}

            const urgentProjects = Array.isArray(customerUrgentProjects) ? customerUrgentProjects : [];
            const wrapper = document.getElementById('customer-urgent-project-chart-wrapper');
            if (!wrapper) return;
            if (urgentProjects.length === 0) {
                wrapper.innerHTML = '<div class="p-6 text-center text-slate-400">Tidak ada proyek urgent untuk ditampilkan.</div>';
                return;
            }

            const urgentProjectsData = urgentProjects;
            const urgentChartWrapper = wrapper;
            if (urgentChartWrapper) {
                urgentChartWrapper.innerHTML = `<canvas id="customerUrgentProjectBarChart" class="w-full" style="height:${Math.max(160, urgentProjectsData.length * 36)}px"></canvas>`;
                const ctxU = document.getElementById('customerUrgentProjectBarChart').getContext('2d');
                window._customerUrgentChart = new Chart(ctxU, {
                    type: 'bar',
                    data: { labels: urgentProjectsData.map(p => p.project ?? '-'), datasets: [{ label: 'Jumlah', data: urgentProjectsData.map(p => (typeof p.total === 'number' ? p.total : (parseInt(p.total) || 1))), backgroundColor: 'rgba(239,68,68,0.8)', borderColor: '#ef4444', borderRadius: 8, borderWidth: 1, maxBarThickness: 32 }] },
                    options: {
                        indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false }, datalabels: { anchor: 'end', align: 'right', color: '#ef4444', font: { weight: 'bold', size: 11 }, formatter: (v, ctx) => { const p = urgentProjectsData[ctx.dataIndex] || {}; const seksi = p.seksi ?? '-'; let tgl = '-'; if (p.end) { if (/^\d{2}-\d{2}-\d{4}$/.test(p.end)) tgl = p.end; else if (/^\d{4}-\d{2}-\d{2}$/.test(p.end)) { const [y,m,d] = p.end.split('-'); tgl = `${d}-${m}-${y}`; } else tgl = p.end; } else { tgl = 'Tidak Ada Tanggal'; } return `${seksi} | ${tgl}`; } } },
                        scales: { x: { display: true, grid: { display: false }, min: 0, max: (function(){ const vals = urgentProjectsData.map(p => (typeof p.total === 'number' ? p.total : (parseInt(p.total) || 1))); const maxVal = Math.max(...vals); return Math.ceil(maxVal * 1.2) || 5; })(), ticks: { stepSize: 1, font: { size: 11 } } }, y: { grid: { display: false }, ticks: { font: { size: 11 } } } },
                        animation: { duration: 1500, easing: 'easeOutQuart' }
                    },
                    plugins: [ChartDataLabels]
                });
            }
        })();

        // === Chart visibility and resize handler ===
        (function(){
            let resizeTimer = null;
            let visibilityObserver = null;

            function ensureChartVisibility(){
                const chartWrapper = document.getElementById('customer-progress-joborder-chart-wrapper');
                const canvas = document.getElementById('customerProgressJobOrderBarChart');

                if (chartWrapper) {
                    chartWrapper.style.visibility = 'visible';
                    chartWrapper.style.opacity = '1';
                }

                if (canvas) {
                    canvas.style.visibility = 'visible';
                    canvas.style.display = 'block';
                }

                if (window._customerProgressChart) {
                    try { window._customerProgressChart.update('none'); } catch(e) {}
                }
            }

            function setupVisibilityObserver(){
                if ('IntersectionObserver' in window) {
                    const chartWrapper = document.getElementById('customer-progress-joborder-chart-wrapper');
                    if (chartWrapper && !visibilityObserver) {
                        visibilityObserver = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) { setTimeout(ensureChartVisibility, 50); }
                            });
                        }, { threshold: 0.1 });
                        visibilityObserver.observe(chartWrapper);
                    }
                }
            }

            function recomputeProgressHeight(){
                try{
                    const items = Array.isArray(customerProgressJobOrders) ? customerProgressJobOrders : [];
                    const itemCount = items.length || 0;
                    const rowHeight = 40; 
                    const minHeight = 200;
                    const canvasHeight = Math.max(minHeight, Math.min(1600, itemCount * rowHeight));
                    const scrollWrapper = document.getElementById('customer-progress-joborder-scroll-wrapper');
                    const chartCanvas = document.getElementById('customerProgressJobOrderBarChart');

                    if (scrollWrapper) {
                        if (itemCount > 10) {
                            scrollWrapper.style.maxHeight = (rowHeight * 10) + 'px';
                            scrollWrapper.style.overflowY = 'auto';
                        } else {
                            scrollWrapper.style.maxHeight = '';
                            scrollWrapper.style.overflowY = 'hidden';
                        }
                    }

                    if (chartCanvas) { chartCanvas.height = canvasHeight; }

                    if (window._customerProgressChart && typeof window._customerProgressChart.resize === 'function') {
                        window._customerProgressChart.resize();
                    }

                    setTimeout(ensureChartVisibility, 100);
                }catch(e){}
            }

            function handleResize(){
                if (resizeTimer) clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function(){
                    recomputeProgressHeight();
                    ensureChartVisibility();
                }, 150);
            }

            window.addEventListener('resize', handleResize);

            setTimeout(() => {
                const scrollWrapper = document.getElementById('customer-progress-joborder-scroll-wrapper');
                if (scrollWrapper) { scrollWrapper.addEventListener('scroll', ensureChartVisibility); }
            }, 500);

            document.addEventListener('DOMContentLoaded', function(){
                setTimeout(() => {
                    setupVisibilityObserver();
                    recomputeProgressHeight();
                    ensureChartVisibility();
                }, 200);
            });

            setTimeout(() => {
                setupVisibilityObserver();
                recomputeProgressHeight();
                ensureChartVisibility();
            }, 300);

            setInterval(ensureChartVisibility, 2000);
        })();
    </script>

    <style>
        #customer-progress-joborder-chart-wrapper { visibility: visible !important; opacity: 1 !important; min-height: 200px; }
        #customerProgressJobOrderBarChart { visibility: visible !important; display: block !important; }
        #customer-progress-joborder-scroll-wrapper { scroll-behavior: smooth; }
        .chart-container { transition: opacity 0.3s ease; }
        canvas { image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges; }
        .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background-color: rgba(59, 130, 246, 0.3); border-radius: 3px; }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover { background-color: rgba(59, 130, 246, 0.5); }
    </style>
@endsection
