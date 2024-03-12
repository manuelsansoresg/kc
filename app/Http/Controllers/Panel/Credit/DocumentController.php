<?php

namespace App\Http\Controllers\Panel\Credit;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\HistoryLog;
use App\Strategies\Values\TemplateValues;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($model, $history_id)
    {
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $files            = (new $actionStrategy)->configUpload();
        $title = 'Acción carga';
        try {
            $title = (new $actionStrategy)->setTitleDocument();
        } catch (\Throwable $th) {
            //throw $th;
        }
        $history          = HistoryLog::find($history_id);
        $credit           = $history->historyCredit;
        $credit_id        = $credit->id;
        $client           = $credit->creditClientPerson;
        $product          = $credit->creditProduct;
        

        return view('panel.credit.files', compact('title', 'files', 'credit_id', 'model', 'product', 'credit', 'client', 'history'));
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
     * *Show uploaded files in credits
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
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
