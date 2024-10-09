<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMaxCreditAmmountToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->renameColumn('max_credit_amount', 'max_loan_ammount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->renameColumn('max_loan_ammount', 'max_credit_amount');
        });
    }
}
