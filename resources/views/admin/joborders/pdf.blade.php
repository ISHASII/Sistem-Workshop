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
    <div style="margin-bottom:12px;">
        <h2 style="text-align:center; margin:0 0 8px 0;">PROJECT PROPOSAL</h2>

        <!-- Top info row: Seksi / Area / Tanggal -->
        <div style="border:1px solid #333; padding:8px;">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="width:30%; vertical-align:top;">
                        <strong>Seksi:</strong> {{ $joborder->seksi ?? '' }}<br>
                        <strong>Area:</strong> {{ $joborder->area ?? '' }}
                    </td>
                    <td style="width:40%; text-align:center; vertical-align:middle;">

                    </td>
                    <td style="width:30%; text-align:right; vertical-align:top;">
                        <strong>Tanggal:</strong>
                        {{ $joborder->start ? \Carbon\Carbon::parse($joborder->start)->format('d F Y') : '' }}
                    </td>
                </tr>
            </table>

            <!-- Four-column box for Nama Project / Latar Belakang / Tujuan / Target -->
            <table style="width:100%; border-collapse:collapse; margin-top:8px;">
                <tr>
                    <th style="width:25%; padding:6px; border:1px solid #333; background:#f0f0f0;">NAMA PROJECT</th>
                    <th style="width:25%; padding:6px; border:1px solid #333; background:#f0f0f0;">LATAR BELAKANG</th>
                    <th style="width:25%; padding:6px; border:1px solid #333; background:#f0f0f0;">TUJUAN</th>
                    <th style="width:25%; padding:6px; border:1px solid #333; background:#f0f0f0;">TARGET</th>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #333; vertical-align:top;">{{ $joborder->project ?? '' }}</td>
                    <td style="padding:8px; border:1px solid #333; vertical-align:top;">{!! nl2br(e($joborder->latar_belakang ?? '')) !!}</td>
                    <td style="padding:8px; border:1px solid #333; vertical-align:top;">{!! nl2br(e($joborder->tujuan ?? '')) !!}</td>
                    <td style="padding:8px; border:1px solid #333; vertical-align:top;">{!! nl2br(e($joborder->target ?? '')) !!}</td>
                </tr>
            </table>
        </div>
    </div>

    <h3 style="margin-top:12px; margin-bottom:6px;">Perhitungan Material</h3>
    <table>
        <thead>
            <tr>
                <th style="width:12%;">PART NUMBER</th>
                <th style="width:48%;">NAMA PART</th>
                <th style="width:20%; text-align:right;">KEBUTUHAN</th>
                <th style="width:20%;">SATUAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($joborder->items as $i => $it)
                @php
                    $mat = $it->material;
                    $partNumber = $mat->part_number ?? ($mat->kode ?? '');
                    $namaPart = $mat? $mat->nama : '';
                    $kebutuhan = $it->jumlah ?? 0;
                    $satuan = $it->satuan ?? ($mat && $mat->satuan ? $mat->satuan->name : '');
                @endphp
                <tr>
                    <td>{{ $partNumber }}</td>
                    <td>{{ $namaPart }}</td>
                    <td style="text-align:right;">{{ $kebutuhan }}</td>
                    <td>{{ $satuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:12px;">
        <strong>Evaluasi:</strong> {{ $joborder->evaluasi ?? '' }}
    </div>

    <!-- Design images (all images) -->
    @if(!empty($joborder->images) && is_array($joborder->images))
        <div style="margin-top:18px; page-break-inside: avoid;">
            <h4 style="margin:0 0 6px 0;">Desain</h4>
            <table style="width:100%; border-collapse:collapse;">
                @php $images = array_values($joborder->images); @endphp
                @foreach(array_chunk($images, 3) as $row)
                    <tr>
                        @foreach($row as $idx => $imgPath)
                            <td style="width:33%; padding:4px; vertical-align:top;">
                                <div style="border:1px solid #333; padding:2px; text-align:center;">
                                    <img src="{{ public_path($imgPath) }}" style="max-width:100%; max-height:180px; height:auto; display:block; margin:0 auto;" alt="Design" />
                                </div>
                            </td>
                        @endforeach
                        {{-- Fill remaining cells in the row if less than 3 --}}
                        @for($i = count($row); $i < 3; $i++)
                            <td style="width:33%; padding:4px;"></td>
                        @endfor
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    <!-- Signature blocks: compact, avoid page-break stretching -->
    <div style="margin-top:12px;">
        <table style="width:100%; border-collapse:collapse; text-align:center; font-size:10px; table-layout:fixed; page-break-inside:avoid;">
            <tr>
                <th style="width:33%; padding:4px 6px; border:1px solid #333; background:#f0f0f0;">Dipesan</th>
                <th style="width:33%; padding:4px 6px; border:1px solid #333; background:#f0f0f0;">Diketahui</th>
                <th style="width:33%; padding:4px 6px; border:1px solid #333; background:#f0f0f0;">Disetujui</th>
            </tr>
            @if($joborder->creator && $joborder->creator->role === 'admin')
                <tr>
                    <!-- Box Dipesan -->
                    <td style="padding:15px 4px; border:1px solid #333; height:70px; vertical-align:middle;">
                        <div style="font-size:16px; font-weight:bold; color:#999; letter-spacing:2px;">RESERVED</div>
                    </td>
                    <!-- Box Diketahui -->
                    <td style="padding:15px 4px; border:1px solid #333; height:70px; vertical-align:middle;">
                        <div style="font-size:16px; font-weight:bold; color:#2e7d32; letter-spacing:1px;">APPROVED</div>
                    </td>
                    <!-- Box Disetujui -->
                    <td style="padding:15px 4px; border:1px solid #333; height:70px; vertical-align:middle;">
                        <div style="font-size:16px; font-weight:bold; color:#2e7d32; letter-spacing:1px;">APPROVED</div>
                    </td>
                </tr>
                <tr>
                    <!-- Detail Dipesan -->
                    <td style="padding:4px 6px; border:1px solid #333; font-size:9px;">
                        <div style="margin-bottom:2px;"><strong>Management EPP</strong></div>
                        <div style="color:#666;">{{ $joborder->created_at->format('d/m/Y') }}</div>
                    </td>
                    <!-- Detail Diketahui -->
                    <td style="padding:4px 6px; border:1px solid #333; font-size:9px;">
                        <div style="margin-bottom:2px;"><strong>Management EPP</strong></div>
                        <div style="color:#666;">{{ $joborder->created_at->format('d/m/Y') }}</div>
                    </td>
                    <!-- Detail Disetujui -->
                    <td style="padding:4px 6px; border:1px solid #333; font-size:9px;">
                        <div style="margin-bottom:2px;"><strong>Management EPP</strong></div>
                        <div style="color:#666;">{{ $joborder->created_at->format('d/m/Y') }}</div>
                    </td>
                </tr>
            @else
                <tr>
                    <!-- Box Dipesan -->
                    <td style="padding:15px 4px; border:1px solid #333; height:70px; vertical-align:middle;">
                        <div style="font-size:16px; font-weight:bold; color:#999; letter-spacing:2px;">RESERVED</div>
                    </td>
                    <!-- Box Diketahui -->
                    <td style="padding:15px 4px; border:1px solid #333; height:70px; vertical-align:middle;">
                        @if($joborder->approval_status === 'approved')
                            <div style="font-size:16px; font-weight:bold; color:#2e7d32; letter-spacing:1px;">APPROVED</div>
                        @elseif($joborder->approval_status === 'rejected')
                            <div style="font-size:16px; font-weight:bold; color:#d32f2f; letter-spacing:1px;">REJECTED</div>
                        @else
                            <div style="font-size:14px; font-weight:bold; color:#999;">PENDING</div>
                        @endif
                    </td>
                    <!-- Box Disetujui -->
                    <td style="padding:15px 4px; border:1px solid #333; height:70px; vertical-align:middle;">
                        @if($joborder->epp_approval_status === 'approved')
                            <div style="font-size:16px; font-weight:bold; color:#2e7d32; letter-spacing:1px;">APPROVED</div>
                        @else
                            <div style="font-size:14px; font-weight:bold; color:#999;">PENDING</div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <!-- Detail Dipesan -->
                    <td style="padding:4px 6px; border:1px solid #333; font-size:9px;">
                        <div style="margin-bottom:2px;"><strong>{{ $joborder->creator->name ?? '-' }}</strong></div>
                        <div style="color:#666;">{{ $joborder->created_at->format('d/m/Y') }}</div>
                    </td>
                    <!-- Detail Diketahui -->
                    <td style="padding:4px 6px; border:1px solid #333; font-size:9px;">
                        @if($joborder->approval_status === 'approved')
                            <div style="margin-bottom:2px;"><strong>{{ $joborder->approvedBy->name ?? '-' }}</strong></div>
                            <div style="color:#666;">{{ $joborder->approved_at ? $joborder->approved_at->format('d/m/Y') : '-' }}</div>
                        @elseif($joborder->approval_status === 'rejected')
                            <div style="margin-bottom:2px;"><strong>{{ $joborder->rejectedBy->name ?? '-' }}</strong></div>
                            <div style="color:#666;">{{ $joborder->rejected_at ? $joborder->rejected_at->format('d/m/Y') : '-' }}</div>
                        @else
                            <div style="color:#999;">-</div>
                        @endif
                    </td>
                    <!-- Detail Disetujui -->
                    <td style="padding:4px 6px; border:1px solid #333; font-size:9px;">
                        @if($joborder->epp_approval_status === 'approved')
                            <div style="margin-bottom:2px;"><strong>{{ $joborder->eppApprovedBy->name ?? '-' }}</strong></div>
                            <div style="color:#666;">{{ $joborder->epp_approved_at ? $joborder->epp_approved_at->format('d/m/Y') : '-' }}</div>
                        @else
                            <div style="color:#999;">-</div>
                        @endif
                    </td>
                </tr>
            @endif
        </table>
    </div>
</body>
</html>
