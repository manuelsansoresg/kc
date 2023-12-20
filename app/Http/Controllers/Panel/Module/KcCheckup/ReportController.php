<?php

namespace App\Http\Controllers\Panel\Module\KcCheckup;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Credit;
use App\Models\File;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Strategies\Values\SendNotificationsValues;
use App\Strategies\Values\TemplateValues;
use Illuminate\Http\Request;

class ReportController extends Controller
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($history_id)
    {
    }

    public function list($history_id)
    {
        $get_history = HistoryLog::find($history_id);
        $model = ($get_history != null && $get_history->status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION) ? 'debtCredit' : 'newCredit';
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $list       = (new $actionStrategy)->listStepReport($history_id);

        return response()->json(['data' => $list]);
    }

    public function actionReport($history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit = $history->historyCredit;
        $product = $credit->creditProduct;
        $client = $credit->creditClientPerson;
        $model = ($history != null && $history->status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION) ? 'debtCredit' : 'newCredit';
        return view('panel.module.checkup.actions.report.list', compact('credit', 'product', 'client', 'history_id', 'history', 'model'));
    }

    public function desitionReport($history_id)
    {
        $history    = HistoryLog::find($history_id);
        $credit     = $history->historyCredit;
        $product    = $credit->creditProduct;
        $client     = $credit->creditClientPerson;
        $agreement  = $credit->creditAgreement;
        $financials = FinancialProduct::getByRate($credit);
        //dd($agreement->financialAgreement);
        $model      = ($history != null && $history->status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION) ? 'debtCredit' : 'newCredit';

        return view('panel.module.checkup.actions.report.desition', compact('credit', 'product', 'financials', 'client', 'history_id', 'history', 'model'));
    }

    public function verifyReport($credit_id, $product_id)
    {
        $product = FinancialProduct::find($product_id);
        $status = 200;
        $content = '';
        $banks = '';
        $credit = Credit::find($credit_id);
        if ($product!= null && $product->is_tramitar == 1 && $product->is_vincular_banco == 1 && ($credit != null && $credit->bank_id === null)) {
            $status = 500;
            $content = '';
            $bank_ids_array = explode(',', $product->bank_ids);
            $banks = Bank::whereIn('id', $bank_ids_array)->get();
            $banks = \View::make('panel.product.button_banks', ['banks' => $banks, 'credit' => $credit])->render();
        }
        return response()->json([
            'status' => $status,
            'content' => $content,
            'banks' => $banks,
        ]);
    }

    public function desitionAccept($credit_id, $financial_id, $type)
    {
       
        $credit     = Credit::find($credit_id);
        $get_financial_product = FinancialProduct::find($financial_id);
        $is_notify = isset($_GET['is_notify']) ? $_GET['is_notify'] : 'false';
        if ($credit != null) {
            if ($type == 1) { // credito nuevo
                
                $credit->applied_financial = $get_financial_product->financial_id;
                $credit->financial_product_id = $get_financial_product->id;
                $credit->update();
                if ($is_notify == 'false') {
                    HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_ACTION_DESITION, HistoryLog::KC_CHECK_UP_ACTION_DESITION, null, false);
                    HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_DESITION, $credit->id, 1);//marcar como finalizada
                    File::updateModel($credit->id, HistoryLog::KC_CONTROL_DESK, [HistoryLog::KC_CHECK_UP, HistoryLog::ADD_PROSPECT]);
                    
                    $history = HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK, HistoryLog::KC_CHECK_UP);
                    
                    $notification_add   = SendNotificationsValues::STRATEGY['pushCreditKcControlDesk'];
                    (new $notification_add)->send($credit->id);
                }
                
            } else {//reduccion

                $credit->applied_financial = $get_financial_product->financial_id;
                $credit->financial_product_id = $get_financial_product->id;
                $credit->update();
                if ($is_notify == false) {
                    HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION, null, false);

                    HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION, $credit->id, 1);
                    File::updateModel($credit->id, HistoryLog::KC_SWAP, [HistoryLog::KC_CHECK_UP_DEBT_REDUCTION, HistoryLog::ADD_PROSPECT]);
                    

                    $history = HistoryLog::move($credit->id, HistoryLog::KC_SWAP, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION);
                    
                    $notification_add   = SendNotificationsValues::STRATEGY['pushCreditKcSwap'];
                    (new $notification_add)->send($credit->id);
                }
            }
        }
        return response()->json('ok');
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
