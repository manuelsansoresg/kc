<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClabeOwnershipAndValidatedClabeToClientPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->smallInteger('clabe_ownership')->nullable()->after('payroll_total');
            $table->string('validated_clabe')->nullable()->after('payroll_total');
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
            $table->dropColumn('clabe_ownership');
            $table->dropColumn('validated_clabe');
        });
    }
}
