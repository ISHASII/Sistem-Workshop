<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'jabatan_id')) {
                $table->foreignId('jabatan_id')
                    ->nullable()
                    ->after('department_id')
                    ->constrained('jabatans')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'jabatan_id')) {
                $table->dropConstrainedForeignId('jabatan_id');
            }
        });
    }
};
