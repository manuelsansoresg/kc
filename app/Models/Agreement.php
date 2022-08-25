<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status'
    ];


    public function getAll()
    {
        return Agreement::all();
    }
    
    public function getAllActive()
    {
        return Agreement::where('status', 1)->get();
    }

    public static function listDatatable()
    {
       
        
        $get_list    = Agreement::all();
        $data        = array();
        foreach ($get_list as $query) {
            $option = \View::make('panel.agreement.add_option_dt', [ 'type' => 2, 'id' => $query->id])->render();
            
            $lbl_status = '<span class="text-success">Sí</span>';
            if ($query->status == 0) {
                $lbl_status = '<span class="text-danger">No</span>';
            }
            
            $data[] = array(
                'name' => $query->name,
                'description' =>$query->description,
                'status' => $lbl_status,
                'options' => $option
            );
        }
        return $data;
    }

    public static function saveEdit($request)
    {
        if ($request->agreement_id == null) {
            $agreement = new Agreement($request->data);
            $agreement->save();
        } else {
            $agreement = Agreement::find($request->agreement_id);
            $agreement->fill($request->data);
            $agreement->update();
        }
       
        return $agreement;
    }

    public function lead()
    {
        return $this->hasOne(Lead::class);
    }
    
    public function credit()
    {
        return $this->hasOne(Credit::class);
    }

    public function financialAgreement()
    {
        return $this->hasMany(FinancialAgreement::class);
    }
}
