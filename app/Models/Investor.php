<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        'pending_funded_capital',
        'pending_withdrawn_money',
        'pending_funding_amount',
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


    public static function updateInvestorBalances($investorId)
    {
        $investor = Investor::find($investorId);

        if (!$investor) {
            Log::warning("Investor ID $investorId not found.");
            return null;
        }

        // ✅ Paso 1: Obtener todas las transacciones con sumatorias por tipo y estatus
        $transactions = Transaction::where('investor_id', $investorId)
            ->whereIn('transaction_type', [1, 2])
            ->selectRaw("
                SUM(CASE WHEN transaction_type = 1 AND operation_status = 1 THEN amount ELSE 0 END) AS funded_capital,
                SUM(CASE WHEN transaction_type = 1 AND operation_status != 1 THEN amount ELSE 0 END) AS pending_funded_capital,
                SUM(CASE WHEN transaction_type = 2 AND operation_status = 1 THEN amount ELSE 0 END) AS withdrawn_money,
                SUM(CASE WHEN transaction_type = 2 AND operation_status != 1 THEN amount ELSE 0 END) AS pending_withdrawn_money
            ")
            ->first();

        // ✅ Paso 2: Obtener inversiones y capital colocado
        $investments = InvestorsCredit::where('investor_id', $investorId)
            ->where('status', '>=', 1)
            ->selectRaw("
                SUM(CASE WHEN status > 2 THEN import ELSE 0 END) AS total_capital,
                SUM(CASE WHEN status < 3 THEN import ELSE 0 END) AS loans_in_process,
                SUM(CASE WHEN status > 2 THEN placed_capital ELSE 0 END) AS placed_capital
            ")
            ->first();

        // ✅ Paso 2.1: Calcular pending_funding_amount
        $pendingFundingAmount = Credit::whereIn('applied_financial_product', function ($query) use ($investorId) {
                $query->select('financial_products_id')
                    ->from('investor_products')
                    ->where('investor_id', $investorId);
            })
            ->where('status', 0)
            ->where('canceled', 0)
            ->sum('applied_import');

        // ✅ Paso 3: Valores con fallback
        $fundedCapital = $transactions->funded_capital ?? 0;
        $pendingFundedCapital = $transactions->pending_funded_capital ?? 0;
        $withdrawnMoney = $transactions->withdrawn_money ?? 0;
        $pendingWithdrawnMoney = $transactions->pending_withdrawn_money ?? 0;

        $totalCapital = $investments->total_capital ?? 0;
        $loansInProcess = $investments->loans_in_process ?? 0;
        $placedCapital = $investments->placed_capital ?? 0;

        // ✅ Paso 4: Cálculo de disponibilidad
        $totalAvailable = $fundedCapital
            - $totalCapital
            - $loansInProcess
            + $investor->total_collected
            - $investor->collection_commission
            - $investor->iva_commission
            - $withdrawnMoney
            - $pendingWithdrawnMoney;

        // ✅ Paso 5: Calcular monto prestado desde última actualización
        $loanUsed = ($investor->lendable_updated_time !== null)
            ? InvestorsCredit::where('investor_id', $investorId)
                ->where('status', '!=', 0)
                ->where('created_at', '>', $investor->lendable_updated_time)
                ->sum('import')
            : 0;

        $loanAvailable = $investor->lendable - $loanUsed;

        // ✅ Paso 6: Activación
        $loanActive = $loanAvailable >= 200 ? 1 : 0;

        // ✅ Paso 7: Disponible para retiro (sin duplicar resta de pendingWithdrawnMoney)
        $withdrawAvailable = max(0, $totalAvailable - $loanAvailable);

        // ✅ Paso 8: Valor total de la cuenta
        $accountValue = $totalAvailable + $loansInProcess + $pendingWithdrawnMoney + $placedCapital;

        // ✅ Paso 9: Actualizar campos del inversionista
        $investor->update([
            'funded_capital' => $fundedCapital,
            'pending_funded_capital' => $pendingFundedCapital,
            'withdrawn_money' => $withdrawnMoney,
            'pending_withdrawn_money' => $pendingWithdrawnMoney,
            'total_capital' => $totalCapital,
            'total_available' => $totalAvailable,
            'loans_in_process' => $loansInProcess,
            'loan_available' => $loanAvailable,
            'loan_active' => $loanActive,
            'withdraw_available' => $withdrawAvailable,
            'account_value' => $accountValue,
            'placed_capital' => $placedCapital,
            'pending_funding_amount' => $pendingFundingAmount,
        ]);

        return $investor;
    }


    public static function updateFinancialProductsLoanAvailable($investorId)
    {
         // Obtener los productos financieros asociados al inversionista
         $financialProductInvestorsIds = InvestorProduct::where('investor_id', $investorId)
         ->pluck('financial_products_id')
         ->unique();
 
         foreach ($financialProductInvestorsIds as $financialProductId) {
             // Obtener todos los inversionistas activos del producto financiero
             $investorIds = InvestorProduct::where('financial_products_id', $financialProductId)
                 ->pluck('investor_id');
 
             // Sumar solo loan_available de inversionistas activos
             $investorLoan = Investor::whereIn('id', $investorIds)
                 ->where('loan_active', 1)
                 ->sum('loan_available');
 
             // Actualizar el loan_available total en el producto financiero
             FinancialProduct::where('id', $financialProductId)
                 ->update(['loan_available' => $investorLoan]);
 
         }
    }

    public static function updateInvestorData($investorId)
    {
        // Primero, actualiza los balances del inversionista
        self::updateInvestorBalances($investorId);
        
        // Luego, actualiza loan_available en financial_products basado en los inversionistas
        self::updateFinancialProductsLoanAvailable($investorId);
        
    }

}
