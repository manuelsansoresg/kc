<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'daily_income',
        'daily_income_adjusted',
        'credit_active',
        'active_discount',
        'periodicity_id',
        'pc_percentage',
        'payment_capacity',

        'ID_primer_apellido',
        'ID_segundo_apellido',
        'ID_nombres',
        'ID_vigencia',
        
        'ID_CIC',
        'ID_IDC',
        
        'payroll_date',
        'payroll_total',
        
        'clabe_ownership',
        'validated_clabe',
    ];

    public static function listDatatable($isAdmin = true)
    {
        if ($isAdmin === true) {
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
        } else {
            $userId = Auth::user()->id;
            $investor = Investor::where('user_id', $userId)->first();
            if ($investor != null) {
                $agreementIds = InvestorsAgreement::where('investor_id', $investor->id)
                ->pluck('agreement_id')
                ->unique()
                ->values() // Reindexa los índices del arreglo
                ->toArray();
                $getClientPersons = ClientPerson::whereIn('agreement_id', $agreementIds)->get();
                foreach ($getClientPersons as $query) {
                    $agreement = Agreement::find($query->agreement_id);
                    $option         = \View::make('panel.client.add_option_dt', [ 'id' => $query->id])->render();
                    $data[] = array(
                        'id' => $query->id,
                        'name' =>  $query->name.' '.$query->last_name.' '.$query->second_last_name,
                        'agreement' => $agreement != null ? $agreement->name : null,
                        'cellphone' => $query->cellphone,
                        'rfc' => $query->rfc,
                        'estatus' => $query->active == 1 ? '<span class="text-success">Activo </span>' : '<span class="text-danger"> Inactivo </span>',
                        'options' => $option
                    );
                }
            }
        }
        
        
        return $data;
    }

    public static function saveEdit($request)
    {
        $clientId = $request->client_id;
        $data = $request->data;
        $data['active'] = isset($data['active'])? 1 : 0;
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

    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id')->withDefault([
            'name' => '',
        ]);
    }
}
