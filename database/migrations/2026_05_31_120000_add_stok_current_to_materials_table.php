<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('materials', 'stok_current')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->decimal('stok_current', 12, 2)->default(0)->after('jumlah');
            });
        }

        // Initialize stok_current with the current dynamically calculated stock
        $materials = DB::table('materials')->get();
        foreach ($materials as $material) {
            $stokMasuk = DB::table('material_movements')
                ->where('material_id', $material->id)
                ->where('type', 'in')
                ->sum('jumlah');

            $stokKeluar = DB::table('material_movements')
                ->where('material_id', $material->id)
                ->where('type', 'out')
                ->sum('jumlah');

            $stokCurrent = $material->jumlah + $stokMasuk - $stokKeluar;

            DB::table('materials')
                ->where('id', $material->id)
                ->update(['stok_current' => $stokCurrent]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('materials', 'stok_current')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->dropColumn('stok_current');
            });
        }
    }
};
