<?php

namespace App\Http\Controllers\Panel\Credit;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\CreditReference;
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

    public function reference($model, $history_id)
    {
        $reference_id = null;
        return view('panel.credit.reference.form', compact('history_id', 'reference_id'));
    }
    
    public function storeReference($history_id, Request $request)
    {
        $history            = HistoryLog::find($history_id);
        $credit             = $history->historyCredit;
        $credit_reference   = CreditReference::saveEdit($credit->id, $request);
        return response()->json($credit_reference);
    }

    public function advisorStore($credit_id, Request $request)
    {
        Credit::find($credit_id)->update(
            ['asesor_id' => $request->asesor_id]
        );
    }

    public function listReference($history_id)
    {
        $history    = HistoryLog::find($history_id);
        $credit     = $history->historyCredit;
        $list       = CreditReference::list($history, $credit->id);
        return response()->json(['data' => $list]);
    }

    public function editReference($history_id, $reference_id)
    {
        $reference =  CreditReference::find($reference_id);
        return view('panel.credit.reference.form', compact('history_id', 'reference_id', 'reference'));
    }
   
    public function showReference($reference_id)
    {
        $reference =  CreditReference::find($reference_id);
        return response()->json($reference);
    }

    public function deleteReference($reference_id)
    {
        $reference = CreditReference::find($reference_id);
        $reference->delete();
        return response()->json($reference);
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
                HistoryLog::KC_CHECK_UP_ACTION_DESITION,
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM,
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION,

                HistoryLog::KC_CONTROL_DESK_UPLOAD,
                HistoryLog::KC_CONTROL_DESK_FORM,

                HistoryLog::KC_CONTROL_DESK_FORM_STEP_2,

                HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1,
                HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1,
                HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2,
                
                HistoryLog::KC_CONTROL_DESK_FORM_STEP_4,
                HistoryLog::KC_CONTROL_DESK_FORM_STEP_5,

                HistoryLog::KC_SWAP_UPLOAD,
                HistoryLog::KC_SWAP_FORM,
                HistoryLog::KC_SWAP_UPLOAD_2,
                
                HistoryLog::KC_SWAP_FORM_STEP_2,
                HistoryLog::KC_SWAP_FORM_STEP_2_2,
                HistoryLog::KC_SWAP_UPLOAD_STEP_2_3,
                HistoryLog::KC_SWAP_FORM_STEP_2_3,
                
                HistoryLog::KC_SWAP_UPLOAD_STEP_3,
                HistoryLog::KC_SWAP_FORM_STEP_3,
                HistoryLog::KC_SWAP_FORM_STEP_3_2,
                
                HistoryLog::KC_DELIVERY_FORM,
                HistoryLog::KC_DELIVERY_UPLOAD_STEP_2,
                HistoryLog::KC_DELIVERY_FORM_STEP_3,
                
                HistoryLog::KC_AFTER_FORM,
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
            HistoryLog::CREDITS_PAID => 'Pagados',
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
