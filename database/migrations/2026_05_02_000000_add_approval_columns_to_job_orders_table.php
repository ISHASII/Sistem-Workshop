<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('job_orders', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('approved')->after('end');
            }
            if (!Schema::hasColumn('job_orders', 'approval_requested_at')) {
                $table->timestamp('approval_requested_at')->nullable()->after('approval_status');
            }
            if (!Schema::hasColumn('job_orders', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('approval_requested_at')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('job_orders', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            if (!Schema::hasColumn('job_orders', 'rejected_by')) {
                $table->foreignId('rejected_by')->nullable()->after('approved_at')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('job_orders', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }
            if (!Schema::hasColumn('job_orders', 'rejection_reason')) {
                $table->string('rejection_reason')->nullable()->after('rejected_at');
            }
        });

        DB::table('job_orders')->whereNull('approval_status')->update([
            'approval_status' => 'approved',
            'approval_requested_at' => DB::raw('created_at'),
            'approved_at' => DB::raw('created_at'),
        ]);
    }

    public function down(): void
    {
        Schema::table('job_orders', function (Blueprint $table) {
            if (Schema::hasColumn('job_orders', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
            if (Schema::hasColumn('job_orders', 'rejected_at')) {
                $table->dropColumn('rejected_at');
            }
            if (Schema::hasColumn('job_orders', 'rejected_by')) {
                $table->dropConstrainedForeignId('rejected_by');
            }
            if (Schema::hasColumn('job_orders', 'approved_at')) {
                $table->dropColumn('approved_at');
            }
            if (Schema::hasColumn('job_orders', 'approved_by')) {
                $table->dropConstrainedForeignId('approved_by');
            }
            if (Schema::hasColumn('job_orders', 'approval_requested_at')) {
                $table->dropColumn('approval_requested_at');
            }
            if (Schema::hasColumn('job_orders', 'approval_status')) {
                $table->dropColumn('approval_status');
            }
        });
    }
};
