<?php

namespace App\Http\Controllers\Api\Campaign;

use App\Http\Controllers\Controller;
use App\Models\ApiLead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $request_data = array(
            'servicio' => $request->servicio
        );
        ApiLead::create(['data'=> json_encode($request_data)]);
    }
}
