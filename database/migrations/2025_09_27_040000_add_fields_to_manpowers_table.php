<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('manpowers', function (Blueprint $table) {
            $table->string('jenis_kelamin', 20)->default('laki-laki');
            $table->string('status_pegawai', 20)->default('kontrak');
        });
    }

    public function down(): void
    {
        Schema::table('manpowers', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin','status_pegawai']);
        });
    }
};
