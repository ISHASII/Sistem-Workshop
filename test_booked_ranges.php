<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing bookedRanges conversion...\n\n";

$jos = \App\Models\JobOrder::select('id', 'start', 'end')->get();
echo 'Total Job Orders: ' . $jos->count() . "\n\n";

$bookedRanges = [];
foreach($jos as $jo) {
    try {
        $start = \Carbon\Carbon::createFromFormat('d-m-Y', $jo->start);
        $end = \Carbon\Carbon::createFromFormat('d-m-Y', $jo->end);
    } catch (\Throwable $e) {
        try {
            $start = \Carbon\Carbon::createFromFormat('Y-m-d', $jo->start);
            $end = \Carbon\Carbon::createFromFormat('Y-m-d', $jo->end);
        } catch (\Throwable $e2) {
            echo "ID: {$jo->id} | ERROR parsing dates\n";
            continue;
        }
    }
    
    $bookedRanges[] = [
        'id' => $jo->id,
        'original_start' => $jo->start,
        'original_end' => $jo->end,
        'from' => $start->format('Y-m-d'),
        'to' => $end->format('Y-m-d')
    ];
    
    echo "ID: {$jo->id} | {$jo->start} to {$jo->end} => {$start->format('Y-m-d')} to {$end->format('Y-m-d')}\n";
}

echo "\n\nJSON for flatpickr:\n";
echo json_encode(array_map(function($r) {
    return ['from' => $r['from'], 'to' => $r['to']];
}, $bookedRanges), JSON_PRETTY_PRINT);
