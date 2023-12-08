<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\ApiActionManychat;
use App\Models\Bank;
use App\Models\Lead;
use Illuminate\Http\Request;

class ActionManychatController extends Controller
{
    public function store($section, Request $request)
    {
        $head = array(
            'organizacion' => array('agreement_id', 'Organización'),
            'banco' => array('bank_id', 'Banco'),
        );
        
        if ($head[$section]) {
            $select_head            = $head[$section][0];
            $head_value             = $head[$section][1];
            $data                   = $request->all();
            $manychat_id            = $data['id'];
            $custom_fields          = $data['custom_fields'];
            //$select_custom_field    = $custom_fields[$head_value];
            $select_custom_field    = 'manuel';
            
            self::saveOrganization($section, $select_head, $select_custom_field, $manychat_id);
            self::saveBank($section, $select_head, $select_custom_field, $manychat_id);

            

            return response()->json(200);
            
        }
        return response()->json(500);
        
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

    public function saveAction($action, $value, $manychat_id)
    {
        $lead = Lead::where('manychat_id', $manychat_id);
        $lead->update([
            $action => $value
        ]);
        return $lead;
    }
}
