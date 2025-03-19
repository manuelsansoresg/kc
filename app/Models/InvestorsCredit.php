<?php

namespace App\Models;

use App\Models\kaaxSidecc\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvestorsCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_id',
        'investor_id',
        'percentage',
        'import',
        'total_collected',
        'placed_capital',
        'commission_rate',
        'commission_amount',
        'recovered_capital',
        'profit_collected',
        'total_credit',
        'status',
        'total_balance',
        'credit_status',
        'iva_collected',
        'iva_commission',
    ];

    public static function saveEdit($creditId)
    {
        $getCredit = Credit::find($creditId);
        if (!$getCredit) {
            return;
        }

        $appliedFinancialProduct = $getCredit->applied_financial_product;
        $appliedImport = $getCredit->applied_import;
        $appliedLoanTotalAmount = $getCredit->applied_loan_total_amount;

        // Obtener el producto financiero del crédito
        $getFinancialProduct = FinancialProduct::find($appliedFinancialProduct);
        if (!$getFinancialProduct) {
            return;
        }

        $totalLoanAvailable = $getFinancialProduct->loan_available;

        // Obtener inversionistas activos que participan en este producto financiero
        $getInvestors = InvestorProduct::where('financial_products_id', $appliedFinancialProduct)
            ->pluck('investor_id');

        $activeInvestors = Investor::whereIn('id', $getInvestors)
            ->where('loan_active', 1)
            ->get();

        foreach ($activeInvestors as $investor) {
            try {
                // Cálculo del porcentaje de participación
                $percent = ($investor->loan_available / $totalLoanAvailable) * 100;

                if ($percent > 0) {
                    // Cálculo del importe proporcional
                    $import = ($percent * $appliedImport) / 100;
                    $totalCredit = ($percent * $appliedLoanTotalAmount) / 100;

                    $dataInvestorCredit = [
                        'credit_id' => $creditId,
                        'investor_id' => $investor->id,
                        'percentage' => $percent,
                        'import' => $import,
                        'commission_rate' => $getFinancialProduct->collection_commission_rate,
                        'total_credit' => $totalCredit,
                        'status' => 1
                    ];

                    // Buscar si ya existe un registro en investors_credits
                    $existInvestorCredit = InvestorsCredit::where('credit_id', $creditId)
                        ->where('investor_id', $investor->id)
                        ->first();

                    if (!$existInvestorCredit) {
                        InvestorsCredit::create($dataInvestorCredit);
                    } else {
                        $existInvestorCredit->update($dataInvestorCredit);
                    }
                }
            } catch (\Exception $e) {
                \Log::error("Error al procesar investor_id {$investor->id}: " . $e->getMessage());
            }
        }

    }

    public static function setPlacedCapital($creditId)
    {
        /* $investors = InvestorsCredit::where('credit_id', $creditId)->get();
        foreach ($investors as $investor) {
            $placedCapital = $investor->total_capital  - $investor->recoverd_capital;
            Investor::where('id', $investor->id)->update([
                'placed_capital' => $placedCapital
            ]);
        } */
    }

    public static function listStatements($investorId)
    {
        $investorCredits = InvestorsCredit::where('investor_id', $investorId)->get();
        $credits = array();
        foreach ($investorCredits as $investorCredit) {
            DB::connection('kaax_sidecc');
            $percentage = $investorCredit->percentage / 100;
            $collections = Collection::select(
                    'collections.kc_credit_id as id', 'statements.fecha_pago', 'statements.tipo_de_pago',
                    'statements.pagado',
                    DB::raw("$percentage * statements.pagado AS importe")
                    )
                    ->join('statements', 'statements.credit_id', 'collections.credit_id')
                    ->where('statements.estatus_pago', 1)
                    ->where('collections.kc_credit_id', $investorCredit->credit_id)->get();
            
            foreach ($collections as $collection) {
                $credits[] = array(
                    'id' => $collection->id,
                    'fecha' => $collection->fecha_pago,
                    'tipo' => isset(config('enums.pago')[$collection->tipo_de_pago])? config('enums.pago')[$collection->tipo_de_pago] : null,
                    'importe' => $collection->importe,
                    'comision' => null,
                    'options' => null,
                );
            }        
           
        }
        return $credits;
    }

    public static function setComissionRateAndAmount($creditId)
    {
        $credit         = Credit::find($creditId);
        $financial      = FinancialProduct::where('id', $credit->applied_financial_product)->first();
        $commissionRate = $financial->collection_commission_rate;

        $getInvestors = InvestorsCredit::where('credit_id', $creditId)->get();

        foreach ($getInvestors  as $getInvestor) {
            $totalCollected = $getInvestor->total_collected;
            $commission_amount = ($commissionRate * $totalCollected) / 100;
            InvestorsCredit::where('id', $getInvestor->id)->update([
                'commission_amount' => $commission_amount,
            ]);
           
        }
    }

   

}
