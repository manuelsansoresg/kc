<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsAndProductsToFinancials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //* all relations check in the config folder (enums)
        Schema::table('financials', function (Blueprint $table) {
            $table->string('logo')->after('company_name')->nullable();
            $table->date('date_of_update')->after('logo')->nullable();
            $table->integer('country_id')->after('date_of_update')->nullable();
            $table->integer('sector_id')->after('country_id')->nullable();
            $table->integer('regulator_id')->after('sector_id')->nullable();
            $table->string('start_of_operations')->after('regulator_id')->nullable();
            $table->string('web')->after('start_of_operations')->nullable();
            $table->string('email')->after('web')->nullable();
            $table->string('phone')->after('email')->nullable();
            $table->text('comment')->after('phone')->nullable();
            $table->smallInteger('status')->after('comment')->nullable();
            
            $table->string('privacy_notice')->after('status')->nullable();
            $table->smallInteger('mkt_purposes')->after('privacy_notice')->nullable();
            $table->smallInteger('prospecting_purposes')->after('mkt_purposes')->nullable();
            $table->smallInteger('data_secondary_purposes')->after('prospecting_purposes')->nullable();
            $table->smallInteger('allows_refusal_use')->after('data_secondary_purposes')->nullable();
            $table->smallInteger('sensible_data')->after('allows_refusal_use')->nullable();
            $table->smallInteger('transfer_third')->after('sensible_data')->nullable();
            $table->smallInteger('transfer_third_collection')->after('transfer_third')->nullable();
            $table->smallInteger('arco_rights')->after('transfer_third_collection')->nullable();
            $table->smallInteger('revocation_of_consent')->after('arco_rights')->nullable();
            $table->smallInteger('options_to_limit_data_usage')->after('revocation_of_consent')->nullable();
            $table->smallInteger('tracking_technologies')->after('options_to_limit_data_usage')->nullable();
            $table->smallInteger('holders_consent')->after('tracking_technologies')->nullable();


            $table->integer('total_claims_condusef')->after('Holders_consent')->nullable();
            $table->integer('claim_rate_per_10k')->after('total_claims_condusef')->nullable();
            $table->integer('user_service_performance_index')->after('claim_rate_per_10k')->nullable();
            $table->integer('total_sanctions')->after('user_service_performance_index')->nullable();
            $table->integer('compliance_condusef_records')->after('total_sanctions')->nullable();
            $table->integer('condusef_evaluation_product')->after('compliance_condusef_records')->nullable();

            $table->string('rfc')->after('condusef_evaluation_product')->nullable();
            $table->string('tax_domicile')->after('rfc')->nullable();
        });

        Schema::create('financial_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->string('name');
            $table->string('alias')->nullable();
            $table->integer('type_product_id')->nullable();
            $table->smallInteger('status')->nullable();
            $table->integer('collateral_id')->nullable();
            $table->integer('periodicity_id')->nullable();
            $table->integer('min_deadline_month')->nullable();
            $table->integer('max_deadline_month')->nullable();
            $table->integer('type_interest')->nullable();
            $table->text('pay_form')->nullable();
            $table->decimal('annual_int_rate_iva')->nullable();
            $table->decimal('real_cat')->nullable();
            $table->integer('principal_pay')->nullable();
            $table->integer('resolution_time_hours')->nullable();
            $table->integer('delivery_time_hours')->nullable();
            $table->decimal('moratorium_int_rate_vat')->nullable();

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
            
            $table->smallInteger('reca')->nullable();
            $table->string('num_reca')->nullable();
            $table->smallInteger('allows_prepayments')->nullable();
            $table->string('prepayment_procedure')->nullable();
            $table->smallInteger('allows_early_term_contract')->nullable();
            $table->string('procedure_early_term_contract')->nullable();
            $table->integer('type_signature_id')->nullable();
            $table->smallInteger('query_credit')->nullable();

            $table->smallInteger('abusive_clause1')->nullable();
            $table->smallInteger('abusive_clause2')->nullable();
            $table->smallInteger('abusive_clause3')->nullable();
            $table->smallInteger('abusive_clause4')->nullable();
            $table->smallInteger('abusive_clause5')->nullable();
            $table->smallInteger('abusive_clause6')->nullable();
            $table->smallInteger('abusive_clause7')->nullable();
            $table->smallInteger('abusive_clause8')->nullable();
            $table->smallInteger('abusive_clause9')->nullable();
            $table->smallInteger('abusive_clause10')->nullable();
            $table->smallInteger('abusive_clause11')->nullable();
            $table->smallInteger('abusive_clause12')->nullable();
            $table->smallInteger('abusive_clause13')->nullable();
            $table->timestamps();

            $table->foreign('financial_id')->references('id')->on('financials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financials', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropColumn('date_of_update');
            $table->dropColumn('country_id');
            $table->dropColumn('sector_id');
            $table->dropColumn('regulator_id');
            $table->dropColumn('start_of_operations');
            $table->dropColumn('web');
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('comment');
            $table->dropColumn('status');
            
            $table->dropColumn('privacy_notice');
            $table->dropColumn('mkt_purposes');
            $table->dropColumn('prospecting_purposes');
            $table->dropColumn('data_secondary_purposes');
            $table->dropColumn('allows_refusal_use');
            $table->dropColumn('sensible_data');
            $table->dropColumn('transfer_third');
            $table->dropColumn('transfer_third_collection');
            $table->dropColumn('arco_rights');
            $table->dropColumn('revocation_of_consent');
            $table->dropColumn('options_to_limit_data_usage');
            $table->dropColumn('tracking_technologies');
            $table->dropColumn('holders_consent');
            
            $table->dropColumn('total_claims_condusef');
            $table->dropColumn('claim_rate_per_10k');
            $table->dropColumn('user_service_performance_index');
            $table->dropColumn('total_sanctions');
            $table->dropColumn('compliance_condusef_records');
            $table->dropColumn('condusef_evaluation_product');
            
            $table->dropColumn('rfc');
            $table->dropColumn('tax_domicile');
        });
        Schema::dropIfExists('financial_products');
    }
}
