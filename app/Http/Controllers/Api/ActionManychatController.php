<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\ApiActionManychat;
use App\Models\Lead;
use Illuminate\Http\Request;

class ActionManychatController extends Controller
{
    public function store($section, Request $request)
    {
        $head = array(
            'organizacion' => array('agreement_id', 'Organización')
        );
        
        if ($head[$section]) {
            $select_head            = $head[$section][0];
            $head_value             = $head[$section][1];
            $data                   = $request->all();
            $manychat_id            = $data['id'];
            $custom_fields          = $data['custom_fields'];
            $select_custom_field    = $custom_fields[$head_value];
            $organization           = self::saveOrganization($select_head, 'YUC - Educación Media Superior', $manychat_id);

            return response()->json([
                'select_head' => $select_head,
                'value' => 'YUC - Educación Media Superior',
                'manychat_id' => $manychat_id,
                'organization' => $organization,
            ]);

            

            //return response()->json(200);
            
            /* return response()->json([
                'manychat_id' => $manychat_id,
                'id' => $data['id'],
                'custom_fields' => $custom_fields,
                'select_custom_field' => $select_custom_field,
                'head_value' => $head_value,
            ]); */
        }
        /* return response()->json(500); */
        
    }

    public function saveOrganization($action, $value, $manychat_id)
    {
        if ($value != null) {
            $agreement = Agreement::where('name', $value)->first();
            if ($agreement != null) {
                //return self::saveAction($action, $agreement->id, $manychat_id);
                return array($action, $agreement->id);

            }
        }
        return 'error';
    }

    public function saveAction($action, $value, $manychat_id)
    {
       /*  $lead = Lead::find($manychat_id);
        $lead->update([
            $action => $value
        ]);
        return $lead; */
    }
}
