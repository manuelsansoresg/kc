<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBankClabeToCreditPayOff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credit_pay_off', function (Blueprint $table) {
            $table->string('bank_clabe')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_pay_off', function (Blueprint $table) {
            $table->integer('bank_clabe')->nullable()->change();
        });
    }
}
