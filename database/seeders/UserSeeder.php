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
        $customerJabatan = Jabatan::firstWhere('name', 'Customer');
        $mngtCustomerJabatan = Jabatan::firstWhere('name', 'Management Customer');
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
            ['username' => 'mngt.epp'],
            [
                'name' => 'Management EPP',
                'email' => 'mngt.epp@epp.test',
                'password' => $password,
                'role' => 'management-epp',
                'jabatan_id' => $mngtEppJabatan?->id,
            ]
        );

        // 3. Department-specific accounts
        $departements = Departement::all();

        foreach ($departements as $dept) {
            $deptSlug = strtolower(str_replace(' ', '', $dept->name));

            // Customer per department
            User::updateOrCreate(
                ['username' => 'cust.' . $deptSlug],
                [
                    'name' => 'Customer ' . $dept->name,
                    'email' => 'cust.' . $deptSlug . '@epp.test',
                    'password' => $password,
                    'role' => 'customer',
                    'department_id' => $dept->id,
                    'jabatan_id' => $customerJabatan?->id,
                ]
            );

            // Management Customer per department
            User::updateOrCreate(
                ['username' => 'mngt.' . $deptSlug],
                [
                    'name' => 'Management ' . $dept->name,
                    'email' => 'mngt.' . $deptSlug . '@epp.test',
                    'password' => $password,
                    'role' => 'management-customer',
                    'department_id' => $dept->id,
                    'jabatan_id' => $mngtCustomerJabatan?->id,
                ]
            );
        }
    }
}
