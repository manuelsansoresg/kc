<?php

namespace App\Http\Controllers\Panel\Module;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\HistoryLog;
use App\Strategies\Values\TemplateValues;
use Illuminate\Http\Request;

class KcCheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.module.checkup.list');
    }

    public function list()
    {
        $users = Credit::listDatatable();
        return response()->json(['data' => $users]);
    }
    
    public function listStep($history_id)
    {
        $actionStrategy   = TemplateValues::STRATEGY['newCredit'];
        $list       = (new $actionStrategy)->listStep($history_id);
        
        return response()->json(['data' => $list]);
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
        $history_id = $id;
        $history = HistoryLog::find($id);
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $product = $credit->creditProduct;
        return view('panel.module.checkup.steps.list', compact('history_id', 'product', 'credit', 'client'));
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
