<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCmAgreementSignToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->smallInteger('cm_agreement_sign')->nullable()->after('cm_agreement');
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
            $table->dropColumn('cm_agreement_sign');
        });
    }
}
