<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsComisionsToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            // Add new columns after fp_simulation_rate
            $table->after('fp_simulation_rate', function ($table) {
                $table->integer('opening_commission_type')->nullable();
                $table->decimal('opening_commission_rate', 8, 2)->nullable(); // 4 decimal places
                $table->decimal('opening_commission_amount', 8, 2)->nullable(); // 2 decimal places
                $table->decimal('collection_commission_rate', 8, 2)->nullable();
                $table->decimal('annual_interest_rate', 8, 2)->nullable();
                $table->decimal('daily_interest_rate', 8, 2)->nullable();
            });
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
            // Remove the newly added columns
            $table->dropColumn('opening_commission_type');
            $table->dropColumn('opening_commission_rate');
            $table->dropColumn('opening_commission_amount');
            $table->dropColumn('collection_commission_rate');
            $table->dropColumn('annual_interest_rate');
            $table->dropColumn('daily_interest_rate');
        });
    }
}
