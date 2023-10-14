<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodicityProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_periodicity', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('periodicity_id');
            $table->timestamps();
        });
        
        Schema::create('product_payment_method', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('payment_method_id');
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
        Schema::dropIfExists('product_periodicity');
        Schema::dropIfExists('product_payment_method');
    }
}
