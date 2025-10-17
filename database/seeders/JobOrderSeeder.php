<?php

namespace Database\Seeders;

use App\Models\JobOrder;
use App\Models\JobOrderItem;
use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Job Order Headers dengan informasi lengkap
        $jobOrders = [
            [
                'no' => 1,
                'seksi' => 'Gensub',
                'status' => 'Urgent',
                'project' => 'Pembuatan Shutter Visor dan Bracket Plate Number L Area Gensub',
                'start' => '12-Agu-24',
                'end' => '22-Agu-24',
                'progress' => 100,
                'actual' => '22-Agu-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 2,
                'seksi' => 'Assy Unit',
                'status' => 'Medium',
                'project' => 'Pembuatan Tiang Sign Penyebrangan Perlintasan',
                'start' => '13-Agu-24',
                'end' => '15-Agu-24',
                'progress' => 30,
                'actual' => '15-Agu-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 3,
                'seksi' => 'Assy Unit',
                'status' => 'Urgent',
                'project' => 'Pembuatan Tiang Sign Larangan Turun Tangga VIP',
                'start' => '13-Agu-24',
                'end' => '17-Agu-24',
                'progress' => 70,
                'actual' => '17-Agu-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 4,
                'seksi' => 'Assy Unit',
                'status' => 'Medium',
                'project' => 'Pembuatan Tiang Sign Himbauan Safety Menaiki Tangga 18 Set',
                'start' => '13-Agu-24',
                'end' => '20-Agu-24',
                'progress' => 20,
                'actual' => '20-Agu-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 5,
                'seksi' => 'Painting Steel',
                'status' => 'Low',
                'project' => 'Pembuatan Siku Tembok Area Painting Steel CED',
                'start' => '15-Agu-24',
                'end' => '18-Agu-24',
                'progress' => 10,
                'actual' => '20-Agu-24',
                'evaluasi' => 'Terlambat',
            ],
            [
                'no' => 6,
                'seksi' => 'Assy Unit',
                'status' => 'Medium',
                'project' => 'Pembuatan Guarding Area Safety Net Area Cluster R1 dan Area Cluster L2 Assy Unit',
                'start' => '19-Agu-24',
                'end' => '22-Agu-24',
                'progress' => 50,
                'actual' => '22-Agu-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 7,
                'seksi' => 'Gensub',
                'status' => 'Low',
                'project' => 'Perapihan Kabel',
                'start' => '22-Agu-24',
                'end' => '25-Agu-24',
                'progress' => 10,
                'actual' => '25-Agu-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 8,
                'seksi' => 'Welding',
                'status' => 'Low',
                'project' => 'Pemasang Guarding Siku di H-biem',
                'start' => '4-Sep-24',
                'end' => '9-Sep-24',
                'progress' => 25,
                'actual' => '9-Sep-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 9,
                'seksi' => 'Gensub',
                'status' => 'Urgent',
                'project' => 'Tangga Pijakan Cleaning Layer Marshall',
                'start' => '5-Sep-24',
                'end' => '8-Sep-24',
                'progress' => 100,
                'actual' => '8-Sep-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 10,
                'seksi' => 'Gensub',
                'status' => 'Medium',
                'project' => 'Modifikasi Meja Transfer Cover Body',
                'start' => '5-Sep-24',
                'end' => '8-Sep-24',
                'progress' => 100,
                'actual' => '8-Sep-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 11,
                'seksi' => 'Welding',
                'status' => 'Medium',
                'project' => 'Pembuatan Lemari Penyimpanan Cat',
                'start' => '12-Sep-24',
                'end' => '13-Sep-24',
                'progress' => 80,
                'actual' => '13-Sep-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 12,
                'seksi' => 'Gensub',
                'status' => 'Urgent',
                'project' => 'Pembuatan Stoper Kereta Cushion dan Kereta Wheel',
                'start' => '17-Sep-24',
                'end' => '19-Sep-24',
                'progress' => 67,
                'actual' => '19-Sep-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 13,
                'seksi' => 'Gensub',
                'status' => 'Low',
                'project' => 'Pembuatan Stoper Kereta ABS Fr Side',
                'start' => '17-Sep-24',
                'end' => '20-Sep-24',
                'progress' => 30,
                'actual' => '20-Sep-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 14,
                'seksi' => 'Gensub',
                'status' => 'Medium',
                'project' => 'Pembuatan Stoper Kereta ABS CB',
                'start' => '17-Sep-24',
                'end' => '21-Sep-24',
                'progress' => 79,
                'actual' => '22-Sep-24',
                'evaluasi' => 'Terlambat',
            ],
            [
                'no' => 15,
                'seksi' => 'Gensub',
                'status' => 'High',
                'project' => 'Pembuatan Safety Heaader Angin',
                'start' => '17-Sep-24',
                'end' => '22-Sep-24',
                'progress' => 100,
                'actual' => '22-Sep-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 16,
                'seksi' => 'Gensub',
                'status' => 'High',
                'project' => 'Pembuatan Stoper Kereta Double Seat',
                'start' => '17-Sep-24',
                'end' => '22-Sep-24',
                'progress' => 100,
                'actual' => '22-Sep-24',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 17,
                'seksi' => 'Assy Engine',
                'status' => 'Low',
                'project' => 'Tangan 4K+S',
                'start' => '18-Sep-24',
                'end' => '25-Sep-24',
                'progress' => 0,
                'actual' => '28-Sep-24',
                'evaluasi' => 'Terlambat',
            ],
        ];

        // Material Items per Project
        $materialItems = [
            // Project 1
            [1, 'Besi Siku', '40x40x4 mm', 9, 'btg'],
            [1, 'Besi Hollow', '40x40x4 mm', 12, 'btg'],
            [1, 'Placoon Roll', '', 8, 'btg'],
            [1, 'Cat Mist Blue', '', 3, 'L'],
            [1, 'Thinner', '', 3, 'L'],
            [1, 'Besi Behel', '', 2, 'btg'],

            // Project 2
            [2, 'Besi Hollow', '40x40x20 mm', 4, 'btg'],

            // Project 3
            [3, 'Cat Hitam', '', 5, 'kg'],

            // Project 4
            [4, 'Thinner', '', 15, 'L'],
            [4, 'Acrylic Bening', '3 mm', 4, 'lbr'],
            [4, 'Dynabolt', '10 mm', 10, 'pcs'],
            [4, 'Besi Behel', '10 mm', 6, 'btg'],
            [4, 'Besi Siku', '40x40x4 mm', 2, 'btg'],

            // Project 5
            [5, 'Besi Siku', '40x40x4mm', 20, 'btg'],
            [5, 'Fisher', '8', 100, 'pcs'],
            [5, 'Baut Fisher', '8', 100, 'pcs'],
            [5, 'Cat Golden Yellow', '', 5, 'kg'],

            // Project 6
            [6, 'Besi Hollow', '40x40x20 mm', 15, 'btg'],
            [6, 'Besi Siku', '40x40x12 mm', 8, 'btg'],
            [6, 'Thinner', '', 25, 'L'],
            [6, 'Acrylic Bening', '', 3, 'lbr'],
            [6, 'Cat Golden Yellow', '', 20, 'kg'],
            [6, 'Cat Hitam', '', 5, 'kg'],
            [6, 'Plat Ezer', '1,2 mm', 2, 'lbr'],

            // Project 7
            [7, 'Tray Kabel', '', 15, 'M'],
            [7, 'Tali TIS / cable TIS', '', 3, 'ktg'],

            // Project 8
            [8, 'Besi Siku', '4 cm', 5, 'btg'],

            // Project 9
            [9, 'Besi Hollow', '40x40x4 mm', 3, 'btg'],
            [9, 'Plat Besi', '3 mm', 1, 'btg'],
            [9, 'Electroda', '', 5, 'kg'],
            [9, 'Cat Mist Blue', '', 3, 'L'],
            [9, 'Thinner', '', 3, 'L'],
            [9, 'Mata Cutting Wheel', '', 1, 'pcs'],
            [9, 'Mata Gerinda Potong', '', 8, 'pcs'],

            // Project 10
            [10, 'Besi Hollow', '40x40x4 mm', 12, 'btg'],
            [10, 'Cat Mist Blue', '', 4, 'L'],
            [10, 'Thinner', '', 1, 'L'],
            [10, 'Mata Gerinda Potong', '', 3, 'pcs'],
            [10, 'Mata Gerinda Halus', '', 3, 'pcs'],
            [10, 'Mata Cutting Wheel', '', 1, 'pcs'],
            [10, 'Besi Siku', '40x40x4 mm', 3, 'btg'],
            [10, 'Besi Henderson', '', 1, 'btg'],
            [10, 'Electroda', '', 5, 'kg'],

            // Project 11
            [11, 'Besi Hollow', '', 5, 'btg'],

            // Project 12
            [12, 'Besi Siku', '40x40x4 mm', 2, 'btg'],
            [12, 'Cat Hitam', '', 2, 'L'],
            [12, 'Cat Kuning', '', 2, 'L'],
            [12, 'Thinner', '', 1, 'pcs'],
            [12, 'Mata Gerinda Potong', '', 4, 'pcs'],
            [12, 'Mata Cutting Wheel', '', 1, 'pcs'],
            [12, 'Electroda', '', 4, 'kg'],

            // Project 13
            [13, 'Besi Siku', '40x40x4 mm', 1, 'btg'],
            [13, 'Cat Hitam', '', 1, 'L'],
            [13, 'Cat Kuning', '', 1, 'L'],
            [13, 'Thinner', '', 0.5, 'pcs'],
            [13, 'Mata Gerinda Potong', '', 2, 'pcs'],
            [13, 'Mata Cutting Wheel', '', 0.5, 'pcs'],
            [13, 'Electroda', '', 1, 'kg'],

            // Project 14
            [14, 'Besi Siku', '40x40x4 mm', 1, 'btg'],
            [14, 'Cat Hitam', '', 1, 'L'],
            [14, 'Cat Kuning', '', 1, 'L'],
            [14, 'Thinner', '', 0.5, 'pcs'],
            [14, 'Mata Gerinda Potong', '', 2, 'pcs'],
            [14, 'Mata Cutting Wheel', '', 0.5, 'pcs'],
            [14, 'Electroda', '', 1, 'kg'],

            // Project 15
            [15, 'Besi Hollow', '40x40x4 mm', 2, 'btg'],
            [15, 'Cat Hitam', '', 2, 'L'],
            [15, 'Cat Kuning', '', 2, 'L'],
            [15, 'Thinner', '', 1, 'pcs'],
            [15, 'Mata Gerinda Potong', '', 3, 'pcs'],
            [15, 'Mata Cutting Wheel', '', 0.5, 'pcs'],
            [15, 'Plat Besi', '', 1, 'lbr'],
            [15, 'Electroda', '', 2, 'kg'],

            // Project 16
            [16, 'Besi Siku', '40x40x4 mm', 1, 'btg'],
            [16, 'Cat Hitam', '', 1, 'L'],
            [16, 'Cat Kuning', '', 1, 'L'],
            [16, 'Thinner', '', 0.5, 'pcs'],
            [16, 'Mata Gerinda Potong', '', 2, 'pcs'],
            [16, 'Mata Cutting Wheel', '', 0.5, 'pcs'],
            [16, 'Electroda', '', 1, 'kg'],

            // Project 17
            [17, 'Besi Hollow', '40x40x2,8 mm', 15, 'btg'],
            [17, 'Plat Ezer', '1,2 mm', 1, 'lbr'],
            [17, 'Besi Behel', '∅ 10 mm @ 12 mm', 2, 'btg'],
            [17, 'Roda Kereta Rubber', '∅ 4 inch swivel', 2, 'un'],
            [17, 'Roda Kereta Rubber', '∅ 4 inch fix', 2, 'un'],
            [17, 'Cat Hitam', '@ 0,85 L', 5, 'L'],
            [17, 'Thinner Impala', '1 L', 2, 'L'],
            [17, 'Electroda', '5 Kg', 1, 'box'],
        ];

        // Group material items by project number
        $groupedItems = [];
        foreach ($materialItems as [$no, $material, $spec, $qty, $unit]) {
            if (!isset($groupedItems[$no])) {
                $groupedItems[$no] = [];
            }
            $groupedItems[$no][] = [
                'material' => trim($material),
                'spesifikasi' => trim((string)$spec),
                'jumlah' => $qty,
                'satuan' => trim((string)$unit),
            ];
        }


        DB::transaction(function() use ($jobOrders, $groupedItems) {
            foreach ($jobOrders as $joData) {
                $no = $joData['no'];
                // Simpan ke database dengan format dd-mm-yyyy (sesuai permintaan user)
                $start = $this->convertDateDMY($joData['start']);
                $end = $this->convertDateDMY($joData['end']);
                $actual = $this->convertDateDMY($joData['actual']);

                // Create Job Order
                $jo = JobOrder::create([
                    'seksi' => $joData['seksi'],
                    'status' => $joData['status'],
                    'project' => $joData['project'],
                    'start' => $start,
                    'end' => $end,
                    'progress' => $joData['progress'],
                    'actual' => $actual,
                    'evaluasi' => $joData['evaluasi'],
                ]);

                // Add materials if exists for this project
                if (isset($groupedItems[$no])) {
                    foreach ($groupedItems[$no] as $item) {
                        // Handle fractional quantities
                        $jumlahRaw = $item['jumlah'];
                        $jumlah = null;
                        $fractionNote = '';

                        if (is_numeric($jumlahRaw)) {
                            $jumlahFloat = (float)$jumlahRaw;
                            $jumlah = (int) ceil($jumlahFloat);

                            // Add note if quantity is fractional
                            if (abs($jumlahFloat - floor($jumlahFloat)) > 0.00001) {
                                $fractionNote = ' (qty: ' . str_replace('.', ',', (string)$jumlahFloat) . ')';
                            }
                        }

                        // Find or create material
                        $matName = $this->normalizeMaterialName($item['material']);
                        $material = Material::firstOrCreate(
                            ['nama' => $matName],
                            [
                                'spesifikasi' => null,
                                'jumlah' => 0,
                                'safety_stock' => 0,
                                'satuan_id' => null,
                                'kategori_id' => null,
                            ]
                        );

                        // Create job order item
                        JobOrderItem::create([
                            'job_order_id' => $jo->id,
                            'material_id' => $material->id,
                            'spesifikasi' => trim(($item['spesifikasi'] ?: '') . $fractionNote) ?: null,
                            'jumlah' => $jumlah,
                            'satuan' => $item['satuan'] ?: null,
                        ]);
                    }
                }
            }
        });
    }

    /**
     * Convert date from DD-MMM-YY format to YYYY-MM-DD
     */
    private function convertDate(string $date): string
    {
        $months = [
            'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
            'Mei' => '05', 'Jun' => '06', 'Jul' => '07', 'Agu' => '08',
            'Sep' => '09', 'Okt' => '10', 'Nov' => '11', 'Des' => '12',
        ];
        // Parse format DD-MMM-YY (e.g., 12-Agu-24)
        $parts = explode('-', $date);
        if (count($parts) === 3) {
            $day = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
            $month = $months[$parts[1]] ?? '01';
            $year = '20' . $parts[2]; // Assuming 20xx century
            return "$year-$month-$day";
        }
        return date('Y-m-d'); // Fallback to today
    }

    /**
     * Convert date from DD-MMM-YY format to DD-MM-YYYY
     */
    private function convertDateDMY(string $date): string
    {
        $months = [
            'Jan' => '01', 'Feb' => '02', 'Mar' => '03', 'Apr' => '04',
            'Mei' => '05', 'Jun' => '06', 'Jul' => '07', 'Agu' => '08',
            'Sep' => '09', 'Okt' => '10', 'Nov' => '11', 'Des' => '12',
        ];
        $parts = explode('-', $date);
        if (count($parts) === 3) {
            $day = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
            $month = $months[$parts[1]] ?? '01';
            $year = '20' . $parts[2];
            return "$day-$month-$year";
        }
        return date('d-m-Y');
    }

    private function normalizeMaterialName(string $name): string
    {
        $name = trim($name);
        // Unify common variations
        $map = [
            'Besi Siku ' => 'Besi Siku',
            'Baut Fisher' => 'Baut Fischer', // assume variant
            'Fisher' => 'Fischer',
            'Cat Mist Blue' => 'Cat Mist Blue',
            'Cat Hitam' => 'Cat Hitam',
            'Cat Golden Yellow' => 'Cat Golden Yellow',
            'Thinner Impala' => 'Thinner Impala',
        ];
        // fix double spaces & trim
        $name = preg_replace('/\s+/', ' ', $name);
        return $map[$name] ?? $name;
    }
}