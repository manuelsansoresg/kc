<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'financial_id',
        'name',
        'alias',
        'type_product_id',
        'status',

        'collateral_id',
        'periodicity_id',
        'max_credit_amount',
        'min_deadline_month',
        'max_deadline_month',
        'type_interest',
        'pay_form',
        'annual_int_rate_iva',
        'real_cat',
        'principal_pay',
        'resolution_time_hours',
        'delivery_time_hours',
        'moratorium_int_rate_vat',

        'perc_opening_commission',
        'means_pay_arrangement_id',
        'life_insurance_commission_perc',
        'means_pay_life_insurance_id',
        'unemploy_insurance_commission_perc',
        'means_pay_unemploy_insurance_id',
        'unrecognized_transactions_or_charges',
        'administration_or_account_management',
        'drawdown_of_receivables',
        'non_payment',
        'collection_costs',
        'inv_formalization_expenses',
        'prepayment_prepaid',
        'late_or_untimely_pay',
        'statement_reprint',
        'rep_of_means_of_disposal',
        
        'reca',
        'num_reca',
        'allows_prepayments',
        'prepayment_procedure',
        'allows_early_term_contract',
        'procedure_early_term_contract',
        'type_signature_id',
        'query_credit',
        'abusive_clause1',
        'abusive_clause2',
        'abusive_clause3',
        'abusive_clause4',
        'abusive_clause5',
        'abusive_clause6',
        'abusive_clause7',
        'abusive_clause8',
        'abusive_clause9',
        'abusive_clause10',
        'abusive_clause11',
        'abusive_clause12',
        'abusive_clause13',
        'bank_id',
        'consulta_buro',
        'rate_kc',
        'rate_cat',
        'rate_comision',
        'rate_deadline',
        'rate_contract',
        'rate_privacity',
    ];


    public static function getByRate()
    {
        return FinancialProduct::select('commercial_name', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc')
                        ->join('financials', 'financials.id', 'financial_products.financial_id')
                        ->orderBy('rate_kc', 'DESC')
                        ->get();
    }

    public static function saveEdit($request)
    {
        if ($request->product_id == null) {
            $financial_product = FinancialProduct::create($request->except(['_token', 'product_id', 'is_required']));
        } else {
            $financial_product = FinancialProduct::find($request->product_id);
            $financial_product->fill($request->except(['_token', 'product_id', 'is_required']));
            $financial_product->update();
        }
        return $financial_product;
    }
    
    public static function FinancialAndProductByRate($financials)
    {
        $new_financials = [];
        foreach ($financials as $financial) {
            $object_financial = $financial->financial;
            $products = FinancialProduct::where('financial_id', $object_financial->id)
                        ->orderBy('rate_kc', 'DESC')
                        ->get();
    
            $highest_rate_kc = $products->max('rate_kc'); // Obtener el valor más alto de rate_kc
    
            $new_financials[] = [
                'id' => $financial->id,
                'name' => $object_financial->commercial_name,
                'highest_rate_kc' => $highest_rate_kc,
                'products' => $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'rate_kc' => $product->rate_kc,
                    ];
                })->toArray(),
            ];
        }
    
        // Ordenar $new_financials en función del highest_rate_kc en orden descendente
        usort($new_financials, function ($a, $b) {
            return $b['highest_rate_kc'] - $a['highest_rate_kc'];
        });
    
        return $new_financials;
    }

    public static function customSortFinancials($new_financials)
    {
         // Ordenar $new_financials en función del highest_rate_kc en orden descendente
        usort($new_financials, function ($a, $b) {
            return $b['highest_rate_kc'] - $a['highest_rate_kc'];
        });

        // Obtener los tres primeros elementos con el rating más alto
        $topThree = array_slice($new_financials, 0, 3);

        // Crear un nuevo arreglo con el orden personalizado
        $sortedFinancials = $topThree;

        // Verificar si hay al menos 4 elementos antes de acceder al índice 3
        if (count($new_financials) >= 4) {
            // Obtener el elemento original en medio
            $sortedFinancials[] = $new_financials[3];

            // Verificar si hay más de 4 elementos antes de agregar los restantes
            if (count($new_financials) > 4) {
                $sortedFinancials = array_merge($sortedFinancials, array_slice($new_financials, 4));
            }
        }

        return $sortedFinancials;
    }

    
    public static function getProductByFinancial($financial_id)
    {
        $products = FinancialProduct::where('financial_id', $financial_id)->get();
        return $products;
    }
}
