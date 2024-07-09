<?php
namespace App\Models\kaaxSidecc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use HasFactory;
    protected $connection = 'kaax_sidecc';
    protected $fillable = [
        'credit_id',
        'numero_de_pago',
        'pagado',
        'pago_acomulado',
        'cantidad_pagos',
        'entero',
        'decimal',
        'numero_ta',
        'fecha_envio_id',
        //'fecha_ta',
        'saldo_total',
        'abono',
        'interes',
        'iva',
        'saldo_capital',
        'abono_acomulado',
        'fecha_pago',
        'tipo_de_pago',
        'forma_de_pago',
        'estatus_pago',
        'agreement_collection_id_record',
        'client_id',
        'agreement_id',
        'folio',
        'motivo_pago',
        'moneda',
        'pago_acomulado_n',
        'abono_acomulado_n',
        'pago_id', //*se relaciona si viene del modulo de pagos
        'comentario',
        'investor_id',
        'collection_commission_rate',
        'collection_commission_amount',
    ];

}