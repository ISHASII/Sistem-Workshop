<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Material;
use App\Models\Satuan;
use App\Models\Kategori;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        // Map simple unit aliases from the sheet to our Satuan names
        $unitMap = [
            'btg' => 'Batang',
            'pcs' => 'Pieces',
            'lbr' => 'Lebar',
            'kg'  => 'Kilogram',
            'm'   => 'Meter',
            'pile'=> 'Pail',
            'can' => 'Can',
        ];

        // Provided rows
        $rows = [
            ['material' => 'Besi Hollow', 'spesifikasi' => '40x40x2.8 mm', 'jumlah' => 16, 'satuan' => 'btg', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Besi Siku', 'spesifikasi' => '40x40x4 mm @ 6 m', 'jumlah' => 0, 'satuan' => 'btg', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Besi Behel 8', 'spesifikasi' => '8mm', 'jumlah' => 0, 'satuan' => 'btg', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Besi Behel 10', 'spesifikasi' => '10mm', 'jumlah' => 21, 'satuan' => 'btg', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Besi Behel 12', 'spesifikasi' => '12mm', 'jumlah' => 0, 'satuan' => 'btg', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Dynabolt 8', 'spesifikasi' => '8 mm', 'jumlah' => 141, 'satuan' => 'pcs', 'status' => 'Update Stock', 'kategori' => 'Penunjang'],
            ['material' => 'Dynabolt 10', 'spesifikasi' => '10 mm', 'jumlah' => 100, 'satuan' => 'pcs', 'status' => 'Update Stock', 'kategori' => 'Penunjang'],
            ['material' => 'Dynabolt 12', 'spesifikasi' => '12 mm', 'jumlah' => 0, 'satuan' => 'pcs', 'status' => 'Update Stock', 'kategori' => 'Penunjang'],
            ['material' => 'Acrylic Bening', 'spesifikasi' => '240x120x3 mm', 'jumlah' => 1, 'satuan' => 'lbr', 'status' => 'Update Stock', 'kategori' => 'Non Besi'],
            ['material' => 'Acrylic Biru', 'spesifikasi' => '240x120x3 mm', 'jumlah' => 15, 'satuan' => 'lbr', 'status' => 'Update Stock', 'kategori' => 'Non Besi'],
            ['material' => 'Fisher S8', 'spesifikasi' => null, 'jumlah' => 500, 'satuan' => 'pcs', 'status' => 'StockTersedia', 'kategori' => 'Penunjang'],
            ['material' => 'Fisher S6', 'spesifikasi' => null, 'jumlah' => 200, 'satuan' => 'pcs', 'status' => 'StockTersedia', 'kategori' => 'Penunjang'],
            ['material' => 'Screw Tapping 8', 'spesifikasi' => null, 'jumlah' => 400, 'satuan' => 'pcs', 'status' => 'StockTersedia', 'kategori' => 'Penunjang'],
            ['material' => 'Bordes Stainless', 'spesifikasi' => '2mmx1,22mx2,44m', 'jumlah' => 0, 'satuan' => 'pcs', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Electroda', 'spesifikasi' => 'RB 2.6', 'jumlah' => 75, 'satuan' => 'kg', 'status' => 'StockTersedia', 'kategori' => 'Pengecatan'],
            ['material' => 'Besi UNP', 'spesifikasi' => '100x100 mm', 'jumlah' => 10, 'satuan' => 'btg', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Plat Stripe ', 'spesifikasi' => '40x40 mm', 'jumlah' => 0, 'satuan' => 'lbr', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Placoon', 'spesifikasi' => '4 m', 'jumlah' => 18, 'satuan' => 'btg', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Triplek', 'spesifikasi' => '2 cm', 'jumlah' => 10, 'satuan' => 'lbr', 'status' => 'Update Stock', 'kategori' => 'Non Besi'],
            ['material' => 'Selang Air Toyox', 'spesifikasi' => null, 'jumlah' => 400, 'satuan' => 'm', 'status' => 'StockTersedia', 'kategori' => 'Pengecatan'],
            ['material' => 'Cat Hijau Lantai', 'spesifikasi' => null, 'jumlah' => 14, 'satuan' => 'pile', 'status' => 'StockTersedia', 'kategori' => 'Pengecatan'],
            ['material' => 'Cat Kuning Lantai', 'spesifikasi' => null, 'jumlah' => 2, 'satuan' => 'pile', 'status' => 'Update Stock', 'kategori' => 'Pengecatan'],
            ['material' => 'Hardener', 'spesifikasi' => null, 'jumlah' => 16, 'satuan' => 'pile', 'status' => 'StockTersedia', 'kategori' => 'Pengecatan'],
            ['material' => 'Cat Abu Lantai', 'spesifikasi' => null, 'jumlah' => 18, 'satuan' => 'pile', 'status' => 'StockTersedia', 'kategori' => 'Pengecatan'],
            ['material' => 'Epoxy Activator', 'spesifikasi' => null, 'jumlah' => 18, 'satuan' => 'can', 'status' => 'StockTersedia', 'kategori' => 'Pengecatan'],
            ['material' => 'Thinner Impala', 'spesifikasi' => '1 L', 'jumlah' => 87, 'satuan' => 'can', 'status' => 'StockTersedia', 'kategori' => 'Pengecatan'],
            ['material' => 'Vita Cream', 'spesifikasi' => null, 'jumlah' => 17, 'satuan' => 'can', 'status' => 'Update Stock', 'kategori' => 'Pengecatan'],
            ['material' => 'Cat Mist Blue', 'spesifikasi' => null, 'jumlah' => 11, 'satuan' => 'can', 'status' => 'Update Stock', 'kategori' => 'Pengecatan'],
            ['material' => 'Cat Golden Yellow', 'spesifikasi' => null, 'jumlah' => 3, 'satuan' => 'can', 'status' => 'Update Stock', 'kategori' => 'Pengecatan'],
            ['material' => 'Cat Super Black', 'spesifikasi' => null, 'jumlah' => 3, 'satuan' => 'can', 'status' => 'Update Stock', 'kategori' => 'Pengecatan'],
            ['material' => 'Cat Super White', 'spesifikasi' => null, 'jumlah' => 9, 'satuan' => 'can', 'status' => 'Update Stock', 'kategori' => 'Pengecatan'],
            ['material' => 'Rol Cat Besar', 'spesifikasi' => null, 'jumlah' => 15, 'satuan' => 'can', 'status' => 'Update Stock', 'kategori' => 'Pengecatan'],
            ['material' => 'Rol Cat Kecil', 'spesifikasi' => null, 'jumlah' => 3, 'satuan' => 'can', 'status' => 'Update Stock', 'kategori' => 'Pengecatan'],
            ['material' => 'Mini Roller Cover', 'spesifikasi' => null, 'jumlah' => 43, 'satuan' => 'can', 'status' => 'StockTersedia', 'kategori' => 'Pengecatan'],
            ['material' => 'Big Roller Cover', 'spesifikasi' => null, 'jumlah' => 24, 'satuan' => 'can', 'status' => 'StockTersedia', 'kategori' => 'Pengecatan'],
            ['material' => 'Cutting Wheel 14"', 'spesifikasi' => '14"', 'jumlah' => 13, 'satuan' => 'pcs', 'status' => 'Update Stock', 'kategori' => 'Penunjang'],
            ['material' => 'Cutting Wheel 4"', 'spesifikasi' => '4"', 'jumlah' => 130, 'satuan' => 'pcs', 'status' => 'StockTersedia', 'kategori' => 'Penunjang'],
            ['material' => 'Grinding Wheel', 'spesifikasi' => null, 'jumlah' => 8, 'satuan' => 'pcs', 'status' => 'Update Stock', 'kategori' => 'Penunjang'],
            ['material' => 'Besi CNP', 'spesifikasi' => '6 m', 'jumlah' => 3, 'satuan' => 'btg', 'status' => 'Update Stock', 'kategori' => 'Besi'],
            ['material' => 'Plat Ezer', 'spesifikasi' => '1,2 mm', 'jumlah' => 0, 'satuan' => 'lbr', 'status' => 'Update Stock', 'kategori' => 'Besi'],
        ];

        $today = now()->toDateString();

        foreach ($rows as $row) {
            $satuanName = $unitMap[$row['satuan']] ?? null;
            $satuan = $satuanName ? Satuan::where('name', $satuanName)->first() : null;
            $kategori = Kategori::where('name', $row['kategori'])->first();

            if (!$satuan || !$kategori) {
                // Skip if mapping not found to avoid FK errors
                continue;
            }

            Material::create([
                'tanggal' => $today,
                'nama' => $row['material'],
                'spesifikasi' => $row['spesifikasi'],
                'jumlah' => intval($row['jumlah']), // Convert to integer
                'safety_stock' => rand(5, 20), // Random safety stock between 5-20 (already integer)
                'satuan_id' => $satuan->id,
                'kategori_id' => $kategori->id,
            ]);
        }
    }
}
