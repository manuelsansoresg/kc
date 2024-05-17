<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\FinancialAgreement;
use App\Models\FinancialProduct;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.agreement.list');
    }

    public function list()
    {
        $users = Agreement::listDatatable();
        
        return response()->json(['data' => $users]);
    }

    public function getFinancialProducts(Agreement $agreement)
    {
        $get_financials = FinancialAgreement::where('agreement_id', $agreement->id)->get();
        $financials = array();
        if ($get_financials != null) {
            foreach ($get_financials as $financial) {
                $getProduct = FinancialProduct::getbyIdFirst($financial->product_id);
                $financials[$getProduct->id]= $getProduct->commercial_name.' - '.$getProduct->name;
            }
        }
        return response()->json($financials);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agreement_id = null;
        $agreement = null;
        return view('panel.agreement.form', compact('agreement_id', 'agreement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $agreement = Agreement::saveEdit($request);
        FinancialAgreement::saveEdit($agreement->id, $request);
        return response()->json(200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agreement = Agreement::find($id);
        $get_financials = FinancialAgreement::where('agreement_id', $agreement->id)->get();
        //$products = $get_financials->financial;
        //dd($get_financials);
        $financials = array();
        if ($get_financials != null) {
            foreach ($get_financials as $financial) {
                $product = FinancialProduct::getbyIdFirst($financial->product_id);
                $financials[]= $product;
            }
        }
        //$financials = trim($financials, ',');
        $data = array('agreement' => $agreement, 'financials' => $financials);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agreement_id = $id;
        $agreement = Agreement::find($id);
        return view('panel.agreement.form', compact('agreement_id', 'agreement'));
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
        $agreement = Agreement::find($id);
        $agreement->delete();
        return response()->json(200);
    }
}
