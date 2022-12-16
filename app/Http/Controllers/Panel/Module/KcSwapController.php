<?php

namespace App\Http\Controllers\Panel\Module;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\HistoryLog;
use Illuminate\Http\Request;

class KcSwapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.module.swap.list');
    }

    public function list()
    {
        $users = Credit::listDatatable([HistoryLog::KC_SWAP]);
        return response()->json(['data' => $users]);
    }
    //TODO: MAKE FUNCTION
    public function cancel()
    {
        $users = Credit::listDatatable([HistoryLog::KC_SWAP]);
        return response()->json(['data' => $users]);
    }
    public function continue($history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit                     = $history->historyCredit;

        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_UPLOAD, HistoryLog::KC_CONTROL_DESK_UPLOAD, null, false);
        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_FORM, HistoryLog::KC_CONTROL_DESK_FORM, null, false);

        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_UPLOAD, $history->id_rel, 0);
        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM, $history->id_rel, 0);
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
