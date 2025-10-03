<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\InvestorsCredit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
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
        Investor::setLendable($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $investor = Investor::find($id);
        $getUser = User::find(Auth::user()->id);
        $getPermission = $getUser->can('Gestionar colaboradores') ;
        if ($getPermission === true) {
            return redirect('/panel/clients/colaboradores/show');
        }
        
        if ($getUser->can('Otorgar Vo.Bo')) {
            return redirect('panel/solicitud');
        }


        if($investor == null) {
            abort(404);
        }
        $getTotal = InvestorsCredit::selectRaw('SUM(total_credit) as total_credit')->where('investor_id', $id)->first();
        $tramites = InvestorsCredit::selectRaw('SUM(import) as import')->where('investor_id', $id)->where('status',  '1')->first();
        
        $totalCredit = $getTotal != null ? $getTotal->total_credit : 0;      
        return view('panel.module.wallet.resumen', compact('investor', 'totalCredit', 'tramites'));
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

    public function ingresosMensuales($investorId)
    {
        $now = now();
        $importes = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $year = $date->year;
            $month = $date->month;
            $importe = \App\Models\InvestorsCredit::where('investor_id', $investorId)
                ->whereHas('credit', function($q) use ($year, $month) {
                    $q->whereYear('delivered_date', $year)
                      ->whereMonth('delivered_date', $month);
                })
                ->sum('import');
            $importes[] = round($importe, 2);
        }
        return response()->json($importes);
    }
}
