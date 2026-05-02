<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('notifications')) {
            DB::statement("ALTER TABLE notifications MODIFY type VARCHAR(100) NOT NULL DEFAULT 'job_order_created'");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('notifications')) {
            DB::statement("ALTER TABLE notifications MODIFY type ENUM('job_order_created', 'job_order_updated', 'job_order_deleted') NOT NULL DEFAULT 'job_order_created'");
        }
    }
};
