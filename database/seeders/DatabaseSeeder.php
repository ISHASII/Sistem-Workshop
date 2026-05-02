<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run master data first so dependent seeders can reference the records.
        $this->call([
            DepartementSeeder::class,
            JabatanSeeder::class,
            UserSeeder::class,
            \Database\Seeders\ManpowerSeeder::class,
            \Database\Seeders\KategoriSeeder::class,
            \Database\Seeders\SatuanSeeder::class,
            \Database\Seeders\MaterialMovementsSeeder::class,
            \Database\Seeders\JobOrderSeeder::class,
            \Database\Seeders\MaterialSeeder::class,
            \Database\Seeders\MaterialStockInSeeder::class,
            \Database\Seeders\ChecklistQualityItemSeeder::class,
            \Database\Seeders\PerformanceSeeder::class,
        ]);

        // Keep a small factory-created user for quick manual tests (optional).
        User::updateOrCreate([
            'username' => 'testuser',
        ], [
            'username' => 'testuser',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);
    }
}
