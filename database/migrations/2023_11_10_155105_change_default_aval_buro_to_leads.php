<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultAvalBuroToLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->integer('consulta_buro')->default(1)->change();
            $table->integer('aval_o_garantia')->default(1)->change();
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
            $table->integer('consulta_buro')->nullable()->default(null)->change();
            $table->integer('aval_o_garantia')->nullable()->default(null)->change();
        });
    }
}
