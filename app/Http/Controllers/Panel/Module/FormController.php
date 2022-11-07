<?php

namespace App\Http\Controllers\Panel\Module;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\CreditReference;
use App\Models\HistoryLog;
use App\Strategies\Values\TemplateValues;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($model, $history_id)
    {
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $history          = HistoryLog::find($history_id);
        $credit           = $history->historyCredit;
        $form             = (new $actionStrategy)->configForm($credit->id, $history_id);
        $breadcrumb       = (new $actionStrategy)->breadcrumb($history);
        $client           = $credit->creditClientPerson;
        $product          = $credit->creditProduct;
        $id_rel           = $credit->id;
        return view('panel.module.checkup.content_form', compact('form', 'id_rel', 'product', 'credit', 'client', 'history', 'breadcrumb'));
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $actionStrategy   = TemplateValues::STRATEGY[$request->model];
        $form       = (new $actionStrategy)->saveForm($request);
        return response()->json($form);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $credit   = Credit::find($id);
        $client   = $credit->creditClientPerson;
        return response()->json(['credit' => $credit, 'client' => $client]);
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
