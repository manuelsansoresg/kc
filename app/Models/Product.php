<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'alias',
        'c_product_id',
        'c_service_id',
        'comment',
        'status'
    ];

    public function getAll()
    {
        return Product::all();
    }

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
            $product = $query->catalogProduct;
            $service = $query->catalogService;
            $option = \View::make('panel.product.add_option_dt', [ 'type' => 2, 'id' => $query->id])->render();
            
            $lbl_status = '<span class="text-success">Sí</span>';
            if ($query->status == 0) {
                $lbl_status = '<span class="text-danger">No</span>';
            }
            
            $users[] = array(
                'alias' => $query->alias,
                'name' => ($product!= null) ? $product->name : '',
                'service' => ($service != null) ? $service->name : '',
                'comment' => $query->comment,
                'status' => $lbl_status,
                'options' => $option
            );
        }
        return $users;
    }
    
    public function catalogProduct()
    {
        return $this->belongsTo(CProduct::class, 'c_product_id');
    }
    
    public function catalogService()
    {
        return $this->belongsTo(CService::class, 'c_service_id');
    }

    public function lead()
    {
        return $this->hasOne(Lead::class);
    }

    public function clientPerson()
    {
        return $this->hasOne(Credit::class);
    }
}
