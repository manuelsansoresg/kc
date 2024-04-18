<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSodCommissionToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->decimal('opening_commission', 8, 2)->nullable()->after('s2_credit_id');
            $table->decimal('sod_commission', 8, 2)->nullable()->after('s2_credit_id');
            $table->decimal('refinance_adjustment', 8, 2)->nullable()->after('s2_credit_id');
            $table->decimal('third_party_adjustment', 8, 2)->nullable()->after('s2_credit_id');
            $table->decimal('net_amount', 8, 2)->nullable()->after('s2_credit_id');
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
            $table->dropColumn('opening_commission');
            $table->dropColumn('sod_commission');
            $table->dropColumn('refinance_adjustment');
            $table->dropColumn('third_party_adjustment');
            $table->dropColumn('net_amount');
        });
    }
}
