<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddElementsTask1Step2ControlDeskToClientPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->string('ID_primer_apellido')->nullable()->after('cellphone');
            $table->string('ID_segundo_apellido')->nullable()->after('cellphone');
            $table->string('ID_nombres')->nullable()->after('cellphone');
            $table->string('ID_vigencia')->nullable()->after('cellphone');
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
            $table->dropColumn('ID_primer_apellido');
            $table->dropColumn('ID_segundo_apellido');
            $table->dropColumn('ID_nombres');
            $table->dropColumn('ID_vigencia');
        });
    }
}
