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
        $getInvestor = Investor::where('user_id', Auth::user()->id)->first();
        $collections = null;
        $getInvestorCredits = null;
        $data = array();

        if ($getInvestor != null) {
            $getInvestorCredits = InvestorsCredit::where('investor_id', $getInvestor->id)->get();

            foreach ($getInvestorCredits as $getInvestorCredit) {
                $getCollection = Collection::where('kc_credit_id', $getInvestorCredit->credit_id)->first();
                $creditId = $getInvestorCredit->credit_id;

                // Obtener crédito para la fecha de entrega
                $credit = Credit::find($creditId);
                $fechaEntrega = $credit && $credit->delivered_date
                    ? date('Y-m-d', strtotime($credit->delivered_date))
                    : null;

                // Datos crudos
                $importe = $getInvestorCredit->import;
                $pagado = $getInvestorCredit->total_collected;
                $porPagar = $getInvestorCredit->placed_capital;
                $interesProyectado = $getInvestorCredit->total_balance - $porPagar;
                $interesCobrado = $getInvestorCredit->profit_collected + $getInvestorCredit->iva_collected;

                // Formateo de montos
                $valorImporte = format_price($importe);
                $valorPagado = format_price($pagado);
                $valorPorPagar = format_price($porPagar);
                $valorInteresProyectado = format_price($interesProyectado);
                $valorInteresCobrado = format_price($interesCobrado);
                $valorComision = format_price($getInvestorCredit->commission_amount + $getInvestorCredit->iva_commission);

                // Status desde config
                $status = config('enums.investorsCreditsStatus')[$getInvestorCredit->status];

                $data[] = array(
                    'id' => "{$creditId}" . '<a href="/panel/credit/' . $getInvestorCredit->credit_id . '?tab=pagos" target="_blank"> &nbsp; <span class="badge bg-primary">Ver</span> </a>',
                    'status' => $status,
                    'importe' => $valorImporte,
                    'pagado' => $valorPagado,
                    'capital_recuperado' => format_price($getInvestorCredit->recovered_capital),
                    'interes_proyectado' => $valorInteresProyectado,
                    'capital_pendiente' => $valorPorPagar,
                    'interes_cobrado' => $valorInteresCobrado,
                    'comision_kc' => $valorComision,
                    'fecha_entrega' => $fechaEntrega,
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
        $getInvestor = Investor::where('user_id', Auth::user()->id)->first();
        $collections = null;
        $getInvestorCredits = null;
        $data = array();

        if ($getInvestor != null) {
            $getInvestorCredits = InvestorsCredit::where('investor_id', $getInvestor->id)->orderBy('created_at', 'desc')->get();

            foreach ($getInvestorCredits as $getInvestorCredit) {
                $getCollection = Collection::where('kc_credit_id', $getInvestorCredit->credit_id)->first();
                $creditId = $getInvestorCredit->credit_id;

                // Obtener crédito para la fecha de entrega
                $credit = Credit::find($creditId);
                $fechaEntrega = $credit && $credit->delivered_date
                    ? date('Y-m-d', strtotime($credit->delivered_date))
                    : null;

                // Datos crudos
                $importe = $getInvestorCredit->import;
                $pagado = $getInvestorCredit->total_collected;
                $porPagar = $getInvestorCredit->placed_capital;
                $interesProyectado = $getInvestorCredit->total_balance - $porPagar;
                $interesCobrado = $getInvestorCredit->profit_collected + $getInvestorCredit->iva_collected;

                // Formateo de montos
                $valorImporte = format_price($importe);
                $valorPagado = format_price($pagado);
                $valorPorPagar = format_price($porPagar);
                $valorInteresProyectado = format_price($interesProyectado);
                $valorInteresCobrado = format_price($interesCobrado);
                $valorCapitalRecuperado = format_price($getInvestorCredit->recovered_capital);
                $valorComision = format_price($getInvestorCredit->commission_amount + $getInvestorCredit->iva_commission);

                // Status desde config
                $status = config('enums.investorsCreditsStatus')[$getInvestorCredit->status];

                $data[] = array(
                    'id' => "{$creditId}",
                    'action' => '<a href="/panel/credit/' . $creditId . '?tab=pagos" target="_blank"> &nbsp; <span class="badge bg-primary">Ver</span> </a>',
                    'status' => $status,
                    'importe' => $valorImporte,
                    'pagado' => $valorPagado,
                    'capital_recuperado' => $valorCapitalRecuperado,
                    'interes_proyectado' => $valorInteresProyectado,
                    'capital_pendiente' => $valorPorPagar,
                    'interes_cobrado' => $valorInteresCobrado,
                    'comision_kc' => $valorComision,
                    'fecha_entrega' => $fechaEntrega,
                );
            }
        }

        return view('panel.module.wallet.mis_prestamos', compact('getInvestorCredits', 'data'));
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
