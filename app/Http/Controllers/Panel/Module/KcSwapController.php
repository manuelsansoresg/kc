<?php

namespace App\Http\Controllers\Panel\Module;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\File;
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
        HistoryLog::updateStatusProgress(HistoryLog::KC_SWAP_FORM_STEP_3_2, $credit->id, 1);
        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK, $history->old_status_id);
        File::updateModel($credit->id, HistoryLog::KC_CONTROL_DESK, [HistoryLog::KC_SWAP]);
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
