<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditReference extends Model
{
    use HasFactory;
    protected $fillable = [
        'credit_id',
        'last_name',
        'second_lastname',
        'names',
        'relationship',
        'relationship_time_years',
        'relationship_time_months',
        'cel_phone',
        'local_phone',
        'contact_time',
        'postal_code',
        'street',
        'home_external_number',
        'home_internal_number',
        'colony',
        'city',
        'state',
        'country',
        'note',
    ];

    public static function saveEdit($credit_id, $request)
    {
        $data_reference                 = $request->data_reference;
        $reference_id                   = $request->reference_id;
        $data_reference['credit_id']    = $credit_id;

        if ($reference_id == null) {
            $reference = new CreditReference($data_reference);
            $reference->save();
        } else {
            $reference = CreditReference::find($reference_id);
            $reference->fill($data_reference);
            $reference->update();
        }
        return $reference;
    }

    public static function list($history, $credit_id)
    {
        $references = CreditReference::where('credit_id', $credit_id)->get();
        $data_references = array();
        foreach ($references as $reference) {
            $menu_options         = self::menuOption($history, $reference->id);
            $options  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['options']])->render();
            $data_references[] = array(
                'id' => $reference->id,
                'names' => $reference->names,
                'last_name' => $reference->last_name,
                'second_lastname' => $reference->second_lastname,
                'relation' => $reference->relationship,
                'options' =>$options,
            );
        }
        return $data_references;
    }

    public function menuOption($history, $reference_id)
    {
        $menu = array(
            'options' => array(
                [
                    'link' => null,
                    'onclick' => 'modalReference('.$history->id.','.$reference_id.')',
                    'name' => 'Editar',
                    'icon' => 'icon ni ni-edit',
                ],
                [
                    'link' => null,
                    'onclick' => 'deleteReference('.$reference_id.')',
                    'name' => 'Borrar',
                    'icon' => 'icon ni ni-trash',
                ]
            ),
        );

        return $menu;
    }
}
