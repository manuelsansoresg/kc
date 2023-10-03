<?php

namespace App\Http\Controllers\Panel\Module;

use App\Http\Controllers\Controller;
use App\Models\HistoryLog;
use App\Strategies\Values\TemplateValues;
use Illuminate\Http\Request;

class TemplateController extends Controller
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

    public function viewStep($model, $history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $product = $credit->creditProduct;
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $breadcrumb       = (new $actionStrategy)->breadcrumb($history);
        
        if ($model == 'controlDesk' || $model == 'newCredit' || $model == 'debtCredit' || $model == 'swap' || $model == 'delivery'  || $model == 'afterMarket' || $model == 'payment' ) {
            $list_steps       = (new $actionStrategy)->listStep($history_id);
            return view('panel.module.view_steps', compact('history_id', 'product', 'credit', 'client', 'model', 'breadcrumb', 'list_steps', 'actionStrategy'));
        }
        //return view('panel.module.checkup.steps.list', compact('history_id', 'product', 'credit', 'client', 'model', 'breadcrumb'));
    }
    

    public function listStep($model, $history_id)
    {
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $list       = (new $actionStrategy)->listStep($history_id);
        return response()->json(['data' => $list]);
    }

    public function viewAction($model, $history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $product = $credit->creditProduct;
        $model = $model;
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $breadcrumb       = (new $actionStrategy)->breadcrumb($history, 2);
        return view('panel.module.checkup.actions.list', compact('history_id', 'product', 'credit', 'client', 'model', 'breadcrumb'));
    }

    public function viewReport($model, $history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit = $history->historyCredit;
        $product = $credit->creditProduct;
        $client = $credit->creditClientPerson;
        return view('panel.module.checkup.actions.report.index', compact('credit', 'product', 'client', 'history_id', 'history'));
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
