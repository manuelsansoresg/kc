<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\File;
use App\Models\RegisterAction;
use Illuminate\Http\Request;

class RegisterActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function setIdRel($id, Request $request)
    {
        $request->session()->put('id_rel_action', $id);
    }
    
    public function setModel($model, Request $request)
    {
        $request->session()->put('model_action', $model);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $request->model;
        $data = $request->data;
        $register_action = RegisterAction::create($data);
        Action::updateByModel($data['action_id']);
        return response()->json($register_action);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $register_action = RegisterAction::find($id);
        
        $get_action           = Action::find($id);
        $get_action->status   = 0;
        $get_action->update();
        if ($register_action !== null) {
            File::deleteByModel($get_action->section, $id);
            $register_action->delete();
        }
    }
}
