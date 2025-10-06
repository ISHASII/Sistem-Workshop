<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('material_keluars', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('material');
            $table->string('spesifikasi')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->foreignId('satuan_id')->constrained('satuans')->onDelete('restrict');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->enum('type', ['jo', 'memo'])->default('jo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_keluars');
    }
};
