<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('investor_id')->nullable();
            $table->integer('transaction_type')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('capital', 8, 2)->nullable();
            $table->decimal('interest', 8, 2)->nullable();
            $table->decimal('iva', 8, 2)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
