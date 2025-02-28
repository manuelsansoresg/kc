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
        'lendable_updated_time',
        'total_balance',
        'iva_collected',
        'loans_in_process',
        'account_value',
        'iva_commission',
    ];

    public static function setLendableAndLoanAvailable($investorId, $lendable)
    {
        
        $loan = InvestorsCredit::selectRaw('SUM(import) as total')
            ->where('investor_id', $investorId)
            ->where('created_at', '>', now()) // Mejor usar now() en Laravel
            ->where('status', '<>', 0)
            ->first();
        $totalLoan =  $loan == null ? 0 : $loan->total;
        $loan_available = $lendable - $totalLoan;
        Investor::where('id', $investorId)->update([
            'lendable' => $lendable,
            'lendable_updated_time' => now(), // Mejor usar now() en Laravel
            'loan_available' => $loan_available,
        ]);
        
        
        //Transaction::setTotalCapital($investorId);
        
        
    }

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
        /* if ($checkIslimit == true) {
            $data['lendable'] = 9999999;
        } */
        Investor::where('id', $investorId)->update($data);
        //Transaction::setTotalCapital($investorId);
    }

    public static function updateFinancialProductsLoanAvailable($investorId)
    {
        // Obtener los productos financieros asociados al inversionista
        $financialProductInvestorsIds = InvestorProduct::where('investor_id', $investorId)
            ->pluck('financial_products_id')
            ->unique();

        foreach ($financialProductInvestorsIds as $financialProductId) {
            // Obtener todos los inversionistas del producto financiero
            $investorIds = InvestorProduct::where('financial_products_id', $financialProductId)
                ->pluck('investor_id');

            // Calcular la suma de loan_available de los inversionistas activos
            $investorLoan = Investor::whereIn('id', $investorIds)
                ->where('loan_active', 1)
                ->sum('loan_available');

            // Actualizar loan_available en financial_products
            FinancialProduct::where('id', $financialProductId)
                ->update(['loan_available' => $investorLoan]);
        }
    }

    public static function updateInvestorBalances($investorId)
    {
        $investor = Investor::find($investorId);
        if (!$investor) {
            return null;
        }

        // Calcular funded_capital
        $fundedCapital = Transaction::where('investor_id', $investorId)
            ->where('transaction_type', 1)
            ->where('operation_status', 1)
            ->sum('amount');
        
        // Calcular withdrawn_money
        $withdrawnMoney = Transaction::where('investor_id', $investorId)
            ->where('transaction_type', 2)
            ->where('operation_status', 1)
            ->sum('amount');
        
        // Calcular total_capital
        $totalCapital = InvestorsCredit::where('investor_id', $investorId)
            ->where('status', '!=', 0)
            ->sum('import');
        
        // Calcular total_available
        $totalAvailable = $fundedCapital - $totalCapital + $investor->total_collected - $investor->collection_commission - $withdrawnMoney;
        
        // Calcular loans_in_process
        $loansInProcess = $totalCapital - $investor->placed_capital - $investor->recovered_capital;
        
        // Calcular loan_available
        $loanAvailable = $investor->lendable - InvestorsCredit::where('investor_id', $investorId)
            ->where('status', '!=', 0)
            ->where('created_at', '>', $investor->lendable_updated_time)
            ->sum('import');
        
        // Calcular loan_active
        $loanActive = $loanAvailable > 999 ? 1 : 0;
        
        // Calcular withdraw_available
        $withdrawAvailable = $totalAvailable - $loanAvailable;
        
        // Calcular account_value
        $accountValue = $totalAvailable + $loansInProcess + $investor->placed_capital;
        
        // Actualizar la base de datos
        Investor::where('id', $investorId)->update([
            'funded_capital' => $fundedCapital,
            'withdrawn_money' => $withdrawnMoney,
            'total_capital' => $totalCapital,
            'total_available' => $totalAvailable,
            'loans_in_process' => $loansInProcess,
            'loan_available' => $loanAvailable,
            'loan_active' => $loanActive,
            'withdraw_available' => $withdrawAvailable,
            'account_value' => $accountValue
        ]);

        return Investor::find($investorId);
    }

    public static function updateInvestorData($investorId)
    {
        // Primero, actualiza los balances del inversionista
        self::updateInvestorBalances($investorId);

        // Luego, actualiza loan_available en financial_products basado en los inversionistas
        self::updateFinancialProductsLoanAvailable($investorId);
    }

}
