<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('satuans', 'symbol')) {
            Schema::table('satuans', function (Blueprint $table) {
                $table->dropColumn('symbol');
            });
        }
    }

    public function down()
    {
        if (! Schema::hasColumn('satuans', 'symbol')) {
            Schema::table('satuans', function (Blueprint $table) {
                $table->string('symbol', 50)->nullable()->after('name');
            });
        }
    }
};
