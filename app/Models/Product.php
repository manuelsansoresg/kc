<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'c_product_id',
        'c_service_id',
        'comment',
        'status'
    ];

    public static function saveEdit($request)
    {
        if ($request->product_id == null) {
            $product = new Product($request->except(['_token', 'product_id']));
            $product->save();
        } else {
            $product = Product::find($request->product_id);
            $product->fill($request->except(['_token', 'product_id']));
            $product->update();
        }
       
        return $product;
    }

    public static function listDatatable()
    {
       
        
        $get_list    = Product::all();
        $users        = array();
        foreach ($get_list as $query) {
            $product = $query->cProduct;
            $service = $query->cService;
            $option = \View::make('panel.product.add_option_dt', [ 'type' => 2, 'id' => $query->id])->render();
            
            $lbl_status = '<span class="badge bg-success">Sí</span>';
            if ($query->status == 0) {
                $lbl_status = '<span class="badge bg-danger">No</span>';
            }
            
            $users[] = array(
                'name' => $product->name,
                'service' => $service->name,
                'comment' => $query->comment,
                'status' => $lbl_status,
                'options' => $option
            );
        }
        return $users;
    }
    
    public function cProduct()
    {
        return $this->belongsTo(CProduct::class, 'c_product_id');
    }
    
    public function cService()
    {
        return $this->belongsTo(CProduct::class, 'c_service_id');
    }
}
