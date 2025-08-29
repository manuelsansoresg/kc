<?php

namespace App\Http\Controllers;

use App\Lib\CalculadoraCredito;
use App\Lib\Manychat;
use App\Models\Action;
use App\Models\Agreement;
use App\Models\ApiLead;
use App\Models\Bank;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\CreditPayOff;
use App\Models\CurrentFinancialProduct;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\LeadValidation;
use App\Models\Notification;
use App\Models\Sendgridtest;
use App\Models\TokenForms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\File as FileFacade;
use App\Models\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function getHour()
    {
        $hour =  date('Y-m-d H:i:s');
        $zone = date_default_timezone_get();
        return response()->json(['hour' => $hour, 'zone' => $zone, 'cambio' => 2]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    
    
    public function surveyHola()
    {
        return view('quiz.survey_lead');
    }

    public function grafica(Lead $lead)
    {
        $getCalc = new CalculadoraCredito();

        // Obtener el capital total sumando los montos de crédito
        $capitalTotal = CreditPayOff::where('lead_id', $lead->id)->sum('ammount');

        // Obtener la tasa de interés más alta y su alias
        $creditPayMax = CreditPayOff::select(
            'financial_products.alias',
            'financial_products.annual_int_rate_iva'
        )
        ->join('financial_products', 'credit_pay_off.financial_product_id', '=', 'financial_products.id')
        ->where('credit_pay_off.lead_id', $lead->id)
        ->orderByDesc('financial_products.annual_int_rate_iva') // Tomar el mayor
        ->first();

        $tasaInteresBanco = $creditPayMax ? $creditPayMax->annual_int_rate_iva : 0;
        $nombreBanco = $creditPayMax ? $creditPayMax->alias : 'Banco Desconocido';

        // Obtener la tasa de interés de KaaxClub
        $financial = FinancialProduct::where('id', $lead->financial_product_id)->first();
        $tasaInteresKaaxClub = $financial ? $financial->annual_int_rate_iva : null;

        $dias = isset(config('enums.periodicidad_valores')[$financial->periodicity_id]) ? config('enums.periodicidad_valores')[$financial->periodicity_id] : 30;
        $periodicityId = $financial->periodicity_id;
        $namePeriodicity = isset(config('enums.periodicidad_names_chart')[$financial->periodicity_id]) ? config('enums.periodicidad_names_chart')[$financial->periodicity_id] : null;

        $plazo = $lead->plazo_maximo ?? 12; // Si no hay plazo, tomamos 12 meses por defecto

        // Calcular intereses para la barra izquierda (Banco)
        $tasaInteresMensualBanco = ($tasaInteresBanco / 100) / 360 * $dias;
        $pagoPeriodicoBanco = $getCalc->getPaymentPresentValue($tasaInteresMensualBanco, $plazo, -$capitalTotal);
        $interesesBanco = $plazo * $pagoPeriodicoBanco - $capitalTotal;

        // Calcular intereses para la barra derecha (KaaxClub)
        $tasaInteresMensualKaaxClub = ($tasaInteresKaaxClub / 100) / 360 * $dias;
        $pagoPeriodicoKaaxClub = $getCalc->getPaymentPresentValue($tasaInteresMensualKaaxClub, $plazo, -$capitalTotal);
        $interesesKaaxClub = $plazo * $pagoPeriodicoKaaxClub - $capitalTotal;
        return view('comparador-intereses', compact(
            'capitalTotal', 
            'tasaInteresBanco', 
            'tasaInteresKaaxClub', 
            'interesesBanco', 
            'interesesKaaxClub', 
            'nombreBanco', 
            'lead',
            'plazo',
            'namePeriodicity',
        ));
    }

    public function whatsapp()
    {
        $whatsappUrl = 'https://api.whatsapp.com/send?phone=+529999208020&text=Hola,%20quiero%20información';

        // Redireccionar a la URL de WhatsApp
        return Redirect::to($whatsappUrl);
    }

    
    function slackNotification()
    {
    
        Action::accionesVencidas();
    }

    public function surveyForm(Request $request)
    {
        $token        = $request->token;
        $email        = $request->email;
        $validate     = TokenForms::validateToken($token, $email);

        if ($validate) {
            return view('quiz.survey_form');
        }
        abort(404);
    }

    public function contratoClient(ClientPerson $client,  Credit $credit)
    {
        $isFirma = false;
        $firma = null;
        $token = null;
        $ip = null;
        $hostname = null;

        $history = HistoryLog::where([
            'id_rel' => $credit->id,
            'is_credit' => 1,
            'status_id' => HistoryLog::KC_CONTROL_DESK,
            'status' => 1,
        ])->first();
        
        $statusFirmaContratoCM = HistoryLog::where([
            'id_rel' => $credit->id,
            'is_credit' => 1,
            'status_id' => HistoryLog::KC_CONTROL_DESK_TASK1_STEP4,
            'status' => 1,
        ])->orderBy('history_logs.id', 'DESC')
        ->first();

        
        if ($statusFirmaContratoCM == null) {
            abort(404);
        } else {
            $isFirma = $client->cm_agreement == null ? true : false;
        }

        //$isFirma = true;
        $agreement = Agreement::find($credit->agreement_id);
        return view('contrato_cliente', compact('client', 'history', 'isFirma', 'credit', 'firma', 'token', 'ip', 'agreement'));
    }

    public function contratoClientFirma(ClientPerson $client , Credit $credit, Request $request)
    {
        $agreement = Agreement::find($credit->agreement_id);
        $token = $client->id.'-'.\Str::random(10);
        $firma =  $token;
        // Obtener la IP real del usuario
        $ip = $request->ip(); // Esto te dará la IP del cliente
        $hostname = gethostbyaddr($ip);
        $dateTime = Carbon::now()->format('d-m-Y h:i:s a');
        $isFirma = false;

        $data = array(
            'client' => $client,
            'credit' => $credit,
            'isFirma' => $isFirma,
            'token' => $token,
            'firma' => $firma,
            'ip' => $ip,
            'hostname' => $hostname,
            'dateTime' => $dateTime,
            'agreement' => $agreement,
        );
        ClientPerson::where('id', $client->id)->update([
            'cm_agreement' => 1
        ]);
        $history = HistoryLog::where([
            'id_rel' => $credit->id,
            'is_credit' => 1,
            'status_id' => HistoryLog::KC_CONTROL_DESK,
            'status' => 1,
        ])->first();

        
        //dd($client->cm_agreement);
        $nombre = $client->id.'-'.$client->name.' '.$client->last_name.' '.$client->second_last_name.' contrato CM.pdf';
        $directory = public_path('firma_contratos');
        $filePath = $directory . '/' . $nombre;

        File::create([
            'name' => $nombre,
            'model' => 21,
            'id_rel' => $credit->id,
            'client_id' => $client->id,
            'template_config_id' => 4,
            'step' => '4_1',
        ]);

        if ($client->cm_agreement == null) {
        }
        if (!FileFacade::exists($filePath)) {
        }
        $pdf = Pdf::loadView('contrato_cliente', $data);
        $pdf->setPaper('A4');
        $pdf->save('firma_contratos/'.$nombre);
        
       

        
        return redirect('/client/contratocm/'.$client->id.'/1/exit');
    }

    public function contratoClientFirmaExit($clientId ,  $type)
    {
        return view('exit_sign', compact('type'));
    }

    public function contratoCreditSod(Credit $credit)
    {
        $client  = $credit->creditClientPerson;
        $isFirma = false;
        $firma = null;
        $token = null;
        $ip = null;
        $hostname = null;
        
        $agreement = Agreement::find($credit->agreement_id);

        $history = HistoryLog::where([
            'id_rel' => $credit->id,
            'is_credit' => 1,
            'status_id' => HistoryLog::KC_CONTROL_DESK,
            'status' => 1,
        ])->first();
        
        $statusFirmaContratoCM = HistoryLog::where([
            'id_rel' => $credit->id,
            'is_credit' => 1,
            'status_id' => HistoryLog::KC_CONTROL_DESK_TASK2_STEP4,
            'status' => 1,
        ])->first();
        if ($statusFirmaContratoCM == null) {
            abort(404);
        } else {
            $isFirma = $credit->sod_agreement == null ? true : false;
        }
        return view('contrato_sod', compact('client', 'credit', 'agreement', 'history', 'isFirma', 'firma', 'token'));
    }

    public function contratoCreditFirmaSod(Credit $credit , Request $request)
    {
        $client  = $credit->creditClientPerson;
        $token = $client->id.'-'.\Str::random(10);
        $firma =  $token;
        // Obtener la IP real del usuario
        $ip = $request->ip(); // Esto te dará la IP del cliente
        $hostname = gethostbyaddr($ip);
        $dateTime = Carbon::now()->format('d-m-Y h:i:s a');
        $isFirma = false;
        $agreement = Agreement::find($credit->agreement_id);
        

        $data = array(
            'client' => $client,
            'isFirma' => $isFirma,
            'token' => $token,
            'firma' => $firma,
            'ip' => $firma,
            'hostname' => $hostname,
            'dateTime' => $dateTime,
            'credit' => $credit,
            'agreement' => $agreement,
        );
        Credit::where('id', $credit->id)->update([
            'sod_agreement' => 1
        ]);
        
        
        $pdf = Pdf::loadView('contrato_sod', $data);
        $pdf->setPaper('A4');
        $nombre = $client->id.'-'.$client->name.' '.$client->last_name.' '.$client->second_last_name.' contrato SOD.pdf';
        $pdf->save('firma_contratos/'.$nombre);
       

        
        return redirect('/client/sod/'.$credit->id.'/1/exit');
    }

    public function sodCreditFirmaExit($creditId , $type)
    {
        
        return view('exitsod_sign', compact('type'));
    }

    public function report($history_id, $credit_id = null)
    {
        
        session(['report_history_id' => $history_id]);
        
        $history    = HistoryLog::find($history_id);
        if ($credit_id == null) {
            $credit     = $history->historyCredit;
        } else {
            $get_action   = HistoryLog::getByStatusFirst([HistoryLog::KC_CHECK_UP], $credit_id);
            $history      = HistoryLog::find($get_action->id);
            $credit       = Credit::find($credit_id);
        }

        session(['credit_id' => $credit->id]);
        $plazo   = Session::get('plazo');

        
        if ($credit->applied_financial != '') {
            return view('content_expiration_report');
        }
        
        $financial            = $credit->creditFinancial; //financiera transferente
        $client               = $credit->creditClientPerson;
        $option               = 2;
        $status_id            = $history->status_id;
        $agreement            = $credit->creditAgreement;
        $financials           = $agreement != null ? $agreement->financialAgreement : null;
        $financial_products   = FinancialProduct::getByRate($credit);
        //dd($financial_products);
        $new_financials       = FinancialProduct::customSortFinancials($financial_products);
        $existing_ids = $new_financials->pluck('id')->toArray();
        $final_financials = FinancialProduct::customSortFinancials($financial_products->whereNotIn('id', $existing_ids), true);
        //dd($final_financials);
        $banks = Bank::all();
        $my_product_financial = null;
        $my_product           = null;
        
        if ($credit->date_open_report == null) {
            $many_chat = new Manychat();
            $many_chat->addTag('ReporteVisto', $credit->manychat_id);
        }

        Credit::where('id', $credit->id)
                ->where('date_open_report', '=' , null)
                ->update(['date_open_report'=> date('Y-m-d H:i:s')]);

        if ($history->status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION) {
            $is_best = false;
            $chart['Financiera 1'] = array(
                'prestamo' => 20000,
                'interes' => 8000,
                'comision_apertura' => 1000
            );
            $chart['Financiera 2'] = array(
                'prestamo' => 20000,
                'interes' => 1000,
                'comision_apertura' => 0
            );
            $chart['Financiera 3'] = array(
                'prestamo' => 20000,
                'interes' => 9000,
                'comision_apertura' => 600
            );
            $chart['Financiera 4'] = array(
                'prestamo' => 20000,
                'interes' => 11000,
                'comision_apertura' => 0
            );
            $chart['Financiera 5'] = array(
                'prestamo' => 20000,
                'interes' => 8500,
                'comision_apertura' => 0
            );
            $data_report = array(
                'client' => $client,
                'credit' => $credit,
                'financial' => $financial,
                'option' => $option,
                'history_id' => $history_id,
                'is_best' => $is_best,
                'status_id' => $status_id,
            );

            $my_product_financial   = FinancialProduct::existMyFinancial($new_financials, $credit->id);
            $my_products            = CurrentFinancialProduct::getList($credit->id, 2);
            $total_product          = count($my_products);
            $financial_products     = FinancialProduct::getAllByTemplate();

            return view('content_report_debt', compact('banks', 'plazo', 'client', 'credit', 'financial', 'option', 'history_id', 'is_best', 'status_id', 'new_financials', 'financial_products', 'final_financials', 'my_product_financial', 'my_products', 'total_product'));
        }
        return view('content_report', compact('banks', 'client', 'plazo', 'history_id', 'status_id', 'credit', 'new_financials', 'final_financials', 'my_product_financial'));
    }

    public function infoProduct(FinancialProduct $product)
    {
        $info = FinancialProduct::returnInfo($product);
        return response()->json($info);
    }
    
   

    public function storeReportProduct(Request $request)
    {
        $new_data = array(
            'consulta_buro'  => isset($request->consulta_buro)? $request->consulta_buro : 0, 
            'aval_o_garantia' => isset($request->aval_o_garantia)? $request->aval_o_garantia : 0, 
        );

        $report_history_id    = session('report_history_id');
        $history              = HistoryLog::find($report_history_id);
        $get_credit           = Credit::find($history->id_rel);
        $get_credit->fill($new_data); 
        $get_credit->update();
    }

    public function productsShow()
    {
        $history_id           = session('report_history_id');
        $history              = HistoryLog::find($history_id);
        $credit               = $history->historyCredit;
        $financial_products   = FinancialProduct::getByRate($credit);
        $new_financials       = FinancialProduct::customSortFinancials($financial_products);
        $existing_ids         = $new_financials->pluck('id')->toArray();
        $final_financials     = FinancialProduct::customSortFinancials($financial_products->whereNotIn('id', $existing_ids), true);
        $my_product_financial = FinancialProduct::existMyFinancial($new_financials, $credit->id);
        $view                 = \View::make('content_report_products', ['new_financials' => $new_financials, 'credit' => $credit, 'final_financials' => $final_financials])->render();

        $chart1 = isset($new_financials[1]) ? $new_financials[1] : null;
        $chart2 = isset($new_financials[0]) ? $new_financials[0] : null;
        $chart3 = isset($new_financials[2]) ? $new_financials[2] : null;
        $chart4 = $my_product_financial;

        return response()->json([
            'view' => $view,
            'chart1' => $chart1,
            'chart2' => $chart2,
            'chart3' => $chart3,
            'chart4' => $chart4,
        ]);
        
    }

    public function exitReport(Credit $credit)
    {
        $product        = FinancialProduct::find($credit->financial_product_id);
        $status_email   = true;
        $view_info      = null;

        if ($product!= null && $product->is_tramitar == 1 && $product->is_vincular_banco == 1 && ($credit != null && $credit->bank_id === null)) {
            $status_email = true; //*no 
        }
        if ($product != null) {
            FinancialProduct::returnInfo($product, $credit, true);
            $view_info = FinancialProduct::returnInfo($product);
        }
        $client           = ClientPerson::find($credit->client_person_id);
        $manychat_id = $credit->manychat_id;
        if ($manychat_id  != null) {
            $many_chat = new Manychat();
            $many_chat->addTag('ReporteElegido', $manychat_id);
        }
        
        return view('content_exit_report', compact('product', 'status_email',  'view_info', 'credit', 'client'));
    }

    public function updateAndSendEmail(Request $request)
    {
        $data             = $request->data;
        $credit           = Credit::find($request->credit_id);
        $client           = ClientPerson::find($credit->client_person_id);
        $client->email    = $data['email'];
        $client->update();
        $product          = FinancialProduct::find($request->product_id);
        
        
        FinancialProduct::returnInfo($product, $credit, true);
       
    }
    
    public function updateProduct(Request $request)
    {
        $creditId = session('credit_id');
        CurrentFinancialProduct::saveEdit($creditId, $request, 2);
       
    }
    
    public function ProductNotFound()
    {
        $creditId = session('credit_id');
        CurrentFinancialProduct::setOtherProduct($creditId);
    }

    public function importePlazo(Request $request)
    {
         // Obtener los valores de importe y plazo de la solicitud POST
        $importe    = $request->input('importe');
        $plazo      = $request->input('plazo');
        $creditId   = Session::get('credit_id');
        
        if ($importe != null) {
            Credit::where('id', $creditId)->update(['importe_solicitado' => $importe]);
        }
                // Almacenar los valores en variables de sesión
        Session::put('importe', $importe);
        Session::put('plazo', $plazo);
    }

    public function method($history_id)
    {
        $status_id = null;
        return view('content_report_metodologia', compact('history_id', 'status_id'));
    }

    public function showNotification()
    {
        $notifications = Notification::showMyNotification(6);
        return response()->json($notifications);
    }

    public function readNotification()
    {
        $notifications = Notification::readAllMyNotification();
    }

    public function survey($credit_id)
    {
    }

    /**
     * type reason in modal archive, reject and cancel
     *
     * @param string $type
     * @return void
     */
    public function reason($type)
    {
        $enums = array('Cancelar' => 'credit_reason_cancel', 'Rechazar' => 'credit_reason_reject', 'Archivar' => 'credit_reason_archive', 'ArchivarLead' => 'reason_archive');
        return response()->json(config('enums.'.$enums[$type]));
    }

    public function resumeCredit(Credit $credit)
    {
        return view('panel.credit.credit_resume', compact('credit'));
    }

    public function leadStore(Request  $request)
    {
        $lead = Lead::saveLeadSurvey($request);
        return response()->json(['lead' => $lead['lead'], 'history' => $lead['history']]);
    }

    public function leadFormStore(Request  $request)
    {
        $lead         = Lead::saveLeadFormSurvey($request, true);
        $credit_id    = null;

        try {
            $email        = $lead->email;
            $get_client   = ClientPerson::where('email', $email)->first();
            $credit       = Credit::getLastCredit($get_client->id);
            $credit_id    = $credit->id;
        } catch (\Exception $th) {
            
        }
        

        return response()->json(['lead' => $lead, 'credit_id' => $credit_id]);
    }

    public function validateAccess()
    {
        $role = Auth::user()->hasRole('Cliente financiera');
        $is_block = false;
        if ($role === true) {
            $user = User::find(Auth::user()->id);
            $is_block = $user->tyc_accept === 1 ? false : true;
        }
        return response()->json(['is_block' => $is_block]);
    }

    public function showValidateIdentity($token)
    {
        return view('validate-identity', compact('token'));
    }

    public function storeValidateIdentity(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'required|string|max:255',
            'nombres' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'rfc' => 'nullable|string|max:13'
        ]);
        // Decode and extract manychat_id from URL
        // The token is a hash of manychat_id + APP_KEY, so we need to find the manychat_id that generates this hash
        $token = $request->token;
        
        $lead = Lead::where('manychat_id', $token)->orderBy('id', 'desc')->first();
        $clientPerson = ClientPerson::where('rfc', $validated['rfc'])->first();
        $agreement         = $clientPerson != null ? Agreement::find($clientPerson->agreement_id): null;
        $validateAgreement = $agreement != null && $agreement->status == 1 ? true : false;

        $contentValidaciones      = 'Sin coincidencias';
        $statusRFC = 1;
        if ($clientPerson != null && $validateAgreement == true) {
            $statusRFC = 0;
            $contentValidacionesRFC = 'Coincidencia encontrada';
        }
        LeadValidation::saveEdit($lead->id, 'Prospecto - RFC', $statusRFC, $contentValidaciones);
        if ($lead!= null && $clientPerson != null) {
            $lead->update([

                'name' => $clientPerson->name,
                'last_name' => $clientPerson->last_name,
                'second_last_name' => $clientPerson->second_last_name,
                'birth_date' => $clientPerson->birth_date,
                'rfc' => $clientPerson->rfc,
                'email' => $clientPerson->email,
                'agreement_id' => $clientPerson->agreement_id,
                'cellphone' => $clientPerson->cellphone,
            ]);
            $dataField = array(
                'Prospecto - Formulario RFC llenado' => true,
                'Prospecto - Primer apellido' => $clientPerson->last_name,
                'Prospecto - Segundo apellido' => $clientPerson->second_last_name,
                'Prospecto - Fecha de nacimiento' => $clientPerson->birth_date,
                'Prospecto - RFC' => $clientPerson->rfc,
                'Prospecto - Validación RFC' => true,
            );
            $manychat = new Manychat();
            $manychat->setCustomFields($dataField, $token);

            return redirect('/validate-identity/'.$token.'/exit');
        }
        $dataField = array(
            'Prospecto - Formulario RFC llenado' => true,
            'Prospecto - Primer apellido' => $clientPerson->last_name,
            'Prospecto - Segundo apellido' => $clientPerson->second_last_name,
            'Prospecto - Fecha de nacimiento' => $clientPerson->birth_date,
            'Prospecto - RFC' => $clientPerson->rfc,
            'Prospecto - Validación RFC' => false,
        );
        $manychat = new Manychat();
        $manychat->setCustomFields($dataField, $token);
        return redirect()->back()->with('error', 'No se pudo procesar la información');
    }

    public function showValidateIdentityExit($token)
    {
        return view('validate-identity-exit', compact('token'));
        
    }
}
