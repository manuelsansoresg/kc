<?php

namespace App\Http\Controllers;

use App\Models\CreditPayOff;
use Illuminate\Http\Request;

class CreditPayOffController extends Controller
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
        CreditPayOff::saveEdit($request);
               
        return response()->json('ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $creditPays = CreditPayOff::select('credit_pay_off.id', 'financial_products.alias', 'credit_pay_off.ammount')
        ->join('financial_products', 'credit_pay_off.financial_product_id', 'financial_products.id')
        ->where('credit_pay_off.lead_id', $id)
        ->get();
        
        $total = $creditPays->sum('ammount');

        $table           = \View::make('panel.lead.table_compra_cartera', ['creditPays' => $creditPays])->render();
        return response()->json(['table' => $table, 'total' => $total]);
    }

    public static function getDataModal($creditPayOffId)
    {
        $creditPay = CreditPayOff::find($creditPayOffId);
        return response()->json($creditPay);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
        CreditPayOff::where('id', $id)->delete();
    }
}
