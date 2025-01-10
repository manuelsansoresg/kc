<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DinamycStatusIdToHistoryLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->integer('dynamic_status_id')->nullable()->after('old_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropColumn('dynamic_status_id');
        });
    }
}
