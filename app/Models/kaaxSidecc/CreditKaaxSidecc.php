<?php

namespace App\Models\kaaxSidecc;

use App\Models\Credit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditKaaxSidecc extends Model
{
    use HasFactory;
    protected $connection = 'kaax_sidecc';
    protected $table = 'credits';

    public static function sendCreditKaaxSidecc($id_rel)
    {
        $credit = Credit::find($id_rel);
        $client = $credit->creditClientPerson;

        $data_credit = array(
            'kc_credit_id' => $credit->id,
            'client_id' => $client->id,
            'agreement_id' => $credit->agreement_id,
            'tipo_tramite' => $credit->applied_loan_type,
            'valor_slider_simple' => $credit->applied_import,
            'plazo_calculadora_simple' => $credit->applied_term,
            'pago_calculadora_simple' => $credit->applied_payment,
            'valor_slider_avanzada' => $credit->applied_import,
            'plazo_calculadora_avanzada' => $credit->applied_term,
            'pago_calculadora_avanzada' => $credit->applied_payment,
        );
        $creditKaax = CreditKaaxSidecc::create($data_credit);

        $data_client_credit_info = array(
            'credit_id' => $creditKaax->id,
            'kc_credit_id'=>$credit->credit_id,  
            'capital'=> $credit->applied_import,  
            'plazo_quincenas'=>$credit->applied_term,  
            'descuento'=>$credit->applied_payment,  
            'tasa'=>$credit->applied_interest_rate,  
            'monto_total'=>$credit->applied_loan_total_amount,  
        );
        $client_credit_info_kaax = ClientsCreditInfoKaaxSidecc::create($data_client_credit_info);

        $data_collections = array(
            'kc_credit_id' => $credit->id, 
            'client_id' => $credit->client_person_id, 
            'agreement_id' => $credit->agreement_id, 
            'capital' => $credit->applied_import, 
            'plazo' => $credit->applied_term, 
            'descuento' => $credit->applied_payment, 
            'nombre' => $client->last_name.' '.$client->second_last_name.' '.$client->name,
            'numero_empleado' => $client->employee_number,
            'area_laboral' => $client->employee_area,
            'rfc' => $client->rfc,
            'credit_id' => $creditKaax->id,
        );
        CollectionKaaxSidecc::create($data_collections);
    }
}
