<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Lib\CNubarium;
use App\Lib\Csendgrid;
use App\Lib\CSurveySparrow;
use App\Lib\Pusher;
use App\Models\Credit;
use App\Models\Lead;
use App\Strategies\Values\ActionValues;
use App\Strategies\Values\SendNotificationsValues;
use App\Strategies\Values\TemplateValues;
use App\Strategies\Values\ValidateStagesValues;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $nubarium = new CNubarium();
        $curp = $nubarium->validateCurp('RAZR811011HVZMPB01');
        dd($curp); */
       /*  $send_grid = new Csendgrid('manuelsansoresg@gmail.com', 'creacion cuenta', ' ', 'manuel@kaaxclub.com', '', '23-bf86690d3a7bc5cc3d672a8f0b37b86f-700.jpg');
        $send_grid->setTemplate('d-2e7d6583de1647f4bc12ab6410b956b2');
        $send_grid->setParams(['first_name'=> 'Manuel']);
        $send_grid->send(); */
        //$send_grid->createSender('manu', 'irmalorenasosa@kaaxclub.com', 'irmalorenasosa@gmail.com');
        return view('panel.index');
    }

    public function showValidate($id, $model)
    {
        $leadStrategy   = ValidateStagesValues::STRATEGY[$model];
        $validate       = (new $leadStrategy)->getValidate($id);
        
        $view_validate  = \View::make('panel.table_validate', ['errors' => $validate['table']])->render();
        return response()->json($view_validate);
    }

    public function noteStore($model, Request $request)
    {
        $actionStrategy   = ActionValues::STRATEGY[$model];
        $note       = (new $actionStrategy)->saveNote($request);
        return response()->json(200);
    }

    public function listNotes($model, $id_rel)
    {
        
        if ($model == 'lead') {
            $lead = Lead::find($id_rel);
            $notes = $lead->leadNotes;
        } else {
            $credit = Credit::find($id_rel);
            $notes = $credit->creditNotes;
        }
        
        $view           = \View::make('panel.view_content_lead_notes', ['notes' => $notes])->render();
        return response()->json($view);
    }

    public function showAdvisor($model, $id_rel)
    {

        if ($model == 'lead') {
            $lead = Lead::find($id_rel);
            $advisor    = $lead->advisorLead;
        } else {
            $credit = Credit::find($id_rel);
            $advisor    = $credit->advisorCredit;
        }
        return response()->json(['advisor' => $advisor]);
    }

    public function move($model, $id)
    {
        $template   = TemplateValues::STRATEGY[$model];
        $move       = (new $template)->move($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
