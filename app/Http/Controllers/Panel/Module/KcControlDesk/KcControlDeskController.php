<?php

namespace App\Http\Controllers\Panel\Module\KcControlDesk;

use App\Http\Controllers\Controller;
use App\Lib\CalculadoraCredito;
use App\Lib\CNubarium;
use App\Models\Credit;
use App\Models\CreditPayOff;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Kyc;
use Illuminate\Http\Request;

class KcControlDeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.module.control_desk.list');
    }

    public function list()
    {
        $users = Credit::listDatatable([HistoryLog::KC_CONTROL_DESK]);
        return response()->json(['data' => $users]);
    }

    public static function getDataModal($creditPayOffId)
    {
        $creditPay = CreditPayOff::find($creditPayOffId);
        return response()->json($creditPay);
    }

    public function calculateCompraCartera(Credit $credit, $tramitType, $plazo)
    {
        $descuento = 0;
        $calculadora = new CalculadoraCredito();
        $financialProduct = FinancialProduct::find($credit->applied_financial_product);
        $min         = floatval($financialProduct->min_loan_amount);
        $max         = $financialProduct->max_loan_ammount;

        $client = $credit->creditClientPerson;
        $paymentCapacity =  $credit == null ? $client->payment_capacity : $credit->payroll_payment_capacity;

        if ($tramitType == 3) { //refinanciamiento
            $pmt = $paymentCapacity + $descuento;
        } else {
            $pmt = $paymentCapacity;
        }

        $present = $calculadora->presentValue($financialProduct, $plazo, $pmt, $tramitType);
        $montoMaximo = 0; 
        for ($i = $min; $i <= $max; $i += 1000) {
            if (($present > 0 && $present != -0) && $i > $present) {
                break;
            }
            $montoMaximo = $i;
        }

        $creditPay = CreditPayOff::select('ammount')
        ->where('credit_pay_off.client_person_id', $client->id)
        ->where('kc_credit_id_payed_off', '!=', null)
        ->sum('ammount');
       
        $montoRefinanciable = CreditPayOff::select('ammount')
        ->where('credit_pay_off.client_person_id', $client->id)
        ->where('kc_credit_id_payed_off', '=', null)
        ->sum('ammount');
        
        $compraCartera = $creditPay / (100 - $financialProduct->opening_commission_rate) * 100;
        $montoSolicitado = min($compraCartera, $montoMaximo);
        $data = array(
            'compraCartera' => $compraCartera,
            'montoSolicitado' => $montoSolicitado,
            'montoRefinanciable' => $montoRefinanciable,
        );
        return response()->json($data);
    }

    public function finish(HistoryLog $history)
    {
        HistoryLog::move($history->id_rel, HistoryLog::KC_DELIVERY, $history->old_status_id, null);
    }

    public function showStep(Credit $credit)
    {
        
        return view('Panel.module.control_desk.step', compact('credit'));
    }

    public function validateKyc($history_id, $param, $param2, $type)
    {
        //*ejecutar api nubarium
        $history        = HistoryLog::find($history_id);
        $validate_nb    = Kyc::sendValidateKyc($history->id_rel, $type, $param, $param2);
        $estatus        = $validate_nb['estatus'];
        $html           = $validate_nb['html'];
        $msg            = Kyc::formatMsg($validate_nb['result']);
        return response()->json(['status' => $estatus, 'html' => $html, 'msg' => $msg]);
    }

    public function saveKyc($credit_id)
    {
        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK3_STEP2, $credit_id, 1); //* marcar como finalizada la accion
        HistoryLog::move($credit_id, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, null, false);
        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, $credit_id, 0);
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
