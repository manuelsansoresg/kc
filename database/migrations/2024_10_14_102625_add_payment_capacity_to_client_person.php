<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentCapacityToClientPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->decimal('payment_capacity')->nullable()->after('pc_percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->dropColumn('payment_capacity');
        });
    }
}
