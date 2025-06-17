<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDecimalFieldsToCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            Schema::table('credits', function (Blueprint $table) {
                $table->decimal('iva', 8, 2)->default(0)->after('net_amount');
                $table->decimal('ret_iva', 8, 2)->default(0)->after('iva');
                $table->decimal('ret_isr', 8, 2)->default(0)->after('ret_iva');
                $table->decimal('ret_iva_2', 8, 2)->default(0)->after('ret_isr');
                $table->decimal('ret_isr_2', 8, 2)->default(0)->after('ret_iva_2');
            });
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
            $table->dropColumn(['iva', 'ret_iva', 'ret_isr', 'ret_iva_2', 'ret_isr_2']);
        });
    }
}
