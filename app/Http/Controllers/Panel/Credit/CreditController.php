<?php

namespace App\Http\Controllers\Panel\Credit;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\HistoryLog;
use App\Strategies\Values\ActionValues;
use Illuminate\Http\Request;

class CreditController extends Controller
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

    public function storeTag(Request $request)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $tag              = (new $actionStrategy)->saveTag($request);
    }

    public function getTag($credit_id)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $get_tag              = (new $actionStrategy)->getTags($credit_id);
        return response()->json($get_tag);
    }

    public function deleteTag($tag_id)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $tag              = (new $actionStrategy)->deleteTag($tag_id);
        return response()->json($tag);
    }

    public function getNote($credit_id)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $get_note         = (new $actionStrategy)->getNotes($credit_id);
        return response()->json($get_note);
    }

    public function getListAction($credit_id)
    {
        $leadStrategy   = ActionValues::STRATEGY['list'];
        $actions = [
            HistoryLog::KC_CHECK_UP_ACTION_FORM,
            HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM,
            HistoryLog::KC_CHECK_UP_ACTION_DESITION,
            HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION,
        ];
        
        $data_progress       = (new $leadStrategy)->get('in_progress', $actions, $credit_id);
        $data_completed       = (new $leadStrategy)->get('completed', $actions, $credit_id);
        $list = array_merge($data_progress, $data_completed);
        return response()->json(['data' => $list]);
    }

    public function product($status)
    {
        $titles = array(
            HistoryLog::CREDIT_IN_PROGRESS => 'En curso',
            HistoryLog::CREDIT_CANCELED => 'Cancelados',
            HistoryLog::CREDIT_REJECTED => 'Rechazados',
        );
        $title = $titles[$status];
        if ($status != HistoryLog::CREDIT_IN_PROGRESS) {
            return view('panel.credit.product.index', compact('status', 'title'));
        }
        return view('panel.credit.product.in_progress', compact('status', 'title'));
    }

    public function productList($status)
    {
        
        if ($status == HistoryLog::CREDIT_IN_PROGRESS) {
            $list = Credit::listDatatableInProgress([$status]);
        } else {
            $list = Credit::listDatatableProduct([$status]);
        }
        

        return response()->json(['data' => $list]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $credit = Credit::find($id);
        return view('panel.credit.profile', compact('credit'));
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
