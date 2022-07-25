<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CService extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function getAll()
    {
        return CService::all();
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
