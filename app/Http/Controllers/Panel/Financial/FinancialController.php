<?php

namespace App\Http\Controllers\Panel\Financial;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.financial.list');
    }

    public function list()
    {
        $tags = Financial::listDatatable();

        return response()->json(['data' => $tags]);
    }
    public function listProduct($financial_id)
    {
        $tags = Financial::listProductDatatable($financial_id);

        return response()->json(['data' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $financial_id = null;
        $financial = null;
        return view('panel.financial.form', compact('financial_id', 'financial'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->is_required == 'true') {
            if ($request->financial_id == null) {
                $request->validate(
                    [
                    'commercial_name' => 'required|unique:financials,commercial_name',
                    ],
                    [
                        'commercial_name.unique' => 'El valor ya se encuentra registrado'
                    ]
                );
            } else {
                $request->validate(
                    [
                        'commercial_name' => 'required|unique:financials,commercial_name,' . $request->financial_id . ',id',
                    ],
                    [
                        'commercial_name.unique' => 'El valor ya se encuentra registrado'
                    ]
                );
            }
        }
        $financial = Financial::saveEdit($request);
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
        
        $financial      = Financial::find($id);
        $financial_id   = $financial->id;
        return view('panel.financial.form', compact('financial_id', 'financial'));
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
        $financial = Financial::find($id);
        $financial->delete();
    }
}
