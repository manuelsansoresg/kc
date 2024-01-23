<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAgreement extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'agreement_id',
        'product_id',
    ];
    protected $primaryKey = 'agreement_id';

    public static function saveEdit($agreement_id, $request)
    {
        // Obtén los productos existentes para este acuerdo financiero
        $existingProducts = FinancialAgreement::where('agreement_id', $agreement_id)->pluck('product_id')->toArray();

        // Obtén los productos del request
        $products = $request->products;

        // Identifica los productos a eliminar y eliminarlos de la lista existente
        $productsToDelete = array_diff($existingProducts, $products);

        // Elimina los productos que ya no están en la lista
        FinancialAgreement::where('agreement_id', $agreement_id)->whereIn('product_id', $productsToDelete)->delete();

        // Itera sobre los productos del request
        foreach ($products as $key => $product) {
            $existingProduct = FinancialProduct::find($product);

            if ($existingProduct) {
                // Verifica si el registro ya existe antes de crearlo
                $existingConfiguration = FinancialAgreement::where('agreement_id', $agreement_id)
                    ->where('product_id', $product)
                    ->first();

                if (!$existingConfiguration) {
                    $maxId = FinancialAgreement::max('id');
                    $data_financial = array(
                        'id' => $maxId,
                        'agreement_id' => $agreement_id,
                        'product_id' => $product,
                    );

                    FinancialAgreement::create($data_financial);
                }
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
