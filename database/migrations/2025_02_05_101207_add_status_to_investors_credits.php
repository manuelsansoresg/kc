<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToInvestorsCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->smallInteger('status')->nullable()->after('commission_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
