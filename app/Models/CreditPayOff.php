<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditPayOff extends Model
{
    use HasFactory;
    protected $table = 'credit_pay_off';
    protected $fillable = [
        'client_person_id',
        'lead_id',
        'new_kc_credit_id',
        'kc_credit_id_payed_off',
        'financial_product_id',
        'bank_clabe',
        'bank_clabe_valid',
        'ammount',
    ];
}
