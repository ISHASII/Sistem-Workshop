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
            <div class="meta">Generated: {{ now()->format('d-m-Y H:i') }}</div>
        </div>
        <div>
            <div class="meta">Total records: {{ $performances->count() }}</div>
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
                <th>Job Order</th>
            </tr>
        </thead>
        <tbody>
            @foreach($performances as $p)
                <tr>
                    <td>{{ optional($p->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $p->manpower?->nrp }}</td>
                    <td>{{ $p->manpower?->nama }}</td>
                    <td>{{ $p->score }}%</td>
                    <td>{{ $p->rating }}</td>
                    <td>{{ $p->jobOrder?->kode ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>