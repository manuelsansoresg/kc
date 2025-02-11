<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIvaCollectedToInvestors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->decimal('iva_collected')->nullable()->after('total_balance');
        });
        
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->decimal('iva_collected')->nullable()->after('credit_status');
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
            $table->dropColumn('iva_collected');
        });
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->dropColumn('iva_collected');
        });
    }
}
