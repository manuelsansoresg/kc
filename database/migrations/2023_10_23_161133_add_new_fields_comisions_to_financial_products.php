<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsComisionsToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('api_leads');

        Schema::table('financial_products', function (Blueprint $table) {
            $table->dropColumn('perc_opening_commission');
            $table->dropColumn('means_pay_arrangement_id');
            $table->dropColumn('life_insurance_commission_perc');
            $table->dropColumn('means_pay_life_insurance_id');
            $table->dropColumn('unemploy_insurance_commission_perc');
            $table->dropColumn('means_pay_unemploy_insurance_id');
            $table->dropColumn('unrecognized_transactions_or_charges');
            $table->dropColumn('administration_or_account_management');
            $table->dropColumn('drawdown_of_receivables');
            $table->dropColumn('non_payment');
            $table->dropColumn('collection_costs');
            $table->dropColumn('inv_formalization_expenses');
            $table->dropColumn('prepayment_prepaid');
            $table->dropColumn('late_or_untimely_pay');
            $table->dropColumn('statement_reprint');
            $table->dropColumn('rep_of_means_of_disposal');
        });

        Schema::create('product_fees', function (Blueprint $table) {
            $table->id();
            $table->integer('financial_product_id');
            $table->string('concepto')->nullable();
            $table->integer('periodicidad')->nullable();
            $table->integer('moneda')->nullable();
            $table->decimal('valor')->nullable();
            $table->decimal('porcentaje')->nullable();
            $table->integer('referencia')->nullable();
            $table->smallInteger('type')->nullable();
            $table->timestamps();
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
            $table->decimal('perc_opening_commission')->nullable();
            $table->integer('means_pay_arrangement_id')->nullable();
            $table->decimal('life_insurance_commission_perc')->nullable();
            $table->integer('means_pay_life_insurance_id')->nullable();
            $table->decimal('unemploy_insurance_commission_perc')->nullable();
            $table->integer('means_pay_unemploy_insurance_id')->nullable();
            $table->integer('unrecognized_transactions_or_charges')->nullable();
            $table->integer('administration_or_account_management')->nullable();
            $table->integer('drawdown_of_receivables')->nullable();
            $table->integer('non_payment')->nullable();
            $table->integer('collection_costs')->nullable();
            $table->integer('inv_formalization_expenses')->nullable();
            $table->integer('prepayment_prepaid')->nullable();
            $table->integer('late_or_untimely_pay')->nullable();
            $table->integer('statement_reprint')->nullable();
            $table->integer('rep_of_means_of_disposal')->nullable();
        });
    }
}
