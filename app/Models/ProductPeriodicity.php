<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPeriodicity extends Model
{
    use HasFactory;
    protected $table = 'product_periodicity';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'periodicity_id',
        'product_id',
    ];
}
