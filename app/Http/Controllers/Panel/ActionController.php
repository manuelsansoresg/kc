<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Credit;
use App\Models\File;
use App\Models\HistoryLog;
use App\Models\RegisterAction;
use App\Models\TemplateFile;
use App\Strategies\Values\ActionValues;
use App\Strategies\Values\TemplateValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    public function move($id_rel, $status_id, $old_status_id, Request $request)
    {
        $history = HistoryLog::move($id_rel, $status_id, $old_status_id, $request);
        return response()->json($history);
    }

    public function moveDeliveryFinish(HistoryLog $history, $status_id)
    {
        $credit = Credit::find($history->id_rel);
        $credit_id = $credit->id;
        if ($status_id == HistoryLog::KC_DELIVERY_FORM_STEP_3) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_2, $credit_id, 1);
            //*inicializar las acciones de la siguiente etapa en curso
            HistoryLog::move($credit_id, HistoryLog::KC_DELIVERY_FORM_STEP_3, HistoryLog::KC_DELIVERY_FORM_STEP_3, null, false);
            HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_3, $credit_id, 0);
            $credit->credit_signed = 1;
        } elseif ($status_id == HistoryLog::KC_DELIVERY_FORM_STEP_4) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_3, $credit_id, 1);
            //*inicializar las acciones de la siguiente etapa en curso
            HistoryLog::move($credit_id, HistoryLog::KC_DELIVERY_FORM_STEP_4, HistoryLog::KC_DELIVERY_FORM_STEP_4, null, false);
            HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_4, $credit_id, 0);
            $credit->approved = 1;
        } elseif ($status_id == HistoryLog::KC_PAYMENT) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_4, $credit_id, 1);
            //*inicializar las acciones de la siguiente etapa en curso
            HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT, $credit_id, 0);
            HistoryLog::move($credit_id, HistoryLog::KC_PAYMENT, $history->old_status_id, null, false);
            $credit->delivered = 1;
        }
        $credit->update();
    }

    public function complete(HistoryLog $history)
    {
        $action_in_progress   = HistoryLog::getCurrentAction($history->id_rel);
        $model                = HistoryLog::$name_model[$history->status_id];
        $templateStrategy     = TemplateValues::STRATEGY[$model];
        $url                  = (new $templateStrategy)->getUrlActionInProgress($action_in_progress, $history);
        return response()->json([ 'url' => $url]);
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
        $action = Action::saveEdit($request);
        if ($action != null) {
            $request->session()->put('id_rel_action', $action->id);
        }
        return response()->json($action);
    }

    /**
     * guarda el archivo dependiendo del modelo y el tipo de relacion
     *
     * @param int $model   model to indicate relationship
     * @param [type] $id_rel id_rel id to relationship
     * @param Request $request
     * @return void
     */
    public function storeFile($model, Request $request)
    {
        if ($model == 'null') {
            $model = $request->session()->get('model_action');
        }
        $id_rel = $request->session()->get('id_rel_action');
        File::upload($model, $id_rel, $request);
    }

    public function configFilesTemplate($model, $id_rel)
    {
        $actionStrategy   = TemplateValues::STRATEGY[$model];
        $config_files       = (new $actionStrategy)->configUpload();
        $preview = File::getAll($model, $id_rel);

        $data = array('config_files' => $config_files, 'preview' => $preview);
        return response()->json($data);
    }

    public function storeFilesTemplate($model, $id_rel, $template_config_id, Request $request)
    {
        $models = File::MODEL;
        File::upload($models[$model], $id_rel, $request, $template_config_id);
    }

    public function getDataTemplate($model, $id_rel)
    {
        $models = File::MODEL;
        $data_where = array(
            'model' => $models[$model],
            'id_rel' => $id_rel
        );
        $files = File::getAllTemplate($models[$model], $id_rel);
        $file_date = TemplateFile::where($data_where)->get();

        return response()->json(['files' => $files, 'file_date' => $file_date]);
    }

    public function storeFilesDateTemplate(Request $request)
    {
        TemplateFile::saveTemplate($request);
    }

    public function showFiles($model, Request $request)
    {
        if ($model == 'null') {
            $model = $request->session()->get('model_action');
        }
        $id_rel = $request->session()->get('id_rel_action');
        $files = File::getAll($model, $id_rel);
        return response()->json($files);
    }
    /**
     * delete file register action
     *
     * @param [type] $id
     * @return void
     */
    public function deleteFile($id)
    {
        $path = File::PATH;
        $file = File::find($id);
        @unlink($path.'/'.$file->name);
        $file->delete();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $action = Action::getById($id, 'lead');
        return response()->json($action);
    }

    public function viewAction($status)
    {
        $title = ($status == 'in_progress')? 'En curso': 'Concluidas';
        return view('panel.action.list', compact('title', 'status'));
    }
   
    public function viewActionLead($status)
    {
        $title = ($status == 'in_progress')? 'En curso': 'Concluidas';
        return view('panel.action.list_lead', compact('title', 'status'));
    }
    
    /**
     * Use list action programmed and complete
     *
     * @param [type] $id
     * @param [type] $model
     * @param [type] $status
     * @return void
     */
    public function listAction($id, $model, $status)
    {
        $leadStrategy   = ActionValues::STRATEGY[$model];
        $list       = (new $leadStrategy)->list($id, $model, $status);
        return response()->json($list);
    }

    public function viewModuleAction($name_status)
    {
        $title = $name_status == 'in_progress' ? 'En curso' : 'Completado';
        return view('panel.action.module.list', compact('title', 'name_status'));
    }

    public function listModuleAction($name_status)
    {
        $leadStrategy   = ActionValues::STRATEGY['list'];
        $list       = (new $leadStrategy)->get($name_status);
        return response()->json(['data' => $list]);
    }

    /**
     * List use in datatable action list
     *
     * @param [type] $id
     * @param [type] $model
     * @param [type] $status
     * @return void
     */
    public function list($status)
    {
        $list = Action::listDt($status);
        return response()->json(['data' => $list]);
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
        $action = Action::find($id);
        if ($action != null) {
            File::deleteByModel($action->section, $action->id);
            $register_action = RegisterAction::find($action->id);
            if ($register_action != null) {
                $register_action->delete();
            }
            $action->delete();
        }
    }
}
