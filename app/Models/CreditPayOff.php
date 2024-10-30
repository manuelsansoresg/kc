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

    public static function saveEdit($request)
    {
        $data = $request->data;
        $creditPayOffId = $request->creditPayOffId;

        if ($creditPayOffId == null) {
            $creditPay = CreditPayOff::create($data);
        } else {
            $creditPay = CreditPayOff::where('id', $creditPayOffId)->update($data);

        }
        return $creditPay;
    }
}
