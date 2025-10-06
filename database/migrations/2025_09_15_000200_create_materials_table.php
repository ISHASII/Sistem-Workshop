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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama material
            $table->integer('jumlah')->default(0); // Jumlah/stok awal
            $table->integer('safety_stock')->default(0); // Safety stock
            $table->foreignId('satuan_id')->nullable()->constrained('satuans')->onDelete('set null');
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null');
            $table->text('spesifikasi')->nullable(); // Spesifikasi material
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
