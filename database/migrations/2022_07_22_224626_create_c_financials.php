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
        Schema::create('c_financials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('c_financial_id')->nullable()->after('id');
            $table->smallInteger('type_person')->nullable()->after('c_financial_id');
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
        Schema::dropIfExists('c_financials');
        Schema::dropIfExists('c_type_persons');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('c_financial_id');
            $table->dropColumn('type_person');
            $table->dropColumn('razon_social');
        });
    }
}
