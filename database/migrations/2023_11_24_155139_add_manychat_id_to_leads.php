<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManychatIdToLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->bigInteger('manychat_id')->nullable()->after('comment');
        });
        
        Schema::table('credits', function (Blueprint $table) {
            $table->bigInteger('manychat_id')->nullable()->after('aval_o_garantia');
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
            $table->dropColumn('manychat_id');
        });
       
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('manychat_id');
        });
    }
}
