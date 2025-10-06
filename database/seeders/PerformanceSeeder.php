<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Performance;
use App\Models\Manpower;
use App\Models\JobOrder;
use Carbon\Carbon;

class PerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Performance dari tabel yang diberikan
        // Format: NRP, Nama, Job Order ID/Project, Checklist (10 kolom o), Percentage
        // Catatan: Data menggunakan Job Order yang ada di database (17 job orders)
        
        $performanceData = [
            // M. Rizki Darmawan - Job Order pertama (50%)
            [
                'nrp' => '114380',
                'job_order_id' => 1, // JO #1: Cover Mini Excavator
                'tanggal' => '2024-07-15',
                'checklist' => [1, 0, 1, 1, 1, 1, 0, 0, 0, 0], // 5 dari 10 = 50%
                'percentage' => 50
            ],
            
            // Didit Junianto - Job Order #2 (20%)
            [
                'nrp' => '104484',
                'job_order_id' => 2, // JO #2
                'tanggal' => '2024-07-20',
                'checklist' => [0, 0, 1, 1, 0, 0, 0, 0, 0, 0], // 2 dari 10 = 20%
                'percentage' => 20
            ],
            
            // Yongki Adi Saputra - Job Order #3 (50%)
            [
                'nrp' => '126545',
                'job_order_id' => 3, // JO #3
                'tanggal' => '2024-08-10',
                'checklist' => [0, 0, 1, 0, 1, 1, 1, 1, 0, 0], // 5 dari 10 = 50%
                'percentage' => 50
            ],
            
            // Dennis Alfiansyah - Job Order #4 (30%)
            [
                'nrp' => '126521',
                'job_order_id' => 4, // JO #4
                'tanggal' => '2024-08-15',
                'checklist' => [0, 0, 0, 0, 0, 1, 1, 1, 0, 0], // 3 dari 10 = 30%
                'percentage' => 30
            ],
            
            // Rifki Andi Fahrezi - Job Order #5 (70%)
            [
                'nrp' => '126546',
                'job_order_id' => 5, // JO #5: Pembuatan Siku Tembok Area Painting Steel CED
                'tanggal' => '2024-08-20',
                'checklist' => [0, 1, 1, 0, 1, 1, 1, 1, 1, 0], // 7 dari 10 = 70%
                'percentage' => 70
            ],
            
            // M. Rizki Darmawan - Job Order #5 (30%)
            [
                'nrp' => '114380',
                'job_order_id' => 5, // JO #5: Pembuatan Siku Tembok Area Painting Steel CED
                'tanggal' => '2024-08-22',
                'checklist' => [0, 0, 0, 0, 0, 0, 1, 1, 1, 0], // 3 dari 10 = 30%
                'percentage' => 30
            ],
            
            // Didit Junianto - Job Order #5 (50%)
            [
                'nrp' => '104484',
                'job_order_id' => 5, // JO #5: Pembuatan Siku Tembok Area Painting Steel CED
                'tanggal' => '2024-08-23',
                'checklist' => [0, 1, 1, 1, 0, 0, 0, 1, 1, 0], // 5 dari 10 = 50%
                'percentage' => 50
            ],
        ];

        foreach ($performanceData as $data) {
            // Cari manpower berdasarkan NRP
            $manpower = Manpower::where('nrp', $data['nrp'])->first();
            
            if (!$manpower) {
                $this->command->warn("Manpower dengan NRP {$data['nrp']} tidak ditemukan, skip.");
                continue;
            }

            // Cari job order
            $jobOrder = JobOrder::find($data['job_order_id']);
            
            if (!$jobOrder) {
                $this->command->warn("Job Order ID {$data['job_order_id']} tidak ditemukan, skip.");
                continue;
            }

            // Hitung score dari checklist (10 checklist items)
            $checklistValues = $data['checklist'];
            $score = ($data['percentage'] / 100) * 100; // Convert percentage to score
            
            // Tentukan rating berdasarkan score
            $rating = $this->determineRating($score);

            // Create performance record
            Performance::create([
                'manpower_id' => $manpower->id,
                'job_order_id' => $jobOrder->id,
                'tanggal' => $data['tanggal'],
                // 10 checklist items
                'material_sesuai_jo' => (bool) $checklistValues[0],
                'dimensi_sesuai_jo' => (bool) $checklistValues[1],
                'item_sesuai_design' => (bool) $checklistValues[2],
                'pengelasan_tidak_retak' => (bool) $checklistValues[3],
                'item_bebas_spatter' => (bool) $checklistValues[4],
                'baut_terpasang_baik_lengkap' => (bool) $checklistValues[5],
                'tidak_ada_bagian_tajam' => (bool) $checklistValues[6],
                'finishing_standar' => (bool) $checklistValues[7],
                'tidak_ada_kotoran' => (bool) $checklistValues[8],
                'berfungsi_dengan_baik' => (bool) $checklistValues[9],
                'score' => $score,
                'rating' => $rating,
            ]);

            $this->command->info("✓ Performance untuk {$manpower->nama} (NRP: {$manpower->nrp}) - Job Order #{$jobOrder->id} berhasil dibuat");
        }

        $this->command->info("\n=== Performance Seeder Selesai ===");
        $this->command->info("Total: " . count($performanceData) . " performance records");
    }

    /**
     * Determine rating based on score
     */
    private function determineRating($score)
    {
        if ($score >= 90) return 'Excellent';
        if ($score >= 80) return 'Very Good';
        if ($score >= 70) return 'Good';
        if ($score >= 60) return 'Satisfactory';
        if ($score >= 50) return 'Fair';
        return 'Poor';
    }
}
