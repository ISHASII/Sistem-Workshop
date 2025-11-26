<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$jos = \App\Models\JobOrder::select('id', 'project', 'start', 'end')->orderBy('id')->get();

echo "Total Job Orders: " . $jos->count() . "\n\n";

foreach($jos as $jo) {
    echo "ID: {$jo->id} | Project: {$jo->project} | Start: {$jo->start} | End: {$jo->end}\n";
}
