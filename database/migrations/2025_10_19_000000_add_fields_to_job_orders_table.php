<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('job_orders', function (Blueprint $table) {
            $table->string('area')->nullable()->after('project');
            $table->text('latar_belakang')->nullable()->after('area');
            $table->text('tujuan')->nullable()->after('latar_belakang');
            $table->text('target')->nullable()->after('tujuan');
            $table->json('images')->nullable()->after('target');
        });
    }

    public function down()
    {
        Schema::table('job_orders', function (Blueprint $table) {
            $table->dropColumn(['area','latar_belakang','tujuan','target','images']);
        });
    }
};
