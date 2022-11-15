<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSwapStep1ToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->string('id_number')->nullable()->after('payment_check_note');
            $table->string('current_credit_number')->nullable()->after('id_number');
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
            $table->dropColumn('id_number');
            $table->dropColumn('current_credit_number');
        });
    }
}
