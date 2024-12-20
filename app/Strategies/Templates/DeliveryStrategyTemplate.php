<?php

namespace App\Strategies\Templates;

use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\CreditPayOff;
use App\Models\File;
use App\Models\Financial;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\Product;
use App\Models\User;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use stdClass;

class DeliveryStrategyTemplate implements TemplateInterface
{
    const HOUR_STEP_1  = 2;
    const HOUR_STEP_2  = 24;
    const HOUR_STEP_3  = 24;
    const HOUR_STEP_4  = 24;

    public function move($id)
    {
    }

    public function configUpload()
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == 3) {
            return self::uploadStep3();
        }
        return self::uploadStep2();
    }

    public function uploadStep2()
    {
        $elements = array(
            1 => [
                'name' => 'Comprobante de pago',
                'comment' => '',
                'is_required' => true,
                'is_date' => true,
                'max_size' => 2, //* size in MB
                'max_file' => 2,
                'type' => 'image/*, .pdf',
                'comment_date' => null
            ],

            
        );
        return $elements;
    }

    public function uploadstep3()
    {
        $elements = array(
            5 => [
                'name' => 'Edo Cta bancario',
                'comment' => 'Último estado de cuenta',
                'is_required' => false,
                'is_date' => false,
                'max_size' => 2, //* size in MB
                'max_file' => 2,
                'type' => 'image/*, .pdf',
                'comment_date' => null
            ],

        );
        return $elements;
    }

    public function configForm($id_rel, $history_id = null)
    {
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $taskId = null;
        

        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $taskId) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }
        if ($step == 1 && $taskId == 1) {
            return self::configFormStep1Task1($id_rel, $history_id, $taskId);
        } elseif ($step == 1 && $taskId > 1) {
            return self::configDynamicFormStep1Task1($id_rel, $history_id, $taskId);
        }
        
        elseif ($step == 2) {
            return self::configFormstep2($id_rel, $history_id);
        } 
    }

    public function configFormStep1Task1($id_rel, $history_id, $taskId)
    {
        $name_form    = 'frm-template_delivery_task1_step1';
        $type_form    = HistoryLog::KC_DELIVERY_TASK1_STEP1;
        $credit       = Credit::find($id_rel);
        $client = $credit->creditClientPerson;
        $stepRedirect = $taskId +1;
        $client_person = $credit->creditClientPerson;
        
        $contentInfo = \View::make('panel.client.infoClient', ['client' => $client, 'taskId' => 5, 'credit' => $credit])->render();
        $elements = array(
            1 => [
                'title_section' => '',
                'title' => null,
                'subtitle' => null,
                
                'id_field' => 'deadline_date',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'col' => 'col-12',
                'type' => 'div',
                'content' => $contentInfo,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            2 => [
                'title_section' => null,
                'title' => '*Entrega crédito cliente',
                'subtitle' => ' Indica si se ha hecho la transferencia correctamente',
                'name_field' => null,
                'id_field' => 'ammount',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'radio',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-6',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'name' => 'Valida',
                        'name_field' =>  'credit[delivered]',
                        'class' => null,
                        'onclick' => null,
                        'value' => 1,
                        'is_required' => true,
                    ),
                    1 => array(
                        'link' => null,
                        'name' => 'Invalida',
                        'name_field' => 'credit[delivered]',
                        'class' => null,
                        'onclick' => null,
                        'value' => 0,
                        'is_required' => true,
                        
                    ),
                )
            ],
            3 => [
                'title_section' => '',
                'title' => 'Fecha de entrega',
                'subtitle' => 'indica la fecha en la que se hizo la transferencia.',
                'name_field' => 'credit[delivered_date]',
                'id_field' => 'delivered_date',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'date',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => null
            ],
            4 => [
                'title_section' => null,
                'title' => '*Comprobante de entrega',
                'subtitle' => 'Adjunta evidencia de la transferencia',
                'name_field' => 'anverso',
                'id_field' => '1',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'dropzone',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-model',
                'id_field' => 'action-model',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'delivery',
                'col' => 'col-12'
            ],
            
            6 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-id_rel',
                'id_field' => 'action-id_rel',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => $id_rel,
                'col' => 'col-12'
            ],
            7 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect',
                'id_field' => 'url_redirect',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/template/steps/delivery/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            8 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=1_'.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
            9 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'step',
                'id_field' => 'step',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 1,
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    
    public function configDynamicFormStep1Task1($id_rel, $history_id, $taskId)
    {
        $name_form    = 'frm-template_delivery_dynamic_task_step1';
        $type_form    = HistoryLog::KC_DELIVERY__DYNAMIC_TASK_STEP2;
        $credit       = Credit::find($id_rel);
        $client = $credit->creditClientPerson;

        $product = FinancialProduct::find($credit->applied_financial_product);

        $stepRedirect = $taskId +1;
        $client_person = $credit->creditClientPerson;
        $taks = self::ElementsTaskStep1($history_id, null);
        $templateId = $taskId -1;
        $task = $taks[$templateId];
        
        $templateId = $task['id'];


        $payOff = CreditPayOff::find($task['id']);
        


        $contentInfo = \View::make('panel.client.infoClient', ['client' => $client, 'taskId' => 6, 'credit' => $credit, 'payOff' => $payOff])->render();

        $elements = array(
            1 => [
                'title_section' => '',
                'title' => null,
                'subtitle' => null,
                
                'id_field' => 'deadline_date',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'col' => 'col-12',
                'type' => 'div',
                'content' => $contentInfo,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            2 => [
                'title_section' => null,
                'title' => '*Entrega '.$product->alias,
                'subtitle' => ' Indica si se ha hecho la transferencia correctamente',
                'name_field' => null,
                'id_field' => 'ammount',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'radio',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-6',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'name' => 'Valida',
                        'name_field' =>  'credit_pay_off[delivered]',
                        'class' => null,
                        'onclick' => null,
                        'value' => 1,
                        'is_required' => true,
                    ),
                    1 => array(
                        'link' => null,
                        'name' => 'Invalida',
                        'name_field' => 'credit_pay_off[delivered]',
                        'class' => null,
                        'onclick' => null,
                        'value' => 0,
                        'is_required' => true,
                        
                    ),
                )
            ],
            3 => [
                'title_section' => '',
                'title' => 'Fecha de entrega',
                'subtitle' => 'indica la fecha en la que se hizo la transferencia.',
                'name_field' => 'credit_pay_off[delivered_date]',
                'id_field' => 'delivered_date',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'date',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => null
            ],
            4 => [
                'title_section' => null,
                'title' => '*Comprobante de entrega',
                'subtitle' => 'Adjunta evidencia de la transferencia',
                'name_field' => 'anverso',
                'id_field' => $taskId,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'dropzone',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-model',
                'id_field' => 'action-model',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'delivery',
                'col' => 'col-12'
            ],
            
            6 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-id_rel',
                'id_field' => 'action-id_rel',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => $id_rel,
                'col' => 'col-12'
            ],
            7 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect',
                'id_field' => 'url_redirect',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/template/steps/delivery/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            8 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=1_'.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
            9 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'step',
                'id_field' => 'step',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 1,
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }


    public function configFormstep2($id_rel, $history_id)
    {
        $credit           = Credit::find($id_rel);
        $history          = HistoryLog::find($history_id);
        $name_form        = 'frm-template_delivery_step2';
        $type_form        = HistoryLog::KC_DELIVERY_FORM_STEP_2;
        $status_id        = HistoryLog::KC_DELIVERY_FORM_STEP_3;
        $status_cancel    = HistoryLog::CREDIT_CANCELED;
        $old_status       = $history->old_status_id;
        $status_reject    = HistoryLog::CREDIT_REJECTED;
        $url_finish       = '/panel/template/steps/delivery/'.$history_id.'/show';

        $elements = array(

            0 => [
                'title_section' => 'Confirmar firma',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],

            1 => [
                'title_section' => null,
                'title' => 'Docs. Firmados',
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'href',
                'link' => null,
                'onclick' => 'deliveryFinish('.$history_id.', '.$status_id.',"'.$url_finish.'", false)',
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'col' => 'col-12 col-md-4'
            ],
            2 => [
                'title_section' => null,
                'title' => 'Cancelar credito',
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'href',
                'link' => null,
                'onclick' => 'moveModal("Cancelar", '.$credit->id.', '.$status_cancel.', '.$old_status.', "dt-delivery")',
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'col' => 'col-12 col-md-4'
            ],
            3 => [
                'title_section' => null,
                'title' => 'Rechazar crédito',
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'href',
                'link' => null,
                'onclick' => 'moveModal("Rechazar", '.$credit->id.', '.$status_reject.', '.$old_status.', "dt-delivery")',
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'col' => 'col-12 col-md-4'
            ],
            
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form, 'show_btn' => false])->render();
        return $list;
    }

    
    
    
    
    

    public function saveForm($request)
    {
        $id_rel   = $request->id_rel;
        $credit   = Credit::find($id_rel);
        $history  = HistoryLog::find($request->history_id);

        $urlRedirect = isset($request->url_redirect_next) ? $request->url_redirect_next : null;
        $step = null;
        $task = null;
        $getTask = null;

        if ($urlRedirect) {
            // Extraer la parte de consulta de la URL
            $query = parse_url($urlRedirect, PHP_URL_QUERY);

            // Parsear los parámetros de la consulta
            parse_str($query, $params);

            // Obtener el valor de 'step' si existe
            if (isset($params['step'])) {
                $stepValue = $params['step'];

                // Verificar si contiene un guion bajo "_"
                if (strpos($stepValue, '_') !== false) {
                    list($step, $task) = array_map('intval', explode('_', $stepValue));
                } else {
                    $step = intval($stepValue);
                    $task = null;
                }
            }
        }
        if ($task != null) {
            $task = $task -1;

        }


        if ($request->credit) {
            $data_credit = $request->credit;
            if (isset($data_credit['changed_commission'])) {
                $data_credit['changed_commission'] = $data_credit['changed_commission'] * 100;
            }
            $credit->fill($data_credit);
            $credit->update();
        }

        $client = ClientPerson::find($credit->client_person_id);
        if ($request->client_person) {
            $data_client_person = $request->client_person;
            $client->fill($data_client_person);
            $client->update();
        }
        
        if ($history != null) {
            if ($step == 1) {
                if ($task == 1) {
                    $percentTask1Step1  = self::percentTask1Step1($history);
                    
                    if ($percentTask1Step1 == 100) {
                        HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_TASK1_STEP1, $credit->id, 1); //terminar tarea1
                        //iniciar tarea 2 etapa 1
                        HistoryLog::move($credit->id, HistoryLog::KC_DELIVERY__DYNAMIC_TASK_STEP2, HistoryLog::KC_DELIVERY__DYNAMIC_TASK_STEP2, null, false);
                        HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY__DYNAMIC_TASK_STEP2, $credit->id, 0);
                        
                       /*  $notification_add   = SendNotificationsValues::STRATEGY['pushCreditKcDelivery'];
                        (new $notification_add)->send($credit->id); */
                    }
                }
                if ($task > 1) {
                    $taskId = $task -1;
                    //recorrer las tareas dinamicas y ver su porcentaje
                    $elementsStep1 = self::ElementsTaskStep1($request->history_id);
                    $getTask = $elementsStep1[$taskId];

                    $dataPayOff = $request->credit_pay_off;
                    CreditPayOff::where('id', $getTask['id'])->update($dataPayOff);
                    $percent =  self::percentDynamicTaskStep1($history, $getTask['id'], $task);

                    if ($percent == 100) {
                        HistoryLog::where([
                            'is_credit' => 1,
                            'id_rel' => $id_rel,
                            'status_id' => HistoryLog::KC_DELIVERY__DYNAMIC_TASK_STEP2,
                            'status' => 1,
                        ])->update([
                            'dynamic_status_id' => $getTask['id']
                        ]);

                       
                    }

                    if ($task  == count($elementsStep1)) {
                            
                        HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY__DYNAMIC_TASK_STEP2, $credit->id, 1); //terminar tarea1
                        //iniciar tarea 2 etapa 1
                        HistoryLog::move($credit->id, HistoryLog::KC_DELIVERY_TASK1_STEP2, HistoryLog::KC_DELIVERY_TASK1_STEP2, null, false);
                        HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_TASK1_STEP2, $credit->id, 0);
                    }
                    
                   
                }
            }
        }
    }

    public function getUrlActionInProgress($acion_in_progress, $history)
    {
        $url = array(
            'Información del crédito' => '/panel/action-form/delivery/'.$history->id.'/form?step=1',
            'Confirmar firma' => '/panel/action-form/delivery/'.$history->id.'/form?step=2',
            'Resolución de análisis' => '/panel/action-form/delivery/'.$history->id.'/form?step=3',
            'Confirmar entrega' => '/panel/action-form/delivery/'.$history->id.'/form?step=4',
            
        );
        return $url[$acion_in_progress];
    }

    public function listStep($history_id)
    {
        $history              = HistoryLog::find($history_id);

        $credit               = $history->historyCredit;
        $max_hour             = 12;
        $hour                 = $credit->created_at;
        
        $percent_form_step1   = reduceDecimal(self::percentForm($history));
        
        $percentStep2         = reduceDecimal(self::percentStep2($credit->id));
        $percent_form_step3   = reduceDecimal(self::percentFormStep3($credit->id));
        $percent_form_step4   = reduceDecimal(self::percentFormStep4($credit->id));

        $color_inf_credit     = 'success';
        $option_step2         = null;
        $option_step3         = null;
        
        //$percent_form = $percent_form;
        $menu_options         = self::menuOptionsStep($history);
        $status_step1         = $percent_form_step1 == 100? 'Concluido' : 'En curso';
        $status_step2         = 'En espera';
        $status_step3         = 'En espera';
        $status_step4         = 'En espera';

        $option_step2         = null;
        $option_step3         = null;
        $option_step4         = null;

        //TODO: change validation when the decision action is carried out in the report
        if ($status_step1 == 'Concluido') {
            $status_step2 = ($percentStep2 >= 100) ? 'Concluido' : 'En curso';
            $option_step2               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep2']])->render();
        }
        if ($status_step2 == 'Concluido') {
            $status_step3 = ($percent_form_step3 >= 100) ? 'Concluido' : 'En curso';
            $option_step3               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep3']])->render();
        }
       
        if ($status_step3 == 'Concluido') {
            $status_step4 = ($percent_form_step4 >= 100) ? 'Concluido' : 'En curso';
            $option_step4               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep4']])->render();
        }

        $data_deadline              = deadline($hour, $max_hour, $percentStep2, $color_inf_credit);
        $color_inf_credit           = $data_deadline['color'];
        $hour                       = $data_deadline['lbl_hour'];
        $option_step1               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();
        
        
        $view_percent_inf_credit    = 'N/A';
        $view_percent_step1         = \View::make('panel.module.view_percent', ['percent' => $percent_form_step1])->render();
        $view_percent_step2         = \View::make('panel.module.view_percent', ['percent' => $percentStep2])->render();
        $view_percent_step3         = \View::make('panel.module.view_percent', ['percent' => $percent_form_step3])->render();
        $view_percent_step4         = \View::make('panel.module.view_percent', ['percent' => $percent_form_step4])->render();

        $view_count_inf_credit      = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_count_step2           = \View::make('panel.module.view_count', ['number' => 'Dos'])->render();
        $view_count_step3           = \View::make('panel.module.view_count', ['number' => 'Tres'])->render();
        $view_count_step4           = \View::make('panel.module.view_count', ['number' => 'Cuatro'])->render();


        $data = array();
        $data[] = array(
            'nameStep' => 'Entrega',
           
        );
        
        $data[] = array(
            'nameStep' => 'Activación',
            
        );
       
        
       
        return $data;
    }

    public function moduleDeadline($history)
    {
        $max_hour           = 74;
        $percent            = self::getPercent($history);
        $color_inf_credit   = 'success';
        $hour               = $history->created_at;
        $data_deadline      = deadline($hour, $max_hour, $percent, $color_inf_credit);
        $color_inf_credit   = $data_deadline['color'];
        $hour               = $data_deadline['lbl_hour'];
        $view_deadline      = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_deadline;
    }

    public function listAction($history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == 2) {
            return self::actionStep2($history_id);
        } elseif ($step == 3) {
            return self::actionStep3($history_id);
        } elseif ($step == 4) {
            return self::actionStep4($history_id);
        }
        return self::actionStep1($history_id);
    }

    public function listActionByStep($history_id, $step)
    {
        
        if ($step == 2) {
            return null;
            return self::actionStep2($history_id);
        }
        return self::actionStep1($history_id);
    }

    public function percentTask1Step1($history)
    {
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $fields = ['delivered', 'delivered_date'];
        
        if ($client === null) {
            return 0; // Si no hay cliente, el porcentaje es 0.
        }
    
        // Contar los campos no nulos.
        $elements = count(array_filter($fields, fn($field) => !empty($credit->$field)));
        //calcular si adjunto imagen
        $file = File::where([
            'model' => HistoryLog::KC_DELIVERY,
            'id_rel' => $credit->id,
            'step' => 1,
            'template_config_id' => 1,
        ])->count();

        $elements = $file == 0 ? $elements : $elements + 1; 
        // Calcular el porcentaje completado.
        
        $total = count($fields) + 1;
        $percent = ($elements / $total) * 100;
    
        return $percent;
    }
    
    public function percentDynamicTaskStep1($history, $creditPayOffId, $taskId)
    {
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $fields = ['delivered', 'delivered_date'];
        $payOff = CreditPayOff::find($creditPayOffId);
        
        if ($client === null) {
            return 0; // Si no hay cliente, el porcentaje es 0.
        }
    
        // Contar los campos no nulos.
        $elements = count(array_filter($fields, fn($field) => !empty($payOff->$field)));
        //calcular si adjunto imagen
        $file = File::where([
            'model' => HistoryLog::KC_DELIVERY,
            'id_rel' => $credit->id,
            'step' => 1,
            'template_config_id' => $taskId,
        ])->count();
        
        
        
        $elements = $file == 0 ? $elements : $elements + 1; 
        // Calcular el porcentaje completado.
        
        $total = count($fields) + 1;
        $percent = ($elements / $total) * 100;
    
        return $percent;
    }

    public function percentForm($history)
    {
        $percent_form = 0;
        try {
            $credit                       = $history->historyCredit;
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_DELIVERY_TASK1_STEP1], $credit->id)[0];
            $percent_form                 = $in_progress->status_progress == 1 ? 100 : 0;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $percent_form;
    }
    
    public function deadLineStep1($history)
    {
        
        try {
            $color_inf_credit             = 'success';
            $credit                       = $history->historyCredit;
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_DELIVERY_TASK1_STEP1], $credit->id, 0)[0];
            $percent_form                 = self::percentForm($history);
            $max_hour                     = self::HOUR_STEP_1;
            $hour                         = $history->created_at;
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];
            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            return $view_dead_line_inf_credit;
        } catch (\Exception $th) {
            //throw $th;
        }
        return null;
    }

    public function actionStep1($history_id, $step_origin = null)
    {
        return self::ElementsTaskStep1($history_id, $step_origin);
        /* $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_form   = self::percentForm($history);
        
        $status_file    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $name_advisor   = null;
        

        try {
            $user = User::find($advisor->id);
            $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
            if ($advisor->id == Auth::user()->id) {
                $name_advisor = 'Tú';
            }
        } catch (\Exception $th) {
        //throw $th;
        }
        $menu_options   = self::menuOptions($history, 1);
        $view_dead_line  = self::deadLineStep1($history);

        $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        

        $data = array();

        $subject1 = HistoryLog::$label_subject[31];
        $viewStatus1= \View::make('panel.module.status', ['status' => $status_file])->render();

        $data[] = array(
            'name' => 'API',
            'subject' => $subject1,
            'status' => $viewStatus1,
            'deadline' => $view_dead_line,
            'advisor' => $name_advisor,
            'options' => $file_option,
            'link' => '/panel/action-form/delivery/'.$history_id.'/form?step=1'
        );
        return $data; */
    }

    public function ElementsTaskStep1($history_id, $step_origin = null)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percentages    = [
            1 => self::percentTask1Step1($history),
        ];
        $helpText    = [
            1 => 'Adjunta la parte delantera de la INE',
        ];
       
        
        $name_advisor = null;
        try {
            $user = User::find($advisor->id);
            $role = isset(User::$alias_role[$user->getRoleNames()[0]]) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor = $advisor->id == Auth::user()->id ? 'Tú' : $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        } catch (\Exception $th) {
            // No advisor data available.
        }

        $menu_options   = self::menuOptions($history, 1, $step_origin);
        $view_dead_line_form    = self::deadLineStep1($history);

        $data = [];
        $subjects = [
            1 => HistoryLog::$label_subject[HistoryLog::KC_DELIVERY_TASK1_STEP1],
            
        ];
        $currentTaskInProgress = false;
        $statuses = [];
        foreach ($percentages as $index => $percent) {
            $statuses[$index] = $currentTaskInProgress ? 'null' : ($percent >= 100 ? 'Concluido' : 'En curso');
            if ($statuses[$index] === 'En curso') {
                $currentTaskInProgress = true;
            }
        }
        $currentTaskInProgress = false;


        for ($i = 1; $i <= 1; $i++) {
            
            $data[] = [
                'name' => "{$i}- " . ($subjects[$i]),
                'subject' => null ,
                'helpText' => $helpText[$i],
                'status' => $statuses[$i],
                'statusBadge' => $statuses[$i] === 'null' ? null : \View::make('panel.module.status', ['status' => $statuses[$i]])->render(),
                'advisor' => $name_advisor,
                'link' => "/panel/action-form/delivery/{$history_id}/form?step=1_{$i}&step_origin=null",
                'id' => null,
                'count_id' => $i,


            ];
        }
        
        // Verifica si todas las etapas iniciales tienen el estado "Concluido"
        $allStagesConcluded = collect($statuses)->every(fn($status) => $status === 'Concluido');

        // Handle dynamic tasks
        $CreditPayOff = CreditPayOff::select('financial_products.name', 'financial_products.id')
            ->join('financial_products', 'financial_products.id', 'credit_pay_off.financial_product_id')
            ->where(['new_kc_credit_id' => $credit->id])
            ->get();

        $dynamicIndex = 2;
        foreach ($CreditPayOff as $creditPayOff) {

            $dynamicPercent = self::percentDynamicTaskStep1($history, $creditPayOff->id, $dynamicIndex);
            // Asigna el estado dinámico dependiendo de la condición de todas las etapas previas
            $dynamicStatus = $currentTaskInProgress ? 'null' : ($dynamicPercent >= 100 ? 'Concluido' : 'En curso');

            if ($dynamicStatus === 'En curso') {
                $currentTaskInProgress = true;
            }

            $data[] = [
                'name' => "{$dynamicIndex}- Entrega {$creditPayOff->name}",
                'subject' => " " . $creditPayOff->name,
                'helpText' => 'Adjunta el documento ' . $creditPayOff->name,
                'status' => $dynamicStatus,
                'statusBadge' => $dynamicStatus === 'null' ? null : \View::make('panel.module.status', ['status' => $dynamicStatus])->render(),
                'deadline' => $view_dead_line_form,
                'advisor' => $name_advisor,
                'link' => "/panel/action-form/delivery/{$history_id}/form?step=1_{$dynamicIndex}&step_origin=null",
                'id' => $creditPayOff->id,
                'count_id' => $dynamicIndex,
                
            ];

            $dynamicIndex++;
        }
        return $data;
    }

    public function ElementsTaskStep2($history_id, $step_origin = null)
    {

    }

    public function deadLineStep2($history)
    {
        try {
            $credit         = $history->historyCredit;
            $color_inf_credit             = 'success';
            $percent_form                 = self::percentStep2($credit->id);
            /* if ($percent_form == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_2, $credit->id, 1);
                //*inicializar las acciones de la siguiente etapa en curso
                HistoryLog::move($credit->id, HistoryLog::KC_DELIVERY_FORM_STEP_3, HistoryLog::KC_DELIVERY_FORM_STEP_3, null, false);
                HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_3, $credit->id, 0);
            } */
            $max_hour                     = self::HOUR_STEP_2;
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_DELIVERY_FORM_STEP_2], $credit->id)[0];
            $hour                         = $in_progress->date_status_progress;
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];
            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            return $view_dead_line_inf_credit;
        } catch (\Exception $th) {
            //throw $th;
        }
        return null;
    }

    public function actionStep2($history_id)
    {

        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_form   = self::percentStep2($credit->id);
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $name_advisor   = null;
        
        try {
            $user                         = User::find($advisor->id);
            $role                         = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor                 = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
            if ($advisor->id == Auth::user()->id) {
                $name_advisor = 'Tú';
            }
        } catch (\Exception $th) {
        //throw $th;
        }

        $menu_options                 = self::menuOptions($history, 2);
        
        $view_dead_line_step2         = self::deadLineStep2($history);

        $form_option                  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form2']])->render();
        $form_option_2                = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        
        $status_file    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $data = array();

        $subject1 = HistoryLog::$label_subject[32];
        $viewStatus1= \View::make('panel.module.status', ['status' => $status_file])->render();

        $data[] = array(
            'name' => 'API',
            'subject' => $subject1,
            'status' =>  $viewStatus1,
            'deadline' => $view_dead_line_step2,
            'advisor' => $name_advisor,
            'options' => $form_option_2,
            'link' => '/panel/action-form/delivery/'.$history_id.'/form?step=2'
        );
        return $data;
    }

    public function deadLineStep3($history)
    {
        try {
            $credit                       = $history->historyCredit;
            $color_inf_credit             = 'success';
            $percent_form                 = self::percentFormStep3($credit->id);
            $max_hour                     = self::HOUR_STEP_3;
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_DELIVERY_FORM_STEP_3], $credit->id)[0];
            $hour                         = $in_progress->date_status_progress;
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];
            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            return $view_dead_line_inf_credit;
        } catch (\Exception $th) {
            return null;
        }
    }

    public function actionStep3($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_form   = self::percentFormStep3($credit->id);
        $status_form    =  $percent_form == 100 ? 'Concluido' : 'En curso';
        $name_advisor   = null;

        try {
            $user = User::find($advisor->id);
            $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
            if ($advisor->id == Auth::user()->id) {
                $name_advisor = 'Tú';
            }
        } catch (\Exception $th) {
            //throw $th;
        }

        $menu_options   = self::menuOptionsStep3($history);
        $view_dead_line_inf_credit  = self::deadLineStep3($history);
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        

        $data = array();
        $subject1 = HistoryLog::$label_subject[34];
        $viewStatus1= \View::make('panel.module.status', ['status' => $status_form])->render();

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' => $viewStatus1,
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $form_option,
            'link' => '/panel/action-form/delivery/'.$history_id.'/form?step=3'
        );
        return $data;
    }

    public function deadLineStep4($history)
    {
        try {
            $credit                       = $history->historyCredit;
            $color_inf_credit             = 'success';
            $percent_form                 = self::percentFormStep4($credit->id);
            $max_hour                     = self::HOUR_STEP_4;
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_DELIVERY_FORM_STEP_4], $credit->id)[0];
            $hour                         = $in_progress->date_status_progress;
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];
            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            return $view_dead_line_inf_credit;
        } catch (\Exception $th) {
            //throw $th;
        }
        return null;
    }
    
    public function actionStep4($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_form                 = self::percentFormStep4($credit->id);
        $status_form    =  $percent_form == 100 ? 'Concluido' : 'En curso';
        $name_advisor   = null;

        try {
            $user = User::find($advisor->id);
            $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
            if ($advisor->id == Auth::user()->id) {
                $name_advisor = 'Tú';
            }//code...
        } catch (\Exception $th) {
            //throw $th;
        }

        $menu_options   = self::menuOptionsStep4($history);

        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        
        
        $view_dead_line_inf_credit  = self::deadLineStep4($history);
        $data = array();
        
        $subject1 = HistoryLog::$label_subject[33];

        $viewStatus1= \View::make('panel.module.status', ['status' => $status_form])->render();
        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' =>  $viewStatus1,
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $form_option,
            'link' => '/panel/action-form/delivery/'.$history_id.'/form?step=4'
            
        );

        return $data;
    }
    
    

    public function listStepReport($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $max_hour       = 12;
        $hour           = $credit->created_at;
        $menu_options   = self::menuOptionReportStep($history);
        $advisor        = $credit->creditAdvisor;

        $name_module_response   = 'KaaxClub';
        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
        $color_desition   = 'success';
        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;

        $data_deadline    = deadline($hour, $max_hour, 0, 'success');
        $color_desition = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        $view_dead_line_desition  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_desition])->render();
        $options_progress  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['progress']])->render();
        $options_desition  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['desition']])->render();

        $data = array();
        $status_desition = 'En curso';
        $data[] = array(
            'name' => 'Respuesta de módulo',
            'status' => 'Concluida',
            'deadline' => 'N/A',
            'advisor' => $name_module_response,
            'options' => $options_progress,
        );

        $data[] = array(
            'name' => 'Decisión',
            'status' => $status_desition,
            'deadline' => $view_dead_line_desition,
            'advisor' => $name_advisor,
            'options' => $options_desition,
        );

        return $data;
    }

    public function dinamicDeadline($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent   = self::percentFile($credit->id);
        $in_progress        = HistoryLog::getByStatus([$history->status_id], $credit->id)[0];
        $hour               = $in_progress->date_status_progress;

        $menu_options   = self::menuOptions($history, 2);
        $menu  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form2']])->render();
        

        if ($history->status_id == HistoryLog::KC_DELIVERY_FORM_STEP_3) {
            $percent         = self::percentFormStep3($credit->id);
            $menu_options   = self::menuOptionsStep3($history);
            $menu  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        }

        $view_dead_line     = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return array('deadline' => $view_dead_line, 'percent' => $percent, 'menu' => $menu);
    }

    public function menuOptions($history, $step = 1)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/delivery/' . $history->id . '/form?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/template/action-document/delivery/' . $history->id . '?step='.$step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => null,
                    'onclick' => null,
                    'name' => null,
                    'icon' => null
                ]
            ),
        );

        return $menu;
    }

    public function menuOptionsStep3($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/delivery/' . $history->id . '/form?step=3',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/action-form/delivery/' . $history->id . '/form?step=3_2',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/template/action-document/delivery/' . $history->id . '?step=3',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

            )
        );

        return $menu;
    }
    
    public function menuOptionsStep4($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/delivery/' . $history->id . '/form?step=4',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
        );

        return $menu;
    }
    
    public function menuOptionsStep5($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/delivery/' . $history->id . '/form?step=5',
                    'onclick' => '',
                    'name' => 'Ver tareas',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
        );

        return $menu;
    }

    public function menuOptionsStep($history, $type_lbl = 1)
    {
        $lbl_action = $type_lbl === 1 ? 'Lista de tareas' : 'Ver tareas';
        $menu = array(
            'actionstep1' => array(
                [
                    'link' => '/panel/template/actions/delivery/' . $history->id . '/show?step=1',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep2' => array(
                [
                    'link' => '/panel/template/actions/delivery/' . $history->id . '/show?step=2',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep3' => array(
                [
                    'link' => '/panel/template/actions/delivery/' . $history->id . '/show?step=3',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep4' => array(
                [
                    'link' => '/panel/template/actions/delivery/' . $history->id . '/show?step=4',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),

        );

        return $menu;
    }

    public function menuOptionReportStep($history)
    {
        $menu = array(
            'progress' => array(
                [
                    'link' => '/panel/kc-check-up/report/answer_module/' . $history->id . '/show/',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut',
                ]
            ),
            'desition' => array(
                [
                    'link' => '/panel/kc-check-up/report/desition/' . $history->id . '/show/',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut',
                ]
            )
        );
        return $menu;
    }

   

    public function percentUploadStep2($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $total_valid = 0;
        if ($credit != null && $credit->applied_financial != '') {
            $total_valid = $total_valid + 10;
        }

        if ($credit != null && $credit->applied_financial_product != null) {
            $total_valid = $total_valid + 10;
        }

        if ($credit != null && $credit->applied_loan_type != null) {
            $total_valid = $total_valid + 10;
        }

        if ($credit != null && $credit->applied_import != null) {
            $total_valid = $total_valid + 10;
        }

        if ($credit != null && $credit->applied_term != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_periodicity != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_payment != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_loan_total_amount != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_interest_rate != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_CAT != null) {
            $total_valid = $total_valid + 10;
        }
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    public function percentFormStep3($credit_id)
    {
        $credit = Credit::find($credit_id);
        return ($credit != null && $credit->approved == 1) ? 100 : 0;
    }
    
    public function percentFormStep4($credit_id)
    {
        $credit = Credit::find($credit_id);
        return ($credit != null && $credit->delivered == 1) ? 100 : 0;
    }

    

    //* get all percentages of the shares
    public function getPercent($history, $show_current_show = false)
    {
        $credit     = $history->historyCredit;
        $data_actions = array(
            HistoryLog::KC_DELIVERY_TASK1_STEP1,
           /*  HistoryLog::KC_DELIVERY_FORM_STEP_3,
            HistoryLog::KC_DELIVERY_FORM_STEP_4, */
        );
        
        $get_actions = HistoryLog::getByStatus($data_actions, $credit->id);
        $status_progress = 0;
        $current_show = null;

        foreach ($get_actions as $key => $get_action) {
            $status = $get_action->status_progress;
            $status_progress += $status != null ? $status : 0;
        }
        
        if ($status_progress == 0) {
            $current_show = 'Enviar info a s2';
        }  elseif ($status_progress > 1) {
            $current_show = 'Activar crédito';
        }
        //dd($status_progress, $current_show);
        $percent =  (($status_progress) / 2) * 100;

        if ($show_current_show == true) {
            return $current_show;
        }
        
        return reduceDecimal($percent);
    }

    public function getlblStatusApi($history)
    {
        $credit               = $history->historyCredit;
        $percent_form_step1   = self::percentForm($history);
        $percentStep2         = self::percentStep2($credit->id);
        $percent_form_step3   = self::percentFormStep3($credit->id);
        $percent_form_step4   = self::percentFormStep4($credit->id);
        $status_step1         = $percent_form_step1 == 100 && $percentStep2 == 100? 'CONCLUIDA' : 'EN CURSO';
        $total_percent        = ($status_step1 ==  'CONCLUIDA') ? 75 : 60;

        $status_step2         = 'EN ESPERA';
        $status_step3         = 'EN ESPERA';
        if ($status_step1 == 'CONCLUIDA') {
            $status_step2 = ($percent_form_step3 >= 100) ? 'CONCLUIDA' : 'EN CURSO';
            $total_percent = ($percent_form_step3 >= 100) ? 90 : 75;
        }
        if ($status_step2 == 'CONCLUIDA') {
            $status_step3 = ($percent_form_step4 >= 100) ? 'CONCLUIDA' : 'EN CURSO';
            $total_percent = ($percent_form_step4 >= 100) ? 100 : 90;
        }
    
        

        $data_lbl = array(
            'Firma de documentos' => $status_step1,
            'Analisís de todo el crédito' => $status_step2,
            'Entrega de crédito' => $status_step3,
        );
        return array('lbl' => $data_lbl, 'total_percent' => $total_percent);
    }

    public function getFile($template_config_id)
    {
        $config = self::configUpload()[$template_config_id];
        return $config;
    }

    public function percentStep2($credit_id)
    {
        $credit = Credit::find($credit_id);
        return ($credit != null && $credit->credit_signed == 1) ? 100 : 0;
    }

    //*TODO: se deshabilito al ser opcional la caja de carga
    public function percentFile($id_rel)
    {
        $model = File::MODEL['delivery'];
        $percent = 0;
        $total_valid = 1;
        $count_file = 0;
        $percent_file = 0;
        $config_files = self::configUpload();
        
        foreach ($config_files as $key => $config_file) {
            $file = File::where([
                'model' => $model,
                'id_rel' => $id_rel,
                'template_config_id' => $key,
            ])
                ->first();
            if ($file != null && $config_file['is_required'] == true) {
                $count_file = $count_file + 1;
                $percent_file = $percent_file + 100;
            }
        }

        $percent =  (100 / 100) * $percent_file;
        return $percent;
    }

    

    public function menuPrincipalOptions($history)
    {
        $credit           = $history->historyCredit;
        $client           = $credit->creditClientPerson;
        $status_cancel    = HistoryLog::CREDIT_CANCELED;
        $status_reject    = HistoryLog::CREDIT_REJECTED;
        $status_archive   = HistoryLog::CREDIT_ARCHIVE;
        $old_status       = $history->old_status_id;
        $is_user_financial = Auth::user()->hasRole('Cliente financiera');
        if ($is_user_financial === true ) {
            $menu = array(
                'options' => array(
                    [
                        'link' => '/credit-resume/'.$credit->id,
                        'onclick' => '',
                        'name' => 'Ver resumen',
                        'icon' => 'icon ni ni-list-round'
                    ],
                   
                ),
            );
        } else {

            $menu = array(
                'options' => array(
                    [
                        'link' => '/panel/template/steps/delivery/'.$history->id.'/show',
                        'onclick' => '',
                        'name' => 'Ver etapas',
                        'icon' => 'icon ni ni-list-thumb-fill',
                        'class' => 'text-dark'
                    ],
                    [
                        'link' => '/panel/client/'.$client->id,
                        'onclick' => '',
                        'name' => 'Ver perfil cliente',
                        'icon' => 'icon ni ni-user-fill'
                    ],
                    [
                        'link' => '/panel/credit/'.$credit->id,
                        'onclick' => '',
                        'name' => 'Ver perfil crédito',
                        'icon' => 'icon ni ni-report-profit'
                    ],

                    [
                        'link' => 'https://manychat.com/fb861553/chat/'.$credit->manychat_id,
                        'target' => '_blank',
                        'onclick' => '',
                        'name' => 'ManyChat',
                        'icon' => 'icon ni ni-chat-circle'
                    ],
                    
                    [
                        'link' => null,
                        'onclick' => 'moveModal("Cancelar",'.$credit->id.','.$status_cancel.','.$old_status.',"dt-delivery")',
                        'name' => 'Cancelar',
                        'icon' => 'icon ni ni-cross-circle-fill'
                    ],
                    [
                        'link' => null,
                        'onclick' => 'moveModal("Rechazar",'.$credit->id.','.$status_reject.','.$old_status.',"dt-delivery")',
                        'name' => 'Rechazar',
                        'icon' => 'icon ni ni-cross-round-fill'
                    ],
                    [
                        'link' => null,
                        'onclick' => 'moveModal("Archivar",'.$credit->id.','.$status_archive.','.$old_status.',"dt-delivery")',
                        'name' => 'Archivar',
                        'icon' => 'icon ni ni-archive-fill'
                    ],
                    [
                        'link' => '/credit-resume/'.$credit->id,
                        'onclick' => '',
                        'name' => 'Ver resumen',
                        'icon' => 'icon ni ni-list-round'
                    ],
                   
                    [
                        'link' => null,
                        'onclick' => 'concluir('.$history->id.')',
                        'name' => 'Concluir',
                        'icon' => 'icon ni ni-list-round'
                    ],
                ),
            );
        }
        
        return $menu;
    }

    private function getTitles($history)
    {
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $task = null;
        $titles = array();
        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $task) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }
        
        if ($step == 1) {
            $elements = self::ElementsTaskStep1($history->id);
            $totalTaks = count($elements);
            
            $step = isset($_GET['step']) ? $_GET['step'] : null;
            foreach ($elements as $key => $element) {
                $titles[$key + 1] = 'E1/2 - T'.$step.'-'.$totalTaks.$element['subject'];
            }
        }
        if ($step === 2) {
            
            $elements = self::ElementsTaskStep2($history->id);
            /* $totalTaks = count($elements);
            $titles = array();
            $step = isset($_GET['step']) ? $_GET['step'] : null;
            foreach ($elements as $key => $element) {
                $titles[$key + 1] = 'E2/4 - T'.$task.'-'.$totalTaks.$element['subject'];
            } */
            
        }
        
        
      
        return $titles;
    }

    public function optionBreadcumbStep($history)
    {
        $breadcumbs = array(
            0 => array(
             'title' => 'Inicio',
             'link' => '/panel/home',
             'active' => null
            ),
            1 => array(
             'title' => 'KC - Delivery',
             'link' => '/panel/delivery',
             'active' => null
            ),
            2 => array(
             'title' => 'etapas',
             'link' => null,
             'active' => true
            ),
         );
         return $breadcumbs;
    }
    
    public function optionBreadcumblistAction($history)
    {
        $breadcumbs = array(
            0 => array(
             'title' => 'Inicio',
             'link' => '/panel/home',
             'active' => null
            ),
            1 => array(
             'title' => 'KC - Delivery',
             'link' => '/panel/delivery',
             'active' => null
            ),
            2 => array(
                'title' => 'etapas',
                'link' => '/panel/template/steps/delivery/'.$history->id.'/show',
                'active' => true
            ),
            3 => array(
                'title' => 'tareas',
                'link' => null,
                'active' => true
               ),
         );
         return $breadcumbs;
    }

    public function optionSteps($history)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;

        $breadcumbs = array(
            0 => array(
             'title' => 'Inicio',
             'link' => '/panel/home',
             'active' => null
            ),
            1 => array(
             'title' => 'KC - Delivery',
             'link' => '/panel/delivery',
             'active' => null
            ),
            2 => array(
             'title' => 'etapas',
             'link' => '/panel/template/steps/delivery/'.$history->id.'/show',
             'active' => null
            ),
           
         );
         return $breadcumbs;
    }

    public function breadcrumb($history, $type = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == null) {
            $breadcumbs = self::optionBreadcumbStep($history);
        }
        if ($type == 2) {
            $breadcumbs = self::optionBreadcumblistAction($history);
        } else {
            if ($step == 1 || $step == 2 || $step == 3 || $step == 4) {
                $breadcumbs = self::optionSteps($history);
            }
        }

        
        
        $view_breadcumb    = \View::make('panel.module.breadcumb', ['breadcumbs' => $breadcumbs])->render();
        return $view_breadcumb;
    }

    public function setTitle($history)
    {
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $task = null;

        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $task) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }

        $titles = $this->getTitles($history);
        if ($task == null) {
            return isset($titles[$step]) ? $titles[$step] : 'Acción formulario';
        }
        if ($task != null) {
            return isset($titles[$task]) ? $titles[$task] : 'Acción formulario';
        }
    }

    
}
