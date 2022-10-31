<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinancialUserComisionAndCommentToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->unsignedBigInteger('financial_user_assigned')->nullable()->after('notes');
            $table->integer('commission')->nullable()->after('financial_user_assigned');
            $table->text('commission_note')->nullable()->after('commission');

            $table->foreign('financial_user_assigned')->references('id')->on('users')->onDelete('cascade');
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
            $table->dropForeign('financial_user_assigned');
            $table->dropColumn('financial_user_assigned');
            $table->dropColumn('commission');
            $table->dropColumn('commission_note');
        });
    }
}
