<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductComplementaryServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_complementary_services', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('type')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::table('financial_products', function (Blueprint $table) {
            $table->text('alcance_beneficios')->nullable()->after('is_tramitar');
            $table->text('restriccion_exclusion')->nullable()->after('is_tramitar');
            $table->text('programa_educacion_financiera')->nullable()->after('is_tramitar');
            $table->text('referencia_comparativa')->nullable()->after('is_tramitar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_complementary_services');

        Schema::table('financial_products', function (Blueprint $table) {
            $table->dropColumn('alcance_beneficios');
            $table->dropColumn('restriccion_exclusion');
            $table->dropColumn('programa_educacion_financiera');
            $table->dropColumn('referencia_comparativa');
        });
    }
}
