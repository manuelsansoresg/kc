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
        return FinancialProduct::select('commercial_name', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
                                'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity')
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
    
    

    public static function customSortFinancials($financial_products)
    {
        // Ordenar $financial_products en función del rate_kc en orden descendente
        $sortedFinancials = $financial_products->sortByDesc('rate_kc')->values();

        // Obtener los tres primeros elementos con el rating más alto
        $topThree = $sortedFinancials->take(3);

        // Crear un nuevo arreglo con el orden personalizado
        $sortedFinancials = $topThree;

        // Verificar si hay al menos 4 elementos antes de acceder al índice 3
        if ($sortedFinancials->count() >= 4) {
            // Obtener el elemento original en medio
            $sortedFinancials->splice(3, 0, [$sortedFinancials->get(3)]);

            // Verificar si hay más de 4 elementos antes de agregar los restantes
            if ($sortedFinancials->count() > 4) {
                $remaining = $sortedFinancials->splice(4);
                $sortedFinancials = $sortedFinancials->concat($remaining);
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
