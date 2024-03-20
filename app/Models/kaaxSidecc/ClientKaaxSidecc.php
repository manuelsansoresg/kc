<?php

namespace App\Models\kaaxSidecc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientKaaxSidecc extends Model
{
    use HasFactory;
    protected $connection = 'kaax_sidecc';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'clients';

    protected $fillable = [
        'rfc', 'apellido_1', 'apellido_2', 'nombre', 'comment', 'telefono_fijo', 'celular', 'email', 'curp',
        'genero', 'nacionalidad', 'pais_nacimiento', 'entidad_federativa_nacimiento', 'nacimiento', 'codigo_postal', 'codigo_postal_fiscal',
        'calle', 'numero_exterior', 'numero_interior', 'colonia', 'municipio', 'entidad_federativa', 'pais', 'estado_civil',
        'nivel_educativo', 'vivienda', 'tiempo_vivir_ahi', 'inmuebles', 'otro_credito_info_2', 'numero_autos_propios',
        'otro_credito_info_1', 'auto_marcas', 'auto_modelos', 'clabe', 'banco',
    ];
}
