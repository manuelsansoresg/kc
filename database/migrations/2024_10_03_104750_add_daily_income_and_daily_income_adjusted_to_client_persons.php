<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDailyIncomeAndDailyIncomeAdjustedToClientPersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->decimal('daily_income')->after('sod_active');
            $table->decimal('daily_income_adjusted')->after('sod_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->dropColumn('daily_income');
            $table->dropColumn('daily_income_adjusted');
        });
    }
}
