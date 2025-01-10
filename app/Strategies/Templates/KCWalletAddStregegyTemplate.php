<?php

namespace App\Strategies\Templates;

use App\Lib\Csendgrid;
use App\Models\File;
use App\Models\HistoryLog;
use App\Models\Investor;
use App\Models\Transaction;
use App\Models\User;
use App\Strategies\TemplateInterface;
use Illuminate\Support\Facades\Auth;
use ParagonIE\Sodium\Core\Curve25519\H;

class KCWalletAddStregegyTemplate implements TemplateInterface
{
    const HOUR_STEP_1  = 0;
    const HOUR_STEP_1_2  = 24;
    const HOUR_STEP_2  = 8;
    const HOUR_STEP_2_2  = 1;

    public function setURLDocument($id_rel = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        $is_investor = Auth::user()->hasRole('Cliente inversionista');

        if ($step == '1_2' && $is_investor === true) {
            if ($is_investor === true) {
                return '/panel/kc-wallet?alert=true';
            }
            return null;
        }
        /* if ($step == '2') {
            return '/panel/template/steps/wallet/'.$id_rel.'/show';
        } */
        return null;
    }

    private function getTitlesFiles()
    {
        $titles = array(
            '1_2' => HistoryLog::$label_subject[62],
            '2' => HistoryLog::$label_subject[64],
        );
        return $titles;
    }

    public function setTitleDocument()
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        $titles = $this->getTitlesFiles();
        return isset($titles[$step]) ? 'Carga - '.$titles[$step] : 'Acción carga';
    }
    
    public function configForm($id_rel = null, $history_id = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;

        if ($step == 1) {
            return self::configFormStep1($id_rel, $history_id);
        } elseif ($step == 2) {
            return self::configFormstep2($id_rel, $history_id);
        }
    }

    public function configUpload($set_step = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        
        if ($set_step != null) {
            $step = $set_step;
        }

        if ($step == '2') {
            return self::uploadStep2();
        }
        return self::uploadStep1();
    }

    public function uploadStep1()
    {
        $elements = array(
            1 => [
                'name' => 'Comprobante transferencia',
                'comment' => '',
                'is_required' => true,
                'is_date' => false,
                'max_size' => 2, //* size in MB
                'max_file' => 2,
                'type' => 'image/*, .pdf',
                'comment_date' => null
            ],
            

            
        );
        return $elements;
    }
    
    public function uploadStep2()
    {
        $elements = array(
            2 => [
                'name' => 'Evidencia de transferencia',
                'comment' => '',
                'is_required' => true,
                'is_date' => false,
                'max_size' => 2, //* size in MB
                'max_file' => 2,
                'type' => 'image/*, .pdf',
                'comment_date' => null
            ],

            
        );
        return $elements;
    }

    public function configFormStep1($id_rel, $history_id)
    {
        $name_form = 'frm-template_wallet_step1';
        $type_form    = HistoryLog::KC_WALLET_ADD_FORM;
        $users = User::getUserRoleInvestor('Cliente inversionista');
        $funding_operation_type = config('enums.funding_operation');

        $urlRedirect = $history_id == 'null' ? '/panel/kc-wallet' : '/panel/template/steps/wallet/'.$history_id.'/show';
        $buttonLinkExtraFinish = null;
        $is_redirect_document = false;
       
        $is_investor = Auth::user()->hasRole('Cliente inversionista');
        if ($history_id == 'null' && $is_investor === true) {
            
            $buttonLinkExtraFinish = array(
                'name' => 'Continuar',
                'id' => 'url_redirect_finish',
                'class' => 'btn btn-primary',
                'link' => '#',
                'data-redirect' => '/panel/template/action-document/wallet/{id}?step=1_2'
            );
            //$urlRedirect = '/panel/template/action-document/wallet/{id}?step=1_2';
        }
        $typeInvestor = $is_investor ===true ? 'hidden' : 'select2';
        $getInvestor = Investor::where('user_id', Auth::user()->id)->first();
        $optionInvestor = $is_investor === true ? $getInvestor->id : $users;
        
        

        $elements = array(
            1 => [
                'title_section' => null,
                'title' => 'Ordenante',
                'name_field' => 'transaction[investor_id]',
                'id_field' => 'investor_id',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => $typeInvestor,
                'is_option_array' => false,
                'options' => $optionInvestor,
                'value' => $optionInvestor,
                'is_required' => true,
                'is_disabled' => null,
                'onchange' => 'getValue(this)',
            ],

            2 => [
                'title_section' => null,
                'title' => 'Tipo de operación',
                'name_field' => 'transaction[bank_transfer_type]',
                'id_field' => 'bank_transfer_type',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $funding_operation_type,
                'is_required' => true,
                'is_disabled' => null
            ],

            3 => [
                'title_section' => null,
                'title' => 'Número de operación',
                'name_field' => 'transaction[operation_number]',
                'id_field' => 'operation_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],

            4 => [
                'title_section' => null,
                'title' => 'Importe de transferencia',
                'name_field' => 'transaction[amount]',
                'id_field' => 'amount',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            5 => [
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
                'value' => $urlRedirect,
                'col' => 'col-12'
            ],
            
            
        );


        $data = array(
            'elements' => $elements, 'history_id' => $history_id,  'buttonLinkExtraFinish' => $buttonLinkExtraFinish, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form
        );

        if ($is_investor === true) {
            $data['show_btn'] = true;
        }
        $list = \View::make('panel.module.form', $data)->render();
        return $list;
    }

    public function configFormstep2($id_rel = null, $history_id = null)
    {
        $name_form = 'frm-template_wallet_step1_2';
        $type_form    = HistoryLog::KC_WALLET_ADD_FORM_STEP_2;
        $operations = config('enums.operation_status');
        $urlRedirect = '/panel/kc-wallet';
        $elements = array(
            1 => [
                'title_section' => 'Verificar transferencia',
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
            2 => [
                'title_section' => null,
                'title' => 'Confirmar transferencia',
                'name_field' => 'transaction[operation_status]',
                'id_field' => 'operation_status',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $operations,
                'is_required' => true,
                'is_disabled' => null
            ],
            3 => [
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
                'value' => $urlRedirect,
                'col' => 'col-12'
            ],
        );

        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function saveForm($request)
    {
        $data = $request->transaction;
        
        //formulario etapa 1
        $transaction = Transaction::saveEdit($request);

        if ($request->history_id != 'null') {
            $history = HistoryLog::find($request->history_id);
            $percent = self::percentForm($history);
            $percent2 = self::percentForm2($history);

            if ($percent == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET_ADD_FORM, $history->id_rel, 1);

                HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET_ADD_UPLOAD, $history->id_rel, 1);
                
                
                $getTransaction = $transaction['transaction'];
                Transaction::setTotalCapital($getTransaction->investor_id);
                
                
            }
            //confirmar transferencia exitosa
            if (isset($data['operation_status']) && $data['operation_status'] == 1) {
                $modelTransaction = $transaction['transaction'];
                $investor_id = $modelTransaction->investor_id;
                
                Transaction::setTotalCapital($investor_id);
                Investor::setFundedCapital($investor_id);

                $getInvestor = Investor::find($investor_id);
                if ($getInvestor != null) {
                    $getUserInvestor = User::find($getInvestor->user_id);
                    $data_sendgrid = array(
                        'name' => $getUserInvestor->name. ' '.$getUserInvestor->last_name. ' '.$getUserInvestor->second_last_name,
                        'link_account' => asset('panel/inversionista/'.$investor_id),
                    );
                    $send_grid = new Csendgrid($getUserInvestor->email, 'Inversionista - Fondos agregados con éxito');
                    $send_grid->setTemplate('d-38330ff956fc48dc89b4efad477b3985');
                    $send_grid->setParams($data_sendgrid);
                    $send_grid->send();
                }
            }

            if ($percent2 == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET_ADD_FORM_STEP_2, $history->id_rel, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET, $history->id_rel, 1);
            }
        }
        return $transaction['getTransaction'];
    }

    public function percentForm($history)
    {
        $transaction = Transaction::find($history->id_rel);
        $percent = 0;

        $total_valid = 0;
        
        
        if ($transaction != null && $transaction->investor_id != null) {
            $total_valid = 50;
        }
        
        if ($transaction != null && $transaction->bank_transfer_type != null) {
            $total_valid = $total_valid + 50;
        }

        
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }
    
    public function percentForm2($history)
    {
        $transaction = Transaction::find($history->id_rel);
        $percent = 0;

        $total_valid = 0;
        if ($transaction != null && ($transaction->operation_status === 0 || $transaction->operation_status != null )) {
            $total_valid = 100;
        }
        
        $percent = ($total_valid / 1 )  ;
        return $percent;
    }

    public function menuOptionsStep($history, $step = 1)
    {
        $menu = array(
           
            'actionstep1' => array(
                [
                    'link' => '/panel/template/actions/payment/' . $history->id . '/show?step=2',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep2' => array(
                [
                    'link' => '/panel/template/actions/payment/' . $history->id . '/show?step=3',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),

        );

        return $menu;
    }

    public function deadLineStep1($history)
    {
        $max_hour = self::HOUR_STEP_1;
        $transaction = Transaction::find($history->id_rel);
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentForm($history);
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }
   
    public function deadLineStep1_2($history)
    {
        $max_hour = self::HOUR_STEP_1_2;
        $transaction = Transaction::find($history->id_rel);
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFile($history->id_rel);

        
        try {
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_WALLET_ADD_UPLOAD], $history->id_rel)[0];
            $hour                         = $in_progress->created_at;
        } catch (\Throwable $th) {
            $hour                         = $history->created_at;
        }

        
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function deadLineStep2($history)
    {
        try {
            $max_hour = self::HOUR_STEP_2;
            $transaction = Transaction::find($history->id_rel);
            $color_inf_credit             = 'success';
            $percent_form                 = self::percentForm2($history);
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_WALLET_ADD_FORM_STEP_2], $history->id_rel)[0];
            $hour                         = $in_progress->created_at;
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];
            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            return $view_dead_line_inf_credit;
        } catch (\Throwable $th) {
            return null;
        }
    }
    
    public function deadLineStep2_2($history)
    {
        try {
            $max_hour = self::HOUR_STEP_2_2;
            $transaction = Transaction::find($history->id_rel);
            $color_inf_credit             = 'success';
            $percent_form                 = self::percentFile($history->id_rel, 2);
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_WALLET_ADD_UPLOAD_STEP_2], $history->id_rel)[0];
            $hour                         = $in_progress->created_at;
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];
            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            return $view_dead_line_inf_credit;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function percentFile($id_rel, $step = null)
    {
        $model = File::MODEL['wallet'];
        $percent = 0;
        $total_valid = 1;
        $count_file = 0;
        $percent_file = 0;
        $config_files = self::configUpload($step);
        
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

    public function actionStep($history_id)
    {
        $history = HistoryLog::find($history_id);
        $percent_form   = self::percentForm($history);
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $view_dead_line  = self::deadLineStep1($history);
        
        $percent_upload   = self::percentFile($history->id_rel);
        $status_file = ($percent_upload >= 100) ? 'Concluido' : 'En curso';
        $view_dead_line1_2  = self::deadLineStep1_2($history);

        $menu_options   = self::menuOptionsStep($history, 1);
        $option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();

        $subject1 = HistoryLog::$label_subject[61];
        $subject2 = HistoryLog::$label_subject[62];

        $viewStatus1 = \View::make('panel.module.status', ['status' => $status_form])->render();
        $viewStatus2 = \View::make('panel.module.status', ['status' => $status_file])->render();
        
        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' => $viewStatus1,
            'deadline' => $view_dead_line,
            'advisor' => null,
            'options' => $option,
            'link' => '/panel/action-form/wallet/'.$history->id.'/form?step=1'
        );
        
        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject2,
            'status' => $viewStatus2,
            'deadline' => $view_dead_line1_2,
            'advisor' => null,
            'options' => null,
            'link' => '/panel/template/action-document/wallet/'.$history_id.'?step=1_2'
        );
        return $data;
    }

    public function checkTaskAndFinish($idRel)
    {
        $percent_form =  self::percentFile($idRel);
        if ($percent_form == 100) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET_ADD_UPLOAD, $idRel, 1);
        }
    }

    public function finish($idRel, $step)
    {
        $percent_form =  self::percentFile($idRel, 2);
        
        if ($step == '2' && $percent_form == 100) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_WALLET_ADD_UPLOAD_STEP_2, $idRel, 1);
        }
        
    }
   
    public function actionStep2($history_id)
    {

        $history = HistoryLog::find($history_id);
        $percent_form   = self::percentForm2($history);
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $view_dead_line  = self::deadLineStep2($history);
        $percent_upload   = self::percentFile($history->id_rel, 2);
        $status_file = ($percent_upload >= 100) ? 'Concluido' : 'En curso';
        $view_dead_line1_2  = self::deadLineStep2_2($history);

        $menu_options   = self::menuOptionsStep($history, 2);
        $option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();

        $viewStatus1 = \View::make('panel.module.status', ['status' => $status_form])->render();
        $viewStatus2 = \View::make('panel.module.status', ['status' => $status_file])->render();

        $subject1 = HistoryLog::$label_subject[63];
        $subject2 = HistoryLog::$label_subject[64];
        $data = array();
        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject2,
            'status' => $viewStatus2,
            'deadline' => $view_dead_line1_2,
            'advisor' => null,
            'options' => null,
            'link' => '/panel/template/action-document/wallet/'.$history_id.'?step=2'
        );

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' => $viewStatus1,
            'deadline' => $view_dead_line,
            'advisor' => null,
            'options' => $option,
            'link' => '/panel/action-form/wallet/'.$history->id.'/form?step=2'
        );
        
        
        return $data;
    }
    public function listActionByStep($history_id, $step)
    {
        
        if ($step == '2') {
            return self::actionStep2($history_id);
        } 
        return self::actionStep($history_id);
    }


    public function listStep($history_id)
    {
        $history = HistoryLog::find($history_id);
        $transaction = Transaction::find($history->id_rel);
        $menu_options         = self::menuOptionsStep($history);
        $status_step1         = 'En curso';
        $status_step2         = 'En espera';

        $percent_upload   = self::percentFile($history->id_rel);
        
        $percent_step1   = reduceDecimal((self::percentForm($history) + self::percentFile($history->id_rel) ) / 2);
        $percent_step2   = reduceDecimal((self::percentForm2($history) + self::percentFile($history->id_rel, 2) ) / 2);

        if ($percent_step1 == 100) {
            $status_step1 = 'Concluido';
            $status_step2 = 'En curso';
        }


        $view_percent_step1         = \View::make('panel.module.view_percent', ['percent' => $percent_step1])->render();
        $view_percent_step2         = \View::make('panel.module.view_percent', ['percent' => $percent_step2])->render();

        $view_count_step1           = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_count_step2           = \View::make('panel.module.view_count', ['number' => 'Dos'])->render();

        $option_step1               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();
        $option_step2               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();

        $data = array();

        $data[] = array(
            'name' => $view_count_step1,
            'step' => 'Información transferencia',
            'status' => $status_step1,
            'progress' => $view_percent_step1,
            'deadline' => '',
            'options' => $option_step1,
        );
        
        $data[] = array(
            'name' => $view_count_step2,
            'step' => 'Verificar transferencia',
            'status' => $status_step2,
            'progress' => $view_percent_step2,
            'deadline' => '',
            'options' => $option_step2,
        );
        return $data;
    }
    public function move($id)
    {
    }

    public function getPercent($history, $show_current_show = false)
    {
        self::checkTaskAndFinish($history->id_rel);
        $transaction     = Transaction::find($history->id_rel);
        $data_actions = array(
            HistoryLog::KC_WALLET_ADD_FORM,
            HistoryLog::KC_WALLET_ADD_UPLOAD,
            HistoryLog::KC_WALLET_ADD_FORM_STEP_2,
            HistoryLog::KC_WALLET_ADD_UPLOAD_STEP_2,
        );
        //dd($data_actions);
        $get_actions = HistoryLog::getByStatus($data_actions, $transaction->id);
        //dd($get_actions);
        $status_progress = 0;
        $current_show = ''; 
        foreach ($get_actions as $key => $get_action) {
            $status = $get_action->status_progress;
            $status_progress += $status != null ? $status : 0;
            //$current_show = $status < 100 && $get_action->status_id == HistoryLog::KC_DELIVERY_UPLOAD_STEP_2 ? 'Comprobar pago': 'Verificar pago';
        }
        $percent =  $status_progress > 0 ? (($status_progress) / 4) * 100 : 0;
        if ($status_progress <= 2) {
            $current_show = 'Información transferencia';
        } elseif ($status_progress > 2) {
            $current_show = 'Verificar transferencia';
        }

        $percent =  $status_progress > 0 ? (($status_progress) / 4) * 100 : 0;

        if ($show_current_show == true) {
            return $current_show == 100 ? $current_show : null;
        }
        
        return reduceDecimal($percent);
    }

    public function moduleDeadline($history)
    {
        $transaction = Transaction::find($history->id_rel);
        $view_deadline      = \View::make('panel.module.deadline_wallet', ['transaction' => $transaction])->render();
        return $view_deadline;
    }

    public function breadcrumb($history, $type = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        $breadcumbs = self::optionBreadcumbStep($history);
        
        if ($type == 2) {
            $breadcumbs = self::optionBreadcumblistAction($history);
        }
        $view_breadcumb    = \View::make('panel.module.breadcumb', ['breadcumbs' => $breadcumbs])->render();
        return $view_breadcumb;
    }

    public function menuPrincipalOptions($history)
    {

        $menu = array(
            'options' => array(
                [
                    'link' => '/panel/template/steps/wallet/'.$history->id.'/show',
                    'onclick' => '',
                    'name' => 'Ver etapas',
                    'icon' => 'icon ni ni-list-thumb-fill',
                    'class' => 'text-dark'
                ],
               
            ),
        );

        return $menu;
    
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
                'title' => 'KC - Wallet',
                'link' => '/panel/kc-wallet',
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
                'title' => 'KC - Wallet',
                'link' => '/panel/kc-wallet',
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

    public function setTitle()
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        return 'Datos transferencia';
    }
}
