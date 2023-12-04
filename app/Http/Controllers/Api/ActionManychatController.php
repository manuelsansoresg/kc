<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiActionManychat;
use Illuminate\Http\Request;

class ActionManychatController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $manychat_id = $data;
       /*  $data = array(
            'name' => $request->all()
        ); */
        //ApiActionManychat::create($data);
        return response()->json($manychat_id);
    }
}
