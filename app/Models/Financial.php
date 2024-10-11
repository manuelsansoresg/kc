<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    use HasFactory;
    protected $fillable = [
        'commercial_name',
        'company_name',
        'logo',
        'date_of_update',
        'country_id',
        'sector_id',
        'regulator_id',
        'start_of_operations',
        'web',
        'email',
        'phone',
        'comment',
        'status',
        'privacy_notice',
        'mkt_purposes',
        'prospecting_purposes',
        'data_secondary_purposes',
        'allows_refusal_use',
        'sensible_data',
        'transfer_third',
        'transfer_third_collection',
        'arco_rights',
        'revocation_of_consent',
        'options_to_limit_data_usage',
        'tracking_technologies',
        'holders_consent',
        'total_claims_condusef',
        'claim_rate_per_10k',
        'user_service_performance_index',
        'total_sanctions',
        'compliance_condusef_records',
        'condusef_evaluation_product',
        'rfc',
        'tax_domicile',
    ];

    public function getAll()
    {
        return Financial::all();
    }

    public static function saveEdit($request)
    {
        
        if ($request->financial_id == null) {
            $financial = Financial::create($request->except(['_token', 'financial_id', 'logo', 'is_required']));
        } else {
            $financial = Financial::find($request->financial_id);
            $financial->fill($request->except(['_token', 'financial_id', 'logo', 'is_required']));
            $financial->update();
        }
        //* upload image
        if ($request->hasFile('logo') != false) {
            $document   = $request->file('logo');
            $name_full  = rand(1, 999).'-'.$document->getClientOriginalName();
            $path       = File::PATH;
            
            if ($document->move($path, $name_full)) {
                $financial = Financial::find($financial->id);
                $financial->logo = $name_full;
                $financial->update();
            }
        }
        return $financial;
    }

    public static function listDatatable()
    {
        $get_list   = Financial::all();
        $data       = array();

        foreach ($get_list as $query) {
            $option = \View::make('panel.financial.add_option_dt', ['id' => $query->id])->render();
            
            $data[] = array(
                'commercial_name' => $query->commercial_name,
                'company_name' => $query->company_name,
                'options' => $option
            );
        }
        return $data;
    }
    
    public static function listProductDatatable($financial_id)
    {
        $get_list   = FinancialProduct::where('financial_id', $financial_id)->get();
        $data       = array();

        foreach ($get_list as $query) {
            $option = \View::make('panel.financial.product.add_option_dt', ['id' => $query->id])->render();
            
            $lbl_status = '<span class="text-danger">No</span>';
            if ($query->status == 1) {
                $lbl_status = '<span class="text-success">Sí</span>';
            }
    
            
            $data[] = array(
                'id' => $query->id,
                'name' => $query->name,
                'status' => $lbl_status,
                'options' => $option
            );
        }
        return $data;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function financialAgreement()
    {
        return $this->hasMany(FinancialAgreement::class);
    }

    public function credit()
    {
        return $this->hasOne(Credit::class);
    }
}
