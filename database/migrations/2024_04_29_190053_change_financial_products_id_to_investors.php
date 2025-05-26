<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFinancialProductsIdToInvestors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->text('financial_products_id')->nullable()->change();
        });
       
        Schema::table('users', function (Blueprint $table) {
            $table->text('financial_products_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->bigInteger('financial_products_id')->nullable()->change();
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('financial_products_id')->nullable()->change();
        });
    }
}
