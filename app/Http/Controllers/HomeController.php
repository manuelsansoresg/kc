<?php

namespace App\Http\Controllers;

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

    public function passwordChange($lead_id)
    {
        $lead = Lead::find($lead_id);
        if ($lead == null) {
            abort(404);
        }
        return view('panel.user.change_password', compact('lead'));
    }
}
