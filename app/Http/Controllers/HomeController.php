<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\Notification;
use Illuminate\Http\Request;

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

    public function report($history_id)
    {
        $history    = HistoryLog::find($history_id);
        $credit     = $history->historyCredit;
        $financial  = $credit->creditFinancial;
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
            return view('content_report_debt', compact('client', 'financial', 'get_chart', 'option', 'history_id', 'is_best', 'status_id'));
        }
        return view('content_report', compact('client', 'history_id', 'status_id'));
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
}
