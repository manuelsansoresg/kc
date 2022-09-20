<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDebtCreditToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->integer('current_payment')->nullable()->after('asesor_id'); //*save  * 100
            $table->integer('current_periodicity')->nullable()->after('current_payment');
            $table->integer('current_loan')->nullable()->after('current_periodicity'); //*save  * 100
            $table->integer('current_term')->nullable()->after('current_loan');
            $table->integer('current_principal_balance')->nullable()->after('current_term'); //*save  * 100
            $table->integer('current_total_balance')->nullable()->after('current_principal_balance'); //*save  * 100
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
            $table->dropColumn('current_payment');
            $table->dropColumn('current_periodicity');
            $table->dropColumn('current_loan');
            $table->dropColumn('current_term');
            $table->dropColumn('current_principal_balance');
            $table->dropColumn('current_total_balance');
        });
    }
}
