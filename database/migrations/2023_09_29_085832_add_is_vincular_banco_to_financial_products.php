<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsVincularBancoToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->smallInteger('is_vincular_banco')->after('chart_iva')->nullable();
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
            $table->dropColumn('is_vincular_banco');
        });
    }
}
