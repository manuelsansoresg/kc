<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvalOGarantiaToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->smallInteger('aval_o_garantia')->nullable()->after('is_vincular_banco');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->smallInteger('aval_o_garantia')->nullable()->after('financial_product_id');
        });
        Schema::table('credits', function (Blueprint $table) {
            $table->smallInteger('aval_o_garantia')->nullable()->after('is_vincular_banco');
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
            $table->dropColumn('aval_o_garantia');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('aval_o_garantia');
        });
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('aval_o_garantia');
        });
    }
}
