<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValueChartsToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->decimal('chart_costo_anual_total')->after('rate_privacity')->nullable();
            $table->smallInteger('chart_comision_apertura')->after('chart_costo_anual_total')->nullable();
            $table->integer('chart_plazo_maximo')->after('chart_comision_apertura')->nullable();
            $table->integer('chart_capital')->after('chart_plazo_maximo')->nullable();
            $table->integer('chart_interes')->after('chart_capital')->nullable();
            $table->integer('chart_comision')->after('chart_interes')->nullable();
            $table->integer('chart_iva')->after('chart_comision')->nullable();
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
            $table->dropColumn('chart_costo_anual_total');
            $table->dropColumn('chart_comision_apertura');
            $table->dropColumn('chart_plazo_maximo');
            $table->dropColumn('chart_capital');
            $table->dropColumn('chart_interes');
            $table->dropColumn('chart_comision');
            $table->dropColumn('chart_iva');
        });
    }
}
