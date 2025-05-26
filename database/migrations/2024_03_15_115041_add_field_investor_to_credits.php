<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldInvestorToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->unsignedBigInteger('investor_id')->nullable()->after('lead_id');  // Unsigned integer (positive values only)
            $table->unsignedBigInteger('start_period_id')->nullable()->after('lead_id');
    
        });
    }
    
    public function down()
    {
        Schema::table('credits', function (Blueprint $table) {
            // Drop the added columns and foreign key constraints
            $table->dropForeign(['investor_id', 'start_period_id', 'financial_product_id']);
            $table->dropColumn('investor_id');
            $table->dropColumn('start_period_id');
        });
    }
}
