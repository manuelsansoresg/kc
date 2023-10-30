<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComplementaryService extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', 
        'type',
        'description',
    ];

    public static function saveEdit($request)
    {
        $data = $request->data;
        
        if ($request->complementary_id == null) {
            $complementary = ProductComplementaryService::create($data);
        } else {
            $complementary = ProductComplementaryService::find($request->complementary_id);
            $complementary->fill($data);
            $complementary->update();
        }
        return $complementary;
    }
}
