<?php

namespace App\Models\kaaxSidecc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsCreditInfoKaaxSidecc extends Model
{
    use HasFactory;
    protected $connection = 'kaax_sidecc';
    protected $table = 'clients_credit_info';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'credit_id', 'promoter_id', 'producto',
        'capital', 'plazo_quincenas', 'ingreso_mensual', 'descuento',
        'capacidad_credito', 'periodo_id', 'confianza', 'destino_credito', 'destino_credito_id', 'inmuebles',
        'auto', 'auto_detalle', 'numero_autos_propios', 'auto_marcas', 'auto_modelos', 'otro_credito_info_1',
        'otro_credito_info_2', 'comentarios_credito_info', 'estatus_credito', 'otro_credito_status',
        'llenado', 'pagos_anticipados', 'medio_pagos_anticipados', 'frecuencia_pagos_anticipados',
        'fuente_recursos_pagos_anticipados', 'ingresos_mensuales', 'origen_recursos', 'otro_credito_llenado',
        'grado_riesgo', 'expediente', 'comentarios_credito_estatus', 'tasa', 'cat', 'monto_total',
        'nombre', 'parentesco', 'preautorizado', 'capital_insoluto', 'cred_vigente_cap_ins',
        'com_cap_ins', 'capital_terceros', 'capital_ajusado', 'tasa_promocional', 'comision_apertura',
        'iva', 'comision_total', 'capital_cobrar', 'finalizado', 'puesto', 'file_capital_insoluto',
        'porcentaje_comision_apertura', 'kc_credit_id'
    ];
}
