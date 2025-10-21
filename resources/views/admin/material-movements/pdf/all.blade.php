<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Pergerakan Material</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111 }
        table { width:100%; border-collapse: collapse; margin-top:12px }
        th, td { border:1px solid #ccc; padding:6px 8px; text-align:left }
        th { background:#f3f4f6 }
    </style>
</head>
<body>
    <h3>Riwayat Pergerakan Material</h3>
    <div>Generated: {{ now()->format('d-m-Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th style="width:80px">Tanggal</th>
                <th style="width:180px">Material</th>
                <th style="width:80px">Jenis</th>
                <th style="width:80px">Jumlah</th>
                <th style="width:120px">Movement Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movements as $m)
                <tr>
                    <td>{{ optional($m->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $m->material?->nama ?? '-' }}</td>
                    <td>{{ $m->type }}</td>
                    <td style="text-align:right">{{ number_format($m->jumlah ?? 0,0,',','.') }}</td>
                    <td>{{ strtoupper($m->movement_type ?? '-') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
