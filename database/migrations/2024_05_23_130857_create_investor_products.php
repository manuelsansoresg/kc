<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investor_products', function (Blueprint $table) {
            $table->bigInteger('financial_products_id');
            $table->bigInteger('investor_id');
            $table->timestamps();
        });

        Schema::table('investors', function (Blueprint $table) {
            $table->dropColumn('financial_products_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investor_products');

        Schema::table('investors', function (Blueprint $table) {
            $table->text('financial_products_id')->nullable()->after('agreements_id');
        });
    }
}
