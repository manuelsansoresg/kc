<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('client_person_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_person_id');
            $table->unsignedBigInteger('user_id');
            $table->string('field_name');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamps();

            $table->foreign('client_person_id')->references('id')->on('client_person');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_person_history');
    }
}; 