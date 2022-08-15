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
            $product = new Agreement($request->data);
            $product->save();
        } else {
            $product = Agreement::find($request->agreement_id);
            $product->fill($request->data);
            $product->update();
        }
       
        return $product;
    }

    public function lead()
    {
        return $this->hasOne(Lead::class);
    }
}
