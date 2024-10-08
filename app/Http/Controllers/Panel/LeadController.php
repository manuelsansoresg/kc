<?php

namespace App\Http\Controllers\Panel;

use App\Exports\LeadExport;
use App\Http\Controllers\Controller;
use App\Lib\CNubarium;
use App\Lib\Csendgrid;
use App\Lib\Manychat;
use App\Models\Action;
use App\Models\Agreement;
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
use App\Models\InvestorsCredit;
use App\Models\Product;
use App\Models\SodScheduleDate;
use App\Models\SodScheduleName;
use App\Models\Transaction;
use App\Models\User;
use App\Strategies\Values\ActionValues;
use App\Strategies\Values\SendNotificationsValues;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
        //Transaction::setTotalCapital(9);
       

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
        $getLead           = ClientPerson::checkDataModel($valInput,$id);
        $field             = $id == 'cellphone' ? 'cellphone' : 'rfc';
        $getClientPerson   = ClientPerson::where($field, $valInput)->first();
        $agreement         = $getClientPerson != null ? Agreement::find($getClientPerson->agreement_id): null;
        $validateAgreement = $agreement       != null && $agreement->status == 1 ? true : false;
        $isValidateCellphone = false;
        $isValidateRFC = false;
        $isValidate = false;
        
        
        if ($id == 'cellphone') {
            $contentValidaciones      = '<p>Validación Prospecto (celular) / '.$valInput.' / <span class="text-danger"> FAIL</span> </p>';
            if ($getClientPerson != null && $valInput == $getClientPerson->cellphone && 
                $getClientPerson->active == 1 && $validateAgreement == true) {
                $isValidateCellphone = true;
                $contentValidaciones = '<p >Validación Prospecto (celular) / '.$valInput.' /<span class="text-primary"> OK </span></p>';
            }
        }
       
        
        if ($id == 'rfc') {
            $contentValidaciones      = '<p>Validación Prospecto (rfc) / '.$valInput.' / <span class="text-danger"> FAIL</span> </p>';
            
            if ($getClientPerson != null && $valInput == $getClientPerson->rfc && 
                $getClientPerson->active == 1 && $validateAgreement == true) {
                $isValidateRFC = true;
                $contentValidaciones = '<p >Validación Prospecto (rfc) / '.$valInput.' /<span class="text-primary"> OK </span></p>';
            }

        }
        
        $isValidate = $isValidateCellphone == true || $isValidateRFC == true ?  true : false;

        return response()->json(['exist' => $getLead, 'clientPerson' => $getClientPerson, 'contentValidaciones' => $contentValidaciones, 'isValidate' => $isValidate]);
    }

    public function validateCellphoneAndRfc($cellphone , $rfc)
    {
        $getClientPersonCellphone   = ClientPerson::where('cellphone', $cellphone)->first();
        $getClientPersonRFC   = ClientPerson::where('rfc', $rfc)->first();
        
        if ($getClientPersonCellphone != null) {
            $agreement         = $getClientPersonCellphone != null ? Agreement::find($getClientPersonCellphone->agreement_id): null;
        }

        if ($getClientPersonRFC != null) {
            $agreement         = $getClientPersonRFC != null ? Agreement::find($getClientPersonRFC->agreement_id): null;
        }

        $validateAgreement = $agreement       != null && $agreement->status == 1 ? true : false;
        $isValidateCellphone = false;
        $isValidateRFC = false;
        

        if ($getClientPersonCellphone != null && $cellphone == $getClientPersonCellphone->cellphone && 
            $getClientPersonCellphone->active == 1 && $validateAgreement == true) {
            $isValidateCellphone = true;
        }

        if ($getClientPersonRFC != null && $rfc == $getClientPersonRFC->rfc && 
                $getClientPersonRFC->active == 1 && $validateAgreement == true) {
                $isValidateRFC = true;
        }
        //dd($getClientPersonRFC, $validateAgreement, $rfc);
        return response()->json($isValidateCellphone == true && $isValidateRFC == true ? true : false);

    }

    public function getProducts($agreementId)
    {
        $getProducts = FinancialAgreement::select('financial_products.id', 'financial_products.alias')
                        ->join('financial_products', 'financial_products.financial_id', 'financial_agreements.id')
                        ->where(['agreement_id' => $agreementId])->get();
        $products = array();
        if ($getProducts != null) {
            foreach ($getProducts as $getProduct) {
                $products[$getProduct->id]= $getProduct->alias;
            }
        }
        return response()->json($products);
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
        $lead_id            = null;
        $lead               = null;
        $banks              = Bank::all();
        $financial_products = FinancialProduct::getAll();
        $loan_type          = config('enums.loan_type');
        $isNew              = true ;
        $clientPersonId              = null ;

        return view('panel.lead.form', compact('lead_id', 'lead', 'banks', 'financial_products', 'loan_type', 'isNew', 'clientPersonId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lead = Lead::saveEdit($request);
        return response()->json(['lead' => $lead]);
    }

    public function exportLead(Request $request)
    {
        $lead                = Lead::find($request->lead_id);
        $getServicio         = Product::find($lead->product_id);
        $servicio            = $getServicio  != null ? $getServicio->alias : null;
        $getAgreement        = Agreement::find($lead->agreement_id);
        $agreement           = $getAgreement != null ? $getAgreement->name : null;
        $getBank             = Bank::find($lead->id);
        $bank                = $getBank      != null ? $getBank->name : null;
        $getFinancialProduct = FinancialProduct::
                                join('financials', 'financials.id', 'financial_products.financial_id')
                                ->where('financial_products.id',$lead->applied_financial_product)->first();
        $financialProcuct = $getFinancialProduct!= null ? $getFinancialProduct->commercial_name .'-'. $getFinancialProduct->alias  : null;
        $financials = '';

        $financialProducts = CurrentFinancialProduct::where(['id_rel' => $lead->id, 'type' => 1])->get();
        foreach ($financialProducts as $financialProduct) {
            $getFinancialProducts = FinancialProduct::
            join('financials', 'financials.id', 'financial_products.financial_id')
            ->where('financial_products.id',$financialProduct->product_id)->first();

            $financials .= $getFinancialProducts->commercial_name.' - '.$getFinancialProducts->alias.',';
        }
        $financials = trim($financials, ','); 
        $consulta_buro = $lead->consulta_buro == 1? 'Sí' : 'No';
        $status_si_no = config('enums.status_si_no');
        $aval = isset($status_si_no[$lead->aval_o_garantia])? $status_si_no[$lead->aval_o_garantia] : null;

        $data_collection[] = array(
            'name' => $lead->name,
            'last_name' => $lead->last_name,
            'second_last_name' => $lead->second_last_name,
            'cellphone' => $lead->cellphone,
            'email' => $lead->email,
            'rfc' => $lead->rfc,
            'servicio' => $servicio,
            'organizacion' => $agreement,
            'producto_financiero' => $financialProcuct,
            'productos_financieros' => $financials,
            'importe_solicitado' => $lead->importe_solicitado,
            'income' => $lead->income,
            'banco' => $bank,
            'consulta_buro' => $consulta_buro,
            'aval_garantia' => $aval,
        );
        return Excel::download(new LeadExport($data_collection), 'KC - Datos exportados'.$lead->id.'.csv');
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

    public function getSoad(ClientPerson $clientPerson, Agreement $agreement, FinancialProduct $financialProduct)
    {
        $textSoad = '<p> Validación Crédito Preautorizado / SOD Activo /<span  class="text-primary"> OK: <br>  Prospecto No tiene un Salario On-Demand activo
 </span> </p>';
        if ($clientPerson->sod_active == 1) {
            $textSoad = '<p>Validación Crédito Preautorizado / SOD Activo / <span class="text-danger"> FAIL: <br> Prospecto No tiene un Salario On-Demand activo</p>';
        }
        //validar soad en fecha
        $getSodName = SodScheduleName::find($agreement->id);
        $isSoadDate = '<p>Validación Crédito Preautorizado / SOD en rango de fechas permitidas / <span class="text-danger"> FAIL: <br> Solicitud fuera del rango de fechas </span> <p>';
        $is_sod_on_date_allowed = false;
        if ($getSodName != null) {
            $nameField              = "schedule_$getSodName->id";
            $alias                  = "schedule_$getSodName->id as schedule";
            $getDate                = SodScheduleDate::select($alias)->where(['fecha' => date('Y-m-d')])->first();
            $isSoadDate             = $getDate->schedule == 1 ?  '<p>Validación Crédito Preautorizado / SOD en rango de fechas permitidas / <span class="text-primary"> OK: <br> Solicitud dentro del rango de fechas </span> <p>' : $isSoadDate;
            //dd($agreement->id, $getDate);

            $is_sod_on_date_allowed = $getDate->schedule == 1 ? true : false;
            //obtener los productos si tiene sod
            $dailyIncomeAdjusted  = $clientPerson->daily_income_adjusted;
            
            $currentDate = Carbon::now()->toDateString();
            $schedule = SodScheduleDate::selectRaw("
                    CASE
                        WHEN schedule_1 = 2 AND fecha = ? THEN 1
                        ELSE DATEDIFF(fecha, (SELECT MAX(fecha) 
                                            FROM sod_schedule_dates 
                                            WHERE schedule_1 = 2 
                                            AND fecha < ?))
                    END as dias
                ", [$currentDate, $currentDate])
                ->where('fecha', $currentDate)
                ->first();
            //dd($dailyIncomeAdjusted);
            $maximo = $dailyIncomeAdjusted * $schedule->dias;
            // Redondear hacia abajo al múltiplo de 100
            $maximoRedondeado = floor($maximo / 100) * 100;
            //calcular minimo
            $minimo = $clientPerson->daily_income_adjusted * 1;
            $minimoRedondeado = floor($minimo / 100) * 100;
            $contentProductSod = '<p class="text-danger"> El prospecto no puede tramitar un salario On-Demand. <br> Revisa las validaciones </p>';
            if ( $getDate->schedule == 1) {
                $contentProductSod =  \View::make('panel.lead.product_sod ', ['minimo' => $minimoRedondeado, 'maximo' => $minimoRedondeado])->render();
            }

        }
        
        // Obtenemos el valor de la CLABE
        $clabe = $clientPerson->Bank_clabe;

        // Verificamos que la longitud de la CLABE sea mayor a 4
        if (strlen($clabe) > 4) {
            // Reemplazamos todos los caracteres excepto los últimos 4 por asteriscos
            $maskedClabe = str_repeat('*', strlen($clabe) - 4) . substr($clabe, -4);
        } else {
            // Si la CLABE tiene 4 caracteres o menos, la mostramos tal cual
            $maskedClabe = $clabe;
        }

        $dataReturn = array(
                    'TextSoad' => $textSoad, 'soadActive' => $clientPerson->sod_active, 'isSoadDate' => $isSoadDate, 'isSodOnDate' => $is_sod_on_date_allowed, 
                    'maximoRedondeado' => $maximoRedondeado, 'minimoRedondeado' => $minimoRedondeado, 'contentProductSod' => $contentProductSod,
                    'financialProduct' => $financialProduct->name, 'comision' => $financialProduct->sod_commission_amount, 'bank_name' => $clientPerson->bank_name,
                    'cuenta' => $maskedClabe
        );
        return response()->json($dataReturn);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lead_id            = $id;
        $lead               = Lead::find($id);
        $banks              = Bank::all();
        $financial_products = FinancialProduct::getAll();
        $loan_type          = config('enums.loan_type');
        $isNew              = false ;
        $clientPersonId              = $lead->client_person_id ;
        return view('panel.lead.form', compact('lead_id', 'lead', 'banks', 'financial_products', 'loan_type', 'isNew', 'clientPersonId'));
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
