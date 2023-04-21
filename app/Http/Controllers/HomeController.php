<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\Notification;
use App\Models\Sendgridtest;
use App\Models\TokenForms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function report($history_id, $credit_id = null)
    {
        if ($credit_id == null) {
            $history    = HistoryLog::find($history_id);
            $credit     = $history->historyCredit;
        } else {
            $get_action = HistoryLog::getByStatusFirst([HistoryLog::KC_CHECK_UP], $credit_id);
            $history    = HistoryLog::find($get_action->id);
            $credit     = Credit::find($credit_id);
        }

        
        if ($credit->applied_financial != '') {
            return view('content_expiration_report');
        }
        
        $financial  = $credit->creditFinancial; //financiera transferente
        $client     = $credit->creditClientPerson;
        $option     = 2;
        $status_id  = $history->status_id;
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
            $get_chart = isset($chart[$financial->commercial_name])? $chart[$financial->commercial_name]: $chart['Financiera 1'];
            $data_report = array(
                'client' => $client,
                'credit' => $credit,
                'financial' => $financial,
                'get_chart' => $get_chart,
                'option' => $option,
                'history_id' => $history_id,
                'is_best' => $is_best,
                'status_id' => $status_id,
            );
            return view('content_report_debt', compact('client', 'credit', 'financial', 'get_chart', 'option', 'history_id', 'is_best', 'status_id'));
        }
        return view('content_report', compact('client', 'history_id', 'status_id', 'credit'));
    }

    public function exitReport(Credit $credit)
    {
        return view('content_exit_report');
    }

    public function method($history_id)
    {
        return view('content_report_metodologia', compact('history_id'));
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
        return response()->json(['lead' => $lead]);
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
}
