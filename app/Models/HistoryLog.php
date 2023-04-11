<?php

namespace App\Models;

use App\Strategies\Values\TemplateValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HistoryLog extends Model
{
    use HasFactory;

    const LEAD_ARCHIVE                        = 1;
    const ADD_PROSPECT                        = 2;
    const CREATE_PROSPECT                     = 3;
    const LEAD_CONVERT                        = 4;
    const CREATE_CLIENT_PERSON                = 5;
    
    const KC_CHECK_UP                         = 6;
    const KC_CHECK_UP_ACTION_UPLOAD           = 7;
    const KC_CHECK_UP_ACTION_FORM             = 8;
    const KC_CHECK_UP_ACTION_REPORT           = 9;
    const KC_CHECK_UP_ACTION_DESITION         = 14;

    const KC_CHECK_UP_DEBT_REDUCTION          = 10;
    const KC_CHECK_UP_DEBT_REDUCTION_UPLOAD   = 11;
    const KC_CHECK_UP_DEBT_REDUCTION_FORM     = 12;
    const KC_CHECK_UP_DEBT_REDUCTION_REPORT   = 13;
    const KC_CHECK_UP_DEBT_REDUCTION_DESITION = 15;

    const CREDIT_ARCHIVE                      = 16;
    const CREDIT_CANCELED                     = 17;
    const CREDIT_REJECTED                     = 18;
    //* whenever a credit is in a module it must be in progress if it is archived, canceled or refuses to remove it
    const CREDIT_IN_PROGRESS                  = 19;
    
    const NEW_CREDIT_KC_CHECK_UP              = 20;

    const KC_CONTROL_DESK                     = 21;
    const KC_CONTROL_DESK_UPLOAD              = 22;
    const KC_CONTROL_DESK_FORM                = 23;
    
    const KC_CONTROL_DESK_FORM_STEP_2         = 24;
    
    const KC_CONTROL_DESK_UPLOAD_3_1          = 25;
    const KC_CONTROL_DESK_FORM_STEP_3_1       = 26;
    const KC_CONTROL_DESK_FORM_STEP_3_2       = 27;
    
    const KC_CONTROL_DESK_FORM_STEP_4         = 28;
    const KC_CONTROL_DESK_FORM_STEP_5         = 29;
    
    const KC_DELIVERY                         = 30;
    const KC_DELIVERY_FORM                    = 31;
    
    const KC_DELIVERY_FORM_STEP_2             = 32;
    
    const KC_DELIVERY_FORM_STEP_3             = 33;

    const KC_DELIVERY_FORM_STEP_4             = 34;
    
    const CREDITS_PAID                        = 35;
    const CREDITS_DELIVERED                   = 55;

    const KC_AFTER_MARKET                     = 36;
    const KC_AFTER_FORM                       = 48;
    
    const KC_SWAP                             = 37;
    const KC_SWAP_UPLOAD                      = 38;
    const KC_SWAP_FORM                        = 39;
    const KC_SWAP_UPLOAD_2                    = 46;
    
    const KC_SWAP_FORM_STEP_2                 = 40;
    const KC_SWAP_FORM_STEP_2_2               = 41;
    const KC_SWAP_UPLOAD_STEP_2_3             = 42;
    const KC_SWAP_FORM_STEP_2_3               = 43;
    
    const KC_SWAP_UPLOAD_STEP_3               = 44;
    const KC_SWAP_FORM_STEP_3                 = 45;
    const KC_SWAP_FORM_STEP_3_2               = 47;
    
    const KC_PAYMENT                          = 49;
    const KC_PAYMENT_FORM_STEP_1              = 52;
    const KC_PAYMENT_UPLOAD_STEP_1            = 53;

    const KC_PAYMENT_FORM_STEP_2              = 54;
    
    const KC_PAYMENT_PAID_ARCHIVE             = 50;
    const KC_PAYMENT_UNPAID_ARCHIVE           = 51;
    const KC_AFTER_MARKET_ARCHIVE             = 56;
    

    protected $fillable = [
        'id_rel',
        'status_id',
        'old_status_id',
        'reason',
        'file',
        'comment',
        'status',
        'user_id',
        'status_progress', //* 0 en curso 1 finalizada
        'date_status_progress' //* fecha en que se actualiza el status
    ];

    public static $label_status = [
        1 => 'Se archivó el prospecto',
        2 => 'Se asigno el prospecto a',
        3 => 'Se créo el prospecto',
        4 => 'Se creó cliente persona desde prospecto',
        5 => 'se creó el crédito',
        6 => 'Entró a KC - Check up',
        7 => 'Carga',
        8 => 'Formulario',
        9 => 'Reporte',
        10 => 'Crédito nómina reducción',
        11 => 'Carga',
        12 => 'Formulario',
        13 => 'Reporte',
        14 => 'Decisión',
        15 => 'Decisión',
        16 => 'Archivo',
        17 => 'Cancelado',
        18 => 'Rechazado',
        19 => 'En curso',
        20 => 'Nuevo crédito en KC - Check up',
        20 => 'Entró a KC - Control desk',
        21 => 'Control desk',
        22 => 'Carga',
        23 => 'Formulario',
        24 => 'Formulario',
        25 => 'Carga',
        26 => 'Formulario',
        27 => 'Formulario',
        28 => 'Formulario',
        29 => 'Formulario',
        30 => 'Entró a KC - Delivery',
        31 => 'Email',
        32 => 'Formulario',
        33 => 'Carga',
        34 => 'Formulario',
        35 => 'Créditos pagados',
        36 => 'Entró a KC - After market',
        37 => 'Entró a KC - Swap',
        38 => 'Carga',
        39 => 'Formulario',
        40 => 'Formulario',
        41 => 'Formulario',
        42 => 'Carga',
        43 => 'Formulario',
        44 => 'Carga',
        45 => 'Formulario',
        46 => 'Carga',
        47 => 'Formulario',
        48 => 'Formulario',
        49 => 'Entró a KC - Payments',
        50 => 'Entró a  Archivo - KC- Payments - Pagado',
        51 => 'Entró a  Archivo - KC- Payments - No pagado',
        52 => 'Formulario',
        53 => 'Carga',
        54 => 'Formulario',
        54 => 'Formulario',
        55 => 'Formulario',
        56 => 'After market',
    ];
    
    public static $label_subject = [
        7 => 'Documentos cliente',
        8 => 'Información laboral y contacto',
        9 => 'Reporte de crédito',
        11 => 'Documentos cliente',
        12 => 'Información laboral y contacto',
        13 => 'Reporte de crédito',
        14 => 'Eligir la mejor opción',
        15 => 'Eligir la mejor opción',
        16 => 'Archivo',
        17 => 'Cancelado',
        18 => 'Rechazado',
        19 => 'En curso',
        20 => 'Nuevo crédito en KC - Check up',
        22 => 'Documentos cliente',
        23 => 'Determinar crédito max',
        24 => 'Crédito deseado',
        25 => 'Edo Cta',
        26 => 'Llenado de solicitud',
        27 => 'Entrevista',
        28 => 'Análisis KYC',
        29 => 'Contactar financiera',
        //30 => 'Entró a KC - Delivery',
        31 => 'Información del crédito',
        32 => 'Confirmar firma',
        33 => 'Confirmación de entrega',
        34 => 'Resolución de análisis',
        35 => 'Créditos pagados',
        36 => 'Entró a KC - After market',
        37 => 'Entró a KC - Swap',
        38 => 'Documentos cliente',
        39 => 'Información laboral y contacto',
        46 => 'Solicitud de terminación',
        40 => 'Preparar documento',
        41 => 'Confirmar',
        42 => 'Documento firmado',
        43 => 'Enviar solicitud',
        44 => 'Cotización terminación',
        45 => 'Cotización terminación',
        47 => '¿Continuar?',
        48 => 'Calidad de servicio',
        49 => '',
        50 => '',
        51 => '',
        52 => 'Cambios en comisión',
        53 => 'Comprobante de pago',
        54 => 'Verificar pago',
        55 => '',
        56 => '',
    ];

    public static $name_model = [
        6 => 'newCredit',
        7 => 'newCredit',
        8 => 'newCredit',
        9 => 'newCredit',
        10 => 'debtCredit',
        11 => 'debtCredit',
        12 => 'debtCredit',
        13 => 'debtCredit',
        14 => 'debtCredit',
        15 => 'debtCredit',
        21 => 'controlDesk',
        22 => 'controlDesk',
        23 => 'controlDesk',
        24 => 'controlDesk',
        25 => 'controlDesk',
        26 => 'controlDesk',
        27 => 'controlDesk',
        28 => 'controlDesk',
        29 => 'controlDesk',
        30 => 'delivery',
        31 => 'delivery',
        32 => 'delivery',
        33 => 'delivery',
        34 => 'delivery',
        48 => 'delivery',
        36 => 'afterMarket',
        37 => 'swap',
        38 => 'swap',
        39 => 'swap',
        40 => 'swap',
        41 => 'swap',
        42 => 'swap',
        43 => 'swap',
        44 => 'swap',
        45 => 'swap',
        46 => 'swap',
        47 => 'swap',
        48 => 'afterMarket',
        49 => 'payment',
        50 => 'payment',
        51 => 'payment',
        52 => 'payment',
        53 => 'payment',
        54 => 'payment',
        55 => 'delivery',
        56 => 'afterMarket',
    ];

    public static function move($id_rel, $status_id, $old_status_id, $request = null, $update_old_status = true)
    {
        if ($request != null) {
            $data = $request->data;
        }

        $data['id_rel']           = $id_rel;
        $data['status_id']        = $status_id;
        $data['old_status_id']    = $old_status_id;
        $data['status']           = 1;
        $get_status = HistoryLog::where($data)->first();
        self::removeInProgress($id_rel, $status_id);
        
        
        //*validate if old status exist
        $data_old_status = array(
            'old_status_id' => $old_status_id,
            'id_rel' => $id_rel,
        );
        //*if exist reset to 0
        $get_old_status = HistoryLog::where($data_old_status);
        if ($get_old_status != null && $update_old_status == true) {
            $get_old_status->update(['status' => 0]);
        }
        //* if new status and old status don't exist create status
        if ($get_status === null) {
            try {
                $data['user_id']    = Auth::user()->id;
            } catch (\Exception $th) {
            }

            $history = new HistoryLog($data);
            $history->save();
            self::subHistories($id_rel, $status_id, $history);

            return $history;
        }
    }

    public function subHistories($id_rel, $status_id, $history)
    {
        
        if ($status_id == HistoryLog::KC_CHECK_UP) {
            HistoryLog::move($id_rel, HistoryLog::KC_CHECK_UP_ACTION_UPLOAD, HistoryLog::KC_CHECK_UP_ACTION_UPLOAD);
            HistoryLog::move($id_rel, HistoryLog::KC_CHECK_UP_ACTION_FORM, HistoryLog::KC_CHECK_UP_ACTION_FORM);

            //* revisar porcentaje formulario para activar o no la etapa
            $templateStrategy   = TemplateValues::STRATEGY['newCredit'];
            $percent            = (new $templateStrategy)->percentForm($history);
            $credit             = Credit::find($id_rel);

            if ($percent == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_UPLOAD, $id_rel, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_FORM, $id_rel, 1);
                
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_ACTION_REPORT, HistoryLog::KC_CHECK_UP_ACTION_REPORT);
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_ACTION_DESITION, HistoryLog::KC_CHECK_UP_ACTION_DESITION);
                
                //*inicializar las acciones de la siguiente etapa en curso
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_REPORT, $credit->id, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_DESITION, $credit->id, 0);
            } else {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_UPLOAD, $id_rel, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_FORM, $id_rel, 0);
            }
        }
        
        if ($status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION) {
            HistoryLog::move($id_rel, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_UPLOAD, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_UPLOAD);
            HistoryLog::move($id_rel, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM);
            //* revisar porcentaje formulario para activar o no la etapa
            $templateStrategy   = TemplateValues::STRATEGY['debtCredit'];
            $percent            = (new $templateStrategy)->percentForm($history);
            $credit             = Credit::find($id_rel);

            if ($percent == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_UPLOAD, $id_rel, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM, $id_rel, 1);
                
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_REPORT, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_REPORT);
                HistoryLog::move($credit->id, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION);
                
                //*inicializar las acciones de la siguiente etapa en curso
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_REPORT, $credit->id, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION, $credit->id, 0);
            } else {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_UPLOAD, $id_rel, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM, $id_rel, 0);
            }
        }

        if ($status_id == HistoryLog::KC_CONTROL_DESK) {
            HistoryLog::move($id_rel, HistoryLog::KC_CONTROL_DESK_UPLOAD, HistoryLog::KC_CONTROL_DESK_UPLOAD);
            HistoryLog::move($id_rel, HistoryLog::KC_CONTROL_DESK_FORM, HistoryLog::KC_CONTROL_DESK_FORM);

            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_UPLOAD, $id_rel, 0);
            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM, $id_rel, 0);
            //*Cuando es crédito nuevo y viene de KC-Checkup
            HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP, $id_rel, 1);
        }

        if ($status_id == HistoryLog::KC_DELIVERY) {
            HistoryLog::move($id_rel, HistoryLog::KC_DELIVERY_FORM, HistoryLog::KC_DELIVERY_FORM);
            HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM, $id_rel, 0);
        }

        if ($status_id == HistoryLog::KC_SWAP) {
            HistoryLog::move($id_rel, HistoryLog::KC_SWAP_UPLOAD, HistoryLog::KC_SWAP_UPLOAD);
            HistoryLog::move($id_rel, HistoryLog::KC_SWAP_FORM, HistoryLog::KC_SWAP_FORM);
            HistoryLog::move($id_rel, HistoryLog::KC_SWAP_UPLOAD_2, HistoryLog::KC_SWAP_UPLOAD_2);
            
            HistoryLog::updateStatusProgress(HistoryLog::KC_SWAP_UPLOAD, $id_rel, 0);
            HistoryLog::updateStatusProgress(HistoryLog::KC_SWAP_FORM, $id_rel, 0);
            HistoryLog::updateStatusProgress(HistoryLog::KC_SWAP_UPLOAD_2, $id_rel, 0);
            //*Cuando es crédito nuevo y viene de KC-Checkup
            HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP, $id_rel, 1);
        }
        
        if ($status_id == HistoryLog::KC_PAYMENT) {
            //copy to after market
            HistoryLog::move($id_rel, HistoryLog::KC_AFTER_MARKET, HistoryLog::KC_AFTER_MARKET);
            HistoryLog::move($id_rel, HistoryLog::CREDITS_DELIVERED, HistoryLog::CREDITS_DELIVERED);
            
            HistoryLog::move($id_rel, HistoryLog::KC_PAYMENT_FORM_STEP_1, HistoryLog::KC_PAYMENT_FORM_STEP_1);
            HistoryLog::move($id_rel, HistoryLog::KC_PAYMENT_UPLOAD_STEP_1, HistoryLog::KC_PAYMENT_FORM_STEP_1);
            //*inicializar las acciones
            HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT, $id_rel, 1);
            HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT_FORM_STEP_1, $id_rel, 1);
            HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT_UPLOAD_STEP_1, $id_rel, 0);
        }
        if ($status_id == HistoryLog::KC_AFTER_MARKET) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_AFTER_FORM, $id_rel, 0);
            //*inicializar las acciones
            HistoryLog::move($id_rel, HistoryLog::KC_AFTER_FORM, HistoryLog::KC_AFTER_FORM);
            HistoryLog::updateStatusProgress(HistoryLog::KC_AFTER_FORM, $id_rel, 0);
        }
        if ($status_id == HistoryLog::CREDITS_PAID) {
            self::updateReason($history, 'pagado');
        }
    }

    public function removeInProgress($id_rel, $status_id)
    {
        if ($status_id == HistoryLog::CREDIT_ARCHIVE || $status_id == HistoryLog::CREDIT_CANCELED || $status_id == HistoryLog::CREDIT_REJECTED) {
            $where = array(
                'id_rel' => $id_rel,
                'status_id' => HistoryLog::CREDIT_IN_PROGRESS,
            );
            HistoryLog::where($where)->update(['status' => 0]);
        }
    }

    public function updateReason($history, $reason)
    {
        $history = HistoryLog::find($history->id);
        $history->reason = $reason;
        $history->update();
    }
    
    public static function updateStatusProgress($status_id, $id_rel, $status_progress)
    {
        //dd($status_id, $id_rel, $status_progress);
        $history = HistoryLog::where('status_id', $status_id)
                    ->where('id_rel', $id_rel)
                    ->where('status', 1)->first();
        $get_history = null;
        
        if ($history != null) {
            $get_history = HistoryLog::find($history->id);
            $get_history->status_progress = $status_progress;
            if ($get_history->date_status_progress == null) {
                $get_history->date_status_progress =  date('Y-m-d H:i:s');
            }
            $get_history->update();

            if ($history->first() != null) {
                $get_history = HistoryLog::find($history->first()->id);
            }
        }
        
        
        return $get_history;
    }

    public static function getByStatus($status_id, $id_rel = null)
    {
        $history = HistoryLog::wherein('status_id', $status_id);
        if ($id_rel != null) {
            $history->where('id_rel', $id_rel);
        }
        $history = $history->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->get();
        return $history;
    }

    //TODO:create a field in credit that is the name of the module and update that
    public function getStatusCredit($credit_id)
    {
        $data_status = array(
            HistoryLog::KC_CHECK_UP,
            HistoryLog::KC_CHECK_UP_DEBT_REDUCTION,
            HistoryLog::CREDIT_ARCHIVE,
            HistoryLog::CREDIT_CANCELED,
            HistoryLog::CREDIT_REJECTED,
        );
        $status = self::getByStatus($data_status, $credit_id);
        foreach ($status as $row_status) {
            if ($row_status->status_id == HistoryLog::KC_CHECK_UP || $row_status->status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION) {
                $status = 'En curso';
            } else {
                $status = HistoryLog::$label_status[$row_status->status_id];
            }
            return $status;
        }
    }

    public function getCurrentModule($credit_id)
    {
        $lbl_module = array(
            HistoryLog::KC_CHECK_UP => 'KC- Check up',
            HistoryLog::KC_CONTROL_DESK => 'KC- Swap',
            HistoryLog::KC_DELIVERY => 'KC- Delivery',
            HistoryLog::KC_AFTER_MARKET => 'KC- Delivery',
            HistoryLog::KC_SWAP => 'KC- After market',
        );
        $data_actions = array(
            HistoryLog::KC_CHECK_UP,
            HistoryLog::KC_CONTROL_DESK,
            HistoryLog::KC_DELIVERY,
            HistoryLog::KC_AFTER_MARKET,
            HistoryLog::KC_SWAP,
        );
        $status_progress = 0;
        $current_status = 'KC- Check up';
        $get_actions = HistoryLog::getByStatus($data_actions, $credit_id);

        foreach ($get_actions as $key => $get_action) {
            $status_id = $get_action->status_id;
            $status = $get_action->status_progress;
            $status_progress = $status > 0 ? 1 : 0;
            if ($status_progress == 1) {
                $lbl_module[$status_id];
            }
        }
        return $current_status;
    }

    public static function getLastStatus($status, $credit_id, $active = 1)
    {
        $get_status =  HistoryLog::wherein('status_id', $status)
                ->where('id_rel', $credit_id);
        if ($active == 1) {
            $get_status->where('status', $active);
        }
                
        $get_status = $get_status->orderBy('id', 'DESC')->first();
        return $get_status;
    }

    public static function getCurrentAction($credit_id)
    {
        $lbl_module = array(
            HistoryLog::KC_DELIVERY_FORM => 'Información del crédito',
            HistoryLog::KC_DELIVERY_FORM_STEP_2 => 'Confirmar firma',
            HistoryLog::KC_DELIVERY_FORM_STEP_3 => 'Resolución de análisis',
            HistoryLog::KC_DELIVERY_FORM_STEP_4 => 'Confirmar entrega',
            HistoryLog::KC_PAYMENT_UPLOAD_STEP_1 => 'Comprobante de pago',
            HistoryLog::KC_PAYMENT_FORM_STEP_2 => 'Verificar pago',
        );
        $data_actions = array(
            HistoryLog::KC_DELIVERY_FORM,
            HistoryLog::KC_DELIVERY_FORM_STEP_2,
            HistoryLog::KC_DELIVERY_FORM_STEP_3,
            HistoryLog::KC_DELIVERY_FORM_STEP_4,
            HistoryLog::KC_PAYMENT_UPLOAD_STEP_1,
            HistoryLog::KC_PAYMENT_FORM_STEP_2,
        );

        $status_progress = 0;
        $current_status =  null;
        $get_action = HistoryLog::getLastStatus($data_actions, $credit_id);
        //dd($get_action);
        try {
            $status = $get_action->status_progress;
            $status_progress = $status > 0 ? 1 : 0;
            $current_status = $lbl_module[$get_action->status_id];
            /* if ($status_progress == 1) {
            } */
        } catch (\Exception $th) {
            //throw $th;
        }
        return $current_status;
    }
    
    public static function getCurrentStep($credit_id)
    {
        $lbl_module = array(
            HistoryLog::KC_DELIVERY_FORM => 'Información del crédito',
            HistoryLog::KC_DELIVERY_FORM_STEP_2 => 'Confirmar firma',
            HistoryLog::KC_DELIVERY_FORM_STEP_3 => 'Resolución de análisis',
            HistoryLog::KC_DELIVERY_FORM_STEP_4 => 'Confirmar entrega',
            HistoryLog::KC_PAYMENT_UPLOAD_STEP_1 => 'Comprobante de pago',
            HistoryLog::KC_PAYMENT_FORM_STEP_2 => 'Verificar pago',
        );
        $data_actions = array(
            HistoryLog::KC_DELIVERY_FORM,
            HistoryLog::KC_DELIVERY_FORM_STEP_2,
            HistoryLog::KC_DELIVERY_FORM_STEP_3,
            HistoryLog::KC_DELIVERY_FORM_STEP_4,
            HistoryLog::KC_PAYMENT_UPLOAD_STEP_1,
            HistoryLog::KC_PAYMENT_FORM_STEP_2,
        );

        $status_progress = 0;
        $current_status =  null;
        $get_action = HistoryLog::getLastStatus($data_actions, $credit_id);
        //dd($get_action);
        try {
            $status = $get_action->status_progress;
            $status_progress = $status > 0 ? 1 : 0;
            $current_status = $lbl_module[$get_action->status_id];
            /* if ($status_progress == 1) {
            } */
        } catch (\Exception $th) {
            //throw $th;
        }
        return $current_status;
    }

    public static function listArchive($module_id)
    {
        
        $status_id    = $module_id;
        $get_list     = HistoryLog::where(['status_id' => $status_id, 'status' => 1])->get();
        $data         = array();
        foreach ($get_list as $query) {
            $option       = \View::make('panel.lead.add_option_archive_dt', [ 'type' => 2, 'id' => $query->id])->render();
            
            $lbl_status   = '<span class="text-success">Valido</span>';
            $lead         = $query->historyLead;

            if ($lead != null) {
                $product      = $lead != null ? $lead->productLead : null;
                $user         = $lead != null ? $lead->advisorLead : null;
    
                $content_lead         = \View::make('panel.lead.content_lead', ['lead' => $lead])->render();
                $reason = (isset(config('enums.reason_archive')[$query->reason]))? config('enums.reason_archive')[$query->reason] : '';
                $data[] = array(
                    'name' => $content_lead,
                    'date' => formatDateNameMonth($query->created_at),
                    'product' => ($product != null) ? $product->alias : '',
                    'origin' => config('enums.origin')[$lead->origin_id],
                    'reason' => $reason,
                    'label' => config('enums.temperatures')[$lead->temperature_id],
                    'advisor' => ($user != null) ? $user->name.' '.$user->last_name.' '.$user->second_last_name : '',
                    'status' => $lbl_status,
                    'options' => $option,
                );
            }
        }
        return $data;
    }

    public function historyLead()
    {
        return $this->belongsTo(Lead::class, 'id_rel');
    }
    
    public function historyLeadAdvisor()
    {
        return $this->belongsTo(LeadAdvisor::class, 'id_rel');
    }

    public function historyCredit()
    {
        return $this->belongsTo(Credit::class, 'id_rel');
    }
}
