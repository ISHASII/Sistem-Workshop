<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manpower_id');
            $table->unsignedBigInteger('job_order_id')->nullable();
            // Checklist (inspired by attached form)
            $table->boolean('material_sesuai_jo')->default(false);
            $table->boolean('dimensi_sesuai_jo')->default(false);
            $table->boolean('item_sesuai_design')->default(false);
            $table->boolean('pengelasan_tidak_retak')->default(false);
            $table->boolean('item_bebas_spatter')->default(false);
            $table->boolean('baut_terpasang_baik_lengkap')->default(false);
            $table->boolean('tidak_ada_bagian_tajam')->default(false);
            $table->boolean('finishing_standar')->default(false); // cat & coating
            $table->boolean('tidak_ada_kotoran')->default(false); // minyak & sisa material
            $table->boolean('berfungsi_dengan_baik')->default(false);
            // Aggregate
            $table->unsignedTinyInteger('score')->default(0); // 0-100
            $table->string('rating')->nullable();
            $table->timestamps();

            $table->foreign('manpower_id')->references('id')->on('manpowers')->onDelete('cascade');
            $table->foreign('job_order_id')->references('id')->on('job_orders')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('performances');
    }
};
