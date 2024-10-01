<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPerson extends Model
{
    use HasFactory;
    protected $table = 'client_person';

    protected $fillable = [
        'name',
        'last_name',
        'second_last_name',
        'cellphone',
        'email',
        'agreement_id',
        'work_email',
        'birth_date',
        'sex',
        'rfc',
        'nationality',
        'birth_state',
        'curp',
        'marital_status',
        'education_level',
        'client_contact_time',
        'relative_lastname',
        'relative_second_lastname',
        'relative_names',
        'relative_local_phone',
        'relative_cel_phone',
        'relative_contact_time',
        'client_postal_code',
        'client_street',
        'client_home_external_number',
        'client_home_internal_number',
        'client_colony',
        'client_city',
        'client_state',
        'client_country',
        'home_type',
        'home_time_living',
        'propety_ownnership_amount',
        'propety_ownnership_value',
        'vehicle_ownnership_amount',
        'vehicle_ownnership_value',
        'economic_dependents',
        'bank_name',
        'bank_card_number',
        'bank_acount_number',
        'bank_clabe',
        'profession',
        'home_note',
        'workplace_name',
        'admission_date',
        'labor_old',
        'employee_number',
        'employee_category',
        'employee_area',
        'employee_position',
        'monthly_income',
        'aditional_labor_source',
        'aditional_labor_income',
        'workplace_postal_code',
        'workplace_street',
        'workplace_home_external_number',
        'workplace_home_internal_number',
        'workplace_colony',
        'workplace_city',
        'workplace_state',
        'workplace_country',
        'workplace_local_phone',
        'workplace_cel_phone',
        'workplace_code',
        'workplace_local_phone_extension',
        'active',
        'sod_active',
    ];

    public static function listDatatable()
    {
        $clientPersons = ClientPerson::all();
        $data        = array();
        foreach ($clientPersons as $query) {
            $agreement = Agreement::find($query->agreement_id);
            $option         = \View::make('panel.client.add_option_dt', [ 'id' => $query->id])->render();
            $data[] = array(
                'id' => $query->id,
                'name' =>  $query->name.' '.$query->last_name.' '.$query->second_last_name,
                'agreement' => $agreement != null ? $agreement->name : null,
                'cellphone' => $query->cellphone,
                'rfc' => $query->rfc,
                'options' => $option
            );
        }
        return $data;
    }

    public static function saveEdit($request)
    {
        $clientId = $request->client_id;
        $data = $request->data;
        if ($clientId == null) {
            $client =  ClientPerson::create($data);
        } else {
            $client = ClientPerson::where('id', $clientId)->update($data);
        }
        return $client;
    }

    public static function checkDataModel($valueInput , $id)
    {
        $cp =  ClientPerson::where($id, $valueInput)->count();
        return $cp;
    }

    public function credit()
    {
        return $this->hasMany(Credit::class);
    }
}
