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
        // Run individual seeders so `php artisan db:seed` also runs the UserSeeder.
        $this->call([
            UserSeeder::class,
            \Database\Seeders\ManpowerSeeder::class,
            \Database\Seeders\KategoriSeeder::class,
            \Database\Seeders\SatuanSeeder::class,
            \Database\Seeders\MaterialSeeder::class,
            // \Database\Seeders\MaterialMovementsSeeder::class,
            // \Database\Seeders\MaterialMasukSeeder::class,
            \Database\Seeders\JobOrderSeeder::class,
            \Database\Seeders\PerformanceSeeder::class,
        ]);

        // Keep a small factory-created user for quick manual tests (optional).
        User::factory()->create([
            'username' => 'testuser',
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
