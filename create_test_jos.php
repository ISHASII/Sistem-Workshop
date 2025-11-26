<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Create test job orders for November 2025 to see disabled dates
echo "Creating test job orders for November 2025...\n\n";

// JO 1: Nov 1-5, 2025
$jo1 = \App\Models\JobOrder::create([
    'seksi' => 'Test Section',
    'status' => 'Low',
    'project' => 'Test Lock Display Nov 1-5',
    'start' => '01-11-2025',
    'end' => '05-11-2025',
    'created_by' => 1
]);

echo "Created JO #{$jo1->id}: {$jo1->start} to {$jo1->end}\n";

// JO 2: Nov 10-15, 2025
$jo2 = \App\Models\JobOrder::create([
    'seksi' => 'Test Section',
    'status' => 'Low',
    'project' => 'Test Lock Display Nov 10-15',
    'start' => '10-11-2025',
    'end' => '15-11-2025',
    'created_by' => 1
]);

echo "Created JO #{$jo2->id}: {$jo2->start} to {$jo2->end}\n";

// JO 3: Nov 20-25, 2025
$jo3 = \App\Models\JobOrder::create([
    'seksi' => 'Test Section',
    'status' => 'Low',
    'project' => 'Test Lock Display Nov 20-25',
    'start' => '20-11-2025',
    'end' => '25-11-2025',
    'created_by' => 1
]);

echo "Created JO #{$jo3->id}: {$jo3->start} to {$jo3->end}\n";

echo "\nTest job orders created! Now refresh the create job order page.\n";
echo "The dates Nov 1-5, 10-15, and 20-25 should appear LOCKED with red background and 🔒 icon.\n";
