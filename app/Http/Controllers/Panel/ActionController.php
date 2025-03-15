<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Credit;
use App\Models\CurrentFinancialProduct;
use App\Models\File;
use App\Models\HistoryLog;
use App\Models\Investor;
use App\Models\InvestorsCredit;
use App\Models\RegisterAction;
use App\Models\TemplateFile;
use App\Models\Transaction;
use App\Strategies\Values\ActionValues;
use App\Strategies\Values\SendNotificationsValues;
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

    public function listProductFinancial($id, $type)
    {
        $financials = CurrentFinancialProduct::getList($id, $type);
        return response()->json(['financials' => $financials]);
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
        //*agregar que cuando viene de control desk haga lo mismo si viniera de delivery
        
        /* if ($status_id == HistoryLog::KC_DELIVERY_FORM_STEP_3) {
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
            HistoryLog::move($credit_id, HistoryLog::KC_PAYMENT, HistoryLog::KC_PAYMENT, null, false);
            // send push
            $notification_add   = SendNotificationsValues::STRATEGY['pushCreditKcPayment'];
            (new $notification_add)->send($credit->id);
            
            HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT, $credit_id, 0);
            $credit->delivered = 1;
            //desactivate delivery
            HistoryLog::where(['id_rel' => $credit_id, 'status_id' => HistoryLog::KC_DELIVERY, 'status' => 1])
                        ->update(['status' => 0]);
        } elseif ($status_id == HistoryLog::KC_CONTROL_DESK || $status_id == HistoryLog::KC_SWAP || $status_id == HistoryLog::KC_CHECK_UP || $status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION) {
            //*inicializar las acciones de la siguiente etapa en curso
            HistoryLog::move($credit_id, HistoryLog::KC_PAYMENT, HistoryLog::KC_PAYMENT, null, false);
            // send push
            $notification_add   = SendNotificationsValues::STRATEGY['pushCreditKcPayment'];
            (new $notification_add)->send($credit->id);
            $credit->delivered = 1;

            HistoryLog::where(['id_rel' => $credit_id, 'status_id' => $history->status_id, 'status' => 1])
                        ->update(['status' => 0]);

        }
        $credit->update(); */
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
        $step = isset($request->step) && $request->step != 'undefined' ? $request->step : null;
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

    public function getDataTemplate($model, $id_rel, Request $request)
    {
        
        $models = File::MODEL;
        $data_where = array(
            'model' => $models[$model],
            'id_rel' => $id_rel
        );
        
        $step = isset($request->step) && $request->step != 'undefined' ? $request->step : null;
        $files = File::getAllTemplate($models[$model], $id_rel, $step);
        $file_date = TemplateFile::where($data_where)->get();

        return response()->json(['files' => $files, 'file_date' => $file_date]);
    }

    public function storeFilesDateTemplate(Request $request)
    {
        $models = File::MODEL;
        TemplateFile::saveTemplate($request);
        $step = $request->step;
        if ($request->model == 'controlDesk' && $step == '5_3') {
            $actionStrategy   = TemplateValues::STRATEGY[$request->model];
            $finish       = (new $actionStrategy)->finish($request->id_rel, $step);
        }
        //terminar archivo agregar fondos etapa 1
        if ($request->model == 'wallet'  && $step == '1_2') {
            //*inicializar las acciones de la siguiente etapa en curso
            HistoryLog::move($request->id_rel, HistoryLog::KC_WALLET_ADD_FORM_STEP_2, HistoryLog::KC_WALLET_ADD_FORM_STEP_2, null, false);
            HistoryLog::move($request->id_rel, HistoryLog::KC_WALLET_ADD_UPLOAD_STEP_2, HistoryLog::KC_WALLET_ADD_UPLOAD_STEP_2, null, false);

            HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET_ADD_UPLOAD_STEP_2, $request->id_rel, 0);
            HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET_ADD_FORM_STEP_2, $request->id_rel, 0);
        
        }

        if ($request->model == 'wallet'  && $step == '2') {
            $getTransaction = Transaction::find($request->id_rel);
            Investor::updateInvestorData($getTransaction->investor_id);
            Investor::updateInvestorBalances($getTransaction->investor_id);

            HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET_ADD_UPLOAD_STEP_2, $request->id_rel, 1);
            /* $getInvestors = InvestorsCredit::where('credit_id', $request->id_rel)->get();
            foreach ($getInvestors as $getInvestor) {
                
            } */
            
        }
        //terminar archivo retirar fondos etapa 1
        if ($request->model == 'kc-down-wallet' && $step == '2') {
            HistoryLog::move($request->id_rel, HistoryLog::KC_DOWN_WALLET_ADD_UPLOAD_STEP_2, HistoryLog::KC_DOWN_WALLET_ADD_UPLOAD_STEP_2, null, false);
            $actionStrategy   = TemplateValues::STRATEGY[$request->model];
            $finish       = (new $actionStrategy)->finish($request->id_rel, $step);
        }
        
        
       /*  $data_where = array(
            'model' => $models[$request->model],
            'id_rel' => $request->id_rel
        );
        $files = File::where($data_where)->count(); */
        
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
   
    public function viewActionDt($status, $model)
    {
        $title = ($status == 'in_progress')? 'En curso': 'Concluidas';
        return view('panel.action.list_action_dt', compact('title', 'status', 'model'));
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
        $list       = (new $leadStrategy)->listAction($id, $model, $status);
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
    public function list($status, $model)
    {
        $model = $model == 'lead' ? 1 : 2;
        $list = Action::listDt($status, $model);
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
