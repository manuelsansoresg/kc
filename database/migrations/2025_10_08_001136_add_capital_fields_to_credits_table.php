<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCapitalFieldsToCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->decimal('placed_capital', 8, 2)->nullable()->after('net_amount');
            $table->decimal('recovered_capital', 8, 2)->nullable()->after('placed_capital');
            $table->decimal('total_balance', 8, 2)->nullable()->after('recovered_capital');
            $table->decimal('total_collected', 8, 2)->nullable()->after('total_balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn(['placed_capital', 'recovered_capital', 'total_balance', 'total_collected']);
        });
    }
}
