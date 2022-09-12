<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Lead;
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

    public function report($credit_id)
    {
        $credit = Credit::find($credit_id);
        $client = $credit->creditClientPerson;

        return view('content_report', compact('client'));
    }
}
