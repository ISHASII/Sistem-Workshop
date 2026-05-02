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
        $teknisi = Departement::firstWhere('name', 'Teknisi');
        $produksi = Departement::firstWhere('name', 'Produksi');
        $customer = Jabatan::firstWhere('name', 'Customer');
        $managementCustomer = Jabatan::firstWhere('name', 'Management Customer');

        $users = [
            ['username' => 'customer1', 'name' => 'Customer One', 'email' => 'customer1@example.test', 'password' => Hash::make('password123'), 'role' => 'customer', 'department_id' => $teknisi?->id, 'jabatan_id' => $customer?->id],
            ['username' => 'customer2', 'name' => 'Customer Two', 'email' => 'customer2@example.test', 'password' => Hash::make('password123'), 'role' => 'customer', 'department_id' => $teknisi?->id, 'jabatan_id' => $managementCustomer?->id],
            ['username' => 'customer3', 'name' => 'Customer Three', 'email' => 'customer3@example.test', 'password' => Hash::make('password123'), 'role' => 'customer', 'department_id' => $produksi?->id, 'jabatan_id' => $customer?->id],
            ['username' => 'admin', 'name' => 'Administrator', 'email' => 'admin@example.test', 'password' => Hash::make('adminpass'), 'role' => 'admin'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['username' => $u['username']], $u);
        }
    }
}
