<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->string('subject')->nullable();
            $table->date('start_date');
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('advisor_id')->nullable();
            $table->integer('section')->nullable();
            $table->integer('id_rel')->nullable();
            $table->integer('status')->nullable()->default(0);

            $table->foreign('advisor_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('register_actions', function (Blueprint $table) {
            $table->unsignedBigInteger('action_id')->nullable();
            $table->integer('state')->nullable();
            $table->text('comment')->nullable();
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
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
        Schema::dropIfExists('register_actions');
        Schema::dropIfExists('actions');
    }
}
