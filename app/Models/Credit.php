<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public static function listDatatable()
    {
       
        
        $get_list    = Credit::all();
        $users        = array();
        foreach ($get_list as $query) {
            $product          = $query->creditProduct;
            $alias_product    = $product !== null ? $product->alias : null;
            $client           = $query->creditClientPerson;
            $advisor          = $query->creditAdvisor;
            $option           = \View::make('panel.module.checkup.add_option_dt', ['id' => $query->id, 'client' => $client])->render();
            $content_client   = \View::make('panel.module.checkup.content_client', [ 'client' => $client])->render();
            $progress_bar     = \View::make('panel.module.checkup.progressbar', [ 'client' => $client])->render();
            $dead_line        = \View::make('panel.module.checkup.deadline', [ 'deadline' => $query])->render();
            $content_product  = \View::make('panel.module.checkup.product', [ 'alias_product' => $alias_product])->render();
            
            $name_advisor = $advisor !== null ? $advisor->name.' '.$advisor->last_name : null;

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
        return $users;
    }

    public function creditClientPerson()
    {
        return $this->belongsTo(ClientPerson::class, 'client_person_id');
    }

    public function creditProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function creditAdvisor()
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }
}
