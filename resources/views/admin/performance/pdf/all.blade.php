<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Performance Report - All</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .title { font-size: 16px; font-weight: bold; }
        .meta { font-size: 11px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="title">Performance Report - All</div>
            <div class="meta">Generated: {{ \Illuminate\Support\Carbon::now('Asia/Jakarta')->format('d-m-Y H:i') }}</div>
        </div>
        <div>
            <div class="meta">Total records: {{ $performances->groupBy('manpower_id')->count() }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:90px">Tanggal</th>
                <th style="width:90px">NRP</th>
                <th>Nama</th>
                <th style="width:80px">Score</th>
                <th style="width:120px">Rating</th>
            </tr>
        </thead>
        <tbody>
            @php $grouped = $performances->groupBy('manpower_id'); @endphp
            @foreach($grouped as $manpowerId => $group)
                @php
                    // Use the latest performance row for date and rating
                    $latest = $group->sortByDesc('created_at')->first();
                    $tanggal = $latest->created_at ? (\Illuminate\Support\Carbon::parse($latest->created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i')) : '-';
                    $man = $latest->manpower;
                    $nrp = $man?->nrp;
                    $nama = $man?->nama;
                    $avgScore = $group->avg('score');
                    $avgScoreFormatted = is_numeric($avgScore) ? round($avgScore, 1) . '%' : '-';
                    $rating = $latest->rating;
                    // Collect unique job order codes
                    $jobOrders = $group->pluck('jobOrder')->filter()->pluck('kode')->unique()->values()->all();
                    $jobs = count($jobOrders) ? implode(', ', $jobOrders) : '-';
                @endphp
                <tr>
                    <td>{{ $tanggal }}</td>
                    <td>{{ $nrp }}</td>
                    <td>{{ $nama }}</td>
                    <td>{{ $avgScoreFormatted }}</td>
                    <td>{{ $rating }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
