<?php

namespace App\Http\Controllers\Panel\Module;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\CreditReference;
use App\Models\CreditTag;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
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
        $credit           = $model != 'wallet' && $model != 'kc-down-wallet'  && $history != null ? $history->historyCredit : null;
        $credit_id = $model != 'wallet' && $model != 'kc-down-wallet'  && $history != null ? $credit->id : null;
        $form             = (new $actionStrategy)->configForm($credit_id, $history_id);
        $breadcrumb       = (new $actionStrategy)->breadcrumb($history);
        $title            = (new $actionStrategy)->setTitle($history);
        
        $client           = $model != 'wallet' && $model != 'kc-down-wallet'  && $history != null ? $credit->creditClientPerson : null;
        $product          = $model != 'wallet' && $model != 'kc-down-wallet'  && $history != null ? $credit->creditProduct : null;
        $id_rel           = $model != 'wallet' && $model != 'kc-down-wallet'  && $history != null ? $credit->id : null;
        $financialProduct = $product = FinancialProduct::find($credit->applied_financial_product);
        $getAsesor = User::find($credit->asesor_id);
        
        $tipoCredito = $financialProduct != null  ? Product::find($financialProduct->type_product_id) : null;
        $lastComment = HistoryLog::select('comment')
                        ->where([
                        'id_rel'=> $credit->id,
                        'status' => 1
                    ])->where('comment', '!=', null)->orderBy('id', 'DESC')->first();
        $periodicity = isset(config('financial_enums.periodicity_products')[$credit->applied_periodicity]) && $credit->applied_periodicity != null ? config('financial_enums.periodicity_products')[$credit->applied_periodicity] : null;
        $origin = isset(config('enums.origin')[$credit->origin_id]) ? config('enums.origin')[$credit->origin_id] : null;
        $tags = CreditTag::select('tags.name')
                ->join('tags', 'tags.id', '=', 'credit_tag.tag_id')
                ->where('credit_id', $credit->id)
                ->pluck('tags.name')
                ->implode(',');

            if ($tags === '') {
                $tags = null;
            }
        
        if (($model == 'wallet' || $model == 'kc-down-wallet') && $history_id != 'null') {
            $id_rel = $history->id_rel;
        }
        return view('panel.module.checkup.content_form', compact('form', 'id_rel', 'tags', 'getAsesor', 'periodicity', 'lastComment', 'origin', 'financialProduct', 'tipoCredito', 'title', 'product', 'credit', 'client', 'history', 'breadcrumb'));
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

        if ($type_form != HistoryLog::KC_WALLET_ADD_FORM && $type_form != HistoryLog::KC_WALLET_ADD_FORM_STEP_2 && $type_form != HistoryLog::KC_DOWN_WALLET_ADD_FORM && $type_form != HistoryLog::KC_DOWN_WALLET_ADD_FORM_STEP_2) {
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
