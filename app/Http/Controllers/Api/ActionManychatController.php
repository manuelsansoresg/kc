<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\Manychat;
use App\Models\Agreement;
use App\Models\ApiActionManychat;
use App\Models\Bank;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\Product;
use App\Strategies\Values\SendNotificationsValues;
use App\Strategies\Values\TemplateValues;
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
        
        // Buscar en ClientPerson si existe el teléfono y retornar true o false
        $validate = ClientPerson::where('cellphone', $cleanPhone)->exists();

        $dataField = array(
            'Prospecto -  Validación Celular' => $validate,
        );

        $getClientPerson   = ClientPerson::where('cellphone', $cleanPhone)->first();
        if ($getClientPerson != null) {
            $lead = Lead::where('manychat_id', $manychat_id)->update([
                'name' => $getClientPerson->name,
                'last_name' => $getClientPerson->last_name,
                'second_last_name' => $getClientPerson->second_last_name,
                'birth_date' => $getClientPerson->birth_date,
                'rfc' => $getClientPerson->rfc,
                'email' => $getClientPerson->email,
                'agreement_id' => $getClientPerson->agreement_id,
                'manychat_id' => $manychat_id,
            ]);
            
        } else {
            Lead::where('manychat_id', $manychat_id)->update([
                'manychat_id' => $manychat_id,
                'cellphone' => $cleanPhone,
            ]);
           
        }

        $manychat = new Manychat();
        $manychat->setCustomFields($dataField, $manychat_id);

        return response()->json(['validate' => $validate]);
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
        if ($clientPerson != null && $clientPerson->active == 1) {
            $validacionClienteActivo = true;
        }
       
        $dataField = array(
            'Prospecto - Validación Cliente Activo' => $validacionClienteActivo,
        );
        $manychat->setCustomFields($dataField, $manychat_id);
        return response()->json(['validate' => $validacionClienteActivo, 'rfc' => $rfc]);
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
        $dataField = array(
            'Crédito Preautorizado - Trámite pendiente' => $validacionTramitePendiente,
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
}
