<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveredAndDeliveredDateToCreditPayOff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credit_pay_off', function (Blueprint $table) {
            $table->smallInteger('delivered')->nullable()->after('deadline_date');
            $table->date('delivered_date')->nullable()->after('deadline_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_pay_off', function (Blueprint $table) {
            $table->dropColumn('delivered');
            $table->dropColumn('delivered_date');
        });
    }
}
