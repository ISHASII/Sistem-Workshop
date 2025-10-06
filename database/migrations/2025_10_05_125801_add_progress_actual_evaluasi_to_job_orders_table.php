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
        Schema::table('job_orders', function (Blueprint $table) {
            $table->integer('progress')->nullable()->after('end')->comment('Progress percentage (0-100)');
            $table->date('actual')->nullable()->after('progress')->comment('Actual completion date');
            $table->string('evaluasi')->nullable()->after('actual')->comment('Tepat Waktu or Terlambat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_orders', function (Blueprint $table) {
            $table->dropColumn(['progress', 'actual', 'evaluasi']);
        });
    }
};
