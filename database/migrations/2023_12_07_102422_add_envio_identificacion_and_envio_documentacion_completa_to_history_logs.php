<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnvioIdentificacionAndEnvioDocumentacionCompletaToHistoryLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->smallInteger('envio_identifacion')->default(0)->after('comment');
            $table->smallInteger('envio_documentacion_completa')->default(0)->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_logs', function (Blueprint $table) {
            $table->dropColumn('envio_identifacion');
            $table->dropColumn('envio_documentacion_completa');
        });
    }
}
