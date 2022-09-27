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
        'type_id',
        'asesor_id',
        'current_payment',//*save  * 100
        'current_periodicity',
        'current_loan',//*save  * 100
        'current_term',
        'current_principal_balance',//*save  * 100
        'current_total_balance',//*save  * 100
    ];

    public static function listDatatable()
    {
       
        
        $get_list    = HistoryLog::getByStatus([HistoryLog::KC_CHECK_UP, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION]);
        
        $users        = array();
        foreach ($get_list as $history) {
            $query            = Credit::find($history->id_rel);
            $product          = $query->creditProduct;
            $alias_product    = $product !== null ? $product->alias : null;
            $client           = $query->creditClientPerson;
            $advisor          = $query->creditAdvisor;
            $route            = self::routeShowStep()[$history->status_id];
            $model            = HistoryLog::$name_model[$history->status_id];
            $templateStrategy = TemplateValues::STRATEGY[$model];
            $percent          = (new $templateStrategy)->getPercent($history);

            $hour             = $query->created_at;
            $max_hour         = 24;

            $data_deadline    = deadlineKc($hour, $max_hour);
            $color_inf_credit = $data_deadline['color'];
            $hour             = $data_deadline['lbl_hour'];
            
            $option           = \View::make('panel.module.checkup.add_option_dt', ['id' => $history->id, 'client' => $client, 'credit_id' => $history->id_rel, 'route' => $route])->render();
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
                    'client' => $content_client,
                    'advisor' => $name_advisor,
                    'progress' => $progress_bar,
                    'deadline' => $dead_line,
                    'options' => $option
                );
            }
        }
        return $users;
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
            $option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['archive']])->render();
            $content_client   = \View::make('panel.module.checkup.content_client', [ 'client' => $client])->render();
            $content_product  = \View::make('panel.module.checkup.product', [ 'alias_product' => $alias_product])->render();
            
            $name_advisor = $advisor !== null ? $advisor->name.' '.$advisor->last_name : null;
            $is_advisor     = Auth::user()->hasRole('Asesor');
            if ($is_advisor === true && Auth::user()->id === $advisor->id) {
                $users[] = array(
                    'id' => $query->id,
                    'product' => $content_product,
                    'client' => $content_client,
                    'advisor' => $name_advisor,
                    'options' => $option
                );
            } else {
                $users[] = array(
                    'id' => $query->id,
                    'product' => $content_product,
                    'client' => $content_client,
                    'advisor' => $name_advisor,
                    'options' => $option
                );
            }
        }
        return $users;
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
        );
        return $routes;
    }

    public function creditClientPerson()
    {
        return $this->belongsTo(ClientPerson::class, 'client_person_id');
    }
    
    public function creditAgreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }
    
    public function creditFinancial()
    {
        return $this->belongsTo(Financial::class, 'financial_id');
    }

    public function creditProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
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
}
