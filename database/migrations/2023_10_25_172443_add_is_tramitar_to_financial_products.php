<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsTramitarToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->smallInteger('is_tramitar')->nullable()->after('regulacion')->default(1);
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
            $table->dropColumn('is_tramitar');
        });
    }
}
