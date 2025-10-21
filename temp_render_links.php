<?php
// temp_render_links.php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Pagination\Paginator;

// Ensure paginator uses current path
// Build query similar to controller
$query = App\Models\JobOrder::with(['items.material']);
$joborders = $query->latest()->paginate(10);

// Render links
$html = $joborders->links()->toHtml();

echo $html;