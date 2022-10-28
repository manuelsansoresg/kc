<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsCreditAndClientPersonToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->integer('applied_financial')->nullable()->after('current_total_balance');
            $table->integer('applied_financial_product')->nullable()->after('applied_financial');
            $table->integer('applied_loan_type')->nullable()->after('applied_financial_product');
            $table->integer('applied_sign_type')->nullable()->after('applied_loan_type');
            $table->integer('applied_import')->nullable()->after('applied_sign_type');
            $table->integer('applied_term')->nullable()->after('applied_import');
            $table->integer('applied_periodicity')->nullable()->after('applied_term');
            $table->integer('applied_payment')->nullable()->after('applied_periodicity');
            $table->integer('applied_loan_total_amount')->nullable()->after('applied_payment');
            $table->integer('applied_delivery_method')->nullable()->after('applied_loan_total_amount');
            $table->text('applied_loan_motive')->nullable()->after('applied_delivery_method');
            $table->date('payment_capacity_period')->nullable()->after('applied_loan_motive');
            $table->integer('payment_capacity')->nullable()->after('payment_capacity_period');
            $table->integer('applied_interest_rate')->nullable()->after('payment_capacity');
            $table->integer('applied_CAT')->nullable()->after('applied_interest_rate');
            $table->integer('opening_Commission_percentage')->nullable()->after('applied_CAT');
            //pld
            $table->smallInteger('client_public_servant')->nullable()->after('opening_Commission_percentage');
            $table->string('client_public_servant_position')->nullable()->after('client_public_servant');
            $table->string('client_public_servant_period')->nullable()->after('client_public_servant_position');
            $table->smallInteger('relative_public_servant')->nullable()->after('client_public_servant_period');
            $table->string('relative_public_servant_lastname')->nullable()->after('relative_public_servant');
            $table->string('relative_public_servant_second_lastname')->nullable()->after('relative_public_servant_lastname');
            $table->string('relative_public_servant_names')->nullable()->after('relative_public_servant_second_lastname');
            $table->string('relative_public_servant_relationship')->nullable()->after('relative_public_servant_names');
            $table->string('relative_public_servant_position')->nullable()->after('relative_public_servant_relationship');
            $table->string('relative_public_servant_period')->nullable()->after('relative_public_servant_position');

            $table->smallInteger('prepaid')->nullable()->after('relative_public_servant_period');
            $table->smallInteger('prepad_method')->nullable()->after('prepaid');
            $table->string('prepaid_frequency')->nullable()->after('prepad_method');
            $table->string('prepaid_source')->nullable()->after('prepaid_frequency');

            $table->smallInteger('endorsement')->nullable()->after('prepaid_source');
            $table->smallInteger('real_beneficiary')->nullable()->after('endorsement');
            $table->smallInteger('soruce_provider')->nullable()->after('real_beneficiary');
            $table->smallInteger('real_propetary')->nullable()->after('soruce_provider');
            
            $table->string('applied_loan_discount')->nullable()->after('real_propetary');
            $table->string('statement_delivery_method')->nullable()->after('applied_loan_discount');
            $table->text('notes')->nullable()->after('statement_delivery_method');
        });

        Schema::create('credit_references', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('credit_id')->nullable();
            $table->string('last_name');
            $table->string('second_lastname')->nullable();
            $table->string('names')->nullable();
            $table->string('relationship')->nullable();
            $table->integer('relationship_time_years')->nullable();
            $table->integer('relationship_time_months')->nullable();
            $table->string('cel_phone')->nullable();
            $table->string('local_phone')->nullable();
            $table->string('contact_time')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('street')->nullable();
            $table->string('home_external_number')->nullable();
            $table->string('home_internal_number')->nullable();
            $table->string('colony')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreign('credit_id')->references('id')->on('credits')->onDelete('cascade');
        });

        Schema::table('client_person', function (Blueprint $table) {
            $table->string('work_email')->nullable()->after('agreement_id');
            $table->date('birth_date')->nullable()->after('work_email');
            $table->smallInteger('sex')->nullable()->after('birth_date');
            $table->string('rfc')->nullable()->after('sex');
            $table->string('nationality')->nullable()->after('rfc');
            $table->string('birth_state')->nullable()->after('nationality');
            $table->string('curp')->nullable()->after('birth_state');

            $table->integer('marital_status')->nullable()->after('curp');
            $table->integer('education_level')->nullable()->after('marital_status');
            $table->string('client_contact_time')->nullable()->after('education_level');

            $table->string('relative_lastname')->nullable()->after('client_contact_time');
            $table->string('relative_second_lastname')->nullable()->after('relative_lastname');
            $table->string('relative_names')->nullable()->after('relative_second_lastname');
            $table->string('relative_local_phone')->nullable()->after('relative_names');
            $table->string('relative_cel_phone')->nullable()->after('relative_local_phone');
            $table->string('relative_contact_time')->nullable()->after('relative_cel_phone');

            $table->integer('client_postal_code')->nullable()->after('relative_contact_time');
            $table->string('client_street')->nullable()->after('client_postal_code');
            $table->string('client_home_external_number')->nullable()->after('client_street');
            $table->string('client_home_internal_number')->nullable()->after('client_home_external_number');
            $table->string('client_colony')->nullable()->after('client_home_internal_number');
            $table->string('client_city')->nullable()->after('client_colony');
            $table->string('client_state')->nullable()->after('client_city');
            $table->string('client_country')->nullable()->after('client_state');
            $table->integer('home_type')->nullable()->after('client_country');
            $table->integer('home_time_living')->nullable()->after('home_type');

            $table->integer('propety_ownnership_amount')->nullable()->after('home_time_living');
            $table->integer('propety_ownnership_value')->nullable()->after('propety_ownnership_amount');
            $table->integer('vehicle_ownnership_amount')->nullable()->after('propety_ownnership_value');
            $table->integer('vehicle_ownnership_value')->nullable()->after('vehicle_ownnership_amount');
            $table->integer('economic_dependents')->nullable()->after('vehicle_ownnership_value');

            $table->string('bank_name')->nullable()->after('economic_dependents');
            $table->string('bank_card_number')->nullable()->after('bank_name');
            $table->string('bank_acount_number')->nullable()->after('bank_card_number');
            $table->string('bank_clabe')->nullable()->after('bank_acount_number');
            
           
            $table->string('profession')->nullable()->after('bank_clabe');
            $table->text('home_note')->nullable()->after('profession');

            $table->string('workplace_name')->nullable()->after('home_note');
            $table->date('admission_date')->nullable()->after('workplace_name');
            $table->integer('labor_old')->nullable()->after('admission_date');
            $table->string('employee_number')->nullable()->after('labor_old');
            $table->string('employee_category')->nullable()->after('employee_number');
            $table->string('employee_area')->nullable()->after('employee_category');
            $table->string('employee_position')->nullable()->after('employee_area');
            $table->integer('monthly_income')->nullable()->after('employee_position');
            $table->string('aditional_labor_source')->nullable()->after('monthly_income');
            $table->integer('aditional_labor_income')->nullable()->after('aditional_labor_source');
            $table->integer('workplace_postal_code')->nullable()->after('aditional_labor_income');
            $table->string('workplace_street')->nullable()->after('workplace_postal_code');
            $table->string('workplace_home_external_number')->nullable()->after('workplace_street');
            $table->string('workplace_home_internal_number')->nullable()->after('workplace_home_external_number');
            $table->string('workplace_colony')->nullable()->after('workplace_home_internal_number');
            $table->string('workplace_city')->nullable()->after('workplace_colony');
            $table->string('workplace_state')->nullable()->after('workplace_city');
            $table->string('workplace_country')->nullable()->after('workplace_state');
            $table->string('workplace_local_phone')->nullable()->after('workplace_country');
            $table->integer('workplace_cel_phone')->nullable()->after('workplace_local_phone');
            $table->string('workplace_code')->nullable()->after('workplace_cel_phone');
            $table->integer('workplace_local_phone_extension')->nullable()->after('workplace_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('applied_loan_type');
            $table->dropColumn('applied_sign_type');
            $table->dropColumn('applied_import');
            $table->dropColumn('applied_term');
            $table->dropColumn('applied_periodicity');
            $table->dropColumn('applied_payment');
            $table->dropColumn('applied_loan_total_amount');
            $table->dropColumn('applied_delivery_method');
            $table->dropColumn('applied_loan_motive');
            $table->dropColumn('payment_capacity_period');
            $table->dropColumn('payment_capacity');
            $table->dropColumn('applied_interest_rate');
            $table->dropColumn('applied_CAT');
            $table->dropColumn('opening_Commission_percentage');
            
            $table->dropColumn('client_public_servant');
            $table->dropColumn('client_public_servant_position');
            $table->dropColumn('client_public_servant_period');
            $table->dropColumn('relative_public_servant');
            $table->dropColumn('relative_public_servant_lastname');
            $table->dropColumn('relative_public_servant_second_lastname');
            $table->dropColumn('relative_public_servant_names');
            $table->dropColumn('relative_public_servant_relationship');
            $table->dropColumn('relative_public_servant_position');
            $table->dropColumn('relative_public_servant_period');

            $table->dropColumn('client_public_servant');
            $table->dropColumn('prepad_method');
            $table->dropColumn('prepaid_frequency');
            $table->dropColumn('prepaid_source');

            $table->dropColumn('endorsement');
            $table->dropColumn('real_beneficiary');
            $table->dropColumn('soruce_provider');
            $table->dropColumn('real_propetary');
        });

        Schema::dropIfExists('credit_references');

        Schema::table('client_person', function (Blueprint $table) {
            $table->dropColumn('work_email');
            $table->dropColumn('birth_date');
            $table->dropColumn('sex');
            $table->dropColumn('rfc');
            $table->dropColumn('nationality');
            $table->dropColumn('birth_state');
            $table->dropColumn('curp');
            $table->dropColumn('marital_status');
            $table->dropColumn('education_level');
            $table->dropColumn('client_contact_time');
            $table->dropColumn('relative_lastname');
            $table->dropColumn('relative_second_lastname');
            $table->dropColumn('relative_names');
            $table->dropColumn('relative_local_phone');
            $table->dropColumn('relative_cel_phone');
            $table->dropColumn('relative_contact_time');
            $table->dropColumn('client_postal_code');
            $table->dropColumn('client_street');
            $table->dropColumn('client_home_external_number');
            $table->dropColumn('client_home_internal_number');
            $table->dropColumn('client_colony');
            $table->dropColumn('client_city');
            $table->dropColumn('client_state');
            $table->dropColumn('client_country');
            $table->dropColumn('home_type');
            $table->dropColumn('home_time_living');
            $table->dropColumn('propety_ownnership_amount');
            $table->dropColumn('propety_ownnership_value');
            $table->dropColumn('vehicle_ownnership_amount');
            $table->dropColumn('vehicle_ownnership_value');
            $table->dropColumn('economic_dependents');
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_card_number');
            $table->dropColumn('bank_acount_number');
            $table->dropColumn('bank_clabe');
            
            $table->dropColumn('profession');
            $table->dropColumn('home_note');
            $table->dropColumn('workplace_name');
            $table->dropColumn('admission_date');
            $table->dropColumn('labor_old');
            $table->dropColumn('employee_number');
            $table->dropColumn('employee_category');
            $table->dropColumn('employee_area');
            $table->dropColumn('employee_position');
            $table->dropColumn('monthly_income');
            $table->dropColumn('aditional_labor_source');
            $table->dropColumn('aditional_labor_income');
            $table->dropColumn('workplace_postal_code');
            $table->dropColumn('workplace_street');
            $table->dropColumn('workplace_home_external_number');
            $table->dropColumn('workplace_home_internal_number');
            $table->dropColumn('workplace_colony');
            $table->dropColumn('workplace_city');
            $table->dropColumn('workplace_state');
            $table->dropColumn('workplace_country');
            $table->dropColumn('workplace_local_phone');
            $table->dropColumn('workplace_cel_phone');
            $table->dropColumn('workplace_code');
            $table->dropColumn('workplace_local_phone_extension');
        });
    }
}
