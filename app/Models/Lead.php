<?php

namespace App\Models;

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
    ];

    public static function listDatatable()
    {
       
        $is_asesor = Auth::user()->hasRole('Asesor');
        if ($is_asesor === true) {
            $get_list    = Lead::where('asesor_id', Auth::user()->id)->get();
        } else { 
            $get_list    = Lead::all();
        }


        $data        = array();
        foreach ($get_list as $query) {
            $option = \View::make('panel.lead.add_option_dt', [ 'type' => 2, 'id' => $query->id])->render();
            $lead = \View::make('panel.lead.content_lead', ['lead' => $query])->render();
            
            $lbl_status = '<span class="badge bg-success">Valido</span>';
            
            $product    = $query->productLead;
            $user       = $query->advisorLead;

            $data[] = array(
                'name' => $lead,
                'date' => formatDateNameMonth($query->created_at),
                'product' => ($product != null) ? $product->alias : '',
                'origin' => config('enums.origin')[$query->origin_id],
                'label' => config('enums.temperatures')[$query->temperature_id],
                'advisor' => ($user != null) ? $user->name.' '.$user->last_name.' '.$user->second_last_name : '',
                'status' => $lbl_status,
                'options' => $option
            );
        }
        return $data;
    }

    public static function saveEdit($request)
    {
        $data = $request->data;
        if ($data['agreement_id'] == 0) { //si es  0 se insertara el nuevo agreement
            $agreement = new Agreement(['name' => $request->new_agreement, 'status' => 1]);
            $agreement->save();
            $data['agreement_id'] = $agreement->id;
        }

        if ($request->lead_id == null) {
            $product = new Lead($data);
            $product->save();
        } else {
            $product = Lead::find($request->lead_id);
            $product->fill($data);
            $product->update();
        }
       
        return $product;
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
                $channel = config('enums.channel_asesor');
                break;
            case '3':
                //* WebApp
                $channel = config('enums.channel_asesor');
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
}
