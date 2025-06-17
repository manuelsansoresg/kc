<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSodScheduleNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sod_schedule_names', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coment')->nullable();
            $table->timestamps();
        });
       
        Schema::create('sod_schedule_dates', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('schedule_1')->nullable();
            $table->integer('schedule_2')->nullable();
            $table->integer('schedule_3')->nullable();
            $table->integer('schedule_4')->nullable();
            
            $table->timestamps();
        });
        Schema::table('agreements', function (Blueprint $table) {
            $table->smallInteger('sod_schedule_id')->nullable()->after('loan_available');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sod_schedule_names');
        Schema::dropIfExists('sod_schedule_dates');
        Schema::table('agreements', function (Blueprint $table) {
            $table->dropColumn('sod_schedule_id');
        });
    }
}
