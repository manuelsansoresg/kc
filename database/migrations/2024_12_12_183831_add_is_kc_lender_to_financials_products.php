<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsKcLenderToFinancialsProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->smallInteger('is_kc_lender')->nullable()->after('max_term');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->dropColumn('is_kc_lender');
        });
    }
}
