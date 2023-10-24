<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFee extends Model
{
    use HasFactory;
    protected $fillable = [
        'financial_product_id',
        'concepto',
        'periodicidad',
        'moneda',
        'valor',
        'porcentaje',
        'referencia',
        'type',
    ];

    public static function saveEdit($request)
    {
        $data = $request->data;
        

        $productFee = ProductFee::create($data);
        /* if ($data['financial_product_id'] == null) {
        } else {
            $productFee = ProductFee::find($request->product_id);
            $productFee->fill($data);
            $productFee->update();
        }
        return $productFee; */
        return $productFee;
    }

}
