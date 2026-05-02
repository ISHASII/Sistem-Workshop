<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;

class DepartementSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Teknisi',
            'Produksi',
            'Administrasi',
            'Warehouse',
        ];

        foreach ($names as $name) {
            Departement::updateOrCreate(['name' => $name], ['name' => $name]);
        }
    }
}
