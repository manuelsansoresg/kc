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
        'loan_active',
        'funded_capital',
        'withdrawn_money',
        'withdrawn_money',
    ];

    public static function setFundedCapital($investorId)
    {
        
        $getTransaction = Transaction::selectRaw('SUM(amount) as amount')
        ->where([
            'operation_status' => 1, 
            'transaction_type' => 1, 
            'investor_id' => $investorId,
        ])->first();
        
        if ($getTransaction != null) {
            Investor::where('id', $investorId)->update([
                'funded_capital' => $getTransaction->amount
            ]);
        }
        
        $getTransactionWithDrawn = Transaction::selectRaw('SUM(amount) as amount')
        ->where([
            'operation_status' => 1,
            'transaction_type' => 2,
            'investor_id' => $investorId,
        ])->first();
        if ($getTransactionWithDrawn != null) {
            Investor::where('id', $investorId)->update([
                'withdrawn_money' => $getTransactionWithDrawn->amount
            ]);
        }
        
    }

    public static function setDataInvestor($investorId)
    {
        $sum = InvestorsCredit::selectRaw('
            SUM(import) as import,
            SUM(total_collected) as total_collected,
            SUM(recovered_capital) as recovered_capital,
            SUM(placed_capital) as placed_capital,
            SUM(commission_amount) as commission_amount,
            SUM(profit_collected) as profit_collected
            ')->where('investor_id', $investorId)
            ->first();
        
        InvestorsCredit::where('investor_id', $investorId)->update([
            'import' => $sum->import, 
            'total_collected' => $sum->total_collected, 
            'recovered_capital' => $sum->recovered_capital, 
            'placed_capital' => $sum->placed_capital, 
            'commission_amount' => $sum->commission_amount, 
            'profit_collected' => $sum->profit_collected, 
        ]);

    }


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
