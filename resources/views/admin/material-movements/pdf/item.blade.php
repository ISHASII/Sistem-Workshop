<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pergerakan Material #{{ $materialMovement->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:13px; color:#111 }
        table { width:100%; border-collapse: collapse; margin-top:8px }
        th, td { border:1px solid #ccc; padding:8px; text-align:left }
        th { background:#f3f4f6; width:30% }
    </style>
</head>
<body>
    <h3>Pergerakan Material</h3>
    <div>Generated: {{ now()->format('d-m-Y H:i') }}</div>

    <table>
        <tr>
            <th>ID</th>
            <td>{{ $materialMovement->id }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ optional($materialMovement->tanggal)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Material</th>
            <td>{{ $materialMovement->material?->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jenis</th>
            <td>{{ ucfirst($materialMovement->type) }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ number_format($materialMovement->jumlah ?? 0,0,',','.') }}</td>
        </tr>
        <tr>
            <th>Movement Type</th>
            <td>{{ strtoupper($materialMovement->movement_type ?? '-') }}</td>
        </tr>
    </table>
</body>
</html>
