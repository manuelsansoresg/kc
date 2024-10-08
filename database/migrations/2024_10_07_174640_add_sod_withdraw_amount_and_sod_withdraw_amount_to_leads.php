<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSodWithdrawAmountAndSodWithdrawAmountToLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->decimal('sod_withdraw_amount')->nullable()->after('is_sod_on_date_allowed');
            $table->decimal('sod_commision_amount')->nullable()->after('is_sod_on_date_allowed');
            $table->decimal('sod_total_payment')->nullable()->after('is_sod_on_date_allowed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('sod_withdraw_amount');
            $table->dropColumn('sod_commision_amount');
            $table->dropColumn('sod_total_payment');
        });
    }
}
