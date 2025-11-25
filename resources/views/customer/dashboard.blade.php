@extends('layouts.customer')

@section('title', 'Customer Dashboard')

@section('content')
    <div class="w-full min-h-screen py-4 px-3">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-xl font-semibold mb-3">Customer Dashboard</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                    <div id="customer-debug-panel" class="col-span-1 lg:col-span-2 text-right">
                        <div id="customer-debug-content" class="mt-2 hidden bg-slate-50 rounded p-3 text-xs text-slate-700 max-h-48 overflow-auto border">
                            <div><strong>Counts:</strong>
                                <span id="dbg-count-joborders">JobOrders: -</span> •
                                <span id="dbg-count-joborders-monthly">Monthly: -</span> •
                                <span id="dbg-count-urgent-projects">UrgentProjects: -</span> •
                                <span id="dbg-count-material-cats">MaterialCats: -</span>
                            </div>
                            <pre id="dbg-json" class="mt-2 text-xs whitespace-pre-wrap"></pre>
                        </div>
                    </div>
                    <!-- Progress Job Order (large) -->
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
                            <form id="customer-filterJobOrderMonth" class="flex flex-wrap items-center gap-2 max-w-full sm:max-w-xs" method="GET" action="">
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
                                                $joProject = data_get($jo, 'project');
                                                $joEvaluasi = data_get($jo, 'evaluasi');
                                            @endphp
                                            <tr>
                                                <td class="px-2 py-1 align-top text-xs">{{ $joStart ? \Carbon\Carbon::parse($joStart)->format('d M Y') : '-' }}</td>
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

                    <!-- Material Stock Summary -->
                    <div class="bg-white/80 rounded-2xl shadow border border-slate-200 p-4 lg:col-span-2">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                <h3 class="font-bold text-lg">Material Stock Summary</h3>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                            <button id="mat-prev-btn" type="button" class="text-xs px-2 py-1 rounded-xl bg-gray-100 hover:bg-gray-200 border border-gray-200 flex-shrink-0">
                                <span class="hidden sm:inline">Prev</span>
                                <svg class="sm:hidden w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button id="mat-play-btn" type="button" class="text-xs px-2 py-1 rounded-xl bg-gray-100 hover:bg-gray-200 border border-gray-200 flex-shrink-0" aria-pressed="true">
                                <span class="hidden sm:inline mat-play-text">Pause</span>
                                <svg class="sm:hidden w-4 h-4 inline ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><g class="icon-pause"><rect x="6" y="5" width="4" height="14" rx="1"></rect><rect x="14" y="5" width="4" height="14" rx="1"></rect></g><g class="icon-play" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v18l15-9L5 3z"></path></g></svg>
                            </button>
                            <button id="mat-next-btn" type="button" class="text-xs px-2 py-1 rounded-xl bg-gray-100 hover:bg-gray-200 border border-gray-200 flex-shrink-0">
                                <span class="hidden sm:inline">Next</span>
                                <svg class="sm:hidden w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                        <div class="overflow-x-auto rounded-xl border border-slate-100">
                            <div id="material-chart-container-inner" class="w-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts: Chart.js + datalabels -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <script>
        // === DATA SOURCES (passed from controller) ===
        const customerProgressJobOrders = @json($joborders ?? []);
        const customerJobMonthly = @json($joborders_monthly ?? []);
        const customerUrgentProjects = @json($urgent_projects ?? []);
        // Material data (match admin): grouped by kategori
        const materialsByCategory = @json($materials_by_category ?? []);

        // === JOB ORDER BAR CHART (same behavior as admin) ===
        (function(){
            if (typeof Chart === 'undefined') { console.warn('Chart.js not loaded'); return; }
            if (window.ChartDataLabels) try { Chart.register(ChartDataLabels); } catch(e) {}

            const progressJobOrders = Array.isArray(customerProgressJobOrders) ? customerProgressJobOrders : [];
            const progressScrollWrapper = document.getElementById('customer-progress-joborder-scroll-wrapper');
            const progressChartWrapper = document.getElementById('customer-progress-joborder-chart-wrapper');

            function renderProgressChart(){
                const itemCount = progressJobOrders.length;
                // compact layout constants
                const rowHeight = 40; // smaller row height for compact view
                const minHeight = 200;
                const maxHeight = Math.max(minHeight, Math.min(1600, itemCount * rowHeight));

                // horizontal sizing: smaller per-item width in compact mode
                const perItemWidth = 42; // px per project (compact)
                const minCanvasWidth = progressChartWrapper ? progressChartWrapper.clientWidth : 520;
                const canvasWidth = Math.max(minCanvasWidth, itemCount * perItemWidth);

                // Vertical scrolling for many items (keep behavior)
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
                
                // Clear and set up container with proper visibility
                progressChartWrapper.style.visibility = 'visible';
                progressChartWrapper.innerHTML = `<div style="width:${canvasWidth}px; min-height:${maxHeight}px;"><canvas id="customerProgressJobOrderBarChart" width="${canvasWidth}" height="${maxHeight}" style="display:block; width:100%; height:100%;" ></canvas></div>`;
                
                // Wait for DOM update
                setTimeout(() => {
                    const canvas = document.getElementById('customerProgressJobOrderBarChart');
                    if (!canvas) return;
                    
                    // ensure CSS allows horizontal scroll on outer wrapper
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
                                    // Ensure visibility after animation
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
            
            // Call with proper timing
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', renderProgressChart);
            } else {
                setTimeout(renderProgressChart, 50);
            }
        })();

        // === Job Order Monthly (simple table already rendered server-side) ===
        // no JS required here beyond the server-rendered table; filter form will submit GET

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

            wrapper.innerHTML = `<canvas id="customerUrgentProjectBarChart" class="w-full"></canvas>`;
            const canvas = document.getElementById('customerUrgentProjectBarChart');
            if (!canvas) return;
            canvas.width = canvas.clientWidth || 720;
            canvas.height = Math.max(120, urgentProjects.length * 32);
            const ctx = canvas.getContext('2d');

            const labels = urgentProjects.map(p => p.project ?? '-');
            const dataVals = urgentProjects.map(p => (typeof p.total === 'number' ? p.total : (parseInt(p.total) || 0)));

            // Render urgent projects similar to admin
            const urgentProjectsData = Array.isArray(customerUrgentProjects) ? customerUrgentProjects : [];
            const urgentScrollWrapper = document.getElementById('customer-urgent-project-scroll-wrapper');
            const urgentChartWrapper = document.getElementById('customer-urgent-project-chart-wrapper');
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

        // === MATERIAL STOCK SUMMARY (rotate by category every 10s) ===
        const categoryKeys = Object.keys(materialsByCategory || {});
        if (categoryKeys.length > 0) {
            const container = document.getElementById('material-chart-container-inner');
            container.style.position = 'relative';
            let currentChart = null;
            let currentCategoryIndex = 0;
            const rotateInterval = 10000; // 10s
            let rotateTimer = null;
            let isPaused = false;

            function buildChartInContainer(parent, key, data){
                parent.innerHTML = '';
                const labels = data.map(m => m.nama || '-');
                if(labels.length === 0){
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
                        <canvas class="w-full h-44 sm:h-56 lg:h-64 materialBarChartCanvas"></canvas>
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
                        animation: { duration: 500, easing: 'easeOutQuart' }
                    }
                });
                // fade in
                requestAnimationFrame(() => { wrapper.style.opacity = '1'; });
                return { wrapper, chart };
            }

            function showCategory(idx, direction){
                const key = categoryKeys[idx];
                const data = materialsByCategory[key] || [];
                // prepare new slide
                const result = buildChartInContainer(container, key, data);
                if(!result) return;
                // animate out previous
                const previous = container.querySelectorAll('.mat-slide');
                if(previous.length > 1){
                    // the first is the older one, the last is the new; fade out the first
                    const old = previous[0];
                    old.style.opacity = '0';
                    // destroy any chart instance attached (we don't keep refs for old ones)
                    setTimeout(() => { try{ old.remove(); } catch(e){} }, 500);
                }
                // set currentChart for destruction when next changes
                if(currentChart && currentChart.destroy){ try{ currentChart.destroy(); }catch(e){} }
                currentChart = result.chart;
            }

            function startRotation(){ if(rotateTimer) clearInterval(rotateTimer); rotateTimer = setInterval(() => { currentCategoryIndex = (currentCategoryIndex + 1) % categoryKeys.length; showCategory(currentCategoryIndex, 1); }, rotateInterval); }
            function stopRotation(){ if(rotateTimer){ clearInterval(rotateTimer); rotateTimer = null; } }

            // initial
            showCategory(currentCategoryIndex, 0);
            startRotation();

            // controls
            const prevBtn = document.getElementById('mat-prev-btn');
            const nextBtn = document.getElementById('mat-next-btn');
            const playBtn = document.getElementById('mat-play-btn');

            if(prevBtn){ prevBtn.addEventListener('click', function(){
                currentCategoryIndex = (currentCategoryIndex - 1 + categoryKeys.length) % categoryKeys.length;
                showCategory(currentCategoryIndex, -1);
                // restart rotation timer so next auto-change comes after full interval
                if(!isPaused) { stopRotation(); startRotation(); }
            }); }
            if(nextBtn){ nextBtn.addEventListener('click', function(){
                currentCategoryIndex = (currentCategoryIndex + 1) % categoryKeys.length;
                showCategory(currentCategoryIndex, 1);
                if(!isPaused) { stopRotation(); startRotation(); }
            }); }
            if(playBtn){ playBtn.addEventListener('click', function(){
                if(isPaused){
                    isPaused = false; playBtn.textContent = 'Pause'; startRotation();
                } else {
                    isPaused = true; playBtn.textContent = 'Play'; stopRotation();
                }
            }); }
        } else {
            const container = document.getElementById('material-chart-container-inner');
            if(container) container.innerHTML = '<div class="p-4 text-sm text-gray-500">Tidak ada data material.</div>';
        }

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
                    try {
                        window._customerProgressChart.update('none'); // Update without animation
                    } catch(e) {}
                }
            }
            
            function setupVisibilityObserver(){
                if ('IntersectionObserver' in window) {
                    const chartWrapper = document.getElementById('customer-progress-joborder-chart-wrapper');
                    if (chartWrapper && !visibilityObserver) {
                        visibilityObserver = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    setTimeout(ensureChartVisibility, 50);
                                }
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
                    const rowHeight = 40; // Match the chart rowHeight
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
                    
                    if (chartCanvas) {
                        chartCanvas.height = canvasHeight;
                    }
                    
                    if (window._customerProgressChart && typeof window._customerProgressChart.resize === 'function') {
                        window._customerProgressChart.resize();
                    }
                    
                    // Ensure visibility after resize
                    setTimeout(ensureChartVisibility, 100);
                }catch(e){ console.warn('resize progress error', e); }
            }
            
            function handleResize(){
                if (resizeTimer) clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function(){
                    recomputeProgressHeight();
                    ensureChartVisibility();
                }, 150);
            }
            
            function handleScroll(){
                ensureChartVisibility();
            }
            
            // Event listeners
            window.addEventListener('resize', handleResize);
            
            // Add scroll listener to the scroll wrapper
            setTimeout(() => {
                const scrollWrapper = document.getElementById('customer-progress-joborder-scroll-wrapper');
                if (scrollWrapper) {
                    scrollWrapper.addEventListener('scroll', handleScroll);
                }
            }, 500);
            
            // Setup observers and initial calls
            document.addEventListener('DOMContentLoaded', function(){
                setTimeout(() => {
                    setupVisibilityObserver();
                    recomputeProgressHeight();
                    ensureChartVisibility();
                }, 200);
            });
            
            // Also run immediately in case DOMContentLoaded already fired
            setTimeout(() => {
                setupVisibilityObserver();
                recomputeProgressHeight();
                ensureChartVisibility();
            }, 300);
            
            // Periodic visibility check (as backup)
            setInterval(ensureChartVisibility, 2000);
        })();
    </script>

    <style>
        /* Ensure chart containers are always visible */
        #customer-progress-joborder-chart-wrapper {
            visibility: visible !important;
            opacity: 1 !important;
            min-height: 200px;
        }
        
        #customerProgressJobOrderBarChart {
            visibility: visible !important;
            display: block !important;
        }
        
        /* Smooth scroll behavior */
        #customer-progress-joborder-scroll-wrapper {
            scroll-behavior: smooth;
        }
        
        /* Prevent chart flicker during transitions */
        .chart-container {
            transition: opacity 0.3s ease;
        }
        
        /* Ensure proper chart rendering */
        canvas {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
        
        /* Fix scrollbar styling */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgba(59, 130, 246, 0.3);
            border-radius: 3px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background-color: rgba(59, 130, 246, 0.5);
        }
    </style>
@endsection
