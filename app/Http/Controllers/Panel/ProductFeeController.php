<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductFee;
use Illuminate\Http\Request;

class ProductFeeController extends Controller
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
        ProductFee::saveEdit($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fees_comision = ProductFee::where(['financial_product_id'=> $id, 'type' => 1])->get();
        $fees_result = ProductFee::where(['financial_product_id'=> $id, 'type' => 2])->get();
        
       $view_fees_comision =  \View::make('panel.agreement.view_product_fee', ['fees' => $fees_comision])->render();
       $view_fees_result =  \View::make('panel.agreement.view_product_fee', ['fees' => $fees_result])->render();
       //return $view_fees_comision;  
       return response()->json([
        'costoContratacion' => $view_fees_comision,
        'comisiones' => $view_fees_result,
       ]);
    }

    public function showproductFee(ProductFee $productFee)
    {
        return response()->json($productFee);
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
        ProductFee::find($id)->delete();
    }
}
