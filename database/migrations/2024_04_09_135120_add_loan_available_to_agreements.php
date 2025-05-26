<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoanAvailableToAgreements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agreements', function (Blueprint $table) {
            $table->decimal('loan_available', 8,2)->nullable()->after('description');
        });
       
        Schema::table('financial_products', function (Blueprint $table) {
            $table->decimal('loan_available', 8,2)->nullable()->after('daily_interest_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agreements', function (Blueprint $table) {
            $table->dropColumn('loan_available');
        });
       
        Schema::table('financial_products', function (Blueprint $table) {
            $table->dropColumn('loan_available');
        });
    }
}
