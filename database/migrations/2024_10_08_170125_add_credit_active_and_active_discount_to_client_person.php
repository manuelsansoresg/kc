<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditActiveAndActiveDiscountToClientPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->smallInteger('credit_active')->nullable()->after('daily_income_adjusted');
            $table->decimal('active_discount')->nullable()->after('daily_income_adjusted');
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
            $table->dropColumn('credit_active');
            $table->dropColumn('active_discount');
        });
    }
}
