<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Agreement;
use App\Models\ApiLead;
use App\Models\Bank;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\CurrentFinancialProduct;
use App\Models\FinancialProduct;
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
        $new_financials       = FinancialProduct::customSortFinancials($financial_products);
        $existing_ids = $new_financials->pluck('id')->toArray();
        $final_financials = FinancialProduct::customSortFinancials($financial_products->whereNotIn('id', $existing_ids), true);
        $banks = Bank::all();
        $my_product_financial = null;
        $my_product           = null;

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
            return view('content_report_debt', compact('banks', 'client', 'credit', 'financial', 'option', 'history_id', 'is_best', 'status_id', 'new_financials', 'final_financials', 'my_product_financial', 'my_products'));
        }
        return view('content_report', compact('banks', 'client', 'history_id', 'status_id', 'credit', 'new_financials', 'final_financials', 'my_product_financial'));
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
        $product = FinancialProduct::find($credit->financial_product_id);
        return view('content_exit_report', compact('product'));
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
