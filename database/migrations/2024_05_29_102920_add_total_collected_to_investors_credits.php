<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalCollectedToInvestorsCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->decimal('total_collected')->nullable()->after('import');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investors_credits', function (Blueprint $table) {
            $table->dropColumn('total_collected');
        });
    }
}
