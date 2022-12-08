<?php

namespace App\Http\Controllers\Panel\Module\KcControlDesk;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\HistoryLog;
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

    public function validateKyc($history_id)
    {
        $history = HistoryLog::find($history_id);

        $get_credit = Credit::find($history->id_rel);
        $get_credit->kyc_done = 0;
        $get_credit->update();

        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_4, $get_credit->id, 1); //* marcar como finalizada la accion
        HistoryLog::move($get_credit->id, HistoryLog::KC_CONTROL_DESK_FORM_STEP_5, HistoryLog::KC_CONTROL_DESK_FORM_STEP_5, null, false);
        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_5, $get_credit->id, 0);

        return response()->json(0);
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
