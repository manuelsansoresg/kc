<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequisitosToFinancialProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_products', function (Blueprint $table) {
            $table->string('tipo_persona')->nullable()->after('aval_o_garantia');
            $table->string('edad')->nullable()->after('tipo_persona');
            $table->string('antiguedad_laboral')->nullable()->after('edad');
            $table->string('antiguedad_residencial')->nullable()->after('edad');
            $table->string('ingreso_minimo')->nullable()->after('antiguedad_laboral');
            $table->smallInteger('buen_historial_crediticio')->nullable()->after('ingreso_minimo');
            $table->smallInteger('aval_garantia')->nullable()->after('buen_historial_crediticio');
            $table->string('recibir_sueldo_nomina')->nullable()->after('aval_garantia');
            $table->string('identificacion_oficial_vig')->nullable()->after('recibir_sueldo_nomina');
            $table->string('comprobante_domicilio')->nullable()->after('identificacion_oficial_vig');
            $table->string('comprobante_ingresos')->nullable()->after('comprobante_domicilio');
            $table->string('doc_complementaria')->nullable()->after('comprobante_ingresos');
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
            $table->dropColumn('tipo_persona');
            $table->dropColumn('edad');
            $table->dropColumn('antiguedad_laboral');
            $table->dropColumn('antiguedad_residencial');
            $table->dropColumn('ingreso_minimo');
            $table->dropColumn('buen_historial_crediticio');
            $table->dropColumn('aval_garantia');
            $table->dropColumn('recibir_sueldo_nomina');
            $table->dropColumn('identificacion_oficial_vig');
            $table->dropColumn('comprobante_domicilio');
            $table->dropColumn('comprobante_ingresos');
            $table->dropColumn('doc_complementaria');
        });
    }
}
