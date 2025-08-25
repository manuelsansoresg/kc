<?php

namespace App\Http\Controllers\Panel\Module;

use App\Http\Controllers\Controller;
use App\Models\CreditPayOff;
use App\Models\CreditsControlDesk;
use App\Models\CreditTag;
use App\Models\File;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Product;
use App\Models\User;
use App\Strategies\Values\TemplateValues;
use Illuminate\Http\Request;

class TemplateController extends Controller
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

    public function viewStep($model, $history_id)
    {
        $history            = HistoryLog::find($history_id);
        $credit             = null;
        $client             = null;
        $product            = null;
        $creditsControldesk = null;
        $periodicity        = null;
        $tipoCredito        = null;
        $getCompracartera   = null;
        $getAsesor          = null;
        $origin             = null;
        $tags               = null;
        $lastComment        = null;
        $files              = null;
        $path               = File::PATH;

        if ($model != 'wallet' && $model != 'kc-down-wallet') {
            $credit             = $history->historyCredit;
            $client             = $credit->creditClientPerson;
            $product            = $credit->creditProduct;
            $creditsControldesk = CreditsControlDesk::isValidate($credit->id);
            $periodicity        = isset(config('financial_enums.periodicity_products')[$credit->applied_periodicity]) && $credit->applied_periodicity != null ? config('financial_enums.periodicity_products')[$credit->applied_periodicity] : null;
            $financialProduct = $product = FinancialProduct::find($credit->applied_financial_product);
            $tipoCredito = $financialProduct != null  ? Product::find($financialProduct->type_product_id) : null;
            $getCompracartera = CreditPayOff::selectRaw('SUM(ammount) as ammount')
            ->join('financial_products', 'financial_products.id', 'credit_pay_off.financial_product_id')
            ->where([
                'new_kc_credit_id' => $credit->id,
                'is_kc_lender' => 0
            ])->first();
            $getAsesor = User::find($credit->asesor_id);
            $origin = isset(config('enums.origin')[$credit->origin_id]) ? config('enums.origin')[$credit->origin_id] : null;
            $tags = CreditTag::select('tags.name')
                    ->join('tags', 'tags.id', '=', 'credit_tag.tag_id')
                    ->where('credit_id', $credit->id)
                    ->pluck('tags.name')
                    ->implode(',');
    
            if ($tags === '') {
                $tags = null;
            }

            $lastComment = HistoryLog::select('comment')
                            ->where([
                            'id_rel'=> $credit->id,
                            'status' => 1
                        ])->where('comment', '!=', null)->orderBy('id', 'DESC')->first();
            
            $files = File::getByIdRelandModel($credit->id, [HistoryLog::KC_CHECK_UP, HistoryLog::KC_CONTROL_DESK, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION, HistoryLog::KC_SWAP, HistoryLog::KC_DELIVERY]);

        }
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $breadcrumb       = (new $actionStrategy)->breadcrumb($history);
        
        
        
        if ($model == 'controlDesk' || $model == 'newCredit' || $model == 'debtCredit' || $model == 'swap' || $model == 'delivery'  || $model == 'afterMarket' || $model == 'payment' || $model == 'wallet' || $model == 'kc-down-wallet' ) {
            $list_steps       = (new $actionStrategy)->listStep($history_id);
            return view('panel.module.view_steps', compact('history_id', 'path', 'getAsesor', 'files', 'tags', 'lastComment', 'history', 'origin', 'getCompracartera', 'tipoCredito', 'periodicity', 'creditsControldesk', 'product', 'credit', 'client', 'model', 'breadcrumb', 'list_steps', 'actionStrategy'));
        }
        //return view('panel.module.checkup.steps.list', compact('history_id', 'product', 'credit', 'client', 'model', 'breadcrumb'));
    }
    

    public function listStep($model, $history_id)
    {
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $list       = (new $actionStrategy)->listStep($history_id);
        return response()->json(['data' => $list]);
    }

    
    public function validateControlDesk($creditId)
    {
        $creditControlDesk = CreditsControlDesk::where('credit_id', $creditId)->get();
        $table = \View::make('panel.module.control_desk.list_validate', ['creditControlDesk' => $creditControlDesk])->render();
        return response()->json($table);
    }

    public function list($model, $history_id)
    {
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $list       = (new $actionStrategy)->listAction($history_id);
        
        return response()->json(['data' => $list]);
    }

    public function viewAction($model, $history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $product = $credit->creditProduct;
        $model = $model;
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $breadcrumb       = (new $actionStrategy)->breadcrumb($history, 2);
        return view('panel.module.checkup.actions.list', compact('history_id', 'product', 'credit', 'client', 'model', 'breadcrumb'));
    }

    public function viewReport($model, $history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit = $history->historyCredit;
        $product = $credit->creditProduct;
        $client = $credit->creditClientPerson;
        return view('panel.module.checkup.actions.report.index', compact('credit', 'product', 'client', 'history_id', 'history'));
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
