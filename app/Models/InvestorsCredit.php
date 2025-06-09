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
        'refinanciable',
    ];

    

    public static function lockFundingIfComplete($creditId)
    {
        $credit = Credit::find($creditId);

        if (!$credit) return;

        // Solo bloquear si está totalmente fondeado
        if ($credit->funding_capital >= $credit->applied_import) {
            $credit->funding_locked = 1;
            $credit->save();
        }
    }   

    /* public static function updateInvestorCredits($investorId)
    {
        // Obtener los productos financieros relacionados con el inversionista
        $financialProductIds = InvestorProduct::where('investor_id', $investorId)->pluck('financial_products_id');

        if ($financialProductIds->isEmpty()) {
            return; // No hay productos financieros asociados
        }

        // Obtener los créditos relacionados con esos productos financieros
        $creditIds = Credit::whereIn('applied_financial_product', $financialProductIds)->pluck('id');

        // Ejecutar saveEdit para cada crédito
        foreach ($creditIds as $creditId) {
            self::saveEdit($creditId); // Asegúrate de ajustar la clase si saveEdit no está en la misma
        }
    } */

     /**
     * Reparte fondos pendientes a los créditos FIFO de un producto financiero,
     * teniendo en cuenta los importes ya “reservados” en InvestorsCredit.import
     * de créditos pendientes (status = 1 y funding_locked = 0).
     */
    public static function fundPendingCredits(int $financialProductId): void
    {
        // 1. Obtener el producto financiero y su disponibilidad actual
        $financialProduct = FinancialProduct::find($financialProductId);
        if (!$financialProduct || $financialProduct->loan_available <= 0) {
            return;
        }

        // 2. Obtener IDs de créditos pendientes: 
        //    - applied_financial_product = $financialProductId
        //    - funding_locked = 0
        //    - tienen al menos un registro InvestorsCredit.status = 1
        $pendingCreditIds = Credit::where('applied_financial_product', $financialProductId)
            ->where('funding_locked', 0)
            ->whereHas('investorsCredits', function ($q) {
                $q->where('status', 1);
            })
            ->orderBy('created_at', 'asc')
            ->pluck('id')
            ->toArray();

        if (empty($pendingCreditIds)) {
            return;
        }

        // 3. Sumar los “import” ya reservados (status = 1) de esos créditos pendientes
        $reservedTotal = InvestorsCredit::whereIn('credit_id', $pendingCreditIds)
            ->where('status', 1)
            ->sum('import');

        // 4. Recalculamos el pool disponible: 
        //    loan_available actual + reservedTotal
        $newAvailable = $financialProduct->loan_available + $reservedTotal;

        // 5. Eliminar todos los registros InvestorsCredit de esos créditos pendientes
        InvestorsCredit::whereIn('credit_id', $pendingCreditIds)
            ->where('status', 1)
            ->delete();

        // 6. Actualizar loan_available del producto con el nuevo pool
        $financialProduct->loan_available = $newAvailable;
        $financialProduct->save();

        // 7. Volver a obtener los créditos ordenados FIFO
        $pendingCredits = Credit::whereIn('id', $pendingCreditIds)
            ->where('funding_locked', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        // 8. Iterar sobre cada crédito pendiente en orden
        $remainingPool = $financialProduct->loan_available;
        $processedCreditIds = [];

        foreach ($pendingCredits as $credit) {
            $amountNeeded = $credit->applied_import;

            if ($remainingPool >= $amountNeeded) {
                // Puede fondear este crédito en su totalidad
                self::saveEdit($credit->id);

                // Recargar loan_available tras saveEdit
                $financialProduct->refresh();
                $remainingPool = $financialProduct->loan_available;

                // Marcar funding_locked = 1 porque quedó fondeado al 100%
                $credit->funding_locked = 1;
                $credit->save();

                $processedCreditIds[] = $credit->id;

                // Si ya no queda pool, rompemos
                if ($remainingPool <= 0) {
                    break;
                }
            } else {
                // Si el pool no alcanza para este crédito, salimos del bucle
                break;
            }
        }

        // 9. Para todos los créditos que quedaron en $pendingCreditIds 
        //    pero no entraron en $processedCreditIds (es decir, no pudieron fondearse):
        //    Insertar un registro InvestorsCredit con investor_id=null para ellos
        $unfundedCreditIds = array_diff($pendingCreditIds, $processedCreditIds);

        foreach ($unfundedCreditIds as $creditId) {
            $credit = Credit::find($creditId);
            if (!$credit) {
                continue;
            }
            // Insertar inversión “nula” que reserva el importe entero
            InvestorsCredit::create([
                'credit_id'       => $credit->id,
                'investor_id'     => null,
                'percentage'      => 0,
                'import'          => $credit->applied_import,
                'total_credit'    => $credit->applied_loan_total_amount,
                'commission_rate' => $financialProduct->collection_commission_rate,
                'status'          => 1,
            ]);

            // Marcar funding_locked = 1 para indicar que ya fue considerado
            $credit->funding_locked = 1;
            $credit->save();
        }
    }

    /**
     * Asigna fondos de inversionistas activos a un crédito que sabemos
     * puede ser fondeado 100% (FIFO asegura loan_available >= applied_import).
     * Después de repartir entre inversionistas, actualiza loan_available
     * y bloquea funding_locked en el crédito.
     *
     * NOTA: ya no debe manejar caso “sin inversionistas” ni insertar investor_id=null.
     */
    public static function saveEdit(int $creditId): void
    {
        $credit = Credit::find($creditId);
        if (!$credit) {
            return;
        }

        // Si ya está bloqueado, no volvemos a procesarlo
        if ($credit->funding_locked == 1) {
            return;
        }

        $appliedFinancialProduct = $credit->applied_financial_product;
        $amountRequired          = $credit->applied_import;
        $loanTotalAmount         = $credit->applied_loan_total_amount;

        $financialProduct = FinancialProduct::find($appliedFinancialProduct);
        if (!$financialProduct) {
            return;
        }

        $poolAvailable = $financialProduct->loan_available;
        // Dado que fundPendingCredits asegura que poolAvailable >= amountRequired,
        // procedemos a repartir entre inversionistas activos:
        $investorProducts = InvestorProduct::where('financial_products_id', $appliedFinancialProduct)->get();
        $assignedSum      = 0;

        foreach ($investorProducts as $invProd) {
            $investor = Investor::find($invProd->investor_id);
            if (!$investor || $investor->loan_active != 1) {
                continue;
            }

            // Cálculo de porcentaje en función de loan_available y amountRequired
            // (poolAlive >= amountRequired garantiza que podemos usar la misma lógica FIFO)
            $maxAmount = max($poolAvailable, $amountRequired);
            $percent   = $poolAvailable > 0
                ? ($investor->loan_available / $maxAmount) * 100
                : 0;
            $percent = min($percent, 100);

            $import       = ($percent * $amountRequired) / 100;
            $totalCredit  = ($percent * $loanTotalAmount) / 100;

            // Crear/actualizar InvestorsCredit (status = 1)
            $existing = InvestorsCredit::where('credit_id', $credit->id)
                ->where('investor_id', $investor->id)
                ->first();

            $recordData = [
                'credit_id'       => $credit->id,
                'investor_id'     => $investor->id,
                'percentage'      => $percent,
                'import'          => $import,
                'total_credit'    => $totalCredit,
                'commission_rate' => $financialProduct->collection_commission_rate,
                'status'          => 1,
            ];

            if ($existing) {
                // Solo actualizar si está en status = 1
                if ($existing->status == 1) {
                    $existing->update($recordData);
                }
            } else {
                InvestorsCredit::create($recordData);
            }

            $assignedSum += $import;
        }

        // 3. Actualizar funding_capital y bloquear funding_locked
        $credit->funding_capital = $assignedSum;
        if ($assignedSum >= $amountRequired) {
            $credit->funding_locked = 1;
        }
        $credit->save();

        // 4. Actualizar credit_active y sod_active en client_person
        $clientPersonId = $credit->client_person_id;
        $hasActiveCredit = InvestorsCredit::whereIn(
                'credit_id',
                Credit::where('client_person_id', $clientPersonId)
                      ->where('product_id', '!=', 3)
                      ->pluck('id')
            )
            ->whereNotIn('status', [0, 3])
            ->exists();

        $hasActiveSod = InvestorsCredit::whereIn(
                'credit_id',
                Credit::where('client_person_id', $clientPersonId)
                      ->where('product_id', '=', 3)
                      ->pluck('id')
            )
            ->whereNotIn('status', [0, 3])
            ->exists();

        ClientPerson::where('id', $clientPersonId)->update([
            'credit_active' => $hasActiveCredit ? 1 : 0,
            'sod_active'    => $hasActiveSod ? 1 : 0,
        ]);

        // 5. Validación en mesa de control (Fondos suficientes)
        $statusSOD = ($amountRequired > $poolAvailable) ? 0 : 1;
        $request         = new \stdClass();
        $request->{'fondos-suficientes'} = $statusSOD;
        CreditsControlDesk::saveEdit($creditId, $request, 'Fondos suficientes');

        // 6. Finalmente actualizar balances de inversionistas involucrados
        $investorIds = InvestorsCredit::where('credit_id', $creditId)
            ->whereNotNull('investor_id')
            ->pluck('investor_id')
            ->unique();

        foreach ($investorIds as $investorId) {
            Investor::updateInvestorData($investorId);
        }

        // 7. Actualizar loan_available del producto
        //    (en caso de que los inversores hayan quedado con menos disponibilidad)
        $newPool = Investor::whereIn(
                'id',
                InvestorProduct::where('financial_products_id', $appliedFinancialProduct)
                                ->pluck('investor_id')
            )
            ->where('loan_active', 1)
            ->sum('loan_available');

        $financialProduct->loan_available = $newPool;
        $financialProduct->save();
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
