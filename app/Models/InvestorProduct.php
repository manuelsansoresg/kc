<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'financial_products_id',
        'investor_id',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class, 'investor_id');
    }
}
