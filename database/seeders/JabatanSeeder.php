<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Customer',
            'Management Customer',
        ];

        foreach ($names as $name) {
            Jabatan::updateOrCreate(['name' => $name], ['name' => $name]);
        }
    }
}
