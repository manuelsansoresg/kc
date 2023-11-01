<?php

namespace App\Http\Controllers\Panel\Financial;

use App\Http\Controllers\Controller;
use App\Models\FinancialProduct;
use App\Models\ProductComplementaryService;
use Illuminate\Http\Request;

class ProductComplementaryServiceController extends Controller
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
        ProductComplementaryService::saveEdit($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialProduct $product, $type)
    {
        $product_complementary = ProductComplementaryService::where([
            'product_id' => $product->id,
            'type' => $type
        ])->get();
        $view = \View::make('panel.financial.product.view_complementary ', ['query' => $product_complementary])->render();
        return response()->json($view);
    }

    public function refresh($product_id)
    {
        $financial_products = FinancialProduct::find($product_id);
        $complementary_alcance = ProductComplementaryService::where([
            'product_id' => $product_id,
            'type' => 1
        ])->get();
        $complementary_restricciones = ProductComplementaryService::where([
            'product_id' => $product_id,
            'type' => 2
        ])->get();
        $complementary_programas = ProductComplementaryService::where([
            'product_id' => $product_id,
            'type' => 3
        ])->get();
        $complementary_referencias = ProductComplementaryService::where([
            'product_id' => $product_id,
            'type' => 4
        ])->get();

        return response()->json([
            'complementary_alcance' => $complementary_alcance,
            'complementary_restricciones' => $complementary_restricciones,
            'complementary_programas' => $complementary_programas,
            'complementary_referencias' => $complementary_referencias,
            'my_product' => $financial_products
        ]);
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
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductComplementaryService::find($id)->delete();
    }
}
