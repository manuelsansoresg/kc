<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIvaCommissionToInvestors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->decimal('iva_commission')->nullable()->after('account_value');
        });
        
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->decimal('iva_commission')->nullable()->after('iva_collected');
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
            $table->dropColumn('iva_commission');
        });
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->dropColumn('iva_commission');
        });
    }
}
