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
        $history = HistoryLog::find($history_id);
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $option = 2;
        if ($history->status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION) {
            return view('content_report_debt', compact('client', 'option', 'history_id'));
        }
        return view('content_report', compact('client', 'history_id'));
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
