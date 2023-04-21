<?php

namespace App\Models;

use App\Strategies\Values\TemplateValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Credit extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_person_id',
        'product_id',
        'financial_id',
        'agreement_id',
        'origin_id',
        'channel_id',
        'type_id', //*atención
        'asesor_id',
        'current_payment',//*save  * 100
        'current_periodicity',
        'current_loan',//*save  * 100
        'current_term',
        'current_principal_balance',//*save  * 100
        'current_total_balance',//*save  * 100
        'applied_financial',
        'applied_financial_product',
        'applied_loan_type',
        'applied_sign_type',
        'applied_import',//*save  * 100
        'applied_term',
        'applied_periodicity',
        'applied_payment',//*save  * 100
        'applied_loan_total_amount',//*save  * 100
        'applied_delivery_method',
        'applied_loan_motive',
        'payment_capacity_period',
        'payment_capacity',
        'applied_interest_rate',
        'applied_CAT',
        'opening_Commission_percentage',
        'client_public_servant',
        'client_public_servant_position',
        'client_public_servant_period',
        'relative_public_servant',
        'relative_public_servant_lastname',
        'relative_public_servant_second_lastname',
        'relative_public_servant_names',
        'relative_public_servant_relationship',
        'relative_public_servant_position',
        'relative_public_servant_period',
        'client_public_servant',
        'prepad_method',
        'prepaid_frequency',
        'prepaid_source',
        'endorsement',
        'real_beneficiary',
        'soruce_provider',
        'real_propetary',
        'applied_loan_discount',
        'statement_delivery_method',
        'notes',
        'financial_user_assigned',
        'commission',//*save  * 100
        'commission_note',
        'changed_commission', //* save * 100
        'changed_commission_note',
        'payment_check',
        'payment_check_note',
        'id_number',
        'current_credit_number',
        'url_sign',
        'signed',
        'termination_email_sent',
        'termination_number',
        'termination_bank_name',
        'termination_bank_account_holder',
        'termination_bank_account_number',
        'termination_bank_clabe',
        'termination_bank_reference',
        'termination_note',
        'termination_amount', //* save * 100
        'termination_deadline',
        'kyc_done',
        'credit_signed',
        'approved',
        'delivered',
        'interviewer'
    ];

    public static function listDatatable($status)
    {
       
        //*restrict user financial and asesor
        $get_list    = HistoryLog::getByStatus($status);
        $users        = array();
        foreach ($get_list as $history) {
            try {
                $query            = Credit::find($history->id_rel);
                $product          = $query->creditProduct;
                $alias_product    = $product !== null ? $product->alias : null;
                $client           = $query->creditClientPerson;
                $advisor          = $query->creditAdvisor;
                $route            = self::routeShowStep()[$history->status_id];
                $model            = HistoryLog::$name_model[$history->status_id];
                $templateStrategy = TemplateValues::STRATEGY[$model];
                $percent          = (new $templateStrategy)->getPercent($history);
                $percent_form     = (new $templateStrategy)->percentForm($history);
                //dd($history->status_id);
                $hour             = $query->created_at;
                $max_hour         = 24;
                $data_deadline    = deadlineKc($hour, $max_hour);
                $in_progress      = (new $templateStrategy)->getPercent($history, true);
                $dead_line        = (new $templateStrategy)->moduleDeadline($history);
                
                $hour             = $data_deadline['lbl_hour'];
                $status_id        = $history->status_id;
                $option           = \View::make('panel.module.checkup.add_option_dt', ['id' => $history->id, 'client' => $client, 'percent_form' => $percent_form, 'credit_id' => $history->id_rel, 'route' => $route, 'status_id' => $status_id])->render();

                if ($history->status_id === HistoryLog::KC_AFTER_MARKET || $history->status_id === HistoryLog::KC_CONTROL_DESK || $history->status_id === HistoryLog::KC_DELIVERY || $history->status_id === HistoryLog::KC_PAYMENT) {
                    $menu_options          = (new $templateStrategy)->menuPrincipalOptions($history);
                    $option               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['options']])->render();
                }

                if ($history->status_id === HistoryLog::KC_SWAP) {
                    $menu_options          = (new $templateStrategy)->menuPrincipalOptions($history);
                    $option               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['options']])->render();
                }

                $content_client   = \View::make('panel.module.checkup.content_client', [ 'client' => $client])->render();
                $progress_bar     = \View::make('panel.module.checkup.progressbar', [ 'client' => $client, 'percent' => $percent])->render();
                $content_product  = \View::make('panel.module.checkup.product', [ 'alias_product' => $alias_product])->render();
                
                $name_advisor = $advisor !== null ? $advisor->name.' '.$advisor->last_name : null;
                $is_advisor     = Auth::user()->hasRole('Asesor');
                $is_user_financial = Auth::user()->hasRole('Cliente financiera');

                if ($is_advisor === true && Auth::user()->id === $advisor->id) {
                    $users[] = array(
                        'id' => $query->id_rel,
                        'product' => $content_product,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'in_progress' => $in_progress,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                } elseif ($is_user_financial === true && $query->financial_user_assigned === Auth::user()->id) {
                    $users[] = array(
                        'id' => $query->id_rel,
                        'product' => $content_product,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'in_progress' => $in_progress,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                } else {
                    $users[] = array(
                        'id' => $history->id_rel,
                        'product' => $content_product,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'in_progress' => $in_progress,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                }//code...
            } catch (\Exception $th) {
            }
        }
        return $users;
    }

    public static function percentApplyDecision($credit_id)
    {
        $credit   = Credit::find($credit_id);
        $desition = $credit->applied_financial != null ? 100 : 0;
        return $desition;
    }

    public static function listDatatableProduct($status)
    {
        $get_list    = HistoryLog::getByStatus([$status]);
        
        $users        = array();
        foreach ($get_list as $history) {
            $query            = Credit::find($history->id_rel);
            $product          = $query->creditProduct;
            $alias_product    = $product !== null ? $product->alias : null;
            $client           = $query->creditClientPerson;
            $advisor          = $query->creditAdvisor;
            $menu_options   = self::menuOptionCredit($history);

            $reason_enums = array(17 => 'credit_reason_cancel', 18 => 'credit_reason_reject', 16 => 'credit_reason_archive', 35 => 'pagado', 55 => 'delivered');
            $reason = isset(config('enums.'.$reason_enums[$history->status_id])[$history->reason]) ? config('enums.'.$reason_enums[$history->status_id])[$history->reason] : null;

            $option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['archive']])->render();
            $content_client   = \View::make('panel.module.checkup.content_client', [ 'client' => $client])->render();
            $content_product  = \View::make('panel.module.checkup.product', [ 'alias_product' => $alias_product])->render();
            
            $name_advisor = $advisor !== null ? $advisor->name.' '.$advisor->last_name : null;
            $is_advisor     = Auth::user()->hasRole('Asesor');
            if ($is_advisor === true && Auth::user()->id === $advisor->id) {
                $users[] = array(
                    'id' => $query->id,
                    'product' => $content_product,
                    'reason' => $reason,
                    'date' => formatDateNameMonth($history->created_at),
                    'client' => $content_client,
                    'advisor' => $name_advisor,
                    'options' => $option
                );
            } else {
                $users[] = array(
                    'id' => $query->id,
                    'product' => $content_product,
                    'reason' => $reason,
                    'date' => formatDateNameMonth($history->created_at),
                    'client' => $content_client,
                    'advisor' => $name_advisor,
                    'options' => $option
                );
            }
        }
        return $users;
    }

    public static function listDatatableInProgress()
    {
        $get_in_progress    = HistoryLog::getByStatus([HistoryLog::CREDIT_IN_PROGRESS]);
        //$get_list    = HistoryLog::getByStatus([HistoryLog::KC_CHECK_UP, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION]);
        $users        = array();
        foreach ($get_in_progress as $history) {
            $id_rel           = $history->id_rel;

            $query            = Credit::find($history->id_rel);
            $product          = $query->creditProduct;
            $alias_product    = $product !== null ? $product->alias : null;
            $client           = $query->creditClientPerson;
            $advisor          = $query->creditAdvisor;
            try {
                $get_module       = HistoryLog::getInProgress($id_rel, true);
                $name_module       = HistoryLog::getInProgress($id_rel);
                $model            = HistoryLog::$name_model[$get_module];
                $templateStrategy = TemplateValues::STRATEGY[$model];
                $percent          = (new $templateStrategy)->getPercent($history);
                
                

                $hour             = $query->created_at;
                $max_hour         = 24;

                $modulo           = $name_module;

                $data_deadline    = deadlineKc($hour, $max_hour);
                $color_inf_credit = $data_deadline['color'];
                $hour             = $data_deadline['lbl_hour'];
                $status_id        = $history->status_id;
                
                $menu_options     = self::menuInProgressOptions($history);
                $option           = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['options']])->render();
                
                $content_client   = \View::make('panel.module.checkup.content_client', [ 'client' => $client])->render();
                $progress_bar     = \View::make('panel.module.checkup.progressbar', [ 'client' => $client, 'percent' => $percent])->render();
                $dead_line        = \View::make('panel.module.checkup.deadline', [ 'hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
                $content_product  = \View::make('panel.module.checkup.product', [ 'alias_product' => $alias_product])->render();
                
                $name_advisor = $advisor !== null ? $advisor->name.' '.$advisor->last_name : null;
                $is_advisor     = Auth::user()->hasRole('Asesor');
                if ($is_advisor === true && Auth::user()->id === $advisor->id) {
                    $users[] = array(
                        'id' => $query->id,
                        'product' => $content_product,
                        'module' => $modulo,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                } else {
                    $users[] = array(
                        'id' => $query->id,
                        'product' => $content_product,
                        'module' => $modulo,
                        'client' => $content_client,
                        'advisor' => $name_advisor,
                        'progress' => $progress_bar,
                        'deadline' => $dead_line,
                        'options' => $option
                    );
                }
            } catch (\Exception $th) {
            }
        }
        return $users;
    }

    public function menuInProgressOptions($history)
    {
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $menu = array(
            'options' => array(
                [
                    'link' => '/panel/client/'.$client->id,
                    'onclick' => '',
                    'name' => 'Ver perfil cliente',
                    'icon' =>  'icon ni ni-user-fill'
                ],
                [
                    'link' => '/panel/credit/'.$credit->id,
                    'onclick' => '',
                    'name' => 'Ver perfil crédito',
                    'icon' => 'icon ni ni-report-profit'
                ]
            ),
        );

        return $menu;
    }

    public function menuOptionCredit($history)
    {
        $menu = array(
            'archive' => array(
                [
                    'link' => '/panel/credit/'.$history->id_rel,
                    'onclick' => '',
                    'name' => 'Ver perfíl crédito',
                ]
            ),
            'desition' => array(
                [
                    'link' => '/panel/kc-check-up/report/desition/'.$history->id.'/show/',
                    'onclick' => '',
                    'name' => 'Ver acción',
                ]
            )
        );
        return $menu;
    }

    public function routeShowStep()
    {
        $routes = array(
            6 => 'newCredit',
            10 => 'debtCredit',
            19 => 'debtCredit',
            21 => 'controlDesk',
            30 => 'delivery',
            36 => 'afterMarket',
            37 => 'swap',
            49 => 'payment',

        );
        return $routes;
    }
    

    public function creditClientPerson()
    {
        return $this->belongsTo(ClientPerson::class, 'client_person_id');
    }

    public function creditReference()
    {
        return $this->hasMany(CreditReference::class);
    }
    
    public function creditAgreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }

    public static function getLastCredit($client_id)
    {
        return Credit::where('client_person_id', $client_id)->orderBy('id', 'DESC')->limit(1)->first();
    }
    
    public function creditFinancial()
    {
        return $this->belongsTo(Financial::class, 'financial_id');
    }
   
    public function creditAppliedFinancial()
    {
        return $this->belongsTo(Financial::class, 'applied_financial');
    }

    public function creditProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function creditAppliedProduct()
    {
        return $this->belongsTo(Product::class, 'applied_financial_product');
    }
   
    public function creditUserFinancial()
    {
        return $this->belongsTo(User::class, 'financial_user_assigned');
    }

    public function creditAdvisor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function history()
    {
        return $this->hasOne(HistoryLog::class);
    }
   
    public function notification()
    {
        return $this->hasOne(Notification::class);
    }

    public function survey()
    {
        return $this->hasOne(Survey::class);
    }
}
