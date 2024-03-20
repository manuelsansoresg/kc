<?php

namespace App\Models\kaaxSidecc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsJobInfoKaaxSidecc extends Model
{
    use HasFactory;

    protected $connection = 'kaax_sidecc';

    const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	protected $table = 'clients_job_info';

	protected $fillable = [
		'credit_id', 'numero_trabajador', 'nombre_dependencia', 'nombre_jefe_directo',
		'calle', 'numero_exterior', 'numero_interior', 'codigo_postal', 'municipio', 'entidad_federativa',
		'pais', 'telefono_oficina', 'celular', 'actividad_economica_adicional', 'ingreso_economico_adicional',
		'otros_ingresos_mensuales', 'colonia', 'tipo_pago', 'tipo_cliente', 'tipo_comprobante', 'en_bd', 'area_laboral', 'area_laboral_id',
		'puesto_laboral', 'ingreso', 'antiguedad', 'otro_job_info_1', 'otro_job_info_2', 'sueldo_mensual', 'extension', 'recibe_ing_adicionales'
	];
}
