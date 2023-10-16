<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentFinancialProduct extends Model
{
    use HasFactory;
    protected  $fillable = [
        'id_rel',
        'product_id',
        'type',
    ];

    public static function saveEdit($id, $request, $type = 1)
    {
        // Primero, verifica si el acuerdo financiero existe y elimínalo si es el caso.
        $existingConfiguration = CurrentFinancialProduct::where(['id_rel' => $id, 'type' => $type]);

        if ($existingConfiguration != null) {
            $existingConfiguration->delete();
        }

        $products = $request->products;
        foreach ($products as $key => $product) {
            $existingProduct = FinancialProduct::find($product);
    
            if ($existingProduct) {
                $data_financial = array(
                    'id_rel' => $id,
                    'product_id' => $product,
                    'type' => $type,
                );
    
                CurrentFinancialProduct::create($data_financial);
            }
        }
    }

    public static function getList($id, $type)
    {
        $get_financials = CurrentFinancialProduct::where(['id_rel' => $id, 'type' => $type])->get();
        $financials = array();
        foreach ($get_financials as $get_financial) {
            $financials[] = $get_financial;
        }
        return $financials;
    }

    public static function moveToLead($id_lead, $credit_id) 
    {
        CurrentFinancialProduct::where(['id_rel' => $id_lead, 'type' => 1])
        ->update([
            'id_rel' => $credit_id,
            'type' => 2,
        ]);
    }
   
}
