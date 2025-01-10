<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddElementsTask3Step2ControlDeskToClientPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->date('payroll_date')->nullable()->after('ID_CIC');
            $table->decimal('payroll_total')->nullable()->after('ID_CIC');
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
            $table->dropColumn('payroll_date');
            $table->dropColumn('payroll_total');
        });
    }
}
