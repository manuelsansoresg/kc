<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRateAndCatAndComisionAndDeadlineAndContractAndPrivacityToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->decimal('rate_kc')->after('consulta_buro')->nullable();
            $table->decimal('rate_cat')->after('rate_kc')->nullable();
            $table->decimal('rate_comision')->after('rate_cat')->nullable();
            $table->decimal('rate_deadline')->after('rate_comision')->nullable();
            $table->decimal('rate_contract')->after('rate_deadline')->nullable();
            $table->decimal('rate_privacity')->after('rate_contract')->nullable();
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
            $table->dropColumn('rate_kc');
            $table->dropColumn('rate_cat');
            $table->dropColumn('rate_comision');
            $table->dropColumn('rate_deadline');
            $table->dropColumn('rate_contract');
            $table->dropColumn('rate_privacity');
        });
    }
}
