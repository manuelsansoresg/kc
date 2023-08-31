<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImporteSolicitadoBancoNominaTipoCreditoConsultaBuroToLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->decimal('importe_solicitado')->nullable()->after('other');
            $table->integer('bank_id')->nullable()->after('importe_solicitado');
            $table->integer('tipo_credito')->nullable()->after('bank_id');
            $table->smallInteger('consulta_buro')->nullable()->after('tipo_credito');
        });
       
        Schema::table('credits', function (Blueprint $table) {
            $table->decimal('importe_solicitado')->nullable()->after('interviewer');
            $table->integer('bank_id')->nullable()->after('importe_solicitado');
            $table->integer('tipo_credito')->nullable()->after('bank_id');
            $table->smallInteger('consulta_buro')->nullable()->after('tipo_credito');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('importe_solicitado');
            $table->dropColumn('bank_id');
            $table->dropColumn('tipo_credito');
            $table->dropColumn('consulta_buro');
        });
       
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('importe_solicitado');
            $table->dropColumn('bank_id');
            $table->dropColumn('tipo_credito');
            $table->dropColumn('consulta_buro');
        });
    }
}
