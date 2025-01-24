<?php

namespace App\Http\Controllers\Panel\Module\KcControlDesk;

use App\Http\Controllers\Controller;
use App\Lib\CNubarium;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Kyc;
use Illuminate\Http\Request;

class KcControlDeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.module.control_desk.list');
    }

    public function list()
    {
        $users = Credit::listDatatable([HistoryLog::KC_CONTROL_DESK]);
        return response()->json(['data' => $users]);
    }

    public function finish(HistoryLog $history)
    {
        HistoryLog::move($history->id_rel, HistoryLog::KC_DELIVERY, $history->old_status_id, null);
    }

    public function showStep(Credit $credit)
    {
        
        return view('Panel.module.control_desk.step', compact('credit'));
    }

    public function validateKyc($history_id, $param, $param2, $type)
    {
        //*ejecutar api nubarium
        $history        = HistoryLog::find($history_id);
        $validate_nb    = Kyc::sendValidateKyc($history->id_rel, $type, $param, $param2);
        $estatus        = $validate_nb['estatus'];
        $html           = $validate_nb['html'];
        $msg            = Kyc::formatMsg($validate_nb['result']);
        return response()->json(['status' => $estatus, 'html' => $html, 'msg' => $msg]);
    }

    public function saveKyc($credit_id)
    {
        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK3_STEP2, $credit_id, 1); //* marcar como finalizada la accion
        HistoryLog::move($credit_id, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, null, false);
        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, $credit_id, 0);
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
