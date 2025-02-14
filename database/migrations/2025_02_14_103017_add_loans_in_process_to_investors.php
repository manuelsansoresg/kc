<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoansInProcessToInvestors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('process_to_investors', function (Blueprint $table) {
            $table->decimal('loans_in_process')->nullable()->after('iva_collected');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('process_to_investors', function (Blueprint $table) {
            $table->dropColumn('loans_in_process');
        });
    }
}
