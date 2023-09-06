<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->integer('financial_product_id')->after('consulta_buro')->nullable();
        });
        
        Schema::table('credits', function (Blueprint $table) {
            $table->integer('financial_product_id')->after('consulta_buro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('financial_product_id');
        });
        
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('financial_product_id');
        });
    }
}
