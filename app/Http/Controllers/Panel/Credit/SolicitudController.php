<?php

namespace App\Http\Controllers\Panel\Credit;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\CreditPayOff;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Product;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('credit.solicitud');
    }

    public function modalShow($history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit = Credit::find($history->id_rel);
        $product            = $credit->creditProduct;
        $financialProduct = $product = FinancialProduct::find($credit->applied_financial_product);
        $tipoCredito = $financialProduct != null  ? Product::find($financialProduct->type_product_id) : null;
        $periodicity        = isset(config('financial_enums.periodicity_products')[$credit->applied_periodicity]) && $credit->applied_periodicity != null ? config('financial_enums.periodicity_products')[$credit->applied_periodicity] : null;
        $getCompracartera = CreditPayOff::selectRaw('SUM(ammount) as ammount')
            ->join('financial_products', 'financial_products.id', 'credit_pay_off.financial_product_id')
            ->where([
                'new_kc_credit_id' => $credit->id,
                'is_kc_lender' => 0
            ])->first();

        return view('credit.modal_solicitud', compact('history', 'credit', 'product', 'tipoCredito', 'periodicity', 'getCompracartera'));
    }

    public function statusDeny($history_id)
    {
        $history = HistoryLog::find($history_id);
        Credit::where('id', $history->id_rel)->update([
            'status' => 3 //denegar
        ]);
        HistoryLog::where('id', $history_id)->update([
            'status' => 0 //denegar
        ]);


        return response()->json(['data' => 'ok']);
    }

    public function statusApprove($history_id)
    {
        $history = HistoryLog::find($history_id);
        Credit::where('id', $history->id_rel)->update([
            'status' => 2 //aceptar
        ]);
        HistoryLog::where('id', $history_id)->update([
            'status' => 0 //aceptar
        ]);


        return response()->json(['data' => 'ok']);
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
        $users = Credit::listDatatableSolicitud();
        return response()->json(['data' => $users]);
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
