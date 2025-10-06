<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('material_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('materials')->onDelete('restrict');
            $table->enum('type', ['in', 'out']); // in = masuk, out = keluar
            $table->date('tanggal');
            $table->decimal('jumlah', 12, 2);
            $table->string('seksi')->nullable(); // untuk material keluar
            $table->decimal('safety_stock', 12, 2)->nullable(); // untuk material masuk
            $table->enum('movement_type', ['jo', 'memo', 'other'])->default('other'); // type transaksi
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_movements');
    }
};
