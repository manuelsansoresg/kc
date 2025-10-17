<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddUserIdToClientPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Primero agregar la columna como nullable
        Schema::table('client_person', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });

        // Obtener el primer usuario disponible para asignar a registros existentes
        $firstUserId = DB::table('users')->first()->id ?? 1;
        
        // Actualizar todos los registros existentes con un user_id válido
        DB::table('client_person')
            ->whereNull('user_id')
            ->update(['user_id' => $firstUserId]);

        // Ahora agregar la restricción de clave foránea
        Schema::table('client_person', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_person', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
