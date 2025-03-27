<?php

namespace App\Models\kaaxSidecc;

use App\Models\Credit;
use App\Models\FinancialProduct;
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
        'client_id', 'kc_client_id', 'agreement_id', 'tipo_tramite', 'folio', 'active', 'is_prom
        otoer', 'liquidacion_terceros', 'tipo_firma', 'status_online', 'fecha_cobro',
        'fecha_dispersion', 'dispersion', 'file_vobo', 'vobo_aceptado', 'origen',
        'promoter_id',
        'sueldo_calculadora_simple', 'valor_slider_simple', 'plazo_calculadora_simple', 'pago_calculadora_simple',
        'capacidad_pago', 'valor_slider_avanzada', 'plazo_calculadora_avanzada', 'pago_calculadora_avanzada',
        'ajuste_refinanciamiento', 'ajuste_liquidacion_terceros',
        'operacion', 'razon', 'origin_type_credit', 'determinacion_credito', 'kc_credit_id', 'financial_products_id', 'collection_commission_rate',
        'capital', 'plazo', 'descuento', 'total'
    ];

    public static function sendCreditKaaxSidecc($id_rel)
    {
        $credit = Credit::find($id_rel);
        $client = $credit->creditClientPerson;
        $financialProduct = FinancialProduct::find($credit->applied_financial_product);
        $collection_commission_rate = $financialProduct ? $financialProduct->collection_commission_rate : null;

        // * Buscar o actualizar cliente en Sidecc
        $data_client = [
            'apellido_1' => $client->last_name,
            'apellido_2' => $client->second_last_name,
            'nombre' => $client->name,
            'rfc' => $client->rfc,
        ];
        $clientKaaxSidecc = ClientKaaxSidecc::updateOrCreate(['rfc' => $client->rfc], $data_client);

        // * Buscar o actualizar crédito en Sidecc
        $data_credit = [
            'kc_credit_id' => $credit->id,
            'client_id' => $clientKaaxSidecc->id,
            'agreement_id' => $credit->agreement_id,
            'tipo_tramite' => $credit->tramit_type,
            'valor_slider_simple' => $credit->applied_import,
            'plazo_calculadora_simple' => $credit->applied_term,
            'pago_calculadora_simple' => $credit->applied_payment,
            'valor_slider_avanzada' => $credit->applied_import,
            'plazo_calculadora_avanzada' => $credit->applied_term,
            'pago_calculadora_avanzada' => $credit->applied_payment,
            'financial_products_id' => $credit->applied_financial_product,
            'ajuste_liquidacion_terceros' => $credit->third_party_adjustment,
            'ajuste_refinanciamiento' => $credit->refinance_adjustment,
            'collection_commission_rate' => $collection_commission_rate,
            'capital' => $credit->applied_import,
            'plazo' => $credit->applied_term,
            'descuento' => $credit->applied_payment,
            'total' => $credit->applied_loan_total_amount,
            'kc_client_id' => $client->id,
        ];
        $creditKaax = CreditKaaxSidecc::updateOrCreate(['kc_credit_id' => $credit->id], $data_credit);

        // * Agregar log de CRM solo si se creó un nuevo crédito
        if ($creditKaax->wasRecentlyCreated) {
            ClientsLogKaaxSidecc::addCrmLog($creditKaax->id, 'en-entrega', 'en-entrega');
        }

        // * Buscar o actualizar información del crédito del cliente
        $data_client_credit_info = [
            'credit_id' => $creditKaax->id,
            'kc_credit_id' => $credit->id,
            'capital' => $credit->applied_import,
            'plazo_quincenas' => $credit->applied_term,
            'descuento' => $credit->applied_payment,
            'tasa' => $credit->applied_interest_rate,
            'monto_total' => $credit->applied_loan_total_amount,
            'cat' => $credit->applied_CAT,
            'comision_apertura' => $credit->opening_commission,
            'capital_cobrar' => $credit->net_amount,
            'producto' => $credit->applied_financial_product,
            'comision_total' => $credit->opening_commission,
        ];
        ClientsCreditInfoKaaxSidecc::updateOrCreate(['kc_credit_id' => $credit->id], $data_client_credit_info);

        // * Buscar o actualizar información laboral del cliente
        $data_job_info = [
            'credit_id' => $creditKaax->id,
            'numero_trabajador' => $client->employee_number,
            'area_laboral' => $client->employee_area,
        ];
        ClientsJobInfoKaaxSidecc::updateOrCreate(['credit_id' => $creditKaax->id], $data_job_info);

        // * Hacer solicitud a la API externa
        $clientHttp = new Client();
        $request = new GuzzleHttp\Psr7\Request('GET', 'https://kaaxclub.sidecc.xyz/api/credit/' . $creditKaax->id . '/createTa');
        $response = $clientHttp->send($request);
    }
}
