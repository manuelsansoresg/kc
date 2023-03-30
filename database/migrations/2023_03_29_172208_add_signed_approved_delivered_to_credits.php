<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignedApprovedDeliveredToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->integer('credit_signed')->nullable()->after('kyc_done');
            $table->integer('approved')->nullable()->after('signed');
            $table->integer('delivered')->nullable()->after('approved');
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
            $table->dropColumn('signed');
            $table->dropColumn('approved');
            $table->dropColumn('delivered');
        });
    }
}
