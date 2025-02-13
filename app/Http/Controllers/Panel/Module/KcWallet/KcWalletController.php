<?php

namespace App\Http\Controllers\Panel\Module\KcWallet;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\HistoryLog;
use App\Models\Investor;
use App\Models\InvestorsCredit;
use App\Models\kaaxSidecc\Collection;
use App\Models\kaaxSidecc\CrmStatusListKaaxSidecc;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KcWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $investor = Investor::where('user_id', Auth::user()->id)->first();
        $total_available = null;
        if ($investor != null) {
            $total_available = $investor->total_available;
        }
        
        return view('panel.module.wallet.list', compact('total_available'));
    }

    public function list()
    {
        $users = Transaction::listDatatable([HistoryLog::KC_WALLET_ADD_FORM]);
        return response()->json(['data' => $users]);
    }
    
    public function listMisPrestamos()
    {
        $getInvestor       = Investor::where('user_id', Auth::user()->id)->first();
        $collections = null;
        $getInvestorCredits = null;
        $data = array();
        if ($getInvestor != null) {
            $getInvestorCredits = InvestorsCredit::where('investor_id', $getInvestor->id)->get();
            

            foreach ($getInvestorCredits as $getInvestorCredit) {
                $getCollection   = Collection::where('kc_credit_id',  $getInvestorCredit->credit_id)->first();
                $creditId        = $getInvestorCredit->id;
                $valorStatus     = 'Pendiente';
                $importe         = $getInvestorCredit->import ;
                $pagado          = $getInvestorCredit->total_collected;
                $porPagar        = $getInvestorCredit->placed_capital;
                
                $valorImporte    = format_price($importe);
                $valorPagado     = format_price($pagado);
                $valorPorPagar   = format_price($porPagar);

                $interesProyectado = format_price($getInvestorCredit->total_credit  - $getInvestorCredit->import);
                if ($getCollection != null) {
                    $percentage      = $getInvestorCredit->percentage / 100;
                    $getStatus       = CrmStatusListKaaxSidecc::getStatus($getCollection->status);
                    $getInvestor     = Investor::find($getInvestorCredit->investor_id);
                    $getCredit       = Credit::find($getInvestorCredit->credit_id);
                    $valorStatus     = $getStatus->name;
                }

                $data[] = array(
                    'id' => "{$creditId}".'<a href="/panel/credit/'.$getInvestorCredit->credit_id.'?tab=pagos" target="_blank"> &nbsp; <span class="badge bg-primary">Ver</span> </a>',
                    'status' => $valorStatus,
                    'importe' => $valorImporte,
                    'pagado' => $valorPagado,
                    'capital_pendiente' => $valorPorPagar,
                    'capital_recuperado' => format_price($getInvestorCredit->recovered_capital),
                    'interes_proyectado' => $interesProyectado,
                    'interes_cobrado' => format_price($getInvestorCredit->profit_collected),
                    'comision_kc' => format_price($getInvestorCredit->commission_amount),
                );
            }
        }
        return response()->json(['data' => $data]);
    }
   public function listHistory()
   {
    return view('panel.module.wallet.history');
   }

   public function listHistoryShow()
    {
        $investor = Investor::where('user_id', Auth::user()->id)->first();
        
        if ($investor != null) {
            $data = InvestorsCredit::listStatements($investor->id);
            return response()->json(['data' => $data]);
        }
        return response()->json(['data' => null]);
    }

    public function getInvestor(Investor $investor)
    {
        $user = User::find($investor->user_id);
        $legend = \View::make('panel.module.wallet.legendInvestor', ['user' => $user, 'investor' => $investor])->render();
        
        return response()->json($legend);
    }

    public function misPrestamos()
    {
        //dd(Auth::user()->id);
        $collections = null;
        $getInvestorCredits = null;
       
        return view('panel.module.wallet.mis_prestamos', compact('getInvestorCredits'));
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
