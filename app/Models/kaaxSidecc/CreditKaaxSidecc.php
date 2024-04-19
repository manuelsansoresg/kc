<?php

namespace App\Models\kaaxSidecc;

use App\Models\Credit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp;

class CreditKaaxSidecc extends Model
{
    use HasFactory;
    protected $connection = 'kaax_sidecc';
    protected $table = 'credits';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'client_id', 'agreement_id', 'tipo_tramite', 'folio', 'active', 'is_prom
        otoer', 'liquidacion_terceros', 'tipo_firma', 'status_online', 'fecha_cobro',
        'fecha_dispersion', 'dispersion', 'file_vobo', 'vobo_aceptado', 'origen',
        'promoter_id',
        'sueldo_calculadora_simple', 'valor_slider_simple', 'plazo_calculadora_simple', 'pago_calculadora_simple',
        'capacidad_pago', 'valor_slider_avanzada', 'plazo_calculadora_avanzada', 'pago_calculadora_avanzada',
        'ajuste_refinanciamiento', 'ajuste_liquidacion_terceros',
        'operacion', 'razon', 'origin_type_credit', 'determinacion_credito', 'kc_credit_id'
    ];

    public static function sendCreditKaaxSidecc($id_rel)
    {
        $credit = Credit::find($id_rel);
        $client = $credit->creditClientPerson;

        //*buscar si existe cliente en sidecc
        $data_client = array(
            'apellido_1' => $client->last_name,
            'apellido_2' => $client->second_last_name,
            'nombre' => $client->name,
            'rfc' => $client->rfc,
        );
        
        $clientKaaxSidecc = ClientKaaxSidecc::updateOrCreate(['rfc' => $client->rfc], $data_client);

        $data_credit = array(
            'kc_credit_id' => $credit->id,
            'client_id' => $clientKaaxSidecc->id,
            'agreement_id' => $credit->agreement_id,
            'tipo_tramite' => $credit->applied_loan_type,
            'valor_slider_simple' => $credit->applied_import,
            'plazo_calculadora_simple' => $credit->applied_term,
            'pago_calculadora_simple' => $credit->applied_payment,
            'valor_slider_avanzada' => $credit->applied_import,
            'plazo_calculadora_avanzada' => $credit->applied_term,
            'pago_calculadora_avanzada' => $credit->applied_payment,
            'financial_products_id' => $credit->applied_financial_product,
            'ajuste_liquidacion_terceros' => $credit->third_party_adjustment,
            'ajuste_refinanciamiento' => $credit->refinance_adjustment,
        );
        $creditKaax = CreditKaaxSidecc::create($data_credit);
        ClientsLogKaaxSidecc::addCrmLog($creditKaax->id, 'en-entrega', 'en-entrega');

        $data_client_credit_info = array(
            'credit_id' => $creditKaax->id,
            'kc_credit_id'=>$credit->id,  
            'capital'=> $credit->applied_import,  
            'plazo_quincenas'=>$credit->applied_term,  
            'descuento'=>$credit->applied_payment,  
            'tasa'=>$credit->applied_interest_rate,  
            'monto_total'=>$credit->applied_loan_total_amount,  
            'cat'=>$credit->applied_CAT,  
            'comision_apertura'=>$credit->opening_commission,  
            'capital_cobrar'=>$credit->net_amount,  
        );
        $client_credit_info_kaax = ClientsCreditInfoKaaxSidecc::create($data_client_credit_info);

        $data_job_info = array(
            'credit_id' => $creditKaax->id,
            'numero_trabajador' => $client->employee_number, 
            'area_laboral' => $client->employee_area, 
        );
        ClientsJobInfoKaaxSidecc::create($data_job_info);

        // Crear una nueva instancia del cliente HTTP
        $client = new Client();

        // Preparar la solicitud GET
        $request = new GuzzleHttp\Psr7\Request('GET', 'https://kaaxclub.sidecc.xyz/api/credit/' . $creditKaax->id . '/createTa');

        // Enviar la solicitud y obtener la respuesta
        $response = $client->send($request);
    }
}
