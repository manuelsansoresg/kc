<?php

namespace App\Http\Controllers\Api\Campaign;

use App\Http\Controllers\Controller;
use App\Lib\Manychat;
use App\Models\ApiLead;
use App\Models\Bank;
use App\Models\HistoryLog;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        try {
            $product_id = $request->servicio == 'reducir_deuda_actual' ? 2 : 1;
            $cellphone = preg_replace('/^\+52/', '', $request->cellphone);
            
            $request_data = array(
                'product_id' => $product_id,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'cellphone' => $cellphone,
                'origin_id' => 4,
                'channel_id' => 1,
                'email' => $request->email,
                'importe_solicitado' => $request->importe_solicitado,

            );

            //*crear usuario manychat
            $data = array(
                "first_name" => $request->name,
                "last_name" => $request->last_name,
                "phone" => "+521".$cellphone,
                "whatsapp_phone" => "521".$cellphone,
                "email" => $request->email,
                "has_opt_in_sms" => true,
                "has_opt_in_email" => true,
                "consent_phrase" => 'kc',
            );
            $manychat = new Manychat();
            $result = json_decode($manychat->altaUsuario($data));
            if ($result->status == 'success') {
                $data_manychat = $result->data;
                $request_data['manychat_id'] = $data_manychat->id;

                
            }

            $lead = Lead::create($request_data);

            if ($result->status == 'success') {
                //*modificar los valores de manychat 
                $get_lead       = Lead::find($lead->id);
                $get_advisor    = $get_lead->advisorLead;
                $advisor        = $get_advisor!= null ? $get_advisor->name.' '.$get_advisor->last_name  : null;
                $get_product    = $get_lead->productLead;
                $product        = $get_product != null ? $get_product->alias : null;
                $get_bank       = Bank::find($get_lead->bank_id);
                $bank           = $get_bank != null ? $get_bank->name : null;
                $manychat       = new Manychat();
                $get_origin     = Lead::getChanelByOrigin($get_lead->origin_id);
                $channel        = isset($get_origin[$get_lead->channel_id])? $get_origin[$get_lead->channel_id] : null;
                $get_agreement  = $get_lead->agreementLead;
                $agreement      = $get_agreement!= null ? $get_agreement->name : null;
                $get_origins    = config('enums.origin');
                $origin         = isset($get_origins[$get_lead->origin_id]) ? $get_origins[$get_lead->origin_id] : null;
                
                $type_products  = config('financial_enums.type_products');
                $type_credit    = isset($type_products[$get_lead->tipo_credito]) ? $type_products[$get_lead->tipo_credito] : null;
                $data = array(
                    'Servicio KC' => $product,
                    'Canal' => $channel,
                    'Importe solicitado' => $request->importe_solicitado,
                    'Origen' => $origin,
                    'Tipo de crédito' => $type_credit,

                );
                $manychat->setCustomFields($data, $data_manychat->id);
            }
            
            
            HistoryLog::move($lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);
            return response()->json(200);
        } catch (\Exception $th) {
            return response()->json(500);
        }
    }
}
