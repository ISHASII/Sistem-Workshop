<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['username' => 'customer1', 'name' => 'Customer One', 'email' => 'customer1@example.test', 'password' => Hash::make('password123'), 'role' => 'customer'],
            ['username' => 'customer2', 'name' => 'Customer Two', 'email' => 'customer2@example.test', 'password' => Hash::make('password123'), 'role' => 'customer'],
            ['username' => 'customer3', 'name' => 'Customer Three', 'email' => 'customer3@example.test', 'password' => Hash::make('password123'), 'role' => 'customer'],
            ['username' => 'admin',     'name' => 'Administrator',  'email' => 'admin@example.test',     'password' => Hash::make('adminpass'), 'role' => 'admin'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['username' => $u['username']], $u);
        }
    }
}
