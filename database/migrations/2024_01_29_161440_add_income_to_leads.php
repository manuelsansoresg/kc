<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIncomeToLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->decimal('income')->nullable()->after('manychat_id');
        });
        
        Schema::table('credits', function (Blueprint $table) {
            $table->decimal('income')->nullable()->after('date_open_report');
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
            $table->dropColumn('income');
        });
        
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('income');
        });
    }
}
