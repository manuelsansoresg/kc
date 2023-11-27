<?php

namespace App\Http\Controllers\Api\Campaign;

use App\Http\Controllers\Controller;
use App\Lib\Manychat;
use App\Models\ApiLead;
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

            );

            //*crear usuario manychat
            $data = array(
                "first_name" => $request->name,
                "last_name" => $request->last_name,
                "phone" => $cellphone,
                "whatsapp_phone" => "+52".$cellphone,
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
            

            HistoryLog::move($lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);
            return response()->json(200);
        } catch (\Exception $th) {
            return response()->json(500);
        }
    }
}
