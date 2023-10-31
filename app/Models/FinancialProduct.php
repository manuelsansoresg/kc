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

        'tipo_persona',
        'edad',
        'antiguedad_laboral',
        'antiguedad_residencial',
        'ingreso_minimo',
        'buen_historial_crediticio',
        'aval_garantia',
        'recibir_sueldo_nomina',
        'identificacion_oficial_vig',
        'comprobante_domicilio',
        'comprobante_ingresos',
        'doc_complementaria',
        
        'regulacion',
        
        'is_tramitar',

        'min_loan_amount',
        'means_channels_of_disposal',
        'coverage',
        'purpose_of_loan',
        'minimum_interest_rate',
        
        'alcance_beneficios',
        'restriccion_exclusion',
        'programa_educacion_financiera',
        'referencia_comparativa',
    ];

    public static function getbyIdFirst($product_id)
    {
        $sql = FinancialProduct::select('commercial_name', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
            'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity',
            'chart_costo_anual_total', 'chart_comision_apertura', 'chart_plazo_maximo', 'chart_capital', 'chart_interes', 'chart_comision', 'chart_iva',
            'financial_products.id as id', 'aval_o_garantia', 'consulta_buro'
        )
            ->join('financials', 'financials.id', 'financial_products.financial_id')
            ->where('financial_products.id', $product_id)
            ->orderBy('rate_kc', 'DESC')->first();
        return $sql;
    }
    
    public static function getAll()
    {
        $sql = FinancialProduct::select('commercial_name', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
            'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity',
            'chart_costo_anual_total', 'chart_comision_apertura', 'chart_plazo_maximo', 'chart_capital', 'chart_interes', 'chart_comision', 'chart_iva',
            'financial_products.id as id', 'aval_o_garantia', 'consulta_buro'
        )
            ->join('financials', 'financials.id', 'financial_products.financial_id')
            ->orderBy('rate_kc', 'DESC')->get();
        return $sql;
    }
    
    public static function getAllByTemplate()
    {
        $sql = FinancialProduct::select('commercial_name', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
            'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity',
            'chart_costo_anual_total', 'chart_comision_apertura', 'chart_plazo_maximo', 'chart_capital', 'chart_interes', 'chart_comision', 'chart_iva',
            'financial_products.id as id', 'aval_o_garantia', 'consulta_buro',
            DB::raw('CONCAT(commercial_name, " - ", alias) as full_name')
        )
            ->join('financials', 'financials.id', 'financial_products.financial_id')
            ->orderBy('rate_kc', 'DESC')->get();
        return $sql;
    }

    public static function getByRate($credit)
    {
        DB::connection()->enableQueryLog();
        $agreement_id           = $credit->agreement_id;
        $type_product_id        = $credit->tipo_credito;
       
        $financial_agreements   = FinancialAgreement::where('agreement_id', $agreement_id)->get();
        $financial_ids          = array();
        $financial_product_ids  = array();
        $products = CurrentFinancialProduct::where(['id_rel' => $credit->id , 'type' => 2])->get();
        
        foreach ($financial_agreements as $financial_agreement) {
            $financial_ids[] = $financial_agreement->product_id;
        }
        
        $sql = FinancialProduct::select('commercial_name', 'is_tramitar', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
            'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity',
            'chart_costo_anual_total', 'chart_comision_apertura', 'chart_plazo_maximo', 'chart_capital', 'chart_interes', 'chart_comision', 'chart_iva',
            'financial_products.id as id', 'aval_o_garantia', 'consulta_buro'
        )
            ->join('financials', 'financials.id', 'financial_products.financial_id')
            ->whereIn('financial_products.id', $financial_ids)
            ->where('financial_products.type_product_id', $type_product_id)
            ->orderBy('rate_kc', 'DESC')->get();
        $consulta_buro          = $credit->consulta_buro;
        $bank_id                = $credit->bank_id;
        $aval_o_garantia        = $credit->aval_o_garantia;
        $queries = DB::getQueryLog();
        //dd($financial_ids, $type_product_id);
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

        foreach ($products as $product) {
            // Itera a través de los productos y compara con $financial_product_ids
            if (!in_array($product->product_id, $financial_product_ids)) {
                $financial_product_ids[] = $product->product_id;
            }
        }
        //dd($consulta_buro,  $bank_id, $aval_o_garantia, $financial_product_ids);

        $result = FinancialProduct::select('commercial_name', 'is_tramitar', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
            'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity',
            'chart_costo_anual_total', 'chart_comision_apertura', 'chart_plazo_maximo', 'chart_capital', 'chart_interes', 'chart_comision', 'chart_iva',
            'financial_products.id as id', 'aval_o_garantia', 'consulta_buro'
        )
            ->join('financials', 'financials.id', 'financial_products.financial_id')
            ->whereIn('financial_products.id', $financial_product_ids)
            ->orderBy('rate_kc', 'DESC')->get();
        
        
        return $result;
    }

    public static function saveEdit($request)
    {
        if ($request->product_id == null) {
            $financial_product = FinancialProduct::create($request->except(['_token', 'product_id', 'is_required', 'principal_pay', 'periodicity_id']));
        } else {
            $financial_product = FinancialProduct::find($request->product_id);
            $financial_product->fill($request->except(['_token', 'product_id', 'is_required', 'principal_pay', 'periodicity_id']));
            $financial_product->update();
        }
        //*guardar las opciones multiples
        if (isset($request->periodicity_id)) {
            $perodicities = $request->periodicity_id;
            $principal_pays = $request->principal_pay;
            
            $get_periodicities = ProductPeriodicity::where('product_id', $financial_product->id)->get();
            $get_payments = ProductPaymentMethod::where('product_id', $financial_product->id)->get();
            foreach ($get_periodicities as $get_periodicity) {
                ProductPeriodicity::where([
                                        'product_id'=> $get_periodicity->product_id,
                                        ])->delete();
            }
            
            foreach ($get_payments as $get_payment) {
                ProductPaymentMethod::where([
                                        'product_id'=> $get_payment->product_id,
                                        ])->delete();
            }
           
           
    
            foreach ($perodicities as $periodicity_id) {
                ProductPeriodicity::create(
                    [
                        'periodicity_id' => $periodicity_id,
                        'product_id' => $financial_product->id,
                    ]
                );
            }
           
            foreach ($principal_pays as $principal_pay) {
                ProductPaymentMethod::create(
                    [
                        'payment_method_id' => $principal_pay,
                        'product_id' => $financial_product->id,
                    ]
                );
            }
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

    public static function existMyFinancial($financial_products, $credit_id)
    {

        $my_product_financials = CurrentFinancialProduct::
                                select('commercial_name', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
                                    'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity',
                                    'chart_costo_anual_total', 'chart_comision_apertura', 'chart_plazo_maximo', 'chart_capital', 'chart_interes', 'chart_comision', 'chart_iva',
                                    'financial_products.id as id', 'aval_o_garantia', 'consulta_buro'
                                )
                                ->join('financial_products', 'financial_products.id', 'current_financial_products.product_id')
                                ->join('financials', 'financials.id', 'financial_products.financial_id')
                                ->where(['id_rel' => $credit_id, 'type' =>2])
                                ->orderBy('rate_kc', 'ASC')
                                ->first();
        //dd($financial_products);
        /* foreach ($financial_products as $financial_products) {
            foreach ($my_product_financials as $my_product_financial) {
                if ($my_product_financial != null && $my_product_financial->id == $financial_products->id) {
                    $is_financial = false;
                }
            }
            
        } */
        
        
        //return $is_financial == true ? $my_product_financial : null;
        return $my_product_financials;
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

    public function financialAgreement()
    {
        return $this->hasMany(FinancialAgreement::class);
    }
}
