<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsBankToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('agreement_id')->nullable()->after('tyc_accept');
            $table->string('bank_name')->nullable()->after('tyc_accept');
            $table->string('bank_card_number')->nullable()->after('tyc_accept');
            $table->string('bank_account_number')->nullable()->after('tyc_accept');
            $table->string('bank_clabe')->nullable()->after('tyc_accept');
            $table->foreign('agreement_id')->references('id')->on('agreements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['agreement_id']);
            // Then drop the columns in the reverse order they were added
            $table->dropColumn('bank_clabe');
            $table->dropColumn('bank_account_number');
            $table->dropColumn('bank_card_number');
            $table->dropColumn('bank_name');
            $table->dropColumn('agreement_id'); // Now dropping 'agreement_id' as it was added last
        });
    }
}
