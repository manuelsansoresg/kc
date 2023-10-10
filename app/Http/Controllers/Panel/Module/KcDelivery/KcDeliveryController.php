<?php

namespace App\Http\Controllers\Panel\Module\KcDelivery;

use App\Http\Controllers\Controller;
use App\Lib\Csendgrid;
use App\Models\Credit;
use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KcDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.module.delivery.list');
    }

    public function list()
    {
        $users = Credit::listDatatable([HistoryLog::KC_DELIVERY]);
        return response()->json(['data' => $users]);
    }

    public function sendEmail($history_id)
    {
        $history    = HistoryLog::find($history_id);
        $credit     = $history->historyCredit;
        HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM, $credit->id, 1);
        //*inicializar las acciones de la siguiente etapa en curso
        HistoryLog::move($credit->id, HistoryLog::KC_DELIVERY_FORM_STEP_2, HistoryLog::KC_DELIVERY_FORM_STEP_2, null, false);
        HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_2, $credit->id, 0);

        //*send email
        try {
            $financial_t = $credit->creditAppliedFinancial;
            $name_financial_t = $financial_t->email;
            $send_grid = new Csendgrid($name_financial_t, 'creacion cuenta');
            $send_grid->setTemplate('d-208896a6a91043619f40ba61cbebf5c7');
            $data_params = array(
                'link_account' => asset('credit-resume/'.$credit->id),
            );
            $send_grid->setParams($data_params);
            $send_grid->send();
        } catch (\Exception $th) {
            //throw $th;
        }
        
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
