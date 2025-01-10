<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecoveredCapitalAndProfitCollectedToInvestorsCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->decimal('recovered_capital')->nullable()->after('commission_amount');
            $table->decimal('profit_collected')->nullable()->after('commission_amount');
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
            $table->dropColumn('recovered_capital');
            $table->dropColumn('profit_collected');
        });
    }
}
