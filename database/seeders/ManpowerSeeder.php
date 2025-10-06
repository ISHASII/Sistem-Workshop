<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manpower;

class ManpowerSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['nrp' => '114380', 'nama' => 'M. Rizki Darmawan', 'jenis_kelamin' => 'laki-laki', 'status_pegawai' => 'kontrak'],
            ['nrp' => '104484', 'nama' => 'Didit Junianto', 'jenis_kelamin' => 'laki-laki', 'status_pegawai' => 'kontrak'],
            ['nrp' => '126545', 'nama' => 'Yongki Adi Saputra', 'jenis_kelamin' => 'laki-laki', 'status_pegawai' => 'kontrak'],
            ['nrp' => '126521', 'nama' => 'Dennis Alfiansyah', 'jenis_kelamin' => 'laki-laki', 'status_pegawai' => 'kontrak'],
            ['nrp' => '126546', 'nama' => 'Rifki Andi Fahrezi', 'jenis_kelamin' => 'laki-laki', 'status_pegawai' => 'kontrak'],
        ];

        foreach ($rows as $r) {
            Manpower::updateOrCreate(
                ['nrp' => $r['nrp']],
                [
                    'nama' => $r['nama'],
                    'jenis_kelamin' => $r['jenis_kelamin'],
                    'status_pegawai' => $r['status_pegawai'],
                ]
            );
        }
    }
}
