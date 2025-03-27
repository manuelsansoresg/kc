<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendingFundedCapitalAndPendingWithdrawnMoneyToInvestors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->decimal('pending_funded_capital', 8, 2)->default(0)->after('iva_commission');
            $table->decimal('pending_withdrawn_money', 8, 2)->default(0)->after('pending_funded_capital');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->dropColumn('pending_funded_capital');
            $table->dropColumn('pending_withdrawn_money');
        });
    }
}
