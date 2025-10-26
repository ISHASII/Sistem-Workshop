<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Performance Report - {{ $performance->manpower?->nama ?? 'Performance' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #111; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 8px; }
        .meta { font-size: 12px; color: #444; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f3f4f6; width: 30%; }
    </style>
</head>
<body>
    <div class="title">Performance Detail</div>
    @php
        $__generated_at = \Illuminate\Support\Carbon::now('Asia/Jakarta')->format('d-m-Y H:i');
        $__performance_tanggal = $performance->created_at ? (\Illuminate\Support\Carbon::parse($performance->created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i')) : '-';
    @endphp

    <div class="meta">Generated: {{ $__generated_at }}</div>

    <table>
        <tr>
            <th>Tanggal</th>
            <td>{{ $__performance_tanggal }}</td>
        </tr>
        <tr>
            <th>NRP</th>
            <td>{{ $performance->manpower?->nrp }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $performance->manpower?->nama }}</td>
        </tr>
        <tr>
            <th>Score</th>
            <td>{{ $performance->score }}%</td>
        </tr>
        <tr>
            <th>Rating</th>
            <td>{{ $performance->rating }}</td>
        </tr>
        <tr>
            <th>Job Order</th>
            <td>{{ $performance->jobOrder?->kode ?? '-' }}</td>
        </tr>
    </table>

    <h4 style="margin-top:12px">Checklist</h4>
    <table>
        <tbody>
            @foreach([
                'material_sesuai_jo' => 'Material sesuai JO',
                'dimensi_sesuai_jo' => 'Dimensi sesuai JO',
                'item_sesuai_design' => 'Item sesuai design',
                'pengelasan_tidak_retak' => 'Pengelasan tidak retak',
                'item_bebas_spatter' => 'Item bebas spatter',
                'baut_terpasang_baik_lengkap' => 'Baut terpasang baik & lengkap',
                'tidak_ada_bagian_tajam' => 'Tidak ada bagian tajam',
                'finishing_standar' => 'Finishing standar',
                'tidak_ada_kotoran' => 'Tidak ada kotoran',
                'berfungsi_dengan_baik' => 'Berfungsi dengan baik'
            ] as $field => $label)
                <tr>
                    <th>{{ $label }}</th>
                    <td>{{ $performance->{$field} ? 'Ya' : 'Tidak' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
