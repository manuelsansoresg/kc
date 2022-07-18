<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        
        Schema::create('c_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('c_product_id')->nullable();
            $table->unsignedBigInteger('c_service_id')->nullable();
            $table->text('comment')->nullable();
            $table->integer('status');
            $table->foreign('c_product_id')->references('id')->on('c_products')->onDelete('cascade');
            $table->foreign('c_service_id')->references('id')->on('c_services')->onDelete('cascade');
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
        Schema::dropIfExists('c_products');
        Schema::dropIfExists('products');

        
    }
}
