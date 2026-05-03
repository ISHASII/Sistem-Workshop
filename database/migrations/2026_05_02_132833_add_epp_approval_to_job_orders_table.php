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
            $table->enum('epp_approval_status', ['pending', 'approved'])->default('pending')->after('approval_status');
            $table->foreignId('epp_approved_by')->nullable()->constrained('users')->nullOnDelete()->after('approved_at');
            $table->timestamp('epp_approved_at')->nullable()->after('epp_approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_orders', function (Blueprint $table) {
            $table->dropForeign(['epp_approved_by']);
            $table->dropColumn(['epp_approval_status', 'epp_approved_by', 'epp_approved_at']);
        });
    }
};
