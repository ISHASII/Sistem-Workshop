<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $names = ['Besi', 'Non Besi', 'Penunjang', 'Pengecatan'];

        foreach ($names as $name) {
            Kategori::updateOrCreate(['name' => $name], ['name' => $name]);
        }
    }
}
