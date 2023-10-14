<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->decimal('min_loan_amount')->nullable()->after('aval_o_garantia');
            $table->string('means_channels_of_disposal')->nullable()->after('min_loan_amount');
            $table->string('coverage')->nullable()->after('means_channels_of_disposal');
            $table->string('purpose_of_loan')->nullable()->after('coverage');
            $table->decimal('minimum_interest_rate')->nullable()->after('purpose_of_loan');
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
            $table->dropColumn('min_loan_amount');
            $table->dropColumn('means_channels_of_disposal');
            $table->dropColumn('coverage');
            $table->dropColumn('purpose_of_loan');
            $table->dropColumn('minimum_interest_rate');
        });
    }
}
