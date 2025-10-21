<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Material - {{ $material->nama }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #111; }
        .title { font-size:18px; font-weight:700; margin-bottom:8px }
        .meta { font-size:12px; color:#444 }
        table { width:100%; border-collapse: collapse; margin-top:8px }
        th, td { border:1px solid #ccc; padding:8px; text-align:left }
        th { background:#f3f4f6; width:30% }
    </style>
</head>
<body>
    <div class="title">Detail Material</div>
    <div class="meta">Generated: {{ now()->format('d-m-Y H:i') }}</div>

    <table>
        <tr>
            <th>Tanggal</th>
            <td>{{ $material->tanggal ? (\Illuminate\Support\Carbon::parse($material->tanggal)->format('d-m-Y')) : '-' }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $material->nama }}</td>
        </tr>
        <tr>
            <th>Spesifikasi</th>
            <td>{{ $material->spesifikasi ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $material->kategori?->nama ?? $material->kategori?->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Satuan</th>
            <td>{{ $material->satuan?->nama ?? $material->satuan?->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Stok Saat Ini</th>
            <td>{{ number_format($material->getCurrentStok(),0,',','.') }}</td>
        </tr>
        <tr>
            <th>Safety Stock</th>
            <td>{{ number_format($material->safety_stock ?? 0,0,',','.') }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($material->getCurrentStok() <= 0)
                    Habis
                @elseif($material->isStokKurang())
                    Kurang
                @else
                    Aman
                @endif
            </td>
        </tr>
    </table>

    @if($material->movements && $material->movements->count())
        <h4 style="margin-top:12px">Riwayat Pergerakan</h4>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($material->movements as $mv)
                    <tr>
                        <td>{{ optional($mv->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ ucfirst($mv->type ?? '-') }}</td>
                        <td>{{ number_format($mv->jumlah ?? 0,0,',','.') }}</td>
                        <td>{{ $mv->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
