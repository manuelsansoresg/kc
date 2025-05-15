<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditStatusToInvestorsCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->integer('credit_status')->nullable()->after('total_balance');
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
            $table->dropColumn('credit_status');
        });
    }
}
