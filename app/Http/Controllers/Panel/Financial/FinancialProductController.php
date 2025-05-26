<?php

namespace App\Http\Controllers\Panel\Financial;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\FinancialProduct;
use App\Models\ProductPaymentMethod;
use App\Models\ProductPeriodicity;
use Illuminate\Http\Request;

class FinancialProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($financial_id)
    {
        $product_id           = null;
        $financial_product    = null;
        $banks                = Bank::all();

        return view('panel.financial.product.form', compact('financial_id', 'product_id', 'financial_product', 'banks'));
    }

    public function getPeriodicityAndPaymentMethod($product_id)
    {
        $periodicities = ProductPeriodicity::where('product_id', $product_id)->get();
        $payments = ProductPaymentMethod::where('product_id', $product_id)->get();

        return response()->json(['periodicities' => $periodicities, 'payments' => $payments]);
    }
    
    public function getTramite(FinancialProduct $product)
    {
        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* if ($request->is_required == 'true') {
            if ($request->product_id == null) {
                $request->validate(
                    [
                    'name' => 'required|unique:financial_products,name',
                    ],
                    [
                        'name.unique' => 'El valor ya se encuentra registrado'
                    ]
                );
            } else {
                $request->validate(
                    [
                        'name' => 'required|unique:financial_products,name,' . $request->product_id . ',id',
                    ],
                    [
                        'name.unique' => 'El valor ya se encuentra registrado'
                    ]
                );
            }
        } */
        $financial = FinancialProduct::saveEdit($request);
        return response()->json($financial);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $financialProduct = FinancialProduct::find($id);
        return response()->json($financialProduct);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banks                = Bank::all();
        $financial_product    = FinancialProduct::find($id);
        $product_id           = $id;
        $financial_id         = $financial_product->financial_id;

        return view('panel.financial.product.form', compact('financial_id', 'product_id', 'financial_product', 'banks'));
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
        $financial = FinancialProduct::find($id);
        $financial->delete();
    }
}
