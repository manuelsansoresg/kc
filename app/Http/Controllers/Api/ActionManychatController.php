<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\Manychat;
use App\Models\Agreement;
use App\Models\ApiActionManychat;
use App\Models\Bank;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\FinancialAgreement;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\LeadValidation;
use App\Models\Product;
use App\Models\SodScheduleDate;
use App\Models\SodScheduleName;
use App\Strategies\Values\SendNotificationsValues;
use App\Strategies\Values\TemplateValues;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActionManychatController extends Controller
{
    public function store($section, Request $request)
    {
        $head = array(
            'organizacion' => array('agreement_id', 'Organización'),
            'banco' => array('bank_id', 'Banco'),
            'servicio-kc' => array('product_id', 'Servicio KC'),
            'tipo-credito' => array('tipo_credito', 'Tipo de crédito'),
            'ingresos' => array('income', 'Ingresos'),
        );
        
        if ($head[$section]) {
            $select_head            = $head[$section][0];
            $head_value             = $head[$section][1];
            $data                   = $request->all();
            $manychat_id            = $data['id'];
            $custom_fields          = $data['custom_fields'];
            $select_custom_field    = $custom_fields[$head_value];
            
            self::saveOrganization($section, $select_head, $select_custom_field, $manychat_id);
            self::saveBank($section, $select_head, $select_custom_field, $manychat_id);
            self::saveServicio($section, $select_head, $select_custom_field, $manychat_id);
            self::saveTipoCredito($section, $select_head, $select_custom_field, $manychat_id);
            self::saveIngreso($section, $select_head, $select_custom_field, $manychat_id);

            return response()->json(200);
            
        }
        return response()->json(500);
        
    }

    public function storeLead(Request $request)
    {
        $data           = $request->all();
        $manychat_id    = $data['id'];
        $lead           = Lead::where('manychat_id', $manychat_id)->first();
        if ($lead != null) {
            $template       = TemplateValues::STRATEGY['lead'];
            $history_id = (new $template)->move($lead->id);
            $manychat = new Manychat();
            $data = array(
                'URL Reporte' => 'https://kaaxclub.com/reporte/'.$history_id->id,

            );
            $manychat->setCustomFields($data, $manychat_id);
            return response()->json(200);
        }
        return response()->json(500);
    }

    public function storeLeadWaComplete(Request $request)
    {
        $data             = $request->all();
        $custom_fields    = $data['custom_fields'];
        $get_product = Product::where('alias', $custom_fields['Servicio KC'])->first();

        $data_lead = array(
            'name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'manychat_id' => $data['id'],
            'product_id' => $get_product->id,
            'origin_id' => 2,
            'channel_id' => 2,
            

        );
        Lead::create($data_lead);
        return response()->json(200);
    }

    public function saveOrganization($section, $action, $value, $manychat_id)
    {
        if ($value != null && $section == 'organizacion') {
            $agreement = Agreement::where('name', $value)->first();
            if ($agreement != null) {
                return self::saveAction($action, $agreement->id, $manychat_id);

            }
        }
    }
    
    public function saveBank($section, $action, $value, $manychat_id)
    {
        if ($value != null && $section == 'banco') {
            //*primero buscar un banco que exista
            $get_bank = Bank::where('name', $value)->first();
            if ($get_bank != null) {
                return self::saveAction($action, $get_bank->id, $manychat_id);
            } else { //* si no existe buscar el mas parecido y si no elegir otro
                $search_bank = Bank::where('name', 'like', '%' . $value . '%')->first();
                if ($search_bank != null) {
                    return self::saveAction($action, $search_bank->id, $manychat_id);
                } else {
                    return self::saveAction($action, 99, $manychat_id);
                }

            }
        }
    }

    public function saveServicio($section, $action, $value, $manychat_id)
    {
        if ($value != null && $section == 'servicio-kc') {
            $get_product = Product::where('alias', $value)->first();
            return self::saveAction($action, $get_product->id, $manychat_id);
        }
    }
    
    public function saveTipoCredito($section, $action, $value, $manychat_id)
    {
        $lead = Lead::where('manychat_id', $manychat_id)->first();
        $tipo_credito = $value == 'Crédito personal' ? 2 : 3; 
        
        if ($lead != null && $section == 'tipo-credito') {
            Lead::where('manychat_id', $manychat_id)->update(['tipo_credito' => $tipo_credito]);
        }
    }
    
    public function saveIngreso($section, $action, $value, $manychat_id)
    {
        $lead = Lead::where('manychat_id', $manychat_id)->first();
        
        if ($lead != null && $section == 'ingresos') {
            Lead::where('manychat_id', $manychat_id)->update([$action => $value]);
        }
    }

    public function saveAction($action, $value, $manychat_id)
    {
        $lead = Lead::where('manychat_id', $manychat_id);
        $lead->update([
            $action => $value
        ]);
        return $lead;
    }

    public function validatePhone(Request $request)
    {
        $data = $request->all();
        $cellphone = $data['phone'];
        $manychat_id    = $data['id'];
        // Remover el prefijo +52 si existe
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);
        $contentValidaciones      = 'Sin coincidencias';
        $statusCellphone = 0;
        
       

        $getClientPerson   = ClientPerson::where('cellphone', $cleanPhone)->first();
        $agreement         = $getClientPerson != null ? Agreement::find($getClientPerson->agreement_id): null;
        $validateAgreement = $agreement != null && $agreement->status == 1 ? true : false;

        $getLead = Lead::where('manychat_id', $manychat_id)->orderBy('id', 'desc')->first();
        if ($getClientPerson != null) {
            $lead = Lead::where('id', $getLead->id)->update([
                'name' => $getClientPerson->name,
                'last_name' => $getClientPerson->last_name,
                'second_last_name' => $getClientPerson->second_last_name,
                'birth_date' => $getClientPerson->birth_date,
                'rfc' => $getClientPerson->rfc,
                'email' => $getClientPerson->email,
                'agreement_id' => $getClientPerson->agreement_id,
                'manychat_id' => $manychat_id,
                'cellphone' => $cleanPhone,
            ]);
            
        } else {
            Lead::where('id', $getLead->id)->update([
                'manychat_id' => $manychat_id,
                'cellphone' => $cleanPhone,
            ]);
           
        }
        if ($getClientPerson != null && $validateAgreement == true) {
            $statusCellphone = 1;
            $contentValidaciones = 'Coincidencia encontrada';
        }
        LeadValidation::saveEdit($lead->id, 'Prospecto - Celular', $statusCellphone, $contentValidaciones);

        $dataField = array(
            'Prospecto -  Validación Celular' => $statusCellphone,
        );
        $manychat = new Manychat();
        $manychat->setCustomFields($dataField, $manychat_id);

        return response()->json(['validate' => $statusCellphone]);
    }

    public function createLead(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];
        $cellphone = $data['phone'];
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);
       
        $lead = Lead::create([
            'manychat_id' => $manychat_id,
            'cellphone' => $cleanPhone,
        ]);
        //* Execute notification in create lead
        $notification   = SendNotificationsValues::STRATEGY['leadNewProspect'];
        (new $notification)->send($lead->id);
        HistoryLog::move($lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);

        return response()->json(['lead' => $lead]);
    }

    public function setUrlRfc(Request $request)
    {
        $data = $request->all();
        $manychat_id    = $data['id'];
        $url = base64_encode(hash('sha256', $manychat_id . env('APP_KEY')));
        $dataField = array(
            'Prospecto - Validación RFC' => $url,
        );
        $manychat = new Manychat();
        $manychat->setCustomFields($dataField, $manychat_id);
        
    }

    public function validateClienteActivo(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];
        $cellphone = $data['phone'];
        $rfc = null; 
        $lead = Lead::where('manychat_id', $manychat_id)->orderBy('id', 'desc')->first();
        $manychat = new Manychat();
        $info = json_decode($manychat->getInfoUser($manychat_id));
        $status = $info->status;

        if ($status != 'error') {
            $data = $info->data;
            $custom_fields = $data->custom_fields;
            foreach ($custom_fields as $key => $custom_field) {
                if ($custom_field->name == 'Prospecto - RFC') {
                    $rfc = $custom_field->value;
                    break;
                }
            }
        }

        // Remover el prefijo +52 si existe
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);

        // Primero intentar buscar por celular
        $clientPerson = ClientPerson::where('cellphone', $cleanPhone)->first();

        // Si no se encuentra por celular y tenemos un RFC, intentar buscar por RFC
        if (!$clientPerson && $rfc) {
            $clientPerson = ClientPerson::where('rfc', $rfc)->first();
        }

        // Ahora $clientPerson contendrá el resultado de la búsqueda por celular o por RFC,
        // o será null si no se encontró ningún registro con esos criterios
        $validacionClienteActivo = false;
        $statusActivo = 0;
        $contentActivo = 'Cliente inactivo';
        if ($clientPerson != null && $clientPerson->active == 1) {
            $validacionClienteActivo = true;
            $statusActivo = 1;
            $contentActivo = 'Cliente activo';
        }
        LeadValidation::saveEdit($lead->id, 'Prospecto - Cliente activo', $statusActivo, $contentActivo);
       
        $dataField = array(
            'Prospecto - Validación Cliente Activo' => $validacionClienteActivo,
        );
        $manychat->setCustomFields($dataField, $manychat_id);
        return response()->json(['validate' => $validacionClienteActivo]);
    }

    public function validateTramitePendiente(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];
        $cellphone = $data['phone'];
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);
        $getClientPerson = ClientPerson::where('cellphone', $cleanPhone)->first();
        $rfc = null;
        $manychat = new Manychat();
        $info = json_decode($manychat->getInfoUser($manychat_id));
        $status = $info->status;
        $lead = Lead::where('manychat_id', $manychat_id)->orderBy('id', 'desc')->first();
        if ($status != 'error') {
            $data = $info->data;
            $custom_fields = $data->custom_fields;
            foreach ($custom_fields as $key => $custom_field) {
                if ($custom_field->name == 'Prospecto - RFC') {
                    $rfc = $custom_field->value;
                    break;
                }
            }
        }
        if (!$getClientPerson && $rfc) {
            $getClientPerson = ClientPerson::where('rfc', $rfc)->first();
        }
        $statusTramites = array(
            HistoryLog::KC_CHECK_UP ,
            HistoryLog::CREDIT_IN_PROGRESS ,
            HistoryLog::NEW_CREDIT_KC_CHECK_UP ,
            HistoryLog::KC_CONTROL_DESK ,
            HistoryLog::KC_DELIVERY ,
            HistoryLog::KC_SWAP ,
            HistoryLog::KC_PAYMENT
        );
        $getStatus = $getClientPerson != null ? Credit::where('client_person_id', $getClientPerson->id)->whereIn('credit_status', $statusTramites)->count() : 0;
        $validacionTramitePendiente = $getStatus > 0 ? false : true;
        if ($validacionTramitePendiente == false) {
            LeadValidation::saveEdit($lead->id, 'Crédito preautorizado - Trámite pendiente', 0, 'Tiene trámites pendientes');
        } else {
            LeadValidation::saveEdit($lead->id, 'Crédito preautorizado - Trámite pendiente', 1, 'Sin trámites pendientes');
        }
        $dataField = array(
            'Prospecto - Validar trámite pendiente' => $validacionTramitePendiente,
        );
        $manychat->setCustomFields($dataField, $manychat_id);
        return response()->json(['validate' => $validacionTramitePendiente]);
        
    }

    public function validateIdentity(Request $request)
    {
        $data = $request->all();
        $cellphone = $data['phone'];
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);
        $getClientPerson = ClientPerson::where('cellphone', $cleanPhone)->update([
            'identity_validated' => true,
        ]);
        return response()->json(['validate' => true]);
       
    }

    public function getValidateIdentity(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];
        $cellphone = $data['phone'];
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);
        $getClientPerson = ClientPerson::where('cellphone', $cleanPhone)->first();
        $identity_validated = $getClientPerson != null ? $getClientPerson->identity_validated : false;
        $dataField = array(
            'Prospecto - Validación Identidad' => $identity_validated,
        );
        $manychat = new Manychat();
        $manychat->setCustomFields($dataField, $manychat_id);
        return response()->json(['validate' => $identity_validated]);
    }

    public function validateSodActive(Request $request)
    {
        $manychat = new Manychat();
        $data = $request->all();
        $manychat_id = $data['id'];
        $cellphone = $data['phone'];
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);
        $getClientPerson = ClientPerson::where('cellphone', $cleanPhone)->first();
        $sod_active = 0;
        $textSoad = 'Tiene un Salario On-Demand activo';
        $lead = Lead::where('manychat_id', $manychat_id)->orderBy('id', 'desc')->first();
        if ($getClientPerson != null && $getClientPerson->sod_active == 0) {
            $textSoad = 'No tiene un Salario On-Demand activo';
            $sod_active = 1;
        }
        LeadValidation::saveEdit($lead->id, 'Crédito preautorizado - SOD activo', $sod_active, $textSoad);
        $dataField = array(
            'SOD - Activo' => $sod_active,
        );
        $manychat->setCustomFields($dataField, $manychat_id);
        return response()->json(['validate' => $sod_active]);
    }

    public function validateFechasPermitidas(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];
        $cellphone = $data['phone'];
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);
        $lead = Lead::where('manychat_id', $manychat_id)->orderBy('id', 'desc')->first();
        $financialProduct = FinancialProduct::where('id', $lead->product_id)->first();
        //validar soad en fecha
        $getSodName = SodScheduleName::find($lead->agreement_id);
        $isSoadDate = 'Solicitud fuera del rango de fechas';
        $is_sod_on_date_allowed = false;
        $statusRangoFechas = 0;
        if ($getSodName != null) {
            $nameField              = "schedule_$getSodName->id";
            $alias                  = "schedule_$getSodName->id as schedule";
            $getDate                = SodScheduleDate::select($alias)->where(['fecha' => date('Y-m-d')])->first();
            $isSoadDate             = $getDate!= null && $getDate->schedule == 1 ?  'Solicitud dentro del rango de fechas' : $isSoadDate;
            $statusRangoFechas             = $getDate!= null && $getDate->schedule == 1 ?  1 : 0;
            if ($financialProduct->type_product_id == 3) {
                LeadValidation::saveEdit($lead->id, 'Crédito preautorizado - SOD en rango de fechas permitidas', $statusRangoFechas, $isSoadDate);
            }

        }
        $dataField = array(
            'SOD - Fechas permitidas' => $is_sod_on_date_allowed,
        );
        $manychat = new Manychat();
        $manychat->setCustomFields($dataField, $manychat_id);
        return response()->json(['validate' => $is_sod_on_date_allowed]);
    }

    public function setSod($productId, Request $request)
    {
        $data = $request->all();
        $products = array(
            '1' => 'Crédito personal',
            '2' => 'Soluciona tu deuda',
            '3' => 'Salario On-Demand',
            );
        
        $manychat_id = $data['id'];
        $cellphone = $data['phone'];
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);
        $rfc = null;
        $productName = null;
        $manychat = new Manychat();
        $info = json_decode($manychat->getInfoUser($manychat_id));
        $status = $info->status;
        $getClientPerson = ClientPerson::where('cellphone', $cleanPhone)->first();
        if ($status != 'error') {
            $data = $info->data;
            $custom_fields = $data->custom_fields;
            foreach ($custom_fields as $key => $custom_field) {
                if ($custom_field->name == 'Prospecto - RFC') {
                    $rfc = $custom_field->value;
                    break;
                }
            }
        }
        if (!$getClientPerson && $rfc) {
            $getClientPerson = ClientPerson::where('rfc', $rfc)->first();
        }
        

        $getProduct = Product::where('alias', $products[$productId])->first();
        $getFinancialProduct = FinancialProduct::select('financial_products.id')

        ->join('financial_agreements', 'financial_agreements.product_id', 'financial_products.id')
        ->where('type_product_id', $getProduct->id)
        ->where('financial_agreements.agreement_id', $getClientPerson->agreement_id)
        ->first();
        if ($getFinancialProduct != null) {
            $getLead = Lead::where('manychat_id', $manychat_id)->orderBy('id', 'desc')->first();
            Lead::where('id', $getLead->id)->update([
                'product_id' => $getFinancialProduct->id,
            ]);
        }
        return response()->json(['validate' => true]);
    }

    public function getMontoMinMax(Request $request)
    {
        $lead = Lead::getMontoMinMax($request);
        $minimoRedondeado = $lead['monto_minimo'];
        $maximoRedondeado = $lead['monto_maximo'];
        return response()->json(['monto_minimo' => $minimoRedondeado, 'monto_maximo' => $maximoRedondeado]);
    }

    public function validateMontoSolicitado(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];

        $lead = Lead::getMontoMinMax($request);
        $minimoRedondeado = $lead['monto_minimo'];
        $maximoRedondeado = $lead['monto_maximo'];

        $manychat = new Manychat();
        $info = json_decode($manychat->getInfoUser($manychat_id));
        $status = $info->status;
        $montoSolicitado = null;
        $validateMontoSolicitado = false;
        if ($status != 'error') {
            $data = $info->data;
            $custom_fields = $data->custom_fields;
            foreach ($custom_fields as $key => $custom_field) {
                if ($custom_field->name == 'SOD - Monto solicitado') {
                    $montoSolicitado = $custom_field->value;
                    break;
                }
            }
        }

        if ($montoSolicitado != null) {
            if ($montoSolicitado <= $maximoRedondeado && $montoSolicitado >= $minimoRedondeado) {
                $validateMontoSolicitado = true;
            }
        }
        $dataField = array(
            'SOD - Validar monto solicitado' => $validateMontoSolicitado,
        );
        $manychat->setCustomFields($dataField, $manychat_id);
        return response()->json(['validate' => true]);
    }

    public function serviciosDisponibles(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];
        $rfc = null;
        $cellphone = $data['phone'];
        $cleanPhone = preg_replace('/^\+52/', '', $cellphone);

        $manychat = new Manychat();
        $info = json_decode($manychat->getInfoUser($manychat_id));
        $status = $info->status;
        $getClientPerson = ClientPerson::where('cellphone', $cleanPhone)->first();
        if ($status != 'error') {
            $data = $info->data;
            $custom_fields = $data->custom_fields;
            foreach ($custom_fields as $key => $custom_field) {
                if ($custom_field->name == 'Prospecto - RFC') {
                    $rfc = $custom_field->value;
                    break;
                }
            }
        }
        if (!$getClientPerson && $rfc) {
            $getClientPerson = ClientPerson::where('rfc', $rfc)->first();
        }

        $cpAvailable = $getClientPerson->cp_available;
        $stdAvailable = $getClientPerson->std_available;
        $sodAvailable = $getClientPerson->sod_available;
        
        $products = '';
        if ($cpAvailable !== null) {
            $products .= $cpAvailable;
        }
        if ($stdAvailable !== null) {
            $products .= $stdAvailable;
        }
        if ($sodAvailable !== null) {
            $products .= $sodAvailable;
        }


        $dataField = array(
            'Prospecto - Servicios KC disponibles' => $products,
        );
        $manychat->setCustomFields($dataField, $manychat_id);
        return response()->json(['products' => $products]);
       
    }

    public function sendControlDesk(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];
        $lead = Lead::where('manychat_id', $manychat_id)->orderBy('id', 'desc')->first();
        $template   = TemplateValues::STRATEGY['lead'];
        $move       = (new $template)->move($lead->id);
        return response()->json(['lead' => $move]);
        
    }

    public function firmaContratoCm(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];
        $firmaContrato = false;
        $urlContrato = null;
        $credit = Credit::where([
            'manychat_id' => $manychat_id,
            'credit_status' => HistoryLog::KC_CONTROL_DESK
        ])->first();
        if ($credit != null) {
            $client = $credit->creditClientPerson;
            $manychat = new Manychat();
            $firmaContrato = $client!= null && $client->cm_agreement == 1 ? true : false;
            $urlContrato = $client!= null ? asset('/client/contratocm/'.$client->id.'/'.$credit->id) : null;
            $dataField = array(
                'Prospecto - Firma Contrato CM' => $firmaContrato,
                'Prospecto - URL contrato CM' => $urlContrato,
            );
           $manychat->setCustomFields($dataField, $manychat_id);
        }
        return response()->json(['firmaContrato' => $firmaContrato, 'urlContrato' => $urlContrato]);
    }

    public function firmaDescuentoSod(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data['id'];
        $firmaContrato = false;
        $urlContrato = null;
        $credit = Credit::where([
            'manychat_id' => $manychat_id,
            'credit_status' => HistoryLog::KC_CONTROL_DESK
        ])->first();
        if ($credit != null) {
            $manychat = new Manychat();
            $firmaContrato = $credit->sod_agreement == 1 ? true : false;
            $urlContrato =  asset('/client/sod/'.$credit->id);
            $dataField = array(
                'Prospecto - Firma Solicitud/Descuento SOD' => $firmaContrato,
                'Prospecto - URL Solicitud/Descuento SOD' => $urlContrato,
            );
           $manychat->setCustomFields($dataField, $manychat_id);
        }
        return response()->json(['firmaContrato' => $firmaContrato, 'urlContrato' => $urlContrato]);
    }
}
