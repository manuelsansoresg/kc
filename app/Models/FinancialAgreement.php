<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAgreement extends Model
{
    use HasFactory;
    protected $fillable = [
        'agreement_id',
        'product_id',
    ];
    protected $primaryKey = 'agreement_id';

    public static function saveEdit($agreement_id, $request)
    {
        // Primero, verifica si el acuerdo financiero existe y elimínalo si es el caso.
        $existingConfiguration = FinancialAgreement::where('agreement_id', $agreement_id);

        if ($existingConfiguration != null) {
            $existingConfiguration->delete();
        }

        $products = $request->products;
        foreach ($products as $key => $product) {
            $existingProduct = FinancialProduct::find($product);
    
            if ($existingProduct) {
                $data_financial = array(
                    'agreement_id' => $agreement_id,
                    'product_id' => $product,
                );
    
                FinancialAgreement::create($data_financial);
            }
        }
    }

    public static function getList($agreement_id)
    {
        $get_financials = FinancialAgreement::where('agreement_id', $agreement_id)->get();
        $financials = array();
        foreach ($get_financials as $get_financial) {
            $financial = FinancialProduct::find($get_financial->product_id);
            $financials[] = $financial;
        }
        return $financials;
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }
    
    public function financial()
    {
        return $this->belongsTo(FinancialProduct::class, 'product_id');
    }
}
