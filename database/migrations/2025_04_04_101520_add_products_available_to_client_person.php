<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductsAvailableToClientPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->integer('cp_available')->nullable()->after('identity_validated');
            $table->integer('std_available')->nullable()->after('cp_available');
            $table->integer('sod_available')->nullable()->after('std_available');
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
            $table->dropColumn('cp_available');
            $table->dropColumn('std_available');
            $table->dropColumn('sod_available');
        });
    }
}
