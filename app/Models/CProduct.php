<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function getAll()
    {
        return CProduct::all();
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    
}
