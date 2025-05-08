<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontoMaximoAndPagoMaximoAndPeriodicityToLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->decimal('monto_maximo', 10, 2)->nullable()->after('plazo_maximo');
            $table->decimal('pago_maximo', 10, 2)->nullable()->after('monto_maximo');
            $table->integer('periodicity')->nullable()->after('pago_maximo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('monto_maximo');
            $table->dropColumn('pago_maximo');
            $table->dropColumn('periodicity');
        });
    }
}
