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
    ];


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

    public static function getProductByFinancial($financial_id)
    {
        $products = FinancialProduct::where('financial_id', $financial_id)->get();
        return $products;
    }
}
