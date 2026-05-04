<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Departement;
use App\Models\Jabatan;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('1234567890');

        // Jabatans
        $mngtEppJabatan = Jabatan::firstWhere('name', 'Management EPP');

        // 1. Admin Account
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@epp.test',
                'password' => $password,
                'role' => 'admin',
            ]
        );

        // 2. Management EPP Account
        User::updateOrCreate(
            ['username' => 'mjepp'],
            [
                'name' => 'Management EPP',
                'email' => 'mjepp@epp.test',
                'password' => $password,
                'role' => 'management-epp',
                'jabatan_id' => $mngtEppJabatan?->id,
            ]
        );
    }
}
