<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Job Order #{{ $joborder->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 10px }
        .meta { margin-bottom: 8px }
        table { width:100%; border-collapse: collapse; }
        th, td { padding:6px; border:1px solid #ddd; }
        th { background:#f5f5f5; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Job Order #{{ $joborder->id }}</h2>
        <div class="meta">Project: {{ $joborder->project }}</div>
        <div class="meta">Seksi: {{ $joborder->seksi ?? '-' }} | Status: {{ $joborder->status }}</div>
        <div class="meta">Start: {{ $joborder->start ?? '-' }} | End: {{ $joborder->end ?? '-' }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Material</th>
                <th>Spesifikasi</th>
                <th>Jumlah</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($joborder->items as $i => $it)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $it->material? $it->material->nama : '-' }}</td>
                    <td>{{ $it->spesifikasi }}</td>
                    <td>{{ $it->jumlah }}</td>
                    <td>{{ $it->satuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:12px;">
        <strong>Evaluasi:</strong> {{ $joborder->evaluasi ?? '-' }}
    </div>
</body>
</html>
