<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Satuan;
use App\Models\MaterialMovement;
use Carbon\Carbon;

class MaterialMovementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data copied from the user input (JOB ORDER then MEMO)
        $rows = [
            // JOB ORDER (movement_type = 'jo')
            ['tanggal' => '8/12/2024','nama' => 'Besi Siku','spesifikasi' => '40x40x4 mm','jumlah' => '9','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/12/2024','nama' => 'Besi Hollow','spesifikasi' => '40x40x4 mm','jumlah' => '12','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/12/2024','nama' => 'Placoon Roll','spesifikasi' => null,'jumlah' => '8','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/12/2024','nama' => 'Cat Mist Blue','spesifikasi' => null,'jumlah' => '3','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/12/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '3','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/12/2024','nama' => 'Besi Behel','spesifikasi' => null,'jumlah' => '2','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/13/2024','nama' => 'Besi Hollow','spesifikasi' => '40x40x20 mm','jumlah' => '4','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/13/2024','nama' => 'Cat Hitam','spesifikasi' => null,'jumlah' => '5','satuan' => 'kg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/13/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '15','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/13/2024','nama' => 'Acrylic Bening','spesifikasi' => '3 mm','jumlah' => '4','satuan' => 'lbr','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/13/2024','nama' => 'Dynabolt','spesifikasi' => '10 mm','jumlah' => '10','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/13/2024','nama' => 'Besi Behel','spesifikasi' => '10 mm','jumlah' => '6','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/13/2024','nama' => 'Besi Siku','spesifikasi' => '40x40x4 mm','jumlah' => '2','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/15/2024','nama' => 'Besi Siku','spesifikasi' => '40x40x4mm','jumlah' => '20','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/15/2024','nama' => 'Fisher','spesifikasi' => '8','jumlah' => '100','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/15/2024','nama' => 'Baut Fisher','spesifikasi' => '8','jumlah' => '100','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/15/2024','nama' => 'Cat Golden Yellow','spesifikasi' => null,'jumlah' => '5','satuan' => 'kg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/19/2024','nama' => 'Besi Hollow','spesifikasi' => '40x40x20 mm','jumlah' => '15','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/19/2024','nama' => 'Besi Siku','spesifikasi' => '40x40x12 mm','jumlah' => '8','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/19/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '25','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/19/2024','nama' => 'Acrylic Bening','spesifikasi' => null,'jumlah' => '3','satuan' => 'lbr','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Golden Yellow','spesifikasi' => null,'jumlah' => '20','satuan' => 'kg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Hitam','spesifikasi' => null,'jumlah' => '5','satuan' => 'kg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/19/2024','nama' => 'Plat Ezer','spesifikasi' => '1,2 mm','jumlah' => '2','satuan' => 'lbr','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/22/2024','nama' => 'Tray Kabel','spesifikasi' => null,'jumlah' => '15','satuan' => 'M','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '8/22/2024','nama' => 'Tali TIS / cable TIS','spesifikasi' => null,'jumlah' => '3','satuan' => 'ktg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/4/2024','nama' => 'Besi Siku','spesifikasi' => '4 cm','jumlah' => '5','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Besi Hollow','spesifikasi' => '40x40x4 mm','jumlah' => '3','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Plat Besi','spesifikasi' => '3 mm','jumlah' => '1','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Electroda','spesifikasi' => null,'jumlah' => '5','satuan' => 'kg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Cat Mist Blue','spesifikasi' => null,'jumlah' => '3','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '3','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Mata Cutting Wheel','spesifikasi' => null,'jumlah' => '1','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Mata Gerinda Potong','spesifikasi' => null,'jumlah' => '8','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Besi Hollow','spesifikasi' => '40x40x4 mm','jumlah' => '12','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Cat Mist Blue','spesifikasi' => null,'jumlah' => '4','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '1','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Mata Gerinda Potong','spesifikasi' => null,'jumlah' => '3','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Mata Gerinda Halus','spesifikasi' => null,'jumlah' => '3','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Mata Cutting Wheel','spesifikasi' => null,'jumlah' => '1','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Besi Siku','spesifikasi' => '40x40x4 mm','jumlah' => '3','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Besi Henderson','spesifikasi' => null,'jumlah' => '1','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/5/2024','nama' => 'Electroda','spesifikasi' => null,'jumlah' => '5','satuan' => 'kg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/12/2024','nama' => 'Besi Hollow','spesifikasi' => null,'jumlah' => '5','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/17/2024','nama' => 'Besi Siku','spesifikasi' => '40x40x4 mm','jumlah' => '2','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/17/2024','nama' => 'Cat Hitam','spesifikasi' => null,'jumlah' => '2','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/17/2024','nama' => 'Cat Kuning','spesifikasi' => null,'jumlah' => '2','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/17/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '1','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/17/2024','nama' => 'Mata Gerinda Potong','spesifikasi' => null,'jumlah' => '4','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/17/2024','nama' => 'Mata Cutting Wheel','spesifikasi' => null,'jumlah' => '1','satuan' => 'pcs','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/17/2024','nama' => 'Electroda','spesifikasi' => null,'jumlah' => '4','satuan' => 'kg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/17/2024','nama' => 'Besi Siku','spesifikasi' => '40x40x4 mm','jumlah' => '1','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            // additional repeated entries from 9/17 mostly duplicates in original list
            ['tanggal' => '9/18/2024','nama' => 'Besi Hollow','spesifikasi' => '40x40x2,8 mm','jumlah' => '15','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/18/2024','nama' => 'Plat Ezer','spesifikasi' => '1,2 mm','jumlah' => '1','satuan' => 'lbr','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/18/2024','nama' => 'Besi Behel','spesifikasi' => '∅ 10 mm @ 12 mm','jumlah' => '2','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/18/2024','nama' => 'Roda Kereta Rubber','spesifikasi' => '∅ 4 inch swivel','jumlah' => '2','satuan' => 'un','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/18/2024','nama' => 'Roda Kereta Rubber','spesifikasi' => '∅ 4 inch fix','jumlah' => '2','satuan' => 'un','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/18/2024','nama' => 'Cat Hitam','spesifikasi' => '@ 0,85 L','jumlah' => '5','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/18/2024','nama' => 'Thinner Impala','spesifikasi' => '1 L','jumlah' => '2','satuan' => 'L','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '9/18/2024','nama' => 'Electroda','spesifikasi' => '5 Kg','jumlah' => '1','satuan' => 'box','seksi' => null, 'movement_type' => 'jo'],
            ['tanggal' => '10/1/2024','nama' => 'Besi Hollow','spesifikasi' => '40x40x2.8 mm','jumlah' => '2','satuan' => 'btg','seksi' => null, 'movement_type' => 'jo'],

            // MEMO (movement_type = 'memo')
            ['tanggal' => '9/20/2024','nama' => 'Hardener','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pail','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Cat Hijau Lantai','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pail','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Kuas roll cat besar','spesifikasi' => null,'jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Kuas roll cat kecil','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'List Putih','spesifikasi' => null,'jumlah' => '1','satuan' => 'Liter','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Cat Putih','spesifikasi' => null,'jumlah' => '2','satuan' => 'Liter','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Cat Mist Blue','spesifikasi' => null,'jumlah' => '5','satuan' => 'Kg','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Cat Putih','spesifikasi' => null,'jumlah' => '3','satuan' => 'Kaleng','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Cat Mist Blue','spesifikasi' => null,'jumlah' => '2','satuan' => 'Liter','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Cat Golden Yellow','spesifikasi' => null,'jumlah' => '1','satuan' => 'Kaleng','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Acrylic','spesifikasi' => null,'jumlah' => '1','satuan' => 'Lbr','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Cat Mist Blue','spesifikasi' => null,'jumlah' => '1','satuan' => 'Can','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Acrylic Transparan','spesifikasi' => null,'jumlah' => '1','satuan' => 'Lbr','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Cat List Putih','spesifikasi' => null,'jumlah' => '3','satuan' => 'Can','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Kuas roll cat besar','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/19/2024','nama' => 'Besi Siku','spesifikasi' => '4x4','jumlah' => '1','satuan' => 'Btg','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Besi Siku','spesifikasi' => '4x4','jumlah' => '3','satuan' => 'Btg','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/20/2024','nama' => 'Cat Tembok Vita Cream','spesifikasi' => null,'jumlah' => '1','satuan' => 'Kaleng','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/13/2024','nama' => 'Acrylic Bening','spesifikasi' => null,'jumlah' => '2','satuan' => 'Lbr','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/13/2024','nama' => 'Kuas roll cat besar','spesifikasi' => null,'jumlah' => '4','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/13/2024','nama' => 'Kuas roll cat kecil','spesifikasi' => null,'jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/13/2024','nama' => 'Cat Putih','spesifikasi' => null,'jumlah' => '2','satuan' => 'Kaleng','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/12/2024','nama' => 'Frame Stand Stainless','spesifikasi' => null,'jumlah' => '2','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/10/2024','nama' => 'List Putih','spesifikasi' => null,'jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/4/2024','nama' => 'Alumunium Profile','spesifikasi' => null,'jumlah' => '5','satuan' => 'Btg','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '9/3/2024','nama' => 'Dynabolt','spesifikasi' => 'M8','jumlah' => 'Seadanya','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Plat Bordesk Stainless Steel','spesifikasi' => null,'jumlah' => '10','satuan' => 'Lbr','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Fisher','spesifikasi' => 'S8','jumlah' => '5','satuan' => 'Pac','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Screw Tapping','spesifikasi' => '10x2 Inch','jumlah' => '200','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Mata Gerinda Potong','spesifikasi' => null,'jumlah' => '4','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Alumunium Profile','spesifikasi' => null,'jumlah' => '4','satuan' => 'Btg','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Besi Hollow','spesifikasi' => '4x4x4','jumlah' => '4','satuan' => 'Btg','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/30/2024','nama' => 'Besi Hollow','spesifikasi' => '40x40','jumlah' => '3','satuan' => 'Btg','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/30/2024','nama' => 'Besi Siku','spesifikasi' => null,'jumlah' => '3','satuan' => 'Btg','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/30/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '4','satuan' => 'Can','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/30/2024','nama' => 'Cat Blue','spesifikasi' => null,'jumlah' => '1','satuan' => 'Can','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/30/2024','nama' => 'Impraboard','spesifikasi' => null,'jumlah' => '5','satuan' => 'Lbr','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/30/2024','nama' => 'Plat Stripe','spesifikasi' => null,'jumlah' => '1','satuan' => 'Btg','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/30/2024','nama' => 'List Putih','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/30/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '2','satuan' => 'Liter','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/30/2024','nama' => 'List Putih','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '2','satuan' => 'Liter','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Besi Hollow','spesifikasi' => null,'jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Besi Siku','spesifikasi' => null,'jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/28/2024','nama' => 'Cat Mist Blue','spesifikasi' => null,'jumlah' => '1','satuan' => 'Can','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/27/2024','nama' => 'Fisher & screw','spesifikasi' => null,'jumlah' => '50','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/23/2024','nama' => 'Kereta Trolly Krisbow','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/23/2024','nama' => 'Lemari File Besar','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Kereta Trolly Krisbow','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Kereta Barang','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Hand Truck Trolly','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Fisher Plastic','spesifikasi' => 'S8','jumlah' => '500','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Skrup Fisher','spesifikasi' => 'S8','jumlah' => '500','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Kereta Roda Prestar','spesifikasi' => null,'jumlah' => '2','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Kereta Dorong','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Kereta Trolly Krisbow','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/21/2024','nama' => 'Kereta Trolly Krisbow','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Kereta Dorong','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Kereta Dorong','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/22/2024','nama' => 'Kereta Dorong','spesifikasi' => null,'jumlah' => '1','satuan' => 'Un','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/20/2024','nama' => 'Acrylic Bening','spesifikasi' => '3mm 2.4m x 1.2m','jumlah' => '1','satuan' => 'Lbr','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Plat Bordesk Stainless Steel','spesifikasi' => null,'jumlah' => '7','satuan' => 'Lbr','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Hijau','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pile','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/16/2024','nama' => 'Cat Mist Blue','spesifikasi' => null,'jumlah' => '2','satuan' => 'Can','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/16/2024','nama' => 'Cat Putih','spesifikasi' => null,'jumlah' => '7','satuan' => 'Liter','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/16/2024','nama' => 'Thinner','spesifikasi' => null,'jumlah' => '3','satuan' => 'Liter','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/16/2024','nama' => 'Cat Hijau Lantai','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pail','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/16/2024','nama' => 'Cat Hitam','spesifikasi' => null,'jumlah' => '1','satuan' => 'Can','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/16/2024','nama' => 'Thinner Impala','spesifikasi' => null,'jumlah' => '4','satuan' => 'Can','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/16/2024','nama' => 'Kuas roll cat besar','spesifikasi' => null,'jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/16/2024','nama' => 'Papan Mesin Nama Kosong','spesifikasi' => null,'jumlah' => '13','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/16/2024','nama' => 'Acrylic Transparan','spesifikasi' => null,'jumlah' => '1','satuan' => 'Lbr','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Lantai Yellow Epoxy','spesifikasi' => 'T05 1482 - 13014','jumlah' => '1','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Lantai Green Epoxy','spesifikasi' => 'T05 1482 - 64015','jumlah' => '5','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Epoxy Dark Grey','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pail','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Warna Hitam','spesifikasi' => '3.8 kg/Galon Platone','jumlah' => '5','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Golden Yellow','spesifikasi' => '803 Platone','jumlah' => '5','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Mist Blue','spesifikasi' => '3.785 L/Galon','jumlah' => '10','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Putih','spesifikasi' => null,'jumlah' => '20','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Cat Tahan Panas + Thinner','spesifikasi' => null,'jumlah' => '5','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Kuas roll cat kecil','spesifikasi' => null,'jumlah' => '6','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Bulu Kuas Roll Cat Kecil','spesifikasi' => null,'jumlah' => '6','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Kuas roll cat besar','spesifikasi' => null,'jumlah' => '2','satuan' => null,'seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Kunci Pas 67','spesifikasi' => null,'jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Tap Drill','spesifikasi' => '8mm','jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Tap Drill','spesifikasi' => '6mm','jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Poly Box No.222 Rabbit','spesifikasi' => null,'jumlah' => '12','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Poly Box No.333 Rabbit','spesifikasi' => null,'jumlah' => '9','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Kunci Ring Pas 41 Facom','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Kunci Pipa 15 inch','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Kunci Inggris 15 inch','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Kunci Shock 30mm','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Kunci Ring Pas 30mm','spesifikasi' => null,'jumlah' => '1','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Kunci Pas 60','spesifikasi' => null,'jumlah' => '2','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
            ['tanggal' => '8/19/2024','nama' => 'Plat Bordes','spesifikasi' => null,'jumlah' => '25','satuan' => 'Pcs','seksi' => null, 'movement_type' => 'memo'],
        ];

        foreach ($rows as $row) {
            // Attempt to find or create the material (case-insensitive name match)
            $material = Material::whereRaw('LOWER(nama) = ?', [strtolower($row['nama'])])->first();

            if (! $material) {
                $satuan = null;
                if (! empty($row['satuan'])) {
                    $satuanName = strtolower(trim($row['satuan']));
                    // Satuan model uses 'name' column
                    $satuan = Satuan::whereRaw('LOWER(name) = ?', [$satuanName])->first();
                    // If satuan doesn't exist yet, create it to keep seeder idempotent
                    if (! $satuan) {
                        $satuan = Satuan::create(['name' => $row['satuan']]);
                    }
                }

                $material = Material::create([
                    'nama' => $row['nama'],
                    'spesifikasi' => $row['spesifikasi'] ?? null,
                    'jumlah' => 0,
                    'safety_stock' => 0,
                    'satuan_id' => $satuan ? $satuan->id : null,
                    'kategori_id' => null,
                    'notes' => null,
                ]);
            }

            // Normalize jumlah to decimal (replace commas)
            $rawJumlah = trim((string)($row['jumlah'] ?? ''));
            $normalized = str_replace([','], ['.'], $rawJumlah);
            // If numeric after normalization, cast; otherwise set 0 and record in keterangan
            if (is_numeric($normalized)) {
                $jumlah = (float) $normalized;
            } else {
                $jumlah = 0;
            }

            // Parse tanggal (month/day/year provided)
            try {
                $tanggal = Carbon::createFromFormat('n/j/Y', $row['tanggal'])->toDateString();
            } catch (\Exception $e) {
                // Try d/m/Y as fallback
                $tanggal = Carbon::createFromFormat('d/m/Y', $row['tanggal'])->toDateString();
            }

            // Append jumlah text to keterangan if original jumlah was non-numeric
            $keterangan = $row['spesifikasi'] ?? null;
            if (! is_numeric($normalized) && ! empty($rawJumlah)) {
                $keterangan = trim(($keterangan ? $keterangan . ' | ' : '') . 'jumlah: ' . $rawJumlah);
            }

            MaterialMovement::create([
                'material_id' => $material->id,
                'type' => 'out', // assuming these are usages (out)
                'tanggal' => $tanggal,
                'jumlah' => $jumlah,
                'seksi' => $row['seksi'] ?? null,
                'safety_stock' => null,
                'movement_type' => $row['movement_type'] ?? 'other',
                'keterangan' => $keterangan,
            ]);
        }
    }
}