<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViabilidadViabilidadCreditoToLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->smallInteger('is_viability')->nullable()->after('applied_loan_type');
            $table->smallInteger('is_viability_credit')->nullable()->after('applied_loan_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('is_viability');
            $table->dropColumn('is_viability_credit');
        });
    }
}
