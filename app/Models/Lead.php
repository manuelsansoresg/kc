<?php

namespace App\Models;

use App\Lib\Csendgrid;
use App\Strategies\Values\SendNotificationsValues;
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
        'type_id',
        'financial_id'
    ];

    public static function listDatatable()
    {
       
        $is_asesor = Auth::user()->hasRole('Asesor');
        
        

        $get_list = HistoryLog::getByStatus([HistoryLog::CREATE_PROSPECT]);
        //dd($get_list);
        $data        = array();
        foreach ($get_list as $row) {
            $query = $row->historyLead;
            
            if ($query != null) {
                $leadStrategy   = ValidateStagesValues::STRATEGY['lead'];
                $validate       = (new $leadStrategy)->getValidate($query->id);
    
                $option = \View::make('panel.lead.add_option_dt', [ 'type' => 2, 'id' => $query->id, 'validate' => $validate])->render();
                $lead = \View::make('panel.lead.content_lead', ['lead' => $query])->render();
                
                $lbl_status = '<span class="text-success">Valido</span>';
                
                $product        = $query->productLead;
                $user           = $query->advisorLead;
    
                
                if ($validate['error'] === true) {
                    $lbl_status = '<span class="text-danger">Invalido</span>';
                }
                $origin = (isset(config('enums.origin')[$query->origin_id]))? config('enums.origin')[$query->origin_id] : '';
                $label = (isset(config('enums.temperatures')[$query->temperature_id]))? config('enums.temperatures')[$query->temperature_id] : '';
                
                if ($is_asesor === true &&  Auth::user()->id == $lead->asesor_id) {
                    $data[] = array(
                        'id' => $query->id,
                        'name' => $lead,
                        'date' => formatDateNameMonth($query->created_at),
                        'product' => ($product != null) ? $product->alias : '',
                        'origin' => $origin,
                        'label' => $label,
                        'advisor' => ($user != null) ? $user->name.' '.$user->last_name.' '.$user->second_last_name : '',
                        'status' => $lbl_status,
                        'options' => $option
                    );
                } else {
                    $data[] = array(
                        'id' => $query->id,
                        'name' => $lead,
                        'date' => formatDateNameMonth($query->created_at),
                        'product' => ($product != null) ? $product->alias : '',
                        'origin' => $origin,
                        'label' => $label,
                        'advisor' => ($user != null) ? $user->name.' '.$user->last_name.' '.$user->second_last_name : '',
                        'status' => $lbl_status,
                        'options' => $option
                    );
                }
                
                
            }

        }
        return $data;
    }

    public static function createClientPerson($lead_id)
    {
        $get_lead = LeadClient::where('lead_id', $lead_id)->count();
        $status = 500;
        if ($get_lead === 0) {
            $status = 200;
            $lead = Lead::find($lead_id)->toArray();
            User::saveClientPersona($lead);
        }
        return $status;
    }
    
    public static function listArchive()
    {
        
        $status_id    = HistoryLog::LEAD_ARCHIVE;
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
    
                $data[] = array(
                    'name' => $content_lead,
                    'date' => formatDateNameMonth($query->created_at),
                    'product' => ($product != null) ? $product->alias : '',
                    'origin' => config('enums.origin')[$lead->origin_id],
                    'label' => config('enums.temperatures')[$lead->temperature_id],
                    'advisor' => ($user != null) ? $user->name.' '.$user->last_name.' '.$user->second_last_name : '',
                    'status' => $lbl_status,
                    'options' => $option
                );
            }
        }
        return $data;
    }

    public static function saveEdit($request)
    {
        $data = $request->data;

        $is_asesor = Auth::user()->hasRole('Asesor');

        if (isset($data['agreement_id']) && $data['agreement_id'] == 0) { //si es  0 se insertara el nuevo agreement
            $agreement = new Agreement(['name' => $request->new_agreement, 'status' => 1]);
            $agreement->save();
            $data['agreement_id'] = $agreement->id;
        }
        if ($request->lead_id == null) {
            if ($is_asesor === true) {
                $data['asesor_id'] =  Auth::user()->id;
            }
            $lead = new Lead($data);
            $lead->save();

            //* Execute notification in create lead
            $notification   = SendNotificationsValues::STRATEGY['leadNewProspect'];
            (new $notification)->send($lead->id);

            if ($is_asesor === true) {
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
            $lead = Lead::find($request->lead_id);
            $lead->fill($data);
            $lead->update();
        }
       
        return $lead;
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

    public function history()
    {
        return $this->hasOne(HistoryLog::class);
    }

    public function leadAdvisor()
    {
        return $this->hasMany(LeadAdvisor::class);
    }
}
