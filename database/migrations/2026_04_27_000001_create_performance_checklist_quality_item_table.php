<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasTable('performance_checklist_quality_item')) {
            return;
        }

        Schema::create('performance_checklist_quality_item', function (Blueprint $table) {
            $table->unsignedBigInteger('performance_id');
            $table->unsignedBigInteger('checklist_quality_item_id');

            $table->primary(['performance_id', 'checklist_quality_item_id']);

            $table->foreign('performance_id', 'pcqi_perf_fk')
                ->references('id')
                ->on('performances')
                ->onDelete('cascade');
            $table->foreign('checklist_quality_item_id', 'pcqi_item_fk')
                ->references('id')
                ->on('checklist_quality_items')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('performance_checklist_quality_item');
    }
};
