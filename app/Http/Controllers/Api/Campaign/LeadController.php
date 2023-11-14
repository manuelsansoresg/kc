<?php

namespace App\Http\Controllers\Api\Campaign;

use App\Http\Controllers\Controller;
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
            $lead = Lead::create($request_data);
            HistoryLog::move($lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);
            return response()->json(200);
        } catch (\Exception $th) {
            return response()->json(500);
        }
    }
}
