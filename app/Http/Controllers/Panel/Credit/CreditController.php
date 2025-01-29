<?php

namespace App\Http\Controllers\Panel\Credit;

use App\Exports\ContratoExport;
use App\Http\Controllers\Controller;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\CreditReference;
use App\Models\HistoryLog;
use App\Models\kaaxSidecc\CreditKaaxSidecc;
use App\Models\kaaxSidecc\Pago;
use App\Models\kaaxSidecc\Statement;
use App\Strategies\Values\ActionValues;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CreditController extends Controller
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
        //
    }

    public function reference($model, $history_id)
    {
        $reference_id = null;
        return view('panel.credit.reference.form', compact('history_id', 'reference_id'));
    }
    
    public function storeReference($history_id, Request $request)
    {
        $history            = HistoryLog::find($history_id);
        $credit             = $history->historyCredit;
        $credit_reference   = CreditReference::saveEdit($credit->id, $request);
        return response()->json($credit_reference);
    }

    public function advisorStore($credit_id, Request $request)
    {
        Credit::find($credit_id)->update(
            ['asesor_id' => $request->asesor_id]
        );
    }

    public function storeBank(Request $request)
    {
        $bank_id = $request->bank_id;
        $credit_id = $request->credit_id;
        $credit = Credit::find($credit_id);
        $credit->bank_id = $bank_id;
        $credit->update();
    }

    public function listReference($history_id)
    {
        $history    = HistoryLog::find($history_id);
        $credit     = $history->historyCredit;
        $list       = CreditReference::list($history, $credit->id);
        return response()->json(['data' => $list]);
    }

    public function editReference($history_id, $reference_id)
    {
        $reference =  CreditReference::find($reference_id);
        return view('panel.credit.reference.form', compact('history_id', 'reference_id', 'reference'));
    }
   
    public function showReference($reference_id)
    {
        $reference =  CreditReference::find($reference_id);
        return response()->json($reference);
    }

    public function deleteReference($reference_id)
    {
        $reference = CreditReference::find($reference_id);
        $reference->delete();
        return response()->json($reference);
    }

    public function storeTag(Request $request)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $tag              = (new $actionStrategy)->saveTag($request);
    }

    public function getTag($credit_id)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $get_tag              = (new $actionStrategy)->getTags($credit_id);
        return response()->json($get_tag);
    }

    public function deleteTag($tag_id)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $tag              = (new $actionStrategy)->deleteTag($tag_id);
        return response()->json($tag);
    }

    public function getNote($credit_id)
    {
        $actionStrategy   = ActionValues::STRATEGY['credit'];
        $get_note         = (new $actionStrategy)->getNotes($credit_id);
        return response()->json($get_note);
    }

    public function getListAction($credit_id)
    {
        $leadStrategy   = ActionValues::STRATEGY['list'];
        $actions = [
                HistoryLog::KC_CHECK_UP_ACTION_FORM,
                HistoryLog::KC_CHECK_UP_ACTION_DESITION,
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM,
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION,

                HistoryLog::KC_CONTROL_DESK_TASK1_STEP1,
                HistoryLog::KC_CONTROL_DESK_TASK2_STEP1,

                HistoryLog::KC_CONTROL_DESK_TASK3_STEP1,

                HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1,
                
                HistoryLog::KC_CONTROL_DESK_TASK1_STEP2,
                HistoryLog::KC_CONTROL_DESK_TASK2_STEP2,
                HistoryLog::KC_CONTROL_DESK_TASK3_STEP2,
                HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2,
                

                HistoryLog::KC_SWAP_UPLOAD,
                HistoryLog::KC_SWAP_FORM,
                HistoryLog::KC_SWAP_UPLOAD_2,
                
                HistoryLog::KC_SWAP_FORM_STEP_2,
                HistoryLog::KC_SWAP_FORM_STEP_2_2,
                HistoryLog::KC_SWAP_UPLOAD_STEP_2_3,
                HistoryLog::KC_SWAP_FORM_STEP_2_3,
                
                HistoryLog::KC_SWAP_UPLOAD_STEP_3,
                HistoryLog::KC_SWAP_FORM_STEP_3,
                HistoryLog::KC_SWAP_FORM_STEP_3_2,
                
                HistoryLog::KC_DELIVERY_TASK1_STEP1,
                //HistoryLog::KC_DELIVERY_FORM_STEP_3,
                
                HistoryLog::KC_AFTER_FORM,
        ];
        $data_progress       = (new $leadStrategy)->get('in_progress', $actions, $credit_id);
        $data_completed       = (new $leadStrategy)->get('completed', $actions, $credit_id);
        $list = array_merge($data_progress, $data_completed);
        return response()->json(['data' => $list]);
    }

    public function product($status)
    {
        $titles = array(
            HistoryLog::CREDIT_IN_PROGRESS => 'En curso',
            HistoryLog::CREDIT_CANCELED => 'Cancelados',
            HistoryLog::CREDIT_REJECTED => 'Rechazados',
            HistoryLog::CREDITS_DELIVERED => 'Entregados',
            HistoryLog::CREDITS_PAID => 'Pagado',
            //HistoryLog::KC_DELIVERY => 'En curso',
        );
        $title = $titles[$status];
        if ($status != HistoryLog::CREDIT_IN_PROGRESS) {
            return view('panel.credit.product.index', compact('status', 'title'));
        }
        return view('panel.credit.product.in_progress', compact('status', 'title'));
    }

    public function productList($status)
    {
        
        if ($status == HistoryLog::CREDIT_IN_PROGRESS) {
            $list = Credit::listDatatableInProgress([$status]);
        } else {
            $list = Credit::listDatatableProduct([$status]);
        }
        

        return response()->json(['data' => $list]);
    }

    public function contractExport(Credit $credit)
    {
        $client = ClientPerson::find($credit->client_person_id);
        $data_collection[] = array(
            'id' => $credit->id,
            'name' => $client->name,
            'last_name' => $client->last_name,
            'second_last_name' => $client->second_last_name,
            'cellphone' => $client->cellphone,
            'validated_clabe' => $client->validated_clabe,
            'email' => $client->email,
            'birth_date' => $client->birth_date,
            'rfc' => $client->rfc,
            'curp' => $client->curp,
            'bank_name' => $client->bank_name,
            'bank_acount_number' => $client->bank_acount_number,
            'bank_clabe' => $client->bank_clabe,
            'client_postal_code' => $client->client_postal_code,
            'client_street' => $client->client_street,
            'client_home_external_number' => $client->client_home_external_number,
            'client_home_internal_number' => $client->client_home_internal_number,
            'client_colony' => $client->client_colony,
            'client_city' => $client->client_city,
            'client_state' => $client->client_state,
            'client_country' => $client->client_country,
            'product_id' => $credit->product_id,
            'agreement_id' => $credit->agreement_id,
            'applied_financial_product' => $credit->applied_financial_product,
            'applied_loan_type' => $credit->applied_loan_type,
            'applied_import' => $credit->applied_import,
            'applied_term' => $credit->applied_term,
            'applied_periodicity' => $credit->applied_periodicity,
            'applied_payment' => $credit->applied_payment,
            'applied_total_amount' => $credit->applied_total_amount,
            'applied_interest_rate' => $credit->applied_interest_rate,
            'applied_cat' => $credit->applied_cat,
            'opening_commission_percentage' => $credit->opening_commission_percentage,
            'opening_commission' => $credit->opening_commission,
            'applied_loan_discount' => $credit->applied_loan_discount,
            
            

        );
        
        return Excel::download(new ContratoExport($data_collection), $credit->id.' - Datos contrato.csv');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $credit   = Credit::find($id);
        $creditKaax = CreditKaaxSidecc::where('kc_credit_id', $credit->id)->first();
        $payments = null;
        if ($creditKaax != null) {
            $payments = Statement::where('credit_id', $creditKaax->id)
                    ->where('numero_de_pago', '!=', 0)
                    ->get();
        }
        return view('panel.credit.profile', compact('credit', 'payments'));
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
