<?php

namespace App\Http\Controllers\Panel;

use App\Exports\LeadExport;
use App\Http\Controllers\Controller;
use App\Lib\CalculadoraCredito;
use App\Lib\CNubarium;
use App\Lib\Csendgrid;
use App\Lib\Manychat;
use App\Models\Action;
use App\Models\Agreement;
use App\Models\Bank;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\CreditPayOff;
use App\Models\CurrentFinancialProduct;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\LeadAdvisor;
use App\Models\LeadNote;
use App\Models\Note;
use App\Models\File;
use App\Models\FinancialAgreement;
use App\Models\FinancialProduct;
use App\Models\FpTerm;
use App\Models\Investor;
use App\Models\InvestorsCredit;
use App\Models\kaaxSidecc\Collection;
use App\Models\LeadValidation;
use App\Models\Product;
use App\Models\SodScheduleDate;
use App\Models\SodScheduleName;
use App\Models\Term;
use App\Models\Transaction;
use App\Models\User;
use App\Strategies\Values\ActionValues;
use App\Strategies\Values\SendNotificationsValues;
use Carbon\Carbon;
use Facade\FlareClient\Http\Client;
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

        $dataField = array(
            'Prospecto -  Validación Celular' => true,
        );
        $manychat = new Manychat();
        $manychat->setCustomFields($dataField, '2080577218');

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

    public function chartShow(Lead $lead)
    {

    }

    public function checkData($valInput , $id)
    {
        $getLead           = ClientPerson::checkDataModel($valInput,$id);
        $field             = $id == 'cellphone' ? 'cellphone' : 'rfc';
        $getClientPerson   = ClientPerson::where($field, $valInput)->first();
        $agreement         = $getClientPerson != null ? Agreement::find($getClientPerson->agreement_id): null;
        $validateAgreement = $agreement != null && $agreement->status == 1 ? true : false;
        $isValidateCellphone = false;
        $isValidateRFC = false;
        $isValidate = false;
        $lead = null;
        if ($getClientPerson != null) {
            $lead = Lead::create([
                'name' => $getClientPerson->name,
                'last_name' => $getClientPerson->last_name,
                'second_last_name' => $getClientPerson->second_last_name,
                'birth_date' => $getClientPerson->birth_date,
                'rfc' => $getClientPerson->rfc,
                'email' => $getClientPerson->email,
                'agreement_id' => $getClientPerson->agreement_id,
            ]);
             //* Execute notification in create lead
            $notification   = SendNotificationsValues::STRATEGY['leadNewProspect'];
            (new $notification)->send($lead->id);
            HistoryLog::move($lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);
            
        } else {
            $lead = Lead::create([
                $field => $valInput,
              
            ]);
             //* Execute notification in create lead
            $notification   = SendNotificationsValues::STRATEGY['leadNewProspect'];
            (new $notification)->send($lead->id);
            HistoryLog::move($lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);
        }
       

       
        //* Execute notification in add lead
      //TODO: revisar que la validacion si no existe el celular como quedaria la tabla leadvalidation
        $statusActivo = 0;
        $contentActivo = 'Cliente inactivo';
        if ($getClientPerson != null && $getClientPerson->active == 1) {
            $statusActivo = 1;
            $contentActivo = 'Cliente activo';
        }
        LeadValidation::saveEdit($lead->id, 'Prospecto - Cliente activo', $statusActivo, $contentActivo);
        if ($id == 'cellphone') {
            $contentValidaciones      = 'Sin coincidencias';
            $contentValidacionesCellphone = '';
            $statusCellphone = 0;

            if ($getClientPerson != null && $valInput == $getClientPerson->cellphone && $validateAgreement == true) {
                $isValidateCellphone = true;
                $statusCellphone = 1;
                $contentValidaciones = 'Coincidencia encontrada';
                $contentValidacionesCellphone = 'Coincidencia encontrada';
            }
            LeadValidation::saveEdit($lead->id, 'Prospecto - Celular', $statusCellphone, $contentValidaciones);
        }
       
        
        if ($id == 'rfc') {
            $contentValidaciones      = 'Sin coincidencias';
            $contentValidacionesRFC = 'Sin coincidencias';
            $statusRFC = 0;
            if ($getClientPerson != null && $valInput == $getClientPerson->rfc && $validateAgreement == true) {
                $isValidateRFC = true;
                $statusRFC = 1;
                $contentValidaciones = 'Coincidencia encontrada';
                $contentValidacionesRFC = 'Coincidencia encontrada';
            }
            LeadValidation::saveEdit($lead->id, 'Prospecto - RFC', $statusRFC, $contentValidaciones);
        }
        
        $isValidate = $isValidateCellphone == true || $isValidateRFC == true ?  true : false;
        $statusTramites = array(
            HistoryLog::KC_CHECK_UP ,
            HistoryLog::CREDIT_IN_PROGRESS ,
            HistoryLog::NEW_CREDIT_KC_CHECK_UP ,
            HistoryLog::KC_CONTROL_DESK ,
            HistoryLog::KC_DELIVERY ,
            HistoryLog::KC_SWAP ,
            HistoryLog::KC_PAYMENT
        );
        $getStatus = $getClientPerson != null ? Credit::where('client_person_id', $getClientPerson->id)->whereIn('credit_status', $statusTramites)->count() : 0;
        $creditStatus =  $getStatus > 0 ? false : true;
        $nombreCliente = $getClientPerson!= null ? $getClientPerson->name.' '.$getClientPerson->last_name.' '.$getClientPerson->second_last_name : null;

        if ($creditStatus === false) {
            $contentValidaciones .= '<p >Validación otro trámite pendiente / '.$nombreCliente.' /<span class="text-danger"> Tiene trámites pendientes </span></p>';
            LeadValidation::saveEdit($lead->id, 'Crédito preautorizado - Trámite pendiente', 0, 'Tiene trámites pendientes');
        } else {
            $contentValidaciones .= '<p >Validación otro trámite pendiente / '.$nombreCliente.' /<span class="text-primary"> Sin támites pendientes </span></p>';
            LeadValidation::saveEdit($lead->id, 'Crédito preautorizado - Trámite pendiente', 1, 'Sin trámites pendientes');
        }
        
        return response()->json(['exist' => $getLead, 'clientPerson' => $getClientPerson, 'lead' => $lead, 'contentValidaciones' => $contentValidaciones, 'isValidate' => $isValidate, 'creditStatus' => $creditStatus]);
    }

    public function validateCellphoneAndRfc($cellphone , $rfc, Lead $lead)
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
        
        $isValidate = $isValidateCellphone == true && $isValidateRFC == true ? true : false;

        if ($lead->cellphone_validated == 1) {
            $contentValidaciones = '<p >Validación Prospecto (celular) / '.$cellphone.' /<span class="text-primary"> OK </span></p>';
        }
        
        if ($lead->rfc_validated == true) {
            $contentValidaciones = '<p >Validación Prospecto (rfc) / '.$rfc.' /<span class="text-primary"> OK </span></p>';
        }

        return response()->json(['isValidate' => $isValidate, 'msg' => $contentValidaciones]);

    }

    public function getProducts($agreementId, $clientPersonId)
    {
        $clientPerson = ClientPerson::find($clientPersonId);
        $cpAvailable = $clientPerson->cp_available;
        $stdAvailable = $clientPerson->std_available;
        $sodAvailable = $clientPerson->sod_available;
        $productsId = array(
            $cpAvailable,
            $stdAvailable,
            $sodAvailable
        );

        // Validate that at least one product ID has a value
        $hasValidProduct = false;
        foreach($productsId as $productId) {
            if(!empty($productId)) {
                $hasValidProduct = true;
                break;
            }
        }

        $getProducts = FinancialAgreement::select('financial_products.id', 'financial_products.alias')
                        ->join('financial_products', 'financial_products.id', 'financial_agreements.product_id')
                        ->where(['agreement_id' => $agreementId]);

        if ($clientPerson != null && $hasValidProduct) {
            $getProducts->whereIn('financial_products.type_product_id', $productsId);
        }
        $getProducts = $getProducts->get();

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
        $financial_products = FinancialProduct::getAll(true);
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

    //TODO: POSIBLES VALIDACIONES COMPLETAS
    public function getValidates(Lead $lead)
    {
        $clientPerson = ClientPerson::find($lead->client_person_id);

        
    }

    public function getSoad(ClientPerson $clientPerson, Agreement $agreement, FinancialProduct $financialProduct, $leadId)
    {

        if ($financialProduct->type_product_id == 3) {
            $textSoad = 'Tiene un Salario On-Demand activo';
            $statusPreautorizado = 0;
            if ($clientPerson->sod_active == 0) {
                $textSoad = 'No tiene un Salario On-Demand activo';
                $statusPreautorizado = 1;
            }
            LeadValidation::saveEdit($leadId, 'Crédito preautorizado - SOD activo', $statusPreautorizado, $textSoad);
        }
        
        //validar soad en fecha
        $getSodName = SodScheduleName::find($agreement->id);
        $isSoadDate = 'Solicitud fuera del rango de fechas';
        $is_sod_on_date_allowed = false;
        if ($getSodName != null) {
            $nameField              = "schedule_$getSodName->id";
            $alias                  = "schedule_$getSodName->id as schedule";
            $getDate                = SodScheduleDate::select($alias)->where(['fecha' => date('Y-m-d')])->first();
            $isSoadDate             = $getDate!= null && $getDate->schedule == 1 ?  'Solicitud dentro del rango de fechas' : $isSoadDate;
            $statusRangoFechas             = $getDate!= null && $getDate->schedule == 1 ?  1 : 0;
            if ($financialProduct->type_product_id == 3) {
                LeadValidation::saveEdit($leadId, 'Crédito preautorizado - SOD en rango de fechas permitidas', $statusRangoFechas, $isSoadDate);
            }
            //dd($agreement->id, $getDate);

            $is_sod_on_date_allowed = $getDate!= null && $getDate->schedule == 1 ? true : false;
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
            
            $msgContentProductSod = 'Prospecto no puede tramitar un Salario On-Demand';
            $textSoad = null;
            $statusProductSod = 0;
            
            

            if ( $getDate->schedule == 1) {
                $contentProductSod =  \View::make('panel.lead.product_sod ', ['minimo' => $minimoRedondeado, 'maximo' => $maximoRedondeado])->render();
                $msgContentProductSod = 'Prospecto puede tramitar un Salario On-Demand';
                $statusProductSod = 1;
            }
            if ($financialProduct->type_product_id == 3) {
                LeadValidation::saveEdit($leadId, 'Crédito preautorizado - Trámite SOD autorizado', $statusProductSod, $msgContentProductSod);
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

        $tramites = array();

        if ($financialProduct->type_product_id == 3) {
            $tramites[1] =  config('enums.tipo_tramite')[1];
        }

        $validateSod = Lead::validateSod($clientPerson, $financialProduct);
        
        $dataReturn = array(
                    'TextSoad' => $textSoad, 'soadActive' => $clientPerson->sod_active, 'isSoadDate' => $isSoadDate, 'isSodOnDate' => $is_sod_on_date_allowed, 
                    'maximoRedondeado' => $maximoRedondeado, 'minimoRedondeado' => $minimoRedondeado, 'contentProductSod' => $contentProductSod,
                    'financialProduct' => $financialProduct->name, 'comision' => $financialProduct->sod_commission_amount, 'bank_name' => $clientPerson->bank_name,
                    'cuenta' => $maskedClabe, 'type_product_id' => $financialProduct->type_product_id, 'sodTramites' => $tramites, 'loan_available' => format_price($financialProduct->loan_available)
        );
        return response()->json($dataReturn);
    }

    public function getLeadValidations($leadId)
    {
        try {
            $validations = LeadValidation::getValidationsByLeadId($leadId);
            $table = view('lead.table_validation', ['validations' => $validations])->render();
            
            return response()->json([
                'success' => true,
                'data' => $validations,
                'table' => $table
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las validaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getLeadValidationsLoanTerm($leadId)
    {
        $lead = Lead::find($leadId);
        $msgTerm = 'Crédito seleccionado - Plazo seleccionado';
        $selectedTerm = $lead->selected_term > 0  ? 1 : 0;
        $textTerm = $lead->selected_term > 0 ? 'Seleccionado' : 'Sin seleccionar';
        $selectedLoan = $lead->selected_loan > 0 ? 1 : 0;
        $textLoan = $lead->selected_loan > 0 ? 'Seleccionado' : 'Sin seleccionar';
        $msgLoan = 'Crédito seleccionado - Importe seleccionado';

        LeadValidation::saveEdit($leadId, $msgTerm, $selectedTerm, $textTerm);
        LeadValidation::saveEdit($leadId, $msgLoan, $selectedLoan, $textLoan);
    }

    public function getTramite(ClientPerson $clientPerson, FinancialProduct $financialProduct, $leadId)
    {
        //validaciones sod
        $validateSod = Lead::validateSod($clientPerson, $financialProduct);
        
        // Registrar cada validación individual que viene de validateSod
        if (isset($validateSod['validations']) && is_array($validateSod['validations'])) {
            foreach ($validateSod['validations'] as $validation) {
                // Verificar que todos los campos necesarios existan
                $validationName = $validation['validation_name'] ?? 'Validación sin nombre';
                $status = $validation['status'] ?? false;
                $text = $validation['text'] ?? 'Sin mensaje';

                LeadValidation::saveEdit(
                    $leadId,
                    $validationName,
                    $status ? 1 : 0,
                    $text
                );
            }
        }
        
        $tramites = [];
        if ($clientPerson && $financialProduct) {
            if ($financialProduct->type_product_id != 3) {
                if ($clientPerson->credit_active == 0) {
                    $tramites[1] = config('enums.tipo_tramite')[1]; // Crédito nuevo
                } elseif ($clientPerson->credit_active == 1) {
                    if ($financialProduct->additional_allowed == 1) {
                        $tramites[2] = config('enums.tipo_tramite')[2]; // Crédito adicional
                    }
                    if ($financialProduct->refinancing_allowed == 1) {
                        $tramites[3] = config('enums.tipo_tramite')[3]; // Refinanciamiento
                    }
                }
            } elseif ($financialProduct->type_product_id == 3) {
                if ($clientPerson->sod_active == 0) {
                    $tramites[1] = config('enums.tipo_tramite')[1]; // Crédito nuevo
                }
            }
        }
        
        $dataReturn = array(
            'sodIsTramite' => $validateSod['isTramite'] ?? false,
            'sodMessage' => $validateSod['message'] ?? 'Sin mensaje',
            'sodTramites' => $tramites
        );
        return response()->json($dataReturn);
    }

    public function getRefinanciamiento(ClientPerson $clientPerson, FinancialProduct $financialProduct, $tramitType)
    {
        $getRefinanciamiento = new CalculadoraCredito();
        $montoMaximo         = $getRefinanciamiento->getMontoMaximo($clientPerson, $financialProduct, $tramitType);
        
        $plazoMaximo  = $financialProduct->max_term;
        $periodicidad = config('enums.periodicidad_names')[$financialProduct->periodicity_id];
        $payment      = null;
        $terms        = null;
        
        if ($financialProduct->type_product_id != 3) {
            $payment             = $getRefinanciamiento->getPayment($financialProduct, $montoMaximo);
        }
        
        $productoDeseado     = null;
        $getCollection = Collection::select('collections.kc_credit_id', 'collections.id', 'collections.fecha_cobro', 'collections.descuento', 'crm_status_list.alias', 'collections.saldo_insoluto_real')
                                    ->join('clients_credit_info', 'clients_credit_info.credit_id', 'collections.credit_id')
                                    ->join('crm_status_list', 'crm_status_list.id', 'collections.status')
                                    ->where('collections.refinanciable', 1)
                                    ->where('collections.kc_client_id', $clientPerson->id)
                                    ->where('clients_credit_info.producto', '<>', 3)->get();
        
        $productoDeseado =  \View::make('panel.credit.listRefinanciable ', ['credits' => $getCollection, 'tramitType' => $tramitType, 'type_product_id' => $financialProduct->type_product_id])->render();
        
        if ($financialProduct->max_term != null) {
            $terms = FpTerm::select('terms.id', 'terms.term')
            ->join('terms', 'terms.term_id',  'f_p_terms.term_id')
            ->where('financial_product_id', $financialProduct->id)
            ->where('terms.term', '<=', $financialProduct->max_term)
            ->pluck('terms.term', 'terms.term');
        }
        
        $data = array(
            'montoMaximo' => $montoMaximo,
            'plazoMaximo' => $plazoMaximo,
            'periodicidad' => $periodicidad,
            'payment' => $payment,
            'productoDeseado' => $productoDeseado,
            'terms' => $terms,
        );
        return response()->json($data);
    }

    public function getMontoMaximo(ClientPerson $clientPerson,FinancialProduct $financialProduct,  $tramitType , $creditId, Request $request)

    {
        $min         = floatval($financialProduct->min_loan_amount);
        $max         = $financialProduct->max_loan_ammount;
        $calculadora = new CalculadoraCredito();
        $credits     = $request->credits;
        $plazo       = $request->plazo;
        $descuento = 0;
        $total = 0;
        $creditId = $creditId === "null" ? null : $creditId;
        $getCredit = $creditId !== null ? Credit::find($creditId) : null;
        $paymentCapacity =  $getCredit == null ? $clientPerson->payment_capacity : $getCredit->payroll_payment_capacity;
       

        foreach ($credits as $credit) {
            $getCollection = Collection::find($credit);
            if ($getCollection != null) {
                $descuento += $getCollection->descuento;
                $total += $getCollection->saldo_insoluto_real;
            }
        }
        if ($tramitType == 3) { //refinanciamiento
            $pmt = $paymentCapacity + $descuento;
        } else {
            $pmt = $paymentCapacity;
        }

        $present = $calculadora->presentValue($financialProduct, $plazo, $pmt, $tramitType);
        
        $montoArray = [];

        for ($i = $min; $i <= $max; $i += 1000) {
            if ( ($present > 0 && $present != -0) && $i > $present ) {
                break;
            }
            $montoArray[$i] = $i;
        }
        $data = array(
            'min' => $min,
            'max' => $max,
            'present' => $present,
            'maximo' => $montoArray,
            'descuento' => $descuento,
            'total' => $total,
            'total_price' => format_price($total),
        );
        return response()->json($data);
    }

    public function getResumen( FinancialProduct $financialProduct, $plazo, $monto, $total, $tramitType)
    {
        $comision = $monto * $financialProduct->opening_commission_rate / 100;
        if ($tramitType == 3) {
            $montoEntregar = $monto - $comision - $total;
        } else {
            $montoEntregar = $monto - $comision;
        }
        
        $periodicidad = config('financial_enums.periodicity_products')[$financialProduct->periodicity_id];
        $getCalc = new CalculadoraCredito();
        $pagoPeriodico = $getCalc->getPayment($financialProduct, $monto, $plazo);
        $pagoTotal = $plazo * $pagoPeriodico;
        $tasaAnual = $financialProduct->annual_interest_rate;
        $cat = $financialProduct->real_cat;
        
        $kcInteres = $pagoTotal - $monto;
        $kcPagoTotal = $pagoTotal;

        if (isset($_GET['credit_id'])) {
            $creditId = $_GET['credit_id'];
            $total =   CreditPayOff::select('ammount')
            ->where('credit_pay_off.new_kc_credit_id', $creditId)
            ->where('kc_credit_id_payed_off', '!=', null)
            ->sum('ammount');
        }

        $data = array(
            'montoSolicitado' => format_price($monto),
            'montoSolicitado_sf' => $monto,
            'montoRefinanciar' => format_price($total),
            'comision' => format_price($comision),
            'comisionSF' => $comision,
            'monto_entregar' => format_price($montoEntregar),
            'monto_entregar_decimal' => $montoEntregar,
            'periodicidad' => $periodicidad,
            'plazo' => $plazo,
            'pagoPeriodico' => format_price($pagoPeriodico),
            'pagoPeriodico_sf' => $pagoPeriodico,
            'pagoTotal' => format_price($pagoTotal),
            'pagoTotalSF' => $pagoTotal,
            'tasaAnual' => format_price($tasaAnual / 1.16),
            'cat' => $cat,

            'kcInteres' => $kcInteres,
            'kcPagoTotal' => $kcPagoTotal,
        );
        return response()->json($data);
    }

    public function getChart(FinancialProduct $financialProduct, Lead $lead, $plazo)
    {
        $getCalc = new CalculadoraCredito();

        // Calcular la tasa de interés mensual basada en el producto financiero principal
        $tasaInteresMensual = ($financialProduct->annual_int_rate_iva / 100) / 360 * 30;

        // Obtener el total de la deuda previa del cliente
        $creditPays = CreditPayOff::select(
                'credit_pay_off.id',
                'financial_products.alias',
                'credit_pay_off.ammount',
                'financial_products.annual_int_rate_iva'
            )
            ->join('financial_products', 'credit_pay_off.financial_product_id', '=', 'financial_products.id')
            ->where('credit_pay_off.lead_id', '=', $lead->id)
            ->get();

        $montoCompraCartera = $creditPays->sum('ammount');

        // Reemplazar el monto original con el monto de la deuda existente
        $monto = $montoCompraCartera;

        // Calcular pago con la tasa del producto financiero principal
        $pagoPeriodico = $getCalc->getPaymentPresentValue($tasaInteresMensual, $plazo, -$monto);
        $kcPagoTotal = $plazo * $pagoPeriodico;
        $kcInteres = $kcPagoTotal - $monto;

        // --------------------------------------
        // Cálculo del pago total de la deuda (sumando cada crédito)
        // --------------------------------------
        $deudaPagoTotal = 0;

        foreach ($creditPays as $credit) {
            // Calcular la tasa de interés mensual para cada crédito
            $tasaInteresMensualCredito = ($credit->annual_int_rate_iva / 100) / 360 * 30;

            // Calcular pago periódico de cada crédito
            $pagoPeriodicoCredito = $getCalc->getPaymentPresentValue($tasaInteresMensualCredito, $plazo, -$credit->ammount);

            // Calcular el pago total del crédito y sumarlo a la deuda total
            $pagoTotalCredito = $plazo * $pagoPeriodicoCredito;
            $deudaPagoTotal += $pagoTotalCredito;
        }

        // Calcular el interés total de la deuda
        $deudaInteres = $deudaPagoTotal - $montoCompraCartera;

        // --------------------------------------
        // Cálculo de métricas adicionales
        // --------------------------------------
        $ahorroInteresDinero = $deudaPagoTotal - $kcPagoTotal;
        $ahorroInteresPorcentaje = $deudaInteres > 0 ? ($deudaInteres - $kcInteres) / $deudaInteres : 0;
        $deudaPorcentajeInteres = $montoCompraCartera > 0 ? $deudaInteres / $montoCompraCartera : 0;
        $kcCapital = $montoCompraCartera;
        $kcPorcentajeInteres = $kcCapital > 0 ? $kcInteres / $kcCapital : 0;

        // --------------------------------------
        // Retornar los datos en JSON
        // --------------------------------------
        $data = [
            'deudaCapital' => $montoCompraCartera,
            'kcInteres' => $kcInteres,
            'kcPagoTotal' => $kcPagoTotal,

            'ahorroInteresDinero' => $ahorroInteresDinero,
            'ahorroInteresDinerom' => format_price($ahorroInteresDinero),

            'deudaInteres' => $deudaInteres,
            
            'ahorroInteresPorcentaje' => $ahorroInteresPorcentaje,
            'ahorroInteresPorcentajem' => format_price($ahorroInteresPorcentaje),

            'deudaPorcentajeInteres' => $deudaPorcentajeInteres,
            'deudaPorcentajeInteresm' => format_price($deudaPorcentajeInteres),

            'kcCapital' => $kcCapital,
            'kcPorcentajeInteres' => $kcPorcentajeInteres,

            'deudaPagoTotal' => $deudaPagoTotal,
            'deudaPagoTotalm' => format_price($deudaPagoTotal),
        ];

        return response()->json($data);

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
        $financial_products = FinancialProduct::getAll(true);
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
