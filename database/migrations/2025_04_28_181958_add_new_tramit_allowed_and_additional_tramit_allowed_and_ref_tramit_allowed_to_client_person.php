<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewTramitAllowedAndAdditionalTramitAllowedAndRefTramitAllowedToClientPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->boolean('new_tramit_allowed')->default(false)->after('daily_income');
            $table->boolean('additional_tramit_allowed')->default(false)->after('new_tramit_allowed');
            $table->boolean('ref_tramit_allowed')->default(false)->after('additional_tramit_allowed');
        });

        Schema::table('investors_credits', function (Blueprint $table) {
            $table->boolean('refinanciable')->default(false)->after('iva_commission');
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
            $table->dropColumn('new_tramit_allowed');
            $table->dropColumn('additional_tramit_allowed');
            $table->dropColumn('ref_tramit_allowed');
        });

        Schema::table('investors_credits', function (Blueprint $table) {
            $table->dropColumn('refinanciable');
        });
    }
}
