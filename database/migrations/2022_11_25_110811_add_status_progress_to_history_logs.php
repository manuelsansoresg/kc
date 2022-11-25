<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusProgressToHistoryLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->smallInteger('status_progress')->after('user_id')->nullable();
            $table->dateTime('date_status_progress')->after('status_progress')->nullable();
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
            $table->dropColumn('status_progress');
            $table->dropColumn('date_status_progress');
        });
    }
}
