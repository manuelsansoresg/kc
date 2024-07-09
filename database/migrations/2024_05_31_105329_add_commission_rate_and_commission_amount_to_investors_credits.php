<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommissionRateAndCommissionAmountToInvestorsCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->decimal('commission_rate')->nullable()->after('placed_capital');
            $table->decimal('commission_amount')->nullable()->after('placed_capital');
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
            $table->dropColumn('commission_rate');
            $table->dropColumn('commission_amount');
        });
    }
}
