<?php

namespace App\Http\Controllers\Panel\Module\KcWallet;

use App\Http\Controllers\Controller;
use App\Models\HistoryLog;
use App\Models\Investor;
use App\Models\kaaxSidecc\Collection;
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
        if ($getInvestor != null) {
            $collections = Collection::where('investor_id', $getInvestor->id)->get();
        }
        return view('panel.module.wallet.mis_prestamos', compact('collections'));
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
