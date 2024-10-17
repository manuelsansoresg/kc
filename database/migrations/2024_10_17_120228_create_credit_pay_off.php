<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditPayOff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_pay_off', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_person_id');
            $table->bigInteger('lead_id');
            $table->bigInteger('new_kc_credit_id')->nullable();
            $table->bigInteger('kc_credit_id_payed_off')->nullable();
            $table->bigInteger('financial_product_id')->nullable();
            $table->integer('bank_clabe')->nullable();
            $table->smallInteger('bank_clabe_valid')->nullable();
            $table->decimal('ammount')->nullable();
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
        Schema::dropIfExists('credit_pay_off');
    }
}
