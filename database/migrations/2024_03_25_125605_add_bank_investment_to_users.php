<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankInvestmentToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('investment_bank_name')->after('bank_clabe')->nullable();
            $table->string('investment_bank_account_holder')->after('bank_clabe')->nullable();
            $table->string('investment_bank_account_number')->after('bank_clabe')->nullable();
            $table->string('investment_bank_clabe')->after('bank_clabe')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropcolumn('investment_bank_name');
            $table->dropcolumn('investment_bank_account_holder');
            $table->dropcolumn('investment_bank_account_number');
            $table->dropcolumn('investment_bank_clabe');
        });
    }
}
