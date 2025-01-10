<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTramitTypeToLeadsAndCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->integer('tramit_type')->nullable()->after('sod_total_payment');
        });
        Schema::table('credits', function (Blueprint $table) {
            $table->integer('tramit_type')->nullable()->after('net_amount');
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
            $table->dropColumn('tramit_type');
        });
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('tramit_type');
        });
    }
}
