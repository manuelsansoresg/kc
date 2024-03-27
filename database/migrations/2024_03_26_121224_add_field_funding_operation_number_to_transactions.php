<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldFundingOperationNumberToTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('bank_transfer_type')->nullable()->after('iva');
            $table->integer('operation_number')->nullable()->after('iva');
            $table->smallInteger('operation_status')->nullable()->after('iva');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('bank_transfer_type');
            $table->dropColumn('operation_number');
            $table->dropColumn('operation_status');
        });
    }
}
