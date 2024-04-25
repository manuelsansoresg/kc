<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_capital',
        'placed_capital',
        'recovered_capital',
        'total_collected',
        'profit_collected',
        'loan_available',
        'total_available',
        'collection_commission',
        'lendable',
        'withdraw_available',
        'agreements_id',
        'financial_products_id',
        'loan_active_to_investors',
        'loan_active'
    ];

    public static function setLendable($request)
    {
        $investorId   = $request->investorId;
        $checkIslimit = isset($request->checkIslimit)? $request->checkIslimit : 0;
        $data         = $request->data;
        if ($checkIslimit == true) {
            $data['lendable'] = 9999999;
        }
        Investor::where('id', $investorId)->update($data);
        Transaction::setTotalCapital($investorId);
    }
}
