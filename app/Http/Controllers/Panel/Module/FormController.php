<?php

namespace App\Http\Controllers\Panel\Module;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\CreditReference;
use App\Models\HistoryLog;
use App\Models\Transaction;
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
        $credit           = $model != 'wallet' && $history != null ? $history->historyCredit : null;
        $credit_id = $model != 'wallet' && $history != null ? $credit->id : null;
        $form             = (new $actionStrategy)->configForm($credit_id, $history_id);
        $breadcrumb       = (new $actionStrategy)->breadcrumb($history);
        $title            = (new $actionStrategy)->setTitle($history);
        $client           = $model != 'wallet' && $history != null ? $credit->creditClientPerson : null;
        $product          = $model != 'wallet' && $history != null ? $credit->creditProduct : null;
        $id_rel           = $model != 'wallet' && $history != null ? $credit->id : null;
        

        if ($model == 'wallet' && $history_id != 'null') {
            $id_rel = $history->id_rel;
        }
        return view('panel.module.checkup.content_form', compact('form', 'id_rel', 'title', 'product', 'credit', 'client', 'history', 'breadcrumb'));
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
    public function show($id, $type_form = null)
    {
        $credit = null;
        $client = null;
        $transaction = null;

        if ($type_form != HistoryLog::KC_WALLET_ADD_FORM && $type_form != HistoryLog::KC_WALLET_ADD_FORM_STEP_2) {
            $credit   = Credit::find($id);
            $client   = $credit->creditClientPerson;
        } else {
            $transaction = Transaction::find($id);
        }
        return response()->json(['credit' => $credit, 'client' => $client, 'transaction' => $transaction]);
       
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
