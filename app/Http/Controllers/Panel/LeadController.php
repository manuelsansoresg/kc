<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Lib\CNubarium;
use App\Lib\Csendgrid;
use App\Lib\Manychat;
use App\Models\Action;
use App\Models\Bank;
use App\Models\ClientPerson;
use App\Models\CurrentFinancialProduct;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\LeadAdvisor;
use App\Models\LeadNote;
use App\Models\Note;
use App\Models\File;
use App\Models\FinancialAgreement;
use App\Models\FinancialProduct;
use App\Models\Investor;
use App\Models\User;
use App\Strategies\Values\ActionValues;
use App\Strategies\Values\SendNotificationsValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LeadController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = Action::MODEL['lead'];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $is_financiera = Auth::user()->hasRole('Cliente financiera');
        $is_investor = Auth::user()->hasRole('Cliente inversionista');
        if ($is_financiera === true) {
            return redirect('panel/kc-delivery');
        } elseif ($is_investor  === true) {
            $investor = Investor::where('user_id', Auth::user()->id)->first();
            return redirect('panel/inversionista/'.$investor->id);
        }
        $model        = $this->model;
        return view('panel.lead.list', compact('model'));
    }
    

    public function list()
    {
        $users = Lead::listDatatable();
        return response()->json(['data' => $users]);
    }

    public function checkData($valInput , $id)
    {
        $getLead = ClientPerson::checkDataModel($valInput,$id);
        return response()->json(['exist' => $getLead]);
    }
    
    public function listActions(Lead $lead)
    {
        $notes = $lead->leadNotes;
        $view           = \View::make('panel.view_content_lead_actions ', ['notes' => $notes])->render();
        return response()->json($view);
    }

    public function listFinancial($lead_id)
    {
        $financials = FinancialAgreement::getList($lead_id);
        return response()->json($financials);
    }
    
    

    public function listOrigin($origin_id)
    {
        $channel = Lead::getChanelByOrigin($origin_id);
        
        return response()->json($channel);
    }

   

    public function archive()
    {
        return view('panel.lead.archive');
    }
    
    public function archiveView($module_id)
    {
        $title = isset(HistoryLog::$label_status[$module_id]) ? HistoryLog::$label_status[$module_id] : null;
        return view('panel.archieve.archive_dinamic', ['module_id' => $module_id, 'title' => $title]);
    }

    public function listArchive()
    {
        $archive = Lead::listArchive();
        
        return response()->json(['data' => $archive]);
    }
   
    public function listModuleArchive($module_id)
    {
        $archive = HistoryLog::listArchive($module_id);
        
        return response()->json(['data' => $archive]);
    }

    public function product()
    {
        $status = HistoryLog::CREDIT_ARCHIVE;
        $title = 'Archivo';
        return view('panel.credit.product.index', compact('status', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lead_id = null;
        $lead = null;
        $banks = Bank::all();
        $financial_products = FinancialProduct::getAll();
        $loan_type    = config('enums.loan_type');
        return view('panel.lead.form', compact('lead_id', 'lead', 'banks', 'financial_products', 'loan_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Lead::saveEdit($request);
        return response()->json(200);
    }

    public function storeClientPerson($lead_id)
    {
        $lead = Lead::createClientPerson($lead_id);
        return response()->json($lead);
    }

    public function advisorStore($lead_id, Request $request)
    {
        $lead               = Lead::find($lead_id);
        $lead->asesor_id    = $request->asesor_id;
        $lead->update();

        //* Execute notification in add lead
        $notification_add   = SendNotificationsValues::STRATEGY['leadAddProspect'];
        (new $notification_add)->send($lead->id);
        
        $lead_advisor = LeadAdvisor::create([ 'lead_id' => $lead->id, 'advisor_id' => Auth::user()->id]);
        HistoryLog::move($lead_advisor->id, HistoryLog::ADD_PROSPECT, HistoryLog::ADD_PROSPECT);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lead       = Lead::find($id);
        $channel    = Lead::getChanelByOrigin($lead->origin_id);
        $financials = null;
        
        $advisor    = $lead->advisorLead;

        if ($lead  != null) {
            $financials = FinancialAgreement::getList($lead->id);
        }

        
        return response()->json(['lead' => $lead, 'channel' => $channel, 'financials' => $financials, 'advisor' => $advisor]);
    }

    public function profile($lead_id)
    {
        $lead   = Lead::find($lead_id);
        $model  = $this->model;
        $model_action = 'lead';
        return view('panel.lead.profile', compact('lead', 'model', 'model_action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lead_id = $id;
        $lead = Lead::find($id);
        $banks = Bank::all();
        $financial_products = FinancialProduct::getAll();
        $loan_type    = config('enums.loan_type');
        return view('panel.lead.form', compact('lead_id', 'lead', 'banks', 'financial_products', 'loan_type'));
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

    public function updateTag($lead_id, Request $request)
    {
        Lead::saveEdit($request);
        return response()->json(200);
    }

    public function previewProfile(Lead $lead)
    {
        $agreement = $lead->agreementLead;
        $product = $lead->productLead;
        $tipo_credito = isset(config('financial_enums.type_products')[$lead->tipo_credito]) ? config('financial_enums.type_products')[$lead->tipo_credito]  : null;
        $origins = config('enums.origin');
        $channel = Lead::getChanelByOrigin($lead->origin_id);
        $user = $lead->advisorLead;
        $temperatures = config('enums.temperatures');
        $tags = Lead::tagLead($lead->id, $temperatures[$lead->temperature_id], true);
        $notes = $lead->leadNotes;

        $view_lead = \View::make('panel.view_content_preview_profile', [
            'lead' => $lead, 'agreement' => $agreement, 'product' => $product,
            'tipo_credito' => $tipo_credito, 'origins' => $origins,
            'channel' => $channel, 'user' => $user,
            'tags' => $tags,
            'notes' => $notes,

        
        ])->render();
        return response()->json($view_lead);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CurrentFinancialProduct::deleteAll($id, 1);
        $lead = Lead::find($id);
        $lead->delete();
    }
}
