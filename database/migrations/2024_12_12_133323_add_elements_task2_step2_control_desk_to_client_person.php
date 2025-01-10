<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddElementsTask2Step2ControlDeskToClientPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->integer('ID_CIC')->nullable()->after('ID_vigencia');
            $table->integer('ID_IDC')->nullable()->after('ID_CIC');
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
            $table->dropColumn('ID_CIC');
            $table->dropColumn('ID_IDC');
        });
    }
}
