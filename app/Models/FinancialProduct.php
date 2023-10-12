<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'chart_costo_anual_total',
        'chart_comision_apertura',
        'chart_plazo_maximo',
        'chart_capital',
        'chart_interes',
        'chart_comision',
        'chart_iva',
        'is_vincular_banco',
        'aval_o_garantia',
    ];


    public static function getByRate($credit)
    {
        DB::connection()->enableQueryLog();
        $agreement_id           = $credit->agreement_id;
        $type_product_id        = $credit->tipo_credito;
       
        $financial_agreements   = FinancialAgreement::where('agreement_id', $agreement_id)->get();
        $financial_ids          = array();
        $financial_product_ids  = array();
        
        
        foreach ($financial_agreements as $financial_agreement) {
            $financial_ids[] = $financial_agreement->financial_id;
        }
        //dd($type_product_id, $financial_ids);
        $sql = FinancialProduct::select('commercial_name', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
            'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity',
            'chart_costo_anual_total', 'chart_comision_apertura', 'chart_plazo_maximo', 'chart_capital', 'chart_interes', 'chart_comision', 'chart_iva',
            'financial_products.id as id', 'aval_o_garantia', 'consulta_buro'
        )
            ->join('financials', 'financials.id', 'financial_products.financial_id')
            ->whereIn('financial_products.financial_id', $financial_ids)
            ->where('financial_products.type_product_id', $type_product_id)
            ->orderBy('rate_kc', 'DESC')->get();
        $consulta_buro          = $credit->consulta_buro;
        $bank_id                = $credit->bank_id;
        $aval_o_garantia        = $credit->aval_o_garantia;
        
        foreach ($sql as $sql_query) {
            $product_aval_o_garantia = $sql_query->aval_o_garantia;
            $product_is_vincular_banco = $sql_query->is_vincular_banco;
            $product_consulta_buro = $sql_query->consulta_buro;
        
            if (($consulta_buro == 1 && $product_consulta_buro == 1) ||
                ($aval_o_garantia == 1 && $product_aval_o_garantia == 1) ||
                ($product_is_vincular_banco == 1 && (!is_null($bank_id) && $bank_id > 0)) ||
                (is_null($consulta_buro) || is_null($aval_o_garantia) || is_null($bank_id))
            ) {
                $financial_product_ids[] = $sql_query->id;
            }
        }
        //dd($consulta_buro,  $bank_id, $aval_o_garantia, $financial_product_ids);

        $result = FinancialProduct::select('commercial_name', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
            'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity',
            'chart_costo_anual_total', 'chart_comision_apertura', 'chart_plazo_maximo', 'chart_capital', 'chart_interes', 'chart_comision', 'chart_iva',
            'financial_products.id as id', 'aval_o_garantia', 'consulta_buro'
        )
            ->join('financials', 'financials.id', 'financial_products.financial_id')
            ->whereIn('financial_products.id', $financial_product_ids)
            ->orderBy('rate_kc', 'DESC')->get();
        
        $queries = DB::getQueryLog();
        return $result;
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
    
    

    public static function customSortFinancials($financial_products, $is_limit = false)
    {
        // Ordenar $financial_products en función del rate_kc en orden descendente
        $sortedFinancials = $financial_products->sortByDesc('rate_kc')->values();

        if ($is_limit == false) {
            
            // Verificar si hay al menos 3 elementos
            if ($sortedFinancials->count() >= 3) {
                // Obtener el elemento con la tasa más alta (en medio)
                $middleElement = $sortedFinancials->first();
    
                // Obtener los elementos restantes (excluyendo el primero que ya está en $middleElement)
                $remainingElements = $sortedFinancials->slice(1);
    
                // Obtener los dos elementos más cercanos al elemento del medio en términos de rate_kc
                $closestElements = $remainingElements->sortBy(function ($element) use ($middleElement) {
                    return abs($element['rate_kc'] - $middleElement['rate_kc']);
                })->take(2)->values();
    
                // Crear un nuevo arreglo con los tres elementos en el orden deseado
                $sortedFinancials = collect([$closestElements[0], $middleElement, $closestElements[1]]);
            } else {
                // Si no hay al menos 3 elementos, devolver el arreglo original
                return $sortedFinancials;
            }
        } else {
            if ($is_limit && $sortedFinancials->count() >= 4) {
                // Obtener los elementos después del tercero
                $sortedFinancials = $sortedFinancials->slice(3);
            }
        }

        return $sortedFinancials;
    }

    public static function getById($id)
    {
        return FinancialProduct::select('commercial_name', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
                                'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity',
                                'chart_costo_anual_total', 'chart_comision_apertura', 'chart_plazo_maximo', 'chart_capital', 'chart_interes', 'chart_comision', 'chart_iva',
                                'financial_products.id as id'
                                )
                        ->join('financials', 'financials.id', 'financial_products.financial_id')
                        ->where('financial_products.id', $id)
                        ->first();
    }

    public static function existMyFinancial($financial_products, $final_financial_products, $myFinancial_id)
    {

        $my_product_financial = FinancialProduct::getById($myFinancial_id);
        $is_financial = true;
        foreach ($financial_products as $financial_products) {
            if ($my_product_financial != null && $my_product_financial->id == $financial_products->id) {
                $is_financial = false;
            }
        }
        
        
        return $is_financial == true ? $my_product_financial : null;
    }



    public static function getList($financial_id)
    {
        $get_financials = FinancialProduct::getProductByFinancial($financial_id);
        $financials = array();
        foreach ($get_financials as $get_financial) {
            $financials[] = $get_financial;
        }
        return $financials;
    }

    
    public static function getProductByFinancial($financial_id)
    {
        $products = FinancialProduct::where('financial_id', $financial_id)->get();
        return $products;
    }
}
