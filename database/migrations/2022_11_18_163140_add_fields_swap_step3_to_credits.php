<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsSwapStep3ToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->string('termination_number')->nullable()->after('termination_email_sent');
            $table->string('termination_bank_name')->nullable()->after('termination_number');
            $table->string('termination_bank_account_holder')->nullable()->after('termination_bank_name');
            $table->string('termination_bank_account_number')->nullable()->after('termination_bank_account_holder');
            $table->string('termination_bank_clabe')->nullable()->after('termination_bank_account_number');
            $table->string('termination_bank_reference')->nullable()->after('termination_bank_clabe');
            $table->string('termination_note')->nullable()->after('termination_bank_reference');
            $table->integer('termination_amount')->nullable()->after('termination_note');
            $table->date('termination_deadline')->nullable()->after('termination_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('termination_number');
            $table->dropColumn('termination_bank_name');
            $table->dropColumn('termination_bank_account_holder');
            $table->dropColumn('termination_bank_account_number');
            $table->dropColumn('termination_bank_clabe');
            $table->dropColumn('termination_bank_reference');
            $table->dropColumn('termination_note');
            $table->dropColumn('termination_amount');
            $table->dropColumn('termination_deadline');
        });
    }
}
