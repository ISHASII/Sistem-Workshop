<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChecklistQualityItem;

class ChecklistQualityItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Material sesuai JO',
            'Dimensi sesuai JO',
            'Item sesuai desain',
            'Pengelasan tidak retak',
            'Item bebas spatter',
            'Baut terpasang baik & lengkap',
            'Tidak ada bagian tajam',
            'Finishing sesuai standar',
            'Bersih dari kotoran/minyak',
            'Berfungsi dengan baik',
        ];

        foreach ($items as $index => $name) {
            ChecklistQualityItem::updateOrCreate(
                ['name' => $name],
                ['sort_order' => $index + 1, 'is_active' => true]
            );
        }
    }
}
