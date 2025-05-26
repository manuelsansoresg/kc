<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('total_capital', 8, 2)->nullable();
            $table->decimal('placed_capital', 8, 2)->nullable();
            $table->decimal('recovered_capital', 8, 2)->nullable();
            $table->decimal('total_collected', 8, 2)->nullable();
            $table->decimal('profit_collected', 8, 2)->nullable();
            $table->decimal('loan_available', 8, 2)->nullable();
            $table->decimal('total_available', 8, 2)->nullable();
            $table->decimal('collection_commission', 8, 2)->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investors');
    }
}
