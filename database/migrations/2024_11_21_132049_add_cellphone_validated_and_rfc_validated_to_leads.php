<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCellphoneValidatedAndRfcValidatedToLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->smallInteger('cellphone_validated')->default(0)->nullable()->after('tramit_type');
            $table->smallInteger('rfc_validated')->default(0)->nullable()->after('tramit_type');
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
            $table->dropColumn('cellphone_validated');
            $table->dropColumn('rfc_validated');
        });
    }
}
