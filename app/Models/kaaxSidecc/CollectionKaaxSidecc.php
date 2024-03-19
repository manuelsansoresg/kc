<?php

namespace App\Models\kaaxSidecc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionKaaxSidecc extends Model
{
    use HasFactory;
    protected $connection = 'kaax_sidecc';
    protected $table = 'collections';
    protected $fillable = [
        'credit_id',
        'client_id',
        'agreement_id',
        'folio',
        'capital',
        'plazo',
        'descuento',
        'periodo_id',
        'fecha_inicio',
        'fecha_cobro',
        'fecha_pago',
        'nombre',
        'numero_empleado',
        'area_laboral',
        'puesto_laboral',
        'pago_acumulado_real',
        'pago_acumulado',
        'abono_acumulado_real',
        'abono_acumulado',
        'saldo_total_real',
        'saldo_total',
        'saldo_insoluto_real',
        'saldo_insoluto',
        'saldo_plazo',
        'fecha_termino_id',
        'fecha_termino',
        'fecha_anterior_id',
        'pagado',
        'plazo_cobro',
        'total_credito',
        'saldo_fecha',
        'active',
        'fecha_baja',
        'comentario_baja',
        'rfc',
        'is_liquidacion', //*sirve para marcar si un credito se liquido y no alterar fecha_termino_id en la actualizacion del credito cuando se ejecuta la formula
        'refinanciable',
        'pago_fijo',
        'status',

        'cartera_activo',
        'cartera_colocado_mes',
        'cartera_pagado_mes',
        'cartera_capital_colocado',
        'cartera_capital_pagado',
        'cartera_capital_saldo',
        'cartera_interes_pagado',
        'cartera_iva_pagado',
        'cartera_interes_devengado',
        'cartera_iva_devengado',
        'cartera_interes_vencido',
        'cartera_iva_vencido',
        'cartera_total_saldo',

        'saldo_vencido_capital',
        'saldo_vencido_interes',
        'saldo_vencido_iva',
        'saldo_vencido_total',
        'saldo_actual',

        'investor_id',
        'financial_product_id',
        'opening_commission_type',
        'opening_commission_amount',
        'collection_commission_rate',
        'collection_commission',
        'kc_credit_id'

    ];
}
