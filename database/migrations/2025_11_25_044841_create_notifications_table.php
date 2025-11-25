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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['job_order_created', 'job_order_updated', 'job_order_deleted'])->default('job_order_created');
            $table->json('data')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // admin user
            $table->foreignId('job_order_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('action_by')->constrained('users')->onDelete('cascade'); // customer who performed action
            $table->timestamps();

            $table->index(['user_id', 'read_at']);
            $table->index(['type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
