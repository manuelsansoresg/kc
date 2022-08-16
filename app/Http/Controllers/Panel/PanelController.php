<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Lib\Csendgrid;
use App\Lib\CSurveySparrow;
use App\Lib\Pusher;
use App\Strategies\Values\SendNotificationsValues;
use App\Strategies\Values\ValidateStagesValues;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.index');
    }

    public function showValidate($id, $model)
    {
        $leadStrategy   = ValidateStagesValues::STRATEGY[$model];
        $validate       = (new $leadStrategy)->getValidate($id);
        
        $view_validate  = \View::make('panel.table_validate', ['errors' => $validate['table']])->render();
        return response()->json($view_validate);
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
        //
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
        //
    }
}
