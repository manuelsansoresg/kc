<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFinancialIdProductIdToFinancialAgreements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_agreements', function (Blueprint $table) {
            $table->renameColumn('financial_id', 'product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_agreements', function (Blueprint $table) {
            $table->renameColumn('product_id', 'financial_id');
        });
    }
}
