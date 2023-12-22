<?php

namespace App\Models;

use App\Lib\Csendgrid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        'bank_ids', //este campo se renombro antes era bank_id
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
        
        'proceso_tramite',
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

    public static function returnInfo($product, $credit = null, $is_email = false)
    {
        $colateral_products   = config('financial_enums.colateral_products');
        $periodicity_products = config('financial_enums.periodicity_products');
        $interes_rates        = config('financial_enums.interes_rates');
        $principal_pays       = config('financial_enums.principal_pays');
        $colateral            = isset($colateral_products[$product->collateral_id]) ? $colateral_products[$product->collateral_id] : null;
        $type_interest        = isset($interes_rates[$product->type_interest]) ? $interes_rates[$product->type_interest] : null;
        

        $get_periodicities    = ProductPeriodicity::where('product_id', $product->id)->get();
        $get_payments         = ProductPaymentMethod::where('product_id', $product->id)->get();
        $periodicity          = '';
        $payment              = '';

        foreach ($get_periodicities as $periodicities) {
            $periodicity .= $periodicity_products[$periodicities->periodicity_id].',';
        }
        
        foreach ($get_payments as $get_payment) {
            $payment .= $principal_pays[$get_payment->payment_method_id].',';
        }

        $periodicity                      = trim($periodicity, ',');
        $payment                          = trim($payment, ',');
        $alcance_beneficios               = ($product->alcance_beneficios === '0') ? '' : $product->alcance_beneficios;
        $restriccion_exclusion            = ($product->restriccion_exclusion === '0') ? '' : $product->restriccion_exclusion;
        $programa_educacion_financiera    = ($product->programa_educacion_financiera === '0') ? '' : $product->programa_educacion_financiera;
        $referencia_comparativa           = ($product->referencia_comparativa === '0') ? '' : $product->referencia_comparativa;


        $caracteristicas = array(
            'colateral' => $colateral,
            'periodicidad' => $periodicity,
            'max_credit_amount' => format_price($product->max_credit_amount),
            'min_loan_amount' => format_price($product->min_loan_amount),
            'min_deadline_month' => $product->min_deadline_month,
            'max_deadline_month' => $product->max_deadline_month,
            'type_interest' => $type_interest,
            'minimum_interest_rate' => $product->minimum_interest_rate,
            'annual_int_rate_iva' => $product->annual_int_rate_iva,
            'payment' => $payment,
            'resolution_time_hours' => $product->resolution_time_hours,
            'delivery_time_hours' => $product->delivery_time_hours,
            'moratorium_int_rate_vat' => $product->moratorium_int_rate_vat,
            'means_channels_of_disposal' => $product->means_channels_of_disposal,
            'coverage' => $product->coverage,
            'purpose_of_loan' => $product->purpose_of_loan,
            'alcance_beneficios' => $alcance_beneficios,
            'restriccion_exclusion' => $restriccion_exclusion,
            'programa_educacion_financiera' => $programa_educacion_financiera,
            'referencia_comparativa' => $referencia_comparativa,
        );

        $historial_crediticio = $product->buen_historial_crediticio == 1 ? 'Sí' : 'No';
        $historial_crediticio = $product->buen_historial_crediticio != 1 || $product->buen_historial_crediticio != 1 ? null : $historial_crediticio;
        
        $aval_garantia = $product->buen_aval_garantia == 1 ? 'Sí' : 'No';
        $aval_garantia = $product->buen_aval_garantia != 1 || $product->buen_aval_garantia != 1 ? null : $aval_garantia;

        $requisitos = array(
            'tipo_persona' => $product->tipo_persona,
            'edad' => $product->edad,
            'antiguedad_laboral' => $product->antiguedad_laboral,
            'antiguedad_residencial' => $product->antiguedad_residencial,
            'ingreso_minimo' => format_price($product->ingreso_minimo),
            'buen_historial_crediticio' => $historial_crediticio,
            'aval_garantia' => $aval_garantia,
            'recibir_sueldo_nomina' => $product->recibir_sueldo_nomina,
            'identificacion_oficial_vig' => $product->identificacion_oficial_vig,
            'comprobante_domicilio' => $product->comprobante_domicilio,
            'comprobante_ingresos' => $product->comprobante_ingresos,
            'doc_complementaria' => $product->doc_complementaria,
        );

        $fees_comision = ProductFee::where(['financial_product_id'=> $product->id, 'type' => 1])->get();
        $fees_result = ProductFee::where(['financial_product_id'=> $product->id, 'type' => 2])->get();
        if ($is_email == false) {
            $view_caracteristicas = \View::make('report.viewCaracteristicas', ['caracteristicas' => $caracteristicas,  'tramite' => $product->proceso_tramite, 'requisitos' => $requisitos, 'fees_comision' => $fees_comision, 'fees_result' => $fees_result])->render();
            $data = array(
                'caracteristicas' => $view_caracteristicas,
            );
            return $data;
        }
        if ($credit != null && !Session::has('send_email')) {
            $client = $credit->creditClientPerson;
            $financial = Financial::find($product->financial_id);
            $view_caracteristicas = \View::make('report.viewCaracteristicasEmail', ['caracteristicas' => $caracteristicas, 'requisitos' => $requisitos, 'fees_comision' => $fees_comision, 'fees_result' => $fees_result])->render();
            $new_fees_comision = array();
            $new_fees_result = array();
            
            //dd($fees_comision);
            foreach ($fees_comision as $fees) {
                if ($fees->type == 1) {
                    $concepto = isset(config('enums.periodicity_comision')[$fees->periodicidad]) ? config('enums.periodicity_comision')[$fees->periodicidad] : null;
                    $new_fees_comision[] = array(
                       'name' =>  $fees->concepto.'- $'.format_price($fees->valor).' '.$concepto,
                    );
                } else {
                    $concepto = isset(config('enums.periodicity_comision')[$fees->periodicidad]) ? config('enums.periodicity_comision')[$fees->periodicidad] : null;
                    $new_fees_comision[] = array(
                        'name' =>  $fees->concepto.'- '.$fees->porcentaje.'% '.$fees->referencia.' '. $concepto ,
                    );
                }
                
            }
            
            foreach ($fees_result as $fees_comision) {
                if ($fees_comision->type == 1) {
                    $concepto = isset(config('enums.periodicity_comision')[$fees_comision->periodicidad]) ? config('enums.periodicity_comision')[$fees_comision->periodicidad] : null ;
                    $new_fees_result[] = array(
                        'name' =>  $fees_comision->type. $fees_comision->concepto.'- $'.format_price($fees_comision->valor).' '. $concepto,
                    );
                } else {
                    $concepto = isset(config('enums.periodicity_comision')[$fees_comision->periodicidad]) ? config('enums.periodicity_comision')[$fees_comision->periodicidad] : null;
                    $new_fees_result[] = array(
                        'name' =>  $fees_comision->type.$fees_comision->concepto.'- '.$fees_comision->porcentaje.'% '.$fees_comision->referencia.' '. $concepto ,
                    );
                }
                
            }
            $data_sendgrid = array(
                'first_name' => $client->name. ' '.$client->last_name. ' '.$client->second_last_name,
                'financiera' => $financial->commercial_name,
                'alias_producto' => $product->alias,
                'fees_comision' => $new_fees_comision, 
                'fees_result' => $new_fees_result,
                'tramite' => $product->proceso_tramite,
            );
            $data_sendgrid = array_merge($data_sendgrid, $requisitos, $caracteristicas);
            $send_grid = new Csendgrid($client->email, 'creacion cuenta');
            $send_grid->setTemplate('d-5504f61ffde84a6a9aa400a6970031b3');
            $send_grid->setParams($data_sendgrid);
            $send_grid->send();
            Session::put('send_email', true);
        }
       
     }

    public static function getByRate($credit, $request = null)
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

        //dd($type_product_id);
        
        $sql = FinancialProduct::select('commercial_name', 'is_tramitar', 'company_name', 'financials.id as financial_id', 'name', 'alias', 'rate_kc', 'rate_cat',
            'rate_comision', 'rate_deadline', 'rate_contract', 'rate_privacity', 'bank_ids', 'is_vincular_banco',
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
        //dd($queries);
        //dd($financial_ids, $type_product_id);
        
        $financial_product_ids = [];

        

        foreach ($sql as $sql_query) {
            $product_aval_o_garantia = $sql_query->aval_o_garantia;
            $product_is_vincular_banco = $sql_query->is_vincular_banco;
            $product_consulta_buro = $sql_query->consulta_buro;
            $bank_ids = $sql_query->bank_ids;

            $is_aval = true;
            $is_buro = true;
            $is_bank = true;

            if ($aval_o_garantia === 0 && $product_aval_o_garantia !== 0) {
                $is_aval = false;
            }
            
            if ($consulta_buro === 0 && $product_consulta_buro !== 0) {
                $is_buro = false;
            }

            if ($bank_id > 0 && $bank_ids !== null ) {
                // Divide la cadena de $bank_ids en un arreglo
                $bank_ids_array = explode(',', $bank_ids);
                if (!in_array($bank_id, $bank_ids_array)) {
                    $is_bank = false;
                }
            }
           

            if ($is_aval == true && $is_buro == true && $is_bank == true) {
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
        // Elementos a excluir del arreglo $request
        $excludeKeys = ['_token', 'product_id', 'is_required', 'principal_pay', 'periodicity_id'];

        // Crea un nuevo arreglo que excluye los elementos especificados
        $filteredRequest = $request->except($excludeKeys);

        if (isset($request->alcance_beneficios)) 
        {
            $filteredRequest['alcance_beneficios'] =  self::formatInfoCredit($request->alcance_beneficios);
        }
        
        if (isset($request->restriccion_exclusion)) 
        {
            $filteredRequest['restriccion_exclusion'] =  self::formatInfoCredit($request->restriccion_exclusion);
        }
        if (isset($request->programa_educacion_financiera)) 
        {
            $filteredRequest['programa_educacion_financiera'] =  self::formatInfoCredit($request->programa_educacion_financiera);
        }
        if (isset($request->referencia_comparativa)) 
        {
            $filteredRequest['referencia_comparativa'] =  self::formatInfoCredit($request->referencia_comparativa);
        }
       
        if (isset($request->bank_ids)) 
        {
            $filteredRequest['bank_ids'] =  self::formatInfoCredit($request->bank_ids);
        }

        if ($request->product_id == null) {
            $financial_product = FinancialProduct::create($filteredRequest);
        } else {
            $financial_product = FinancialProduct::find($request->product_id);
            $financial_product->fill($filteredRequest);
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
    
    public function formatInfoCredit($values)
    {
        $new_value = '';
        if (count($values) > 0) {
            foreach ($values as $value) {
                $new_value.= $value.',';
            }
        }
        $new_value = trim($new_value, ',');
        return $new_value;
    }
    

    public static function customSortFinancials($financial_products, $is_limit = false)
    {
        // Ordenar $financial_products en función del rate_kc en orden descendente
        $sortedFinancials = $financial_products->sortByDesc('rate_kc')->values();

        if ($is_limit == false) {
            $sortedFinancials = $sortedFinancials->take(3);
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
