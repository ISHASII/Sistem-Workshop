<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Daftar Material</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; }
        .header { display:flex; justify-content:space-between; align-items:center; }
        .title { font-size:16px; font-weight:700 }
        .meta { font-size:11px; color:#555 }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="title">Daftar Material</div>
        <div class="meta">Generated: {{ \Illuminate\Support\Carbon::now('Asia/Jakarta')->format('d-m-Y H:i') }}</div>
        </div>
        <div class="meta">Total: {{ $materials->count() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:40px">No</th>
                <th style="width:90px">Tanggal</th>
                <th>Nama</th>
                <th>Spesifikasi</th>
                <th style="width:120px">Kategori</th>
                <th style="width:80px">Satuan</th>
                <th style="width:80px">Stok</th>
                <th style="width:80px">Safety</th>
                <th style="width:80px">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $i => $m)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $m->tanggal ? (\Illuminate\Support\Carbon::parse($m->tanggal)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i')) : '-' }}</td>
                    <td>{{ $m->nama }}</td>
                    <td>{{ $m->spesifikasi ?? '-' }}</td>
                    <td>{{ $m->kategori?->nama ?? $m->kategori?->name ?? '-' }}</td>
                    <td>{{ $m->satuan?->nama ?? $m->satuan?->name ?? '-' }}</td>
                    <td>{{ number_format($m->getCurrentStok(),0,',','.') }}</td>
                    <td>{{ number_format($m->safety_stock ?? 0,0,',','.') }}</td>
                    <td>
                        @if($m->getCurrentStok() <= 0)
                            Habis
                        @elseif($m->isStokKurang())
                            Kurang
                        @else
                            Aman
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
