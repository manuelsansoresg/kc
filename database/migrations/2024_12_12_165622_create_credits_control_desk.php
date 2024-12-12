<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsControlDesk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits_control_desk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('credit_id');
            $table->string('id_validation');
            $table->smallInteger('status')->nullable();
            $table->smallInteger('mandatory')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits_control_desk');
    }
}
