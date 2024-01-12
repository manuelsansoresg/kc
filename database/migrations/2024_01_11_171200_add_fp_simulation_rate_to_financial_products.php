<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFpSimulationRateToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->decimal('fp_simulation_rate')->nullable()->after('proceso_tramite');
        });
        Schema::dropIfExists('loan_simulations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->dropColumn('fp_simulation_rate');
        });
        Schema::create('loan_simulations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->decimal('principal')->nullable();
            $table->integer('term')->nullable();
            $table->decimal('payment')->nullable();
            
            $table->foreign('product_id')->references('id')->on('financial_products')->onDelete('cascade');
        });
    }
}
