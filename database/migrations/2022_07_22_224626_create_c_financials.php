<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCFinancials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('financial_id')->nullable()->after('id');
            $table->smallInteger('type_person')->nullable()->after('financial_id');
            $table->string('razon_social')->nullable()->after('type_person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('financial_id');
            $table->dropColumn('type_person');
            $table->dropColumn('razon_social');
        });
    }
}
