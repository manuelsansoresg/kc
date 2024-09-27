<?php

namespace App\Models;

use App\Lib\Csendgrid;
use App\Lib\Manychat;
use App\Strategies\Notifications\Models\Pusher;
use App\Strategies\Values\SendNotificationsValues;
use App\Strategies\Values\TemplateValues;
use App\Strategies\Values\ValidateStagesValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'agreement_id' ,
        'product_id' ,
        'name' ,
        'last_name' ,
        'second_last_name' ,
        'cellphone' ,
        'email' ,
        'origin_id' ,
        'channel_id' ,
        'asesor_id' ,
        'temperature_id' ,
        'type_id', //*atención
        'financial_id',
        'other',
        'importe_solicitado',
        'bank_id',
        'tipo_credito',
        'consulta_buro',
        'financial_product_id',
        'aval_o_garantia',
        'comment',
        'manychat_id',
        'income',
        'rfc',
        'applied_financial_product',
        'applied_loan_type',
        'is_viability',
        'is_viability_credit',
        'birth_date',
        'client_person_id'
    ];

    public static function tagLead ($lead_id, $label, $is_array = false)
    {
        $new_array = array();
        if ($label != null) {
            $new_array[] = '#'.$label;
            $label = '#'. $label;
        }

        $actions = Action::where([
            'id_rel' => $lead_id,
            'section' => 1,
        ])->count();
        if ($actions > 0) {
            $label.= '<br> #AcciónEnCurso';
            $new_array[] = '#AcciónEnCurso';
        }

        if ($is_array == true) {
            return $new_array;
        }
        return $label;
    }

    public static function deleteActions($lead_id)
    {
        $get_actions = Action::where([
            'id_rel' => $lead_id,
        ])->get();
        foreach ($get_actions as $get_action) {
            Action::updateByModel($get_action->id, 2);
        }
    }

    public static function listDatatable()
    {
       
        $is_asesor = Auth::user()->hasRole('Asesor');

        $get_list = HistoryLog::getByStatus([HistoryLog::CREATE_PROSPECT]);
        $data        = array();
        foreach ($get_list as $row) {
            $query = $row->historyLead;
            if ($query != null) {
                $leadStrategy   = ValidateStagesValues::STRATEGY['lead'];
                $validate       = (new $leadStrategy)->getValidate($query->id);
                $option         = \View::make('panel.lead.add_option_dt', [ 'type' => 2, 'id' => $query->id, 'lead' => $query, 'validate' => $validate])->render();
                $lead_view      = \View::make('panel.lead.content_lead', ['lead' => $query, 'validate' => $validate,  'validate' => $validate])->render();
                
                $lbl_status     = '<span class="text-success">Valido</span>';
                
                $product        = $query->productLead;
                $user           = $query->advisorLead;
                $agreement      = $query->agreementLead;
                
    
                
                if ($validate['error'] === true) {
                    $lbl_status = '<span class="text-danger">Invalido</span>';
                }
                $origin = (isset(config('enums.origin')[$query->origin_id]))? config('enums.origin')[$query->origin_id] : '';
                $label = (isset(config('enums.temperatures')[$query->temperature_id]))? config('enums.temperatures')[$query->temperature_id] : '';

                $label = self::tagLead($query->id, $label);
                
                
                if ($is_asesor === true &&  Auth::user()->id == $query->asesor_id) {
                    $data[] = array(
                        'id' => $query->id,
                        'name' => $lead_view,
                        'date' => formatDateNameMonthHour($query->created_at),
                        'product' => ($product != null) ? $product->alias : '',
                        'organizacion' => isset($agreement->name)? $agreement->name : null,
                        'label' => $label,
                        'advisor' => ($user != null) ? $user->name.' '.$user->last_name.' '.$user->second_last_name : '',
                        'options' => $option
                    );
                } else {
                    $data[] = array(
                        'id' => $query->id,
                        'name' => $lead_view,
                        'date' => formatDateNameMonthHour($query->created_at),
                        'product' => ($product != null) ? $product->alias : '',
                        'organizacion' => isset($agreement->name)? $agreement->name : null,
                        'label' => $label,
                        'advisor' => ($user != null) ? $user->name.' '.$user->last_name.' '.$user->second_last_name : '',
                        'options' => $option
                    );
                }
            }
        }
        return $data;
    }

    public static function createClientPerson($lead_id, $is_report = false, $history_id = null)
    {
        $get_lead = LeadClient::where('lead_id', $lead_id);
        $status = 500;
        
        

        if ($get_lead->count() === 0) {
            $status = 200;
            $lead = Lead::find($lead_id)->toArray();
            User::saveLeadClientPersona($lead, $is_report, $history_id);
        }
        return $status;
    }
    
    public static function listArchive()
    {
        
        $status_id    = HistoryLog::LEAD_ARCHIVE;
        $get_list     = HistoryLog::where(['status_id' => $status_id, 'status' => 1])->get();
        $data         = array();
        foreach ($get_list as $query) {
            $option       = \View::make('panel.lead.add_option_archive_dt', [ 'type' => 2, 'lead' => $query, 'id' => $query->id_rel])->render();
            
            $lbl_status   = '<span class="text-success">Valido</span>';
            $lead         = $query->historyLead;

            if ($lead != null) {
                $product      = $lead != null ? $lead->productLead : null;
                $user         = $lead != null ? $lead->advisorLead : null;
                $leadStrategy   = ValidateStagesValues::STRATEGY['lead'];
                $validate       = (new $leadStrategy)->getValidate($query->id);
    
                $content_lead         = \View::make('panel.lead.content_lead', ['lead' => $lead, 'validate' => $validate])->render();
                $reason = (isset(config('enums.reason_archive')[$query->reason]))? config('enums.reason_archive')[$query->reason] : '';
                $data[] = array(
                    'id' => $lead->id,
                    'name' => $content_lead,
                    'date' => formatDateNameMonth($query->created_at),
                    'product' => ($product != null) ? $product->alias : '',
                    'origin' => config('enums.origin')[$lead->origin_id],
                    'reason' => $reason,
                    'label' => '#'.config('enums.temperatures')[$lead->temperature_id],
                    'advisor' => ($user != null) ? $user->name.' '.$user->last_name.' '.$user->second_last_name : '',
                    'status' => $lbl_status,
                    'options' => $option,
                );
            }
        }
        return $data;
    }

    public static function saveEdit($request)
    {
        $data = $request->data;

        $is_asesor = Auth::user()->hasRole('Asesor');

        if (isset($data['consulta_buro'])) {
            $data['consulta_buro'] = $data['consulta_buro'] === null ? 1 : $data['consulta_buro'];  
        }

        if (isset($data['aval_o_garantia'])) {
            $data['aval_o_garantia'] = $data['aval_o_garantia'] === null ? 1 : $data['aval_o_garantia']; 
        }

        
        $data['is_viability'] = isset($data['is_viability']) ? $data['is_viability'] : 0 ; 
        
        
        $data['is_viability_credit'] = isset($data['is_viability_credit']) ? $data['is_viability_credit'] : 0 ; 

       /*  if (isset($data['agreement_id']) && $data['agreement_id'] == 0) { //si es  0 se insertara el nuevo agreement
            unset($data['agreement_id']);
            $new_agreement = Agreement::create([ 'name' => $request->new_agreement, 'description' => $request->new_agreement, 'status' => 1]);
            $data['agreement_id'] = $new_agreement->id;
        } */
        if ($request->isNew == true) {
            if ($is_asesor === true) {
                $data['asesor_id'] =  Auth::user()->id;
            }
            $lead = new Lead($data);
            $lead->save();

            //* Execute notification in create lead
            $notification   = SendNotificationsValues::STRATEGY['leadNewProspect'];
            (new $notification)->send($lead->id);

            if ($data['asesor_id'] != null) {
                $lead_advisor = LeadAdvisor::create([ 'lead_id' => $lead->id, 'advisor_id' => Auth::user()->id]);
                HistoryLog::move($lead_advisor->id, HistoryLog::ADD_PROSPECT, HistoryLog::ADD_PROSPECT);
                //* Execute notification in add lead
                $notification_add   = SendNotificationsValues::STRATEGY['leadAddProspect'];
                (new $notification_add)->send($lead->id);
            }
            HistoryLog::move($lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);
            //*crear contacto sendgrid
            $send_grid = new Csendgrid();
            $send_grid->createContact($lead->email, $lead->first_name, $lead->last_name);
        } else {
            unset($data['origin_id']);
            $lead = Lead::find($request->lead_id);
            $lead->fill($data);
            $lead->update();

            //*actualizar campos manychat si el manychat_id existe
            if ($lead->manychat_id != null) {
                $get_lead       = Lead::find($lead->id);
                $get_advisor    = $get_lead->advisorLead;
                $advisor        = $get_advisor!= null ? $get_advisor->name.' '.$get_advisor->last_name  : null;
                $get_product    = $get_lead->productLead;
                $product        = $get_product != null ? $get_product->alias : null;
                $get_bank       = Bank::find($get_lead->bank_id);
                $bank           = $get_bank != null ? $get_bank->name : null;
                $manychat       = new Manychat();
                $get_origin     = Lead::getChanelByOrigin($get_lead->origin_id);
                $channel        = isset($get_origin[$get_lead->channel_id])? $get_origin[$get_lead->channel_id] : null;
                $get_agreement  = $get_lead->agreementLead;
                $agreement      = $get_agreement!= null ? $get_agreement->name : null;
                $get_origins    = config('enums.origin');
                $origin         = isset($get_origins[$get_lead->origin_id]) ? $get_origins[$get_lead->origin_id] : null;
                
                $type_products  = config('financial_enums.type_products');
                $type_credit    = isset($type_products[$get_lead->tipo_credito]) ? $type_products[$get_lead->tipo_credito] : null;

                //$manychat->setCustomFields($lead->manychat_id, config('enums.custom_fields_many_chat')['Asesor'], $advisor);
                $data = array(
                    'Asesor' => $advisor,
                    'Aval o garantía' => (bool)$get_lead->aval_o_garantia,
                    'Banco' => $bank,
                    'Canal' => $channel,
                    'Consulta buró' => (bool)$get_lead->consulta_buro,
                    'Importe solicitado' => $get_lead->importe_solicitado,
                    'Organización' => $agreement,
                    'Origen' => $origin,
                    'Servicio KC' => $product,
                    'Tipo de crédito' => $type_credit,
        
                );
                $set = $manychat->setCustomFields($data, $lead->manychat_id);
            }
        }
        
        CurrentFinancialProduct::saveEdit($lead->id, $request);
        
        return $lead;
    }

    public static function saveLeadSurvey($request)
    {
        
        $data_lead                    = $request->data;
        $number_step                  = $request->number_step;
        $data_lead['origin_id']       = 2;
        $data_lead['channel_id']      = 1;
        $data_lead['type_id']         = 1;
        $data_lead['tipo_credito']    = 2; //credito personal
        $lead_id                      = $request->lead_id;
        $is_new                       = false;

        if ($data_lead['agreement_id'] == '00') {
            unset($data_lead['agreement_id']);
        }
        $get_lead = Lead::find($lead_id);
        if ($get_lead == null) {
             //*crear usuario manychat
             $manychat = new Manychat();
             $data_manychat = array(
                 "first_name" => $request->name,
                 "last_name" => $request->last_name,
                 "phone" => "+521".$request->cellphone,
                 "whatsapp_phone" => "521".$request->cellphone,
                 "email" => $request->email,
                 "has_opt_in_sms" => true,
                 "has_opt_in_email" => true,
                 "consent_phrase" => 'kc',
             );
             $result = json_decode($manychat->altaUsuario($data_manychat));
             if ($result->status == 'success') {
                $data_manychat              = $result->data;
                $data_lead['manychat_id']   = $data_manychat->id;
            }

            $get_lead = new Lead($data_lead);
            $get_lead->save();
            $is_new = true;

        } else {
            $get_lead->fill($data_lead)->update();
        }

        if ($number_step == 4) {

            //* Execute notification in create lead
            $notification   = SendNotificationsValues::STRATEGY['leadNewProspect'];
            (new $notification)->send($get_lead->id);
            //*crear contacto sendgrid
            $send_grid = new Csendgrid();
            $send_grid->createContact($get_lead->email, $get_lead->first_name, $get_lead->last_name);
            HistoryLog::move($get_lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);
        }
        $history = null;
        if ($number_step == 6) {
            $template   = TemplateValues::STRATEGY['lead'];
            $history = (new $template)->move($get_lead->id);
        }
        return array('lead' => $get_lead, 'history' => $history);
    }

    //* validate save form include iframe in domain appp.kaaxclub
    public static function saveLeadFormSurvey($request, $is_report = false)
    {
        $data_lead                = $request->data;
        $number_step              = $request->number_step;
        $data_lead['origin_id']   = 3;
        $data_lead['channel_id']  = 2;
        $data_lead['type_id']     = 1;
        $lead_id                  = $request->lead_id;
        $correo                   = $request->key_email;
        $email                    = $correo;
        $encoded_email            = urlencode($email);
        $email                    = str_replace('%40', '@', $encoded_email);
        $user                     = User::where('email', $email)->first();
        $data_lead['name']        = $user->name;
        $data_lead['last_name']   = $user->last_name;
        $data_lead['email']       = $email;

        if ($data_lead['agreement_id'] == '00') {
            unset($data_lead['agreement_id']);
        }
        $get_lead = Lead::find($lead_id);
        if ($get_lead == null) {
            $get_lead = new Lead($data_lead);
            $get_lead->save();
            HistoryLog::move($get_lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);
        } else {
            $get_lead->fill($data_lead)->update();
        }
        if ($number_step == 1) {
            $notification   = SendNotificationsValues::STRATEGY['leadNewProspect'];
            (new $notification)->send($lead_id);
        }
        if ($number_step == 3) {
            $template   = TemplateValues::STRATEGY['lead'];
            (new $template)->move($get_lead->id, $is_report);
        }
        return $get_lead;
    }

    public static function createWithSurvey($data, $survey_id)
    {
        $response = json_decode($data['response']);
        $data_lead = array(
            'name' => $response->name,
            'cellphone' => $response->cellphone,
            'email' => $response->email,
            'origin_id' => 2,
            'channel_id' =>1
        );
        $exist_lead = Lead::where($data_lead)->count();
        if ($exist_lead === 0) {
            $survey = ApiSurveySparrow::find($survey_id);
            $survey->status = 1;
            $survey->update();
            $lead = Lead::create($data_lead);
            HistoryLog::move($lead->id, HistoryLog::CREATE_PROSPECT, HistoryLog::CREATE_PROSPECT);
        }
    }

    public static function getChanelByOrigin($origin_id)
    {
        $channel = null;
        switch ($origin_id) {
            case '1':
                //* Asesor
                $channel = config('enums.channel_asesor');
                break;
            case '2':
                //* WebPage
                $channel = config('enums.channel_web_page');
                break;
            case '3':
                //* WebApp
                $channel = config('enums.channel_web_app');
                break;
            case '4':
                //* WebApp
                $channel = config('enums.channel_rss');
                break;
        }
        return $channel;
    }

    public function agreementLead()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }
    
    public function productLead()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function advisorLead()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function leadNotes()
    {
        return $this->hasMany(LeadNote::class);
    }

    public function bankLead()
    {
        return $this->hasMany(Bank::class, 'bank_id');
    }

    public function history()
    {
        return $this->hasOne(HistoryLog::class);
    }

    public function leadAdvisor()
    {
        return $this->hasMany(LeadAdvisor::class);
    }
}
