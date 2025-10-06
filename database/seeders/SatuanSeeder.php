<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satuan;

class SatuanSeeder extends Seeder
{
    public function run()
    {
        $names = [
            'Batang','Pieces','Lebar','Can','Galon','Kilogram','Meter','Cm²','Set','Box','Pack','Liter','Pail','Rol'
        ];

        foreach ($names as $name) {
            Satuan::updateOrCreate(['name' => $name], ['name' => $name]);
        }
    }
}
