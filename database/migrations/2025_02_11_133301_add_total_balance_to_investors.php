<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalBalanceToInvestors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->decimal('total_balance')->nullable()->after('lendable_updated_time');
        });
        
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->decimal('total_balance')->nullable()->after('status');
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
            $table->dropColumn('total_balance');
        });
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->dropColumn('total_balance');
        });
    }
}
