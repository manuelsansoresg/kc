<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBankIdToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->renameColumn('bank_id', 'bank_ids'); // Cambiar el nombre de la columna
        });
        
        Schema::table('financial_products', function (Blueprint $table) {
            $table->text('bank_ids')->nullable()->change(); // Cambiar el tipo de columna a 'text'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->renameColumn('bank_ids', 'bank_id');
        });
        Schema::table('financial_products', function (Blueprint $table) {
            $table->integer('bank_id')->nullable()->after('abusive_clause13');
        });
    }
}
