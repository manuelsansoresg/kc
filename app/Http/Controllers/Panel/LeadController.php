<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Lib\CNubarium;
use App\Lib\Csendgrid;
use App\Models\Action;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\LeadAdvisor;
use App\Models\LeadNote;
use App\Models\Note;
use App\Models\File;
use App\Models\FinancialAgreement;
use App\Models\Notification;
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

        $lead_id = 1;
        $find_lead  = Lead::find($lead_id);
        $find_user  = User::where('email', 'manuelsansoresg@gmail.com')->first();
        $domain = 'https://app.kaaxclub.com';
        $link_login = $domain.'/login';
        $link_password_change = $domain.'/account/'.$lead_id.'/password/change';
        $send_grid = new Csendgrid('manuelsansoresg@gmail.com', 'creacion cuenta');
        $send_grid->setTemplate('d-ea081e65c8014113b50315a103127d13');
        $send_grid->setParams(['first_name'=> $find_lead->name, 'link_login' => $link_login, 'link_password_change' => $link_password_change]);
        $send_grid->send();
        

        $is_financiera = Auth::user()->hasRole('Cliente financiera');
        if ($is_financiera === true) {
            return redirect('panel/kc-delivery');
        }
        $model        = $this->model;
        return view('panel.lead.list', compact('model'));
    }

    public function list()
    {
        $users = Lead::listDatatable();
        return response()->json(['data' => $users]);
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

    public function listArchive()
    {
        $archive = Lead::listArchive();
        
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
        return view('panel.lead.form', compact('lead_id', 'lead'));
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
        return view('panel.lead.form', compact('lead_id', 'lead'));
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
