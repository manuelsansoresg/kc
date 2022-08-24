<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_person', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('second_last_name')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('agreement_id')->nullable();
            $table->foreign('agreement_id')->references('id')->on('agreements')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_person_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->unsignedBigInteger('agreement_id')->nullable();
            $table->integer('origin_id')->nullable();
            $table->integer('channel_id')->nullable();
            $table->integer('type_id')->nullable('temperature_id');
            $table->integer('asesor_id')->nullable();

            $table->foreign('client_person_id')->references('id')->on('client_person')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('financial_id')->references('id')->on('financials')->onDelete('cascade');
            $table->foreign('agreement_id')->references('id')->on('agreements')->onDelete('cascade');
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
        Schema::dropIfExists('credits');
        Schema::dropIfExists('client_person');
    }
}
