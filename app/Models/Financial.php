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
    ];

    public static function saveEdit($request)
    {
        if ($request->financial_id == null) {
            $financial = Financial::create($request->except(['_token', 'financial_id']));
        } else {
            $financial = Financial::find($request->financial_id);
            $financial->fill($request->except(['_token', 'financial_id']));
            $financial->update();
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

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
