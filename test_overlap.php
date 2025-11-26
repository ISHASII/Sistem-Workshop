<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing overlap validation with existing data...\n\n";

// Get the latest job order
$latestJO = \App\Models\JobOrder::orderBy('id', 'desc')->first();

if ($latestJO) {
    echo "Latest Job Order:\n";
    echo "ID: {$latestJO->id}\n";
    echo "Project: {$latestJO->project}\n";
    echo "Start: {$latestJO->start}\n";
    echo "End: {$latestJO->end}\n\n";

    // Parse the latest end date
    try {
        $latestEnd = \Carbon\Carbon::createFromFormat('d-m-Y', $latestJO->end);
    } catch (\Throwable $e) {
        try {
            $latestEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $latestJO->end);
        } catch (\Throwable $e2) {
            echo "Error parsing date: {$latestJO->end}\n";
            exit;
        }
    }

    echo "Latest end date parsed: " . $latestEnd->format('d-m-Y') . "\n";
    echo "Next available start: " . $latestEnd->addDay()->format('d-m-Y') . "\n\n";

    // Test overlap detection
    echo "Testing overlap with date range: 2025-11-26 to 2025-11-28\n";
    $testStart = \Carbon\Carbon::createFromFormat('Y-m-d', '2025-11-26')->startOfDay();
    $testEnd = \Carbon\Carbon::createFromFormat('Y-m-d', '2025-11-28')->endOfDay();

    $allJobOrders = \App\Models\JobOrder::all();
    $hasOverlap = false;

    foreach ($allJobOrders as $jo) {
        try {
            $joStart = \Carbon\Carbon::createFromFormat('d-m-Y', $jo->start)->startOfDay();
        } catch (\Throwable $e) {
            try {
                $joStart = \Carbon\Carbon::createFromFormat('Y-m-d', $jo->start)->startOfDay();
            } catch (\Throwable $e2) {
                continue;
            }
        }

        try {
            $joEnd = \Carbon\Carbon::createFromFormat('d-m-Y', $jo->end)->endOfDay();
        } catch (\Throwable $e) {
            try {
                $joEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $jo->end)->endOfDay();
            } catch (\Throwable $e2) {
                continue;
            }
        }

        // Check overlap
        if ($testStart->lessThanOrEqualTo($joEnd) && $testEnd->greaterThanOrEqualTo($joStart)) {
            echo "OVERLAP FOUND with Job Order ID: {$jo->id}\n";
            echo "  Project: {$jo->project}\n";
            echo "  Start: {$jo->start} -> " . $joStart->format('Y-m-d') . "\n";
            echo "  End: {$jo->end} -> " . $joEnd->format('Y-m-d') . "\n\n";
            $hasOverlap = true;
        }
    }

    if (!$hasOverlap) {
        echo "NO OVERLAP - Date range is available\n";
    }
}
