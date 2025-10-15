<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthenticationFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // pin_hash VARCHAR(255) NOT NULL
            $table->string('pin_hash', 255)->nullable(false)->after('password');

            // user_status ENUM('pending_verification', 'verified', 'active', 'suspended') DEFAULT 'pending_verification'
            // Nota: En la base de datos, el nombre de la columna es 'user_status'.
            // Para el índice, solicitaste usar 'status', lo cual es ambiguo.
            // Usaremos 'user_status' para el índice para mantener la coherencia.
            // Si tu quieres un índice llamado 'idx_user_status' sobre una columna llamada 'status',
            // tendrías que cambiar el nombre de la columna o el nombre del índice.
            $table->enum('user_status', ['pending_verification', 'verified', 'active', 'suspended'])
                  ->default('pending_verification')
                  ->after('email_verified_at');

            // verified_at TIMESTAMP NULL
            $table->timestamp('verified_at')->nullable()->after('user_status');

            // last_login TIMESTAMP NULL
            $table->timestamp('last_login')->nullable()->after('verified_at');
            
            // INDEX idx_user_status (status)
            // Creamos el índice sobre la columna 'user_status' con el nombre solicitado 'idx_user_status'.
            $table->index('user_status', 'idx_user_status');
        });

        Schema::create('verification_tokens', function (Blueprint $table) {
            // id INT AUTO_INCREMENT PRIMARY KEY
            $table->id(); // Equivalente a INT AUTO_INCREMENT PRIMARY KEY

            // user_id INT NOT NULL
            // Definimos la columna y la hacemos UNSIGNED para la clave foránea.
            $table->unsignedBigInteger('user_id');

            // token VARCHAR(255) UNIQUE NOT NULL
            $table->string('token')->unique();

            // type ENUM('phone_verification', 'password_reset') DEFAULT 'phone_verification'
            $table->enum('type', ['phone_verification', 'password_reset'])->default('phone_verification');

            // used BOOLEAN DEFAULT FALSE
            $table->boolean('used')->default(false);

            // created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP (manejo por $table->timestamps() o específico)
            // Laravel maneja 'created_at' y 'updated_at' con $table->timestamps().
            // Como tu tabla usa 'created_at' y no 'updated_at', lo definiremos explícitamente.
            // La función `timestamp()` de Laravel crea un campo TIMESTAMP NULL por defecto.
            // Para simular el DEFAULT CURRENT_TIMESTAMP de tu SQL, usaremos `useCurrent()`.
            $table->timestamp('created_at')->useCurrent();

            // expires_at TIMESTAMP NOT NULL
            $table->timestamp('expires_at');

            // used_at TIMESTAMP NULL
            $table->timestamp('used_at')->nullable();

            // FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // INDEX idx_token (token) - ya cubierto por $table->string('token')->unique()
            // INDEX idx_user_id (user_id)
            // La clave foránea ya suele crear un índice, pero lo definimos explícitamente si es necesario.
            // En este caso, la clave foránea *casi siempre* crea un índice automáticamente.
            // Pero para seguir tu solicitud:
            // $table->index('token', 'idx_token'); // Opcional, ya es UNIQUE
            $table->index('user_id', 'idx_user_id'); 
            
            // Opcionalmente puedes especificar el motor y charset como en tu SQL:
            // $table->engine = 'InnoDB';
            // $table->charset = 'utf8mb4';
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
            // Drop the columns in reverse order
            $table->dropIndex('idx_user_status');
            $table->dropColumn(['last_login', 'verified_at', 'user_status', 'pin_hash']);
        });
        
        Schema::dropIfExists('verification_tokens');
    }
}
