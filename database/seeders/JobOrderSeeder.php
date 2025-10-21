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
        // Job Order Headers dengan informasi lengkap (17 existing + 13 random baru hingga 30)
        $jobOrders = [
            // 17 Existing (tidak diubah)
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
            // 13 Baru (random berdasarkan pola existing)
            [
                'no' => 18,
                'seksi' => 'Welding',
                'status' => 'Low',
                'project' => 'Pembuatan Lemari Guarding Siku di H-biem',
                'start' => '16-Nov-25',
                'end' => '29-Nov-25',
                'progress' => 38,
                'actual' => '29-Nov-25',
                'evaluasi' => 'Terlambat',
            ],
            [
                'no' => 19,
                'seksi' => 'Assy Unit',
                'status' => 'Urgent',
                'project' => 'Perapihan Cushion dan Kereta Wheel',
                'start' => '22-Des-25',
                'end' => '10-Okt-25',
                'progress' => 46,
                'actual' => '10-Okt-25',
                'evaluasi' => 'Terlambat',
            ],
            [
                'no' => 20,
                'seksi' => 'Gensub',
                'status' => 'Medium',
                'project' => 'Pembuatan Safety Header Angin',
                'start' => '06-Des-25',
                'end' => '21-Nov-25',
                'progress' => 17,
                'actual' => '21-Nov-25',
                'evaluasi' => 'Terlambat',
            ],
            [
                'no' => 21,
                'seksi' => 'Quality',
                'status' => 'Urgent',
                'project' => 'Pembuatan Stoper Kereta Area Safety Net Area Cluster R1 dan Area Cluster L2 Assy Unit',
                'start' => '15-Des-25',
                'end' => '15-Okt-25',
                'progress' => 54,
                'actual' => '15-Okt-25',
                'evaluasi' => 'Terlambat',
            ],
            [
                'no' => 22,
                'seksi' => 'Assy Engine',
                'status' => 'Low',
                'project' => 'Pembuatan Siku Area Gensub',
                'start' => '27-Okt-25',
                'end' => '30-Des-25',
                'progress' => 27,
                'actual' => '30-Des-25',
                'evaluasi' => 'Terlambat',
            ],
            [
                'no' => 23,
                'seksi' => 'Welding',
                'status' => 'Low',
                'project' => 'Pemasang Meja Transfer Cover Body',
                'start' => '06-Des-25',
                'end' => '06-Nov-25',
                'progress' => 32,
                'actual' => '26-Okt-25',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 24,
                'seksi' => 'Painting Steel',
                'status' => 'Medium',
                'project' => 'Pembuatan Tiang Sign Cushion dan Kereta Wheel',
                'start' => '13-Des-25',
                'end' => '30-Des-25',
                'progress' => 69,
                'actual' => '05-Nov-25',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 25,
                'seksi' => 'Painting Steel',
                'status' => 'High',
                'project' => 'Pembuatan Lemari Himbauan Safety Menaiki Tangga',
                'start' => '12-Des-25',
                'end' => '17-Des-25',
                'progress' => 73,
                'actual' => '17-Des-25',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 26,
                'seksi' => 'Gensub',
                'status' => 'Low',
                'project' => 'Pembuatan Guarding Siku Tembok Area Painting Steel CED',
                'start' => '29-Nov-25',
                'end' => '09-Nov-25',
                'progress' => 78,
                'actual' => '09-Nov-25',
                'evaluasi' => 'Terlambat',
            ],
            [
                'no' => 27,
                'seksi' => 'Quality',
                'status' => 'High',
                'project' => 'Pemasang Cleaning Layer Marshall',
                'start' => '11-Nov-25',
                'end' => '09-Okt-25',
                'progress' => 48,
                'actual' => '09-Okt-25',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 28,
                'seksi' => 'Painting Steel',
                'status' => 'High',
                'project' => 'Pemasang Guarding Siku di H-biem',
                'start' => '17-Okt-25',
                'end' => '05-Des-25',
                'progress' => 6,
                'actual' => '05-Des-25',
                'evaluasi' => 'Tepat Waktu',
            ],
            [
                'no' => 29,
                'seksi' => 'Painting Steel',
                'status' => 'Medium',
                'project' => 'Pembuatan Tiang Sign Penyebrangan Perlintasan',
                'start' => '10-Des-25',
                'end' => '17-Des-25',
                'progress' => 77,
                'actual' => '17-Des-25',
                'evaluasi' => 'Terlambat',
            ],
            [
                'no' => 30,
                'seksi' => 'Assy Unit',
                'status' => 'Low',
                'project' => 'Pembuatan Lemari Cushion dan Kereta Wheel',
                'start' => '23-Des-25',
                'end' => '09-Des-25',
                'progress' => 42,
                'actual' => '09-Des-25',
                'evaluasi' => 'Terlambat',
            ],
        ];

        // Material Items per Project (existing + random baru untuk 18-30)
        $materialItems = [
            // Existing untuk 1-17 (tidak diubah)
            [1, 'Besi Siku', '40x40x4 mm', 9, 'btg'],
            [1, 'Besi Hollow', '40x40x4 mm', 12, 'btg'],
            [1, 'Placoon Roll', '', 8, 'btg'],
            [1, 'Cat Mist Blue', '', 3, 'L'],
            [1, 'Thinner', '', 3, 'L'],
            [1, 'Besi Behel', '', 2, 'btg'],

            [2, 'Besi Hollow', '40x40x20 mm', 4, 'btg'],

            [3, 'Cat Hitam', '', 5, 'kg'],

            [4, 'Thinner', '', 15, 'L'],
            [4, 'Acrylic Bening', '3 mm', 4, 'lbr'],
            [4, 'Dynabolt', '10 mm', 10, 'pcs'],
            [4, 'Besi Behel', '10 mm', 6, 'btg'],
            [4, 'Besi Siku', '40x40x4 mm', 2, 'btg'],

            [5, 'Besi Siku', '40x40x4mm', 20, 'btg'],
            [5, 'Fisher', '8', 100, 'pcs'],
            [5, 'Baut Fisher', '8', 100, 'pcs'],
            [5, 'Cat Golden Yellow', '', 5, 'kg'],

            [6, 'Besi Hollow', '40x40x20 mm', 15, 'btg'],
            [6, 'Besi Siku', '40x40x12 mm', 8, 'btg'],
            [6, 'Thinner', '', 25, 'L'],
            [6, 'Acrylic Bening', '', 3, 'lbr'],
            [6, 'Cat Golden Yellow', '', 20, 'kg'],
            [6, 'Cat Hitam', '', 5, 'kg'],
            [6, 'Plat Ezer', '1,2 mm', 2, 'lbr'],

            [7, 'Tray Kabel', '', 15, 'M'],
            [7, 'Tali TIS / cable TIS', '', 3, 'ktg'],

            [8, 'Besi Siku', '4 cm', 5, 'btg'],

            [9, 'Besi Hollow', '40x40x4 mm', 3, 'btg'],
            [9, 'Plat Besi', '3 mm', 1, 'btg'],
            [9, 'Electroda', '', 5, 'kg'],
            [9, 'Cat Mist Blue', '', 3, 'L'],
            [9, 'Thinner', '', 3, 'L'],
            [9, 'Mata Cutting Wheel', '', 1, 'pcs'],
            [9, 'Mata Gerinda Potong', '', 8, 'pcs'],

            [10, 'Besi Hollow', '40x40x4 mm', 12, 'btg'],
            [10, 'Cat Mist Blue', '', 4, 'L'],
            [10, 'Thinner', '', 1, 'L'],
            [10, 'Mata Gerinda Potong', '', 3, 'pcs'],
            [10, 'Mata Gerinda Halus', '', 3, 'pcs'],
            [10, 'Mata Cutting Wheel', '', 1, 'pcs'],
            [10, 'Besi Siku', '40x40x4 mm', 3, 'btg'],
            [10, 'Besi Henderson', '', 1, 'btg'],
            [10, 'Electroda', '', 5, 'kg'],

            [11, 'Besi Hollow', '', 5, 'btg'],

            [12, 'Besi Siku', '40x40x4 mm', 2, 'btg'],
            [12, 'Cat Hitam', '', 2, 'L'],
            [12, 'Cat Kuning', '', 2, 'L'],
            [12, 'Thinner', '', 1, 'pcs'],
            [12, 'Mata Gerinda Potong', '', 4, 'pcs'],
            [12, 'Mata Cutting Wheel', '', 1, 'pcs'],
            [12, 'Electroda', '', 4, 'kg'],

            [13, 'Besi Siku', '40x40x4 mm', 1, 'btg'],
            [13, 'Cat Hitam', '', 1, 'L'],
            [13, 'Cat Kuning', '', 1, 'L'],
            [13, 'Thinner', '', 0.5, 'pcs'],
            [13, 'Mata Gerinda Potong', '', 2, 'pcs'],
            [13, 'Mata Cutting Wheel', '', 0.5, 'pcs'],
            [13, 'Electroda', '', 1, 'kg'],

            [14, 'Besi Siku', '40x40x4 mm', 1, 'btg'],
            [14, 'Cat Hitam', '', 1, 'L'],
            [14, 'Cat Kuning', '', 1, 'L'],
            [14, 'Thinner', '', 0.5, 'pcs'],
            [14, 'Mata Gerinda Potong', '', 2, 'pcs'],
            [14, 'Mata Cutting Wheel', '', 0.5, 'pcs'],
            [14, 'Electroda', '', 1, 'kg'],

            [15, 'Besi Hollow', '40x40x4 mm', 2, 'btg'],
            [15, 'Cat Hitam', '', 2, 'L'],
            [15, 'Cat Kuning', '', 2, 'L'],
            [15, 'Thinner', '', 1, 'pcs'],
            [15, 'Mata Gerinda Potong', '', 3, 'pcs'],
            [15, 'Mata Cutting Wheel', '', 0.5, 'pcs'],
            [15, 'Plat Besi', '', 1, 'lbr'],
            [15, 'Electroda', '', 2, 'kg'],

            [16, 'Besi Siku', '40x40x4 mm', 1, 'btg'],
            [16, 'Cat Hitam', '', 1, 'L'],
            [16, 'Cat Kuning', '', 1, 'L'],
            [16, 'Thinner', '', 0.5, 'pcs'],
            [16, 'Mata Gerinda Potong', '', 2, 'pcs'],
            [16, 'Mata Cutting Wheel', '', 0.5, 'pcs'],
            [16, 'Electroda', '', 1, 'kg'],

            [17, 'Besi Hollow', '40x40x2,8 mm', 15, 'btg'],
            [17, 'Plat Ezer', '1,2 mm', 1, 'lbr'],
            [17, 'Besi Behel', '∅ 10 mm @ 12 mm', 2, 'btg'],
            [17, 'Roda Kereta Rubber', '∅ 4 inch swivel', 2, 'un'],
            [17, 'Roda Kereta Rubber', '∅ 4 inch fix', 2, 'un'],
            [17, 'Cat Hitam', '@ 0,85 L', 5, 'L'],
            [17, 'Thinner Impala', '1 L', 2, 'L'],
            [17, 'Electroda', '5 Kg', 1, 'box'],

            // Random baru untuk 18-30 (1-5 item per project, berdasarkan pola existing)
            [18, 'Besi Hollow', '1,2 mm', 10.04, 'un'],
            [18, 'Besi Hollow', '3 mm', 6.65, 'L'],
            [18, 'Plat Ezer', '1,2 mm', 14.01, 'kg'],
            [18, 'Electroda', '∅ 4 inch swivel', 13.96, 'pcs'],
            [18, 'Fisher', '40x40x4 mm', 0.87, 'box'],

            [19, 'Cat Hitam', '', 11.98, 'un'],
            [19, 'Cat Golden Yellow', '3 mm', 15.34, 'kg'],

            [20, 'Placoon Roll', '', 8.3, 'M'],
            [20, 'Cat Golden Yellow', '3 mm', 4.03, 'lbr'],

            [21, 'Besi Behel', '∅ 10 mm @ 12 mm', 18.83, 'M'],
            [21, 'Mata Gerinda Halus', '8', 5.67, 'un'],

            [22, 'Tali TIS / cable TIS', '∅ 10 mm @ 12 mm', 8.16, 'box'],
            [22, 'Tray Kabel', '∅ 4 inch swivel', 13.85, 'un'],

            [23, 'Cat Kuning', '', 5.6, 'btg'],

            [24, 'Mata Cutting Wheel', '', 13.04, 'ktg'],
            [24, 'Thinner', '5 Kg', 19.89, 'pcs'],
            [24, 'Mata Gerinda Halus', '∅ 4 inch fix', 16.51, 'un'],
            [24, 'Plat Besi', '1 L', 13.58, 'un'],

            [25, 'Besi Henderson', '8', 12.01, 'pcs'],
            [25, 'Baut Fisher', '10 mm', 2.97, 'box'],
            [25, 'Tali TIS / cable TIS', '40x40x4 mm', 18.68, 'kg'],
            [25, 'Roda Kereta Rubber', '40x40x4 mm', 6.75, 'pcs'],
            [25, 'Baut Fisher', '', 16.22, 'un'],

            [26, 'Plat Ezer', '8', 3.03, 'kg'],
            [26, 'Besi Siku', '@ 0,85 L', 1.84, 'box'],
            [26, 'Acrylic Bening', '@ 0,85 L', 10.06, 'L'],
            [26, 'Mata Cutting Wheel', '', 17.36, 'ktg'],

            [27, 'Mata Gerinda Potong', '∅ 4 inch fix', 12.55, 'kg'],
            [27, 'Placoon Roll', '', 2.59, 'kg'],
            [27, 'Besi Siku', '∅ 4 inch fix', 7.65, 'L'],

            [28, 'Tray Kabel', '', 8.68, 'un'],

            [29, 'Fisher', '3 mm', 11.81, 'ktg'],
            [29, 'Plat Besi', '@ 0,85 L', 5.71, 'M'],

            [30, 'Mata Gerinda Halus', '', 3.57, 'L'],
            [30, 'Tali TIS / cable TIS', '1 L', 3.15, 'L'],
            [30, 'Mata Gerinda Potong', '∅ 4 inch swivel', 4.54, 'kg'],
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
