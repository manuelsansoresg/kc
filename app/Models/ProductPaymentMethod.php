<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPaymentMethod extends Model
{
    use HasFactory;
    protected $table = 'product_payment_method';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'payment_method_id',
        'product_id',
    ];
}
