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
        // 1) Actualizar el capital prestable del inversionista (lendable y loan_available)
        Investor::setLendableAndLoanAvailable($request->investorId, $request->lendable);
    
        // 2) Recalcular balances del inversionista y loan_available de sus productos financieros
        Investor::updateInvestorData($request->investorId);
    
        // 3) Obtener todos los productos financieros asociados al inversionista
        $financialProductIds = InvestorProduct::where('investor_id', $request->investorId)
            ->pluck('financial_products_id')
            ->unique();
    
        // 4) Intentar fondear créditos pendientes en cada producto financiero
        foreach ($financialProductIds as $financialProductId) {
            InvestorsCredit::fundCredits($financialProductId);
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
