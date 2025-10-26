<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Material;
use App\Models\Satuan;
use Carbon\Carbon;

class MaterialStockInSeeder extends Seeder
{
    /**
     * Seed historical "stok masuk" movements without triggering model events.
     * This seeder inserts directly into the material_movements table to avoid
     * calling the MaterialMovement model boot hooks that would recalculate/persist
     * current stock on materials.
     */
    public function run(): void
    {
        // rows provided by the user (No, Tanggal, Material, Spesifikasi, Jumlah, Satuan)
        $rows = [
            ['tanggal' => '8/22/2024',  'nama' => 'Besi Hollow', 'spesifikasi' => '40x40x2.8 mm', 'jumlah' => 57, 'satuan' => 'btg'],
            ['tanggal' => '12/12/2024', 'nama' => 'Behel',        'spesifikasi' => '4 mm',         'jumlah' => 23, 'satuan' => 'btg'],
            ['tanggal' => '12/12/2024', 'nama' => 'Besi Hollow', 'spesifikasi' => '40x40x2.8 mm', 'jumlah' => 23, 'satuan' => 'btg'],
            ['tanggal' => '30/09/2024', 'nama' => 'Besi Behel',  'spesifikasi' => '8mm',          'jumlah' => 2,  'satuan' => 'btg'],
            ['tanggal' => '10/1/2024',  'nama' => 'Besi Hollow', 'spesifikasi' => '40x40x2.8 mm', 'jumlah' => 3,  'satuan' => 'btg'],
            ['tanggal' => '10/2/2024',  'nama' => 'besi cicak', 'spesifikasi' => '30 mm',        'jumlah' => 2,  'satuan' => 'btg'],
        ];

        // Ensure satuan exists (btg)
        $satuan = Satuan::firstOrCreate(['name' => 'btg']);

        foreach ($rows as $row) {
            // robust date parsing: try common formats
            $tanggal = $this->parseDate($row['tanggal']);
            if (! $tanggal) {
                // skip invalid date rows to avoid seeder failure
                $this->command->warn("Skipping row with invalid date: {$row['tanggal']}");
                continue;
            }

            $nama = trim($row['nama']);
            $spesifikasi = trim($row['spesifikasi'] ?? '');
            $jumlah = (int) $row['jumlah'];

            // find or create material (do not set jumlah here to historical values to avoid interfering)
            $material = Material::firstWhere([
                'nama' => $nama,
                'spesifikasi' => $spesifikasi,
            ]);

            if (! $material) {
                $material = Material::create([
                    'nama' => $nama,
                    'spesifikasi' => $spesifikasi,
                    'jumlah' => 0, // base jumlah left at 0 so historical movements are additive
                    'safety_stock' => 0,
                    'satuan_id' => $satuan->id,
                    'kategori_id' => null,
                ]);
                $this->command->info("Created material: {$nama} ({$spesifikasi})");
            }

            // Idempotency: skip if identical movement already exists
            $exists = DB::table('material_movements')
                ->where('material_id', $material->id)
                ->where('type', 'in')
                ->where('tanggal', $tanggal->toDateString())
                ->where('jumlah', $jumlah)
                ->exists();

            if ($exists) {
                $this->command->info("Skipping existing movement for {$nama} on {$tanggal->toDateString()} ({$jumlah})");
                continue;
            }

            // Insert directly to avoid triggering model events
            DB::table('material_movements')->insert([
                'material_id' => $material->id,
                'type' => 'in',
                'tanggal' => $tanggal->toDateString(),
                'jumlah' => $jumlah,
                'seksi' => null,
                'safety_stock' => null,
                'movement_type' => 'other',
                'keterangan' => 'Seeder: stok masuk historis',
                'created_at' => $tanggal->setTime(8, 0, 0)->toDateTimeString(),
                'updated_at' => $tanggal->setTime(8, 0, 0)->toDateTimeString(),
            ]);

            $this->command->info("Inserted stok masuk for {$nama} on {$tanggal->toDateString()} ({$jumlah})");
        }
    }

    /**
     * Try multiple date formats to parse mixed-format inputs
     */
    protected function parseDate(string $value): ?Carbon
    {
        $formats = ['d/m/Y', 'j/n/Y', 'n/j/Y', 'd-m-Y', 'Y-m-d'];

        foreach ($formats as $fmt) {
            try {
                return Carbon::createFromFormat($fmt, $value)->startOfDay();
            } catch (\Exception $e) {
                // try next
            }
        }

        // final fallback to generic parser
        try {
            return Carbon::parse($value)->startOfDay();
        } catch (\Exception $e) {
            return null;
        }
    }
}
