<?php

namespace App\Http\Controllers\Panel\Client;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Investor;
use App\Models\InvestorsCredit;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = Action::MODEL['client'];
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model        = $this->model;
        return view('panel.client.list', compact('model'));
    }

    public function list()
    {
        $users = ClientPerson::listDatatable();
        return response()->json(['data' => $users]);
    }

    public function showColaboradores()
    {
        return view('panel.client.listColaboradores');
    }

    public function ListColaboradores()
    {
        $users = ClientPerson::listDatatable(false, 'colaboradores');
        return response()->json(['data' => $users]);
    }

    public function savePrestar(Request $request)
    {
        // 1) Primero actualizamos el capital prestable y loan_available del inversionista:
        Investor::setLendableAndLoanAvailable($request->investorId, $request->lendable);
    
        // 2) Luego recalculamos todo en cascada (balance de inversor, loan_available en productos, 
        //    fondeo de créditos pendientes, etc.):
        Investor::updateInvestorData($request->investorId);
    
        // 3) Ya no usamos updateInvestorCredits. En su lugar, obtenemos 
        //    todos los financial_products asociados a ese inversionista y 
        //    llamamos a fundPendingCredits para cada uno:
        $financialProductIds = InvestorProduct::where('investor_id', $request->investorId)
            ->pluck('financial_products_id')
            ->unique();
    
        foreach ($financialProductIds as $fpId) {
            InvestorsCredit::fundPendingCredits($fpId);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client_id    = null;
        $client       = null;
        $agreements = Agreement::where('status', 1)->get();
        return view('panel.client.form', compact('client_id', 'client', 'agreements'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = ClientPerson::saveEdit($request);
        return response()->json(['client' => $client]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = ClientPerson::find($id);
        return response()->json(['client' => $client]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client_id = $id;
        $client = ClientPerson::find($id);
        $agreements = Agreement::where('status', 1)->get();
        return view('panel.client.form', compact('client_id', 'client', 'agreements'));
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
